<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Library;


use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplication;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Library\IncludeHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Document Include Library Helper
 * 
 * @since 5.1.2
 */
final class Document
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 5.1.2
	 */
	protected Registry $registry;

	/**
	 * The IncludeHelper Class.
	 *
	 * @var   IncludeHelper
	 * @since 5.1.2
	 */
	protected IncludeHelper $includehelper;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 5.1.2
	 */
	protected Paths $paths;

	/**
	 * Joomla Application
	 *
	 * @var   CMSApplication
	 * @since 5.1.2
	 */
	protected CMSApplication $app;

	/**
	 * Track library warnings already shown.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected array $libwarning = [];

	/**
	 * Constructor.
	 *
	 * @param Config          $config          The Config Class.
	 * @param Registry        $registry        The Registry Class.
	 * @param IncludeHelper   $includehelper   The IncludeHelper Class.
	 * @param Paths           $paths           The Paths Class.
	 * @param CMSApplication  $app             The CMS Application Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Registry $registry,
		IncludeHelper $includehelper, Paths $paths, ?CMSApplication $app = null)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->includehelper = $includehelper;
		$this->paths = $paths;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Get the generated script inclusion block for a library.
	 *
	 * @param  mixed  $id  The library ID or GUID.
	 *
	 * @return string  The document script block or empty string.
	 * @since  5.1.2
	 */
	public function get($id): string
	{
		$library = $this->registry->get("builder.libraries.$id");

		if (!is_object($library))
		{
			return '';
		}

		if (
			isset($library->how, $library->conditions) &&
			$library->how == 2 &&
			ArrayHelper::check($library->conditions)
		)
		{
			$this->buildConditionalLibraryDocument($id, $this->buildLibraryScripts($id, false));
		}
		elseif (isset($library->how) && $library->how == 1)
		{
			$this->buildLibraryScripts($id);
		}

		if (isset($library->document) && StringHelper::check($library->document))
		{
			return PHP_EOL . PHP_EOL . $library->document;
		}

		return '';
	}

	/**
	 * Build the library document with conditional logic warning.
	 *
	 * @param  mixed  $id       The library ID.
	 * @param  array|null  $scripts  The resolved scripts array.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	protected function buildConditionalLibraryDocument($id, ?array $scripts): void
	{
		if (!isset($this->libwarning[$id]))
		{
			$this->libwarning[$id] = true;
			$library = $this->registry->get("builder.libraries.$id");

			$this->app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_HR_HTHREECONDITIONAL_SCRIPT_WARNINGHTHREE'), 'Warning');

			if (is_object($library) && isset($library->name))
			{
				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_THE_CONDITIONAL_SCRIPT_BUILDER_FOR_BSB_IS_NOT_READY_SORRY',
						$library->name
					),
					'Warning'
				);
			}
			else
			{
				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_THE_CONDITIONAL_SCRIPT_BUILDER_FOR_IDBSB_IS_NOT_READY_SORRY',
						$id
					),
					'Warning'
				);
			}
		}
	}

	/**
	 * Build the script include lines for a library and optionally set document output.
	 *
	 * @param  mixed   $id        The library ID or GUID.
	 * @param  bool    $buildDoc  Whether to assign generated scripts to the library document.
	 *
	 * @return array|null  Returns scripts array if not setting document, or true/false on success.
	 * @since  5.1.2
	 */
	protected function buildLibraryScripts($id, bool $buildDoc = true): ?array
	{
		$scripts = [];
		$library = $this->registry->get("builder.libraries.$id");

		if (!is_object($library))
		{
			return null;
		}

		// Process all defined URLs
		if (!empty($library->urls) && ArrayHelper::check($library->urls))
		{
			foreach ($library->urls as $url)
			{
				if (!empty($url['path']))
				{
					$localPath = $this->getScriptRootPath($url['path']);
					$scripts[md5($url['path'])] = $this->includehelper->get($localPath);
					// load url also if not building document
					if (!$buildDoc)
					{
						// load document script
						$scripts[md5((string) $url['url'])] = $this->includehelper->get(
							$url['url']
						);
					}
				}
				elseif (!empty($url['url']))
				{
					$scripts[md5($url['url'])] = $this->includehelper->get($url['url']);
				}
			}
		}

		// Process all defined local files
		if (!empty($library->files) && ArrayHelper::check($library->files))
		{
			foreach ($library->files as $file)
			{
				if (empty($file['path']) && empty($file['file']))
				{
					continue;
				}

				$relativePath = '/' . trim((string) $file['path'], '/');
				$pathInfo = pathinfo($relativePath);
				$fullPath = $this->getScriptRootPath($relativePath);

				if (!empty($pathInfo['extension']))
				{
					$scripts[md5($relativePath)] = $this->includehelper->get($fullPath, $pathInfo);
				}
				elseif (!empty($file['file']))
				{
					$fileName = trim((string) $file['file'], '/');
					$scripts[md5("{$relativePath}/{$fileName}")] = $this->includehelper->get("{$fullPath}/{$fileName}");
				}
			}
		}

		// Process folders
		if (!empty($library->folders) && ArrayHelper::check($library->folders))
		{
			$files = [];
			foreach ($library->folders as $folder)
			{
				if (!isset($folder['path'], $folder['folder']))
				{
					continue;
				}

				$rootPath = '/' . trim((string)$folder['path'], '/');
				$componentRoot = $this->paths->component_path . $rootPath;

				if (!empty($folder['rename']) && $folder['rename'] == 1)
				{
					$files[$rootPath] = FileHelper::getPaths($componentRoot) ?: [];
				}
				else
				{
					$folderPath = $rootPath . '/' . trim((string)$folder['folder'], '/');
					$files[$folderPath] = FileHelper::getPaths($this->paths->component_path . $folderPath) ?: [];
				}
			}

			foreach ($files as $relative => $paths)
			{
				$fullRoot = $this->getScriptRootPath($relative);
				foreach ($paths as $subPath)
				{
					$key = md5("$relative/$subPath");
						$scripts[$key] = $this->includehelper->get("$fullRoot/$subPath");
				}
			}
		}

		// Output document if required
		if ($buildDoc && ArrayHelper::check($scripts))
		{
			$document = Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " always load these files." . PHP_EOL;
			$document .= Indent::_(2) . implode(PHP_EOL . Indent::_(2), $scripts);

			$this->registry->set("builder.libraries.{$id}.document", $document);
			return null;
		}

		return ArrayHelper::check($scripts) ? $scripts : null;
	}

	/**
	 * Resolve the root path for a script based on its usage location.
	 *
	 * @param  string  $root  The root path to adjust.
	 *
	 * @return string  The resolved root path.
	 * @since  5.1.2
	 */
	protected function getScriptRootPath(string $root): string
	{
		if (str_contains($root, '/media/') && !str_contains($root, '/admin/') && !str_contains($root, '/site/'))
		{
			return str_replace('/media/', '/media/com_' . $this->config->component_code_name . '/', $root);
		}

		if (!str_contains($root, '/media/') && str_contains($root, '/admin/') && !str_contains($root, '/site/'))
		{
			return str_replace('/admin/', '/administrator/components/com_' . $this->config->component_code_name . '/', $root);
		}

		if (!str_contains($root, '/media/') && !str_contains($root, '/admin/') && str_contains($root, '/site/'))
		{
			return str_replace('/site/', '/components/com_' . $this->config->component_code_name . '/', $root);
		}

		return $root;
	}
}

