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
namespace VDM\Component\Componentbuilder\Administrator\View\Get_snippets;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\User\User;
use Joomla\CMS\Document\Document;
use VDM\Component\Componentbuilder\Administrator\Helper\HeaderCheck;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\Filesystem\File;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Session\Session;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Html View class for the Get_snippets
 *
 * @since  1.6
 */
#[AllowDynamicProperties]
class HtmlView extends BaseHtmlView
{
	/**
	 * The styles url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $styles;

	/**
	 * The scripts url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $scripts;

	/**
	 * The actions object
	 *
	 * @var    object
	 * @since  3.10.11
	 */
	public object $canDo;

	/**
	 * The user object.
	 *
	 * @var    User
	 * @since  3.10.11
	 */
	public User $user;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		// get component params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app ??= Factory::getApplication();
		// get the user object
		$this->user ??= $this->getCurrentUser();
		// get global action permissions
		$this->canDo = ComponentbuilderHelper::getActions('get_snippets');
		$this->styles = $this->get('Styles') ?? [];
		$this->scripts = $this->get('Scripts') ?? [];
		// Initialise variables.
		$this->items = $this->get('Items');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode(PHP_EOL, $errors), 500);
		}

		// Set the html view document stuff
		$this->_prepareDocument();

		parent::display($tpl);
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{

		// Only load jQuery if needed. (default is true)
		if ($this->params->get('add_jquery_framework', 1) == 1)
		{
			Html::_('jquery.framework');
		}
		// Load the header checker class.
		// Initialize the header checker.
		$HeaderCheck = new HeaderCheck();

		// Add View JavaScript File
		Html::_('script', "administrator/components/com_componentbuilder/assets/js/get_snippets.js", ['version' => 'auto']);

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css', ['version' => 'auto']);
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js', ['version' => 'auto']);
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = [];
			$uikitComp[] = 'data-uk-grid';
		}

		// Load the needed uikit components in this view.
		if ($uikit != 2 && isset($uikitComp) && ArrayHelper::check($uikitComp))
		{
			// loading...
			foreach ($uikitComp as $class)
			{
				foreach (ComponentbuilderHelper::$uk_components[$class] as $name)
				{
					// check if the CSS file exists.
					if (@file_exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css', ['version' => 'auto']);
					}
					// check if the JavaScript file exists.
					if (@file_exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);
					}
				}
			}
		}
		// load the local snippets
		if (ArrayHelper::check($this->items))
		{
			$local_snippets = array();
			foreach ($this->items as $item)
			{
				$path = StringHelper::safe($item->library . ' - (' . $item->type . ') ' . $item->name, 'filename', '', false). '.json';
				$local_snippets[$path] = $item;
			}
		}
		
		// Add the JavaScript for JStore
		Html::_('script', 'media/com_componentbuilder/js/jquery.json.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/jstorage.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/js/strtotime.js', ['version' => 'auto']);
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = Factory::getSession();
				// must have itin milliseconds
				$expire = ($session->getExpire()*60)* 1000;
			}
			else
			{
				// use the Componentbuilder Global setting
				if (0 !=  $storageTimeToLive)
				{
					// this will convert the time into milliseconds
					$storageTimeToLive =  $storageTimeToLive * 1000;
				}
				$expire = $storageTimeToLive;
			}
		}
		else
		{
			// set to use no storage
			$expire = 30000; // only 30 seconds
		}
		// Set the Time To Live To JavaScript
		$this->document->addScriptDeclaration("var expire = ". (int) $expire.";");
		// set snippet path
		$this->document->addScriptDeclaration("var snippetPath = '". ComponentbuilderHelper::$snippetPath ."';");
		$this->document->addScriptDeclaration("var snippetsPath = '". ComponentbuilderHelper::$snippetsPath ."';");
		// token
		$this->document->addScriptDeclaration("var token = '". Session::getFormToken() ."';");
		// add some global items buckets for bulk updating
		$this->document->addScriptDeclaration("var bulkItems = {};");
		$this->document->addScriptDeclaration("bulkItems.new = [];");
		$this->document->addScriptDeclaration("bulkItems.diverged = [];");
		$this->document->addScriptDeclaration("bulkItems.ahead = [];");
		$this->document->addScriptDeclaration("bulkItems.behind = [];");
		// set an error message if needed
		$this->document->addScriptDeclaration("var returnError = '<div class=\"uk-alert uk-alert-warning\"><h1>".Text::_('COM_COMPONENTBUILDER_AN_ERROR_HAS_OCCURRED')."!</h1><p>".Text::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_LATER').".</p></div>';");
		// need to add some language strings
		Text::script('COM_COMPONENTBUILDER_JCB_COMMUNITY_SNIPPETS');
		Text::script('COM_COMPONENTBUILDER_SNIPPETS');
		Text::script('COM_COMPONENTBUILDER_SNIPPET');
		Text::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_OF_COMMUNITY_VERSION');
		Text::script('COM_COMPONENTBUILDER_GET_SNIPPET');
		Text::script('COM_COMPONENTBUILDER_LOCAL_SNIPPET');
		Text::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		Text::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		Text::script('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION');
		Text::script('COM_COMPONENTBUILDER_USAGE');
		Text::script('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION');
		Text::script('COM_COMPONENTBUILDER_DESCRIPTION');
		Text::script('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION');
		Text::script('COM_COMPONENTBUILDER_VIEW_BLAME');
		Text::script('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_SNIPPET');
		Text::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_REFERENCE_URL');
		Text::script('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED');
		Text::script('COM_COMPONENTBUILDER_SNIPPETS_COULD_NOT_BE_UPDATEDSAVED');
		Text::script('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR');
		Text::script('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS');
		Text::script('COM_COMPONENTBUILDER_JCB_COMMUNITY');
		Text::script('COM_COMPONENTBUILDER_COMPANY_NAME');
		Text::script('COM_COMPONENTBUILDER_AUTHOR_NAME');
		Text::script('COM_COMPONENTBUILDER_AUTHOR_EMAIL');
		Text::script('COM_COMPONENTBUILDER_AUTHOR_WEBSITE');
		Text::script('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_SNIPPETS_AT_THIS_TIME');
		Text::script('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_SNIPPETS_AT_THIS_TIME');
		Text::script('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_SNIPPETS_AT_THIS_TIME');
		Text::script('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_SNIPPETS_AT_THIS_TIME');
		Text::script('COM_COMPONENTBUILDER_THERE_ARE_NO_SNIPPETS_TO_UPDATE_AT_THIS_TIME');
		Text::script('COM_COMPONENTBUILDER_AVAILABLE_LIBRARIES');
		Text::script('COM_COMPONENTBUILDER_OPEN_LIBRARY_SNIPPETS');
		// add some lang verfy messages
		$this->document->addScriptDeclaration("
			// set the snippet from gitHub
			function getConfirmUpdate(status) {
				switch(status) {
					case 'new':
						return '".Text::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_ADD_THIS_NEW_JCB_COMMUNITY_SNIPPET_TO_YOUR_LOCAL_SNIPPETS')."';
					break;
					case 'behind':
						return '".Text::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_NEWER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'ahead':
						return '".Text::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_OLDER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'diverged':
						return '".Text::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_REPLACE_YOUR_LOCAL_SNIPPET_WITH_THIS_JCB_COMMUNITY_SNIPPET')."';
					break;
					default:
						return '".Text::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_CONTINUE')."';
					break;
				}
			}
		");
		// load the local snippets
		if (ArrayHelper::check($this->items))
		{
			// Set the local snippets array
			$this->document->addScriptDeclaration("var local_snippets = ". json_encode($local_snippets).";");
		}
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		// hide the main menu
		$this->app->input->set('hidemainmenu', true);
		// add title to the page
		ToolbarHelper::title(Text::_('COM_COMPONENTBUILDER_GET_SNIPPETS'),'search');
		// add cpanel button
		ToolbarHelper::custom('get_snippets.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('get_snippets.custom_admin_views'))
		{
			// add Custom Admin Views button.
			ToolbarHelper::custom('get_snippets.openCustomAdminViews', 'screen custom-button-opencustomadminviews', '', 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.site_views'))
		{
			// add Site Views button.
			ToolbarHelper::custom('get_snippets.openSiteViews', 'palette custom-button-opensiteviews', '', 'COM_COMPONENTBUILDER_SITE_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.templates'))
		{
			// add Templates button.
			ToolbarHelper::custom('get_snippets.openTemplates', 'brush custom-button-opentemplates', '', 'COM_COMPONENTBUILDER_TEMPLATES', false);
		}
		if ($this->canDo->get('get_snippets.layouts'))
		{
			// add Layouts button.
			ToolbarHelper::custom('get_snippets.openLayouts', 'brush custom-button-openlayouts', '', 'COM_COMPONENTBUILDER_LAYOUTS', false);
		}
		if ($this->canDo->get('get_snippets.snippets'))
		{
			// add Snippets button.
			ToolbarHelper::custom('get_snippets.openSnippets', 'pin custom-button-opensnippets', '', 'COM_COMPONENTBUILDER_SNIPPETS', false);
		}
		if ($this->canDo->get('get_snippets.libraries'))
		{
			// add Libraries button.
			ToolbarHelper::custom('get_snippets.openLibraries', 'puzzle custom-button-openlibraries', '', 'COM_COMPONENTBUILDER_LIBRARIES', false);
		}

		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('get_snippets');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}

		// add the options comp button
		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_componentbuilder');
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var     The output to escape.
	 * @param   bool   $shorten The switch to shorten.
	 * @param   int    $length  The shorting length.
	 *
	 * @return  mixed  The escaped value.
	 * @since   1.6
	 */
	public function escape($var, bool $shorten = false, int $length = 40)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}
}
