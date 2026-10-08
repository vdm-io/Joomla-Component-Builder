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

namespace VDM\Joomla\Componentbuilder\Compiler\Helper;


use Joomla\CMS\Factory;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Minify;
use VDM\Joomla\Componentbuilder\Compiler\Helper\Interpretation;


/**
 * Infusion class
 * 
 * @since 3.2.0
 * @deprecated 3.3
 */
class Infusion extends Interpretation
{
	/**
	 * The language files the compiler wrote
	 *
	 * @var     array
	 * @since   3.2.0
	 */
	public $langFiles = [];

	/**
	 * The admin views whose edit body is built on the second run
	 *
	 * @var     array
	 * @since   3.2.0
	 */
	public $secondRunAdmin;

	/**
	 * Constructor
	 *
	 * @since   3.2.0
	 */
	public function __construct()
	{
		// first we run the perent constructor
		if (parent::__construct())
		{
			// infuse the data into the structure
			return $this->buildFileContent();
		}

		return false;
	}

	/**
	 * Build the content for the structure
	 *
	 * @return  boolean  on success
	 *
	 * @since   3.2.0
	 */
	protected function buildFileContent()
	{
		if (CFactory::_('Component')->isArray('admin_views'))
		{
			// Trigger Event: jcb_ce_onBeforeBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onBeforeBuildFilesContent'
			);

			// everything the component says about itself, before any view is built
			CFactory::_('Architecture.Component.Details')->set();

			// every admin view the component was given
			[$viewarray, $site_edit_view_array] =
				CFactory::_('Architecture.AdminViews.Loop')->build();

			// setup the layouts
			$this->setCustomViewLayouts();

			// every custom admin view the component was given
			CFactory::_('Architecture.CustomAdminViews.Builder')->build();

			// everything the component needs once its views are built
			CFactory::_('Architecture.Component.Assembly')->build(
				$viewarray, $site_edit_view_array
			);

			// run the second run if needed
			$secondRunAdmin = CFactory::_('Compiler.Builder.Second.Run.Admin')
				->allActive() + (array) $this->secondRunAdmin;
			if (ArrayHelper::check($secondRunAdmin))
			{
				// start dynamic build
				foreach ($secondRunAdmin as $function => $arrays)
				{
					if (ArrayHelper::check($arrays)
						&& StringHelper::check($function))
					{
						foreach ($arrays as $array)
						{
							$this->{$function}($array);
						}
					}
				}
			}

			// CONFIG_FIELDSETS
			$keepLang   = CFactory::_('Config')->lang_target;
			CFactory::_('Config')->lang_target = 'admin';
			// run field sets for second time
			CFactory::_('Compiler.Creator.Config.Fieldsets')->set(2);
			CFactory::_('Config')->lang_target = $keepLang;

			// setup front-views and all needed stuff for the site
			if (CFactory::_('Component')->isArray('site_views'))
			{
				CFactory::_('Config')->build_target = 'site';
				// start dynamic build
				foreach (CFactory::_('Component')->get('site_views') as $view)
				{
					CFactory::_('Architecture.SiteViews.Builder')->build($view);
				}

				// setup the layouts
				$this->setCustomViewLayouts();
			}
			else
			{
				// clear all site folder since none is needed
				CFactory::_('Config')->remove_site_folder = true;
			}
			// load the site statics
			CFactory::_('Architecture.Component.SiteStatics')->set();

			// the install, update and uninstall scripts
			CFactory::_('Architecture.Component.InstallScripts')->set();

			// everything the component still needs once every file has its content
			CFactory::_('Architecture.Component.Finalise')->set();

			// Trigger Event: jcb_ce_onAfterBuildFilesContent
			CFactory::_('Event')->trigger(
				'jcb_ce_onAfterBuildFilesContent'
			);
			return true;
		}

		return false;
	}

	/**
	 * Name one view to everything built for it.
	 *
	 * @param   object  $view  The view being built.
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.View.Placeholders instead.
	 */
	protected function setViewPlaceholders(&$view)
	{
		CFactory::_('Architecture.View.Placeholders')->set($view);
	}

	/**
	 * Build the language values and insert into file
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use Architecture.Language.Files instead.
	 */
	public function setLangFileData(): void
	{
		CFactory::_('Architecture.Language.Files')->build();
	}
}

