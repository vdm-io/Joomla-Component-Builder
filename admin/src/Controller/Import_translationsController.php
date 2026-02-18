<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\Utilities\ArrayHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Import\Factory as ImportFactory;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\SessionHelper;
use VDM\Joomla\Componentbuilder\File\Factory as FileFactory;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Import_translations Base Controller
 *
 * @since  1.6
 */
class Import_translationsController extends BaseController
{
	/**
	 * The context for storing internal data, e.g. record.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $context = 'import_translations';

	/**
	 * The URL view item variable.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $view_item = 'import_translations';

	/**
	 * Adds option to redirect back to the dashboard.
	 *
	 * @return  void
	 * @since   3.0
	 */
	public function dashboard(): void
	{
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder', false));
	}

	/**
	 * Go back to the language translations
	 *
	 * @return  true on success
	 * @since  5.1.4
	 */
	public function backToLanguageTranslations()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));

		// redirect to the libraries
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=language_translations', false));

		return;
	}

	/**
	 * get all the import example spreadsheet
	 *
	 * @return  true on success
	 * @since  5.0.2
	 */
	public function getLanguageTranslationsExample()
	{
		// Check for request forgeries
		Session::checkToken() or exit(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = $this->app->getIdentity();

		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=import_translations', false);
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_DOWNLOAD_THE_IMPORT_EXAMPLE');

		// currently only those with permissions can get these images
		if($user->authorise('import_translations.example', 'com_componentbuilder'))
		{
			$message = Text::_('COM_COMPONENTBUILDER_BEXAMPLE_EMPTY_SPREADSHEET_HAS_BEEN_EXPORTEDB');
			$this->setRedirect($redirect_url, $message, 'message');

			$headers = ComponentbuilderHelper::getLanguageTranslationsHeaders() ?? ['source' => 'source'];
			$rows = [array_values($headers)];
			ImportFactory::_('Spreadsheet.Exporter')->export(
				$rows,
				'Language-Translations-Example',
				'Language Translations Example',
				'Language-Translations'
			);

			return true;
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}

	/**
	 * Import the language translations
	 *
	 * @return  bool  True on success
	 * @since   5.1.4
	 */
	public function importLanguageTranslations(): bool
	{
		// CSRF check
		Session::checkToken() or exit(Text::_('JINVALID_TOKEN'));

		$user = $this->app->getIdentity();

		$redirectUrl = Route::_('index.php?option=com_componentbuilder&view=import_translations', false);

		// Permission check (fail fast)
		if (!$user->authorise('import_translations.access', 'com_componentbuilder'))
		{
			$this->setRedirect(
				$redirectUrl,
				Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_IMPORT'),
				'error'
			);

			return false;
		}

		$import = $this->input->post->get('vdm_import', [], 'array');

		if (
			empty($import['file']) ||
			!GuidHelper::valid($import['file'])
		)
		{
			$this->setRedirect(
				$redirectUrl,
				Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_A_FILE_LINKING_ERROR_PLEASE_TRY_AGAIN'),
				'error'
			);

			return false;
		}

		$fileDefinition = null;
		$fileType       = null;
		$entity         = null;

		try
		{
			$entity = SessionHelper::get(
				'componentbuilder_import_translations_guid',
				GuidHelper::get()
			);

			$fileDefinition = SessionHelper::get(
				"componentbuilder_{$entity}"
			);

			$fileType = SessionHelper::get(
				'componentbuilder_import_translations_file_type',
				GuidHelper::get()
			);
		}
		catch (\Throwable $e)
		{
			$this->cleanupImportState($entity, $fileType, $fileDefinition);

			$this->setRedirect(
				$redirectUrl,
				$e->getMessage(),
				'error'
			);

			return false;
		}

		try
		{
			$importer       = ImportFactory::_('Import.Transient');
			$importerEntity = ImportFactory::_('Import.Entity');

			$importerEntity
				->setParentTable('language_translation')
				->setParentKey('id')
				->setLinkField('source');

			$spreadsheet = $this->arrayToObject([
				'maps' => $import['maps'] ?? [],
				'file_path' => $fileDefinition['file_path'] ?? '',
			]);
		}
		catch (\Throwable $e)
		{
			$this->cleanupImportState($entity, $fileType, $fileDefinition);

			$this->setRedirect(
				$redirectUrl,
				$e->getMessage(),
				'error'
			);

			return false;
		}

		try
		{
			$result = $importer
				->execute($spreadsheet)
				->result();
		}
		catch (\Throwable $e)
		{
			$this->cleanupImportState($entity, $fileType, $fileDefinition);

			$this->setRedirect(
				$redirectUrl,
				$e->getMessage(),
				'error'
			);

			return false;
		}

		$this->cleanupImportState($entity, $fileType, $fileDefinition);

		$return_message = Text::_('COM_COMPONENTBUILDER_IMPORTING_THE_LANGUAGE_TRANSLATION_FILE_HAS_FAILED');
		$status = 'error';
		$return = false;

		if (!empty($result->message_success))
		{
			$return_message = '<h3>' . Text::_('COM_COMPONENTBUILDER_IMPORTING_THE_LANGUAGE_TRANSLATION_FILE_WAS_SUCCESSFUL') . '</h3><p>' .
				implode('<br>', (array) $result->message_success) . '</p>';

			$status = 'success';
			$return = true;
		}

		$this->setRedirect(
			$redirectUrl,
			$return_message,
			$status
		);

		if (!empty($result->message_info))
		{
			$messages = '<p>' . implode('<br>', $result->message_info) . '</p>';
			$this->app->enqueueMessage($messages, 'message');
		}

		if (!empty($result->message_error))
		{
			$messages = '<p>' . implode('<br>', $result->message_error) . '</p>';
			$this->app->enqueueMessage($messages, 'error');
		}

		return $return;
	}

	/**
	 * Recursively convert an array and all nested arrays into stdClass objects.
	 *
	 * This method walks through the given array and converts every sub-array
	 * into an object as well. The final result is a fully object-based structure
	 * where array keys become object properties.
	 *
	 * Example:
	 *   ['a' => ['b' => 1]]  →  (object) ['a' => (object) ['b' => 1]]
	 *
	 * Numeric arrays are also converted to objects:
	 *   ['x', 'y'] → (object) [0 => 'x', 1 => 'y']
	 *
	 * This implementation is optimized for performance:
	 * - No JSON encoding/decoding
	 * - No unnecessary copying
	 * - Uses direct recursion
	 *
	 * Suitable for high-volume and production environments.
	 *
	 * @param  array  $data  The input array to convert.
	 *
	 * @return object  The fully converted object structure.
	 *
	 * @since  5.1.4
	 */
	protected function arrayToObject(array $data): object
	{
		// Loop through all array elements
		foreach ($data as $key => $value)
		{
			// If the value is an array, convert it recursively
			if (is_array($value))
			{
				$data[$key] = $this->arrayToObject($value);
			}
			// Otherwise, keep the value as-is
			else
			{
				$data[$key] = $value;
			}
		}

		// Cast the processed array to an object and return it
		return (object) $data;
	}

	/**
	 * Cleanup import session state and temp files
	 *
	 * @param  string|null  $entity
	 * @param  string|null  $fileType
	 * @param  array|null   $fileDefinition
	 *
	 * @return void
	 */
	protected function cleanupImportState(?string $entity, ?string $fileType, ?array $fileDefinition): void
	{
		SessionHelper::set(
			'componentbuilder_import_translations_file_type',
			null
		);

		if ($fileType)
		{
			SessionHelper::set(
				"componentbuilder_import_translations_{$fileType}",
				null
			);
		}

		if ($entity)
		{
			SessionHelper::set(
				"componentbuilder_{$entity}",
				null
			);
		}

		if (!empty($fileDefinition['file_path']))
		{
			FileFactory::_('File.Agent')
				->delete($fileDefinition['file_path']);
		}
	}
}
