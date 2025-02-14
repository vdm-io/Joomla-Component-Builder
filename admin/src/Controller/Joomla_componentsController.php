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
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Componentbuilder\Package\Factory as PackageFactory;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_components Admin Controller
 *
 * @since  1.6
 */
class Joomla_componentsController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_COMPONENTS';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Joomla_component', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('joomla_component.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = Factory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			$pks = ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Joomla_components');
			// get the data to export
			$data = $model->getExportData($pks);
			if (UtilitiesArrayHelper::check($data))
			{
				// now set the data to the spreadsheet
				$date = Factory::getDate();
				ComponentbuilderHelper::xls($data,'Joomla_components_'.$date->format('jS_F_Y'),'Joomla components exported ('.$date->format('jS F, Y').')','joomla components');
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = Factory::getApplication()->getIdentity();
		if ($user->authorise('joomla_component.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Joomla_components');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ObjectHelper::check($headers))
			{
				// Load headers to session.
				$session = Factory::getSession();
				$headers = json_encode($headers);
				$session->set('joomla_component_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'joomla_components');
				$session->set('dataType_VDM_IMPORTINTO', 'joomla_component');
				// Redirect to import view.
				$message = Text::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_JOOMLA_COMPONENTS');
				$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=import_joomla_components', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=joomla_components', false), $message, 'error');
		return;
	}


	/**
	 * Clear tmp folder
	 *
	 * @return  true on success
	 * @since  3.0.0
	 */
	public function clearTmp()
	{
		// Check for request forgeries
		Session::checkToken() or \jexit(Text::_('JINVALID_TOKEN'));

		// check if user has the right
		$user = Factory::getUser();

		// set page redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=joomla_components', false);
		$message = Text::_('COM_COMPONENTBUILDER_COULD_NOT_CLEAR_THE_TMP_FOLDER');
		if($user->authorise('joomla_components.clear_tmp', 'com_componentbuilder') && $user->authorise('core.manage', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('compiler');
			// get tmp folder
			$comConfig = Factory::getConfig();
			$tmp = $comConfig->get('tmp_path');
			if ($model->emptyFolder($tmp))
			{
				$message = Text::_('COM_COMPONENTBUILDER_BTHE_TMP_FOLDER_HAS_BEEN_CLEARED_SUCCESSFULLYB');
				$this->setRedirect($redirect_url, $message, 'message');
				// get application
				$app = Factory::getApplication();
				// wipe out the user c-m-p since we are done with them all
				$app->setUserState('com_componentbuilder.component_folder_name', '');
				$app->setUserState('com_componentbuilder.modules_folder_name', '');
				$app->setUserState('com_componentbuilder.plugins_folder_name', '');
				$app->setUserState('com_componentbuilder.success_message', '');

				return true;
			}
		}
		$this->setRedirect($redirect_url, $message, 'error');
		return false;
	}
}