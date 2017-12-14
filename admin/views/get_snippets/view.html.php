<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
    __      __       _     _____                 _                                  _     __  __      _   _               _
    \ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
     \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
      \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
       \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
        \/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
                                                        | |                                                                 
                                                        |_| 				
/-------------------------------------------------------------------------------------------------------------------------------/

	@version		2.6.x
	@created		30th April, 2015
	@package		Component Builder
	@subpackage		view.html.php
	@author			Llewellyn van der Merwe <http://vdm.bz/component-builder>	
	@github			Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
	@copyright		Copyright (C) 2015. All Rights Reserved
	@license		GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html 
	
	Builds Complex Joomla Components 
                                                             
/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * Componentbuilder View class for the Get_snippets
 */
class ComponentbuilderViewGet_snippets extends JViewLegacy
{
	// Overwriting JView display method
	function display($tpl = null)
	{
                // get component params
		$this->params	= JComponentHelper::getParams('com_componentbuilder');
		// get the application
		$this->app	= JFactory::getApplication();
		// get the user object
		$this->user	= JFactory::getUser();
                // get global action permissions
		$this->canDo	= ComponentbuilderHelper::getActions('get_snippets');
		// Initialise variables.
		$this->items	= $this->get('Items');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			// add the tool bar
			$this->addToolBar();
		}

		// set the document
		$this->setDocument();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		parent::display($tpl);
	}

        /**
	 * Prepares the document
	 */
	protected function setDocument()
	{

		// always make sure jquery is loaded.
		JHtml::_('jquery.framework');
		// Load the header checker class.
		require_once( JPATH_COMPONENT_ADMINISTRATOR.'/helpers/headercheck.php' );
		// Initialize the header checker.
		$HeaderCheck = new componentbuilderHeaderCheck; 

		// Load uikit options.
		$uikit = $this->params->get('uikit_load');
		// Set script size.
		$size = $this->params->get('uikit_min');
		// Set css style.
		$style = $this->params->get('uikit_style');

		// The uikit css.
		if ((!$HeaderCheck->css_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/uikit'.$style.$size.'.css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/uikit'.$size.'.js');
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = array();
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'data-uk-grid';
		}

		// Load the needed uikit components in this view.
		if ($uikit != 2 && isset($uikitComp) && ComponentbuilderHelper::checkArray($uikitComp))
		{
			// load just in case.
			jimport('joomla.filesystem.file');
			// loading...
			foreach ($uikitComp as $class)
			{
				foreach (ComponentbuilderHelper::$uk_components[$class] as $name)
				{
					// check if the CSS file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/css/components/'.$name.$style.$size.'.css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit-v2/js/components/'.$name.$size.'.js', 'text/javascript', true);
					}
				}
			}
		}   
		// load the local snippets
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			$local_snippets = array();
			foreach ($this->items as $item)
			{
				$path = ComponentbuilderHelper::safeString($item->library . ' - (' . $item->type . ') ' . $item->name, 'filename', '', false). '.json';
				$local_snippets[$path] = $item;
			}
		}
		// Add the JavaScript for JStore
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jquery.json.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/jstorage.min.js');
		$this->document->addScript(JURI::root() .'media/com_componentbuilder/js/strtotime.js');
		// check if we should use browser storage
		$setBrowserStorage = $this->params->get('set_browser_storage', null);
		if ($setBrowserStorage)
		{
			// check what (Time To Live) show we use
			$storageTimeToLive = $this->params->get('storage_time_to_live', 'global');
			if ('global' == $storageTimeToLive)
			{
				// use the global session time
				$session = JFactory::getSession();
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
		// set snippet path
		$this->document->addScriptDeclaration("var snippetPath = '". ComponentbuilderHelper::$snippetPath ."';");
		$this->document->addScriptDeclaration("var snippetsPath = '". ComponentbuilderHelper::$snippetsPath ."';");
		// token
		$this->document->addScriptDeclaration("var token = '". JSession::getFormToken() ."';");
		// add some global items buckets for bulk updating
		$this->document->addScriptDeclaration("var bulkItems = {};");
		$this->document->addScriptDeclaration("bulkItems.new = [];");
		$this->document->addScriptDeclaration("bulkItems.diverged = [];");
		$this->document->addScriptDeclaration("bulkItems.ahead = [];");
		$this->document->addScriptDeclaration("bulkItems.behind = [];");
		// set an error message if needed
		$this->document->addScriptDeclaration("var returnError = '<div class=\"uk-alert uk-alert-warning\"><h1>".JText::_('COM_COMPONENTBUILDER_AN_ERROR_HAS_OCCURRED')."!</h1><p>".JText::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_LATER').".</p></div>';");
		// need to add some language strings
		JText::script('COM_COMPONENTBUILDER_SNIPPETS');
		JText::script('COM_COMPONENTBUILDER_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_LOCAL_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		JText::script('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION');
		JText::script('COM_COMPONENTBUILDER_USAGE');
		JText::script('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_DESCRIPTION');
		JText::script('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION');
		JText::script('COM_COMPONENTBUILDER_VIEW_BLAME');
		JText::script('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_SNIPPET');
		JText::script('COM_COMPONENTBUILDER_VIEW_SNIPPET_REFERENCE_URL');
		JText::script('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_SNIPPETS_COULD_NOT_BE_UPDATEDSAVED');
		JText::script('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR');
		JText::script('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS');
		JText::script('COM_COMPONENTBUILDER_JCB_COMMUNITY');
		JText::script('COM_COMPONENTBUILDER_COMPANY_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_NAME');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_EMAIL');
		JText::script('COM_COMPONENTBUILDER_AUTHOR_WEBSITE');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_SNIPPETS_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_THERE_ARE_NO_SNIPPETS_TO_UPDATE_AT_THIS_TIME');
		JText::script('COM_COMPONENTBUILDER_AVAILABLE_LIBRARIES');
		JText::script('COM_COMPONENTBUILDER_OPEN_LIBRARY_SNIPPETS');
		// add some lang verfy messages
		$this->document->addScriptDeclaration("
			// set the snippet from gitHub
			function getConfirmUpdate(status) {
				switch(status) {
					case 'new':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_ADD_THIS_NEW_JCB_COMMUNITY_SNIPPET_TO_YOUR_LOCAL_SNIPPETS')."';
					break;
					case 'behind':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_NEWER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'ahead':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_UPDATE_YOUR_LOCAL_SNIPPET_WITH_THIS_OLDER_JCB_COMMUNITY_SNIPPET')."';
					break;
					case 'diverged':
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_REPLACE_YOUR_LOCAL_SNIPPET_WITH_THIS_JCB_COMMUNITY_SNIPPET')."';
					break;
					default:
						return '".JText::_('COM_COMPONENTBUILDER_ARE_YOU_SURE_YOU_WOULD_LIKE_TO_CONTINUE')."';
					break;
				}
			}
		");
		// Set the Time To Live To JavaScript
		$this->document->addScriptDeclaration("var expire = ". (int) $expire.";");
		// load the local snippets
		if (ComponentbuilderHelper::checkArray($this->items))
		{
			// Set the local snippets array
			$this->document->addScriptDeclaration("var local_snippets = ". json_encode($local_snippets).";");
		}
                // add the document default css file
		$this->document->addStyleSheet(JURI::root(true) .'/administrator/components/com_componentbuilder/assets/css/get_snippets.css'); 
		// Set the Custom JS script to view
		$this->document->addScriptDeclaration("
			// start the moment the document is ready
			jQuery(document).ready(function () {
				// just get the available libraries
				getLibraries(snippetsPath);
			});
			
			// add an ajax call tracker
			var ajaxcall = null;
			var fromLocal = false;
			
			jQuery(document).ready(function(){
				jQuery('body').on('click','.getreaction',function(){
					// Ajax request
					var btn = jQuery(this);
					btn.prop('disabled', true);
					setTimeout(function(){
						btn.prop('disabled', false);
					}, 3000);
					var type = btn.data('type');
					if ('getLibraries' === type) {
						getLibraries(snippetsPath);
					} else if ('getSnippets' === type) {
						var name = btn.data('name');
						getSnippets(snippetsPath, name);
					} else if ('all' === type) {
						var status = btn.data('status');
						bulkSnippetGithub(status);
					} else if ('bulk' === type) {
						checkBulkSnippetGithub();
					} else if ('get' === type) {
						var path = btn.data('path');
						var status = btn.data('status');
						setSnippetGithub(path, status);
					} else {
						var path = btn.data('path');
						getSnippetModal(path, type);
					}
				});
			});
			
			// load every thing once ready
			jQuery(document).ajaxStop(function () {
				if (0 === jQuery.active) {
					//do something special
					if ('snippets' === ajaxcall) {
						setTimeout( function() {
							jQuery('#snippets-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY_SNIPPETS')+'</h1>');
							jQuery('#snippets-display').show();
							jQuery('#snippets-grid').trigger('display.uk.check');
							jQuery('#loading').hide();
						}, 1000);
					} 
				}
			});
			
			// get the libraries
			function getLibraries(path) {
				var _paths = jQuery.jStorage.get('JCB-Snippets-Paths', null);
				// always hide the snippets display
				jQuery('#snippets-display').hide();
				// always reset the grid
				jQuery('#libraries-grid').html('');
				// set the ajax scope
				ajaxcall = 'libraries';
				if (_paths) {
					buildLibraries(_paths);
				} else {
					jQuery.get(path)
					.success(function(paths) {
						// load only this library paths
						jQuery.jStorage.set('JCB-Snippets-Paths', paths, {TTL: expire});
						buildLibraries(paths);
					})
					.error(function(jqXHR, textStatus, errorThrown) { 
						jQuery('#snippets-github').html(returnError);
					});
				}
			}
			
			// build the ibraries object
			function buildLibraries(paths) {
				var _temp = jQuery.jStorage.get('JCB-Libraries', null);
				if (_temp) {
					setLibraries(_temp);
				} else {
					var temp = {};
					jQuery.each(paths.tree, function(key,value) {
						if (value.path.match(\".json$\")) {
							var libName = value.path.split(/ -(.+)/)[0];
							libName = libName.trim()
							temp[libName] = libName;
						}
					});
					// load only this library paths
					jQuery.jStorage.set('JCB-Libraries', temp, {TTL: expire});
					setLibraries(temp);
				}
			}
			
			// set the libraries
			function setLibraries(names) {
				// now load the lib buttons
				jQuery.each(names, function(value) {
					setLibrary(value);
				});
				setTimeout( function() {
					jQuery('#snippets-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_AVAILABLE_LIBRARIES')+'</h1>');
					jQuery('#libraries-display').show();
					jQuery('#libraries-grid').trigger('display.uk.check');
				}, 1000);
			}
			
			// set the snippets
			function setLibrary(name) {
				// get useful ID
				var keyID = getKeyID(name);
				// build the library display
				var html = '<div id=\"'+keyID+'-panel\" class=\"uk-panel\">';
				html += '<div class=\"uk-panel uk-panel-box uk-width-1-1\">';
				html += '<h3 class=\"uk-panel-title\">' + name + '</h3>';
				html += '<hr />';
				// set the data buttons
				html += setLibButtons(name);
				// close the box panel
				html += '</div>';
				html += '</div>';
				// now we have the library
				jQuery('#libraries-grid').append(html);
			}
			
			function setLibButtons(name) {
				return  '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-1 getreaction\" data-name=\"'+name+'\" data-type=\"getSnippets\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION')+'\"><i class=\"uk-icon-thumb-tack\"></i><span class=\"uk-hidden-small\"> '+Joomla.JText._('COM_COMPONENTBUILDER_OPEN_LIBRARY_SNIPPETS')+'</span></button>';
			}
			
			// get the snippets
			function getSnippets(path, libraryName) {
				jQuery('#loading').show();
				// get local values if set
				var _paths = jQuery.jStorage.get('JCB-Snippets-Paths', null);
				// always reset the grid
				jQuery('#snippets-grid').html('');
				// always hide libraries
				jQuery('#libraries-display').hide();
				// set the ajax scope
				ajaxcall = 'snippets';
				fromLocal = false;
				if (_paths) {
					setSnippets(_paths, libraryName);
					jQuery('#snippets-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY_SNIPPETS')+'</h1>');
				} else {
					jQuery.get(path)
					.success(function(paths) {
						// load only this library paths
						jQuery.jStorage.set('JCB-Snippets-Paths', paths, {TTL: expire});
						setSnippets(paths, libraryName);
					})
					.error(function(jqXHR, textStatus, errorThrown) { 
						jQuery('#snippets-github').html(returnError);
					});
				}
				// only use if loading localy
				if (fromLocal) {
					jQuery('#snippets-display').show();
					jQuery('#snippets-grid').trigger('display.uk.check');
					jQuery('#loading').hide();
				}
			}
			
			// set the snippets
			function setSnippets(paths, libraryName) {
				// set the ajax scope
				ajaxcall = 'snippets';
				jQuery.each(paths.tree, function(key,value) {
					if (value.path.match(\".json$\") && value.path.match(\"^\"+libraryName)) {
						var _snippet = jQuery.jStorage.get(value.path, null);
						if (_snippet) {
							setSnippet(_snippet, value.path);
							fromLocal = true;
						} else {
							jQuery.get(snippetPath+value.path)
							.success(function(snippet) {
								// convert the string to json.object
								snippet = jQuery.parseJSON(snippet);
								jQuery.jStorage.set(value.path, snippet, {TTL: expire});
								setSnippet(snippet, value.path);
							})
							.error(function(jqXHR, textStatus, errorThrown) { 
								// we could do more
							});
						}
					}
				});
			}
			
			// set the snippets
			function setSnippet(snippet, key) {
				// get useful ID
				var keyID = getKeyID(key);
				// get the status
				var status = getSnippetStatus(snippet, key);
				// add to bulk updater
				if ('equal' !== status) {
					bulkItems[status].push(key);
				}
				// build the snippet display
				var html = '<div id=\"'+keyID+'-panel\" class=\"uk-panel\" data-uk-filter=\"'+status+'\" data-snippet-libraries=\"'+snippet.library+'\" data-snippet-types=\"'+snippet.type+'\" data-snippet-name=\"'+snippet.name+'\">';
				html += '<div class=\"uk-panel uk-panel-box uk-width-1-1\">';
				html += '<div class=\"uk-panel-badge uk-badge\" ><a id=\"'+keyID+'-badge\" href=\"#'+status+'-meaning\" data-uk-offcanvas class=\"uk-text-uppercase uk-text-contrast\"><i class=\"uk-icon-info\"></i> '+status+'</a></div><br />';
				html += '<h3 class=\"uk-panel-title\">' + snippet.library+ ' - (' + snippet.type + ') ' + snippet.name + '</h3>';
				html += snippet.heading + '<hr />';
				// set the data buttons
				html += setDataButtons(snippet, key, status);
				// set the snippet ref button
				html += setRefButtons(snippet, key, status, keyID);
				// set the contributor buttons
				html += setContributorButtons(snippet, key);
				// close the box panel
				html += '</div>';
				html += '</div>';
				// now we have the snippet
				jQuery('#snippets-grid').append(html);
			}
			
			// set the snippet status
			function getSnippetStatus(snippet, key) {
				// check if JCB already has this snippet
				if(local_snippets.hasOwnProperty(key)){
					// first get local time stamp
					var local_created = strtotime(local_snippets[key].created);
					var local_modified = strtotime(local_snippets[key].modified);
					// now get github time stamps					
					var created = strtotime(snippet.created);
					var modified = strtotime(snippet.modified);
					// work out the status
					if (local_created == created) {
						if (local_modified == modified) {
							return 'equal';
						} else if (local_modified > modified) {
							return 'ahead';
						} else if (local_modified < modified) {
							return 'behind';
						}
					}
					return 'diverged';
				}
				return 'new';
			}
			
			function setDataButtons(snippet, key, status) {
				var html = '<div class=\"uk-button-group uk-width-1-1 uk-margin-small-bottom\">';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"usage\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION')+'\"><i class=\"uk-icon-info\"></i><span class=\"uk-hidden-small\"> '+Joomla.JText._('COM_COMPONENTBUILDER_USAGE')+'</span></button>';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"description\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION')+'\"><i class=\"uk-icon-sticky-note-o\"></i><span class=\"uk-hidden-small\"> '+Joomla.JText._('COM_COMPONENTBUILDER_DESCRIPTION')+'</span></button>';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"snippet\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_SNIPPET_OF_COMMUNITY_VERSION')+'\"><i class=\"uk-icon-code\"></i><span class=\"uk-hidden-small\"> '+Joomla.JText._('COM_COMPONENTBUILDER_SNIPPET')+'</span></button>';
				html += '</div>';
				// return data buttons
				return html;
			}
			
			function setRefButtons(snippet, key, status, keyID) {
				var html = '<div><a class=\"uk-button uk-button-mini uk-button-success uk-margin-small-bottom uk-width-1-1\" href=\"'+snippet.url+'\" target=\"_blank\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_SNIPPET_REFERENCE_URL')+'\"><i class=\"uk-icon-external-link\"></i> ' + snippet.name + '</a></div>';
				// set the update button	
				html += '<div>';
				if ('equal' !== status) {
					if ('new' === status) {
						var tooltip = Joomla.JText._('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
					} else {
						var tooltip = Joomla.JText._('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
					}
					html += '<button id=\"'+keyID+'-getbutton\" class=\"uk-button uk-button-small uk-button-primary uk-width-1-1 uk-margin-small-bottom getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"get\"  title=\"'+tooltip+'\"><i class=\"uk-icon-cloud-download\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_GET_SNIPPET')+'</button>';
				} else {
					html += '<button class=\"uk-button uk-button-small uk-width-1-1 uk-margin-small-bottom\" type=\"button\" disabled title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION')+'\"><i class=\"uk-icon-check-square-o\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_LOCAL_SNIPPET')+'</button>';
				}
				html += '</div>';
				// return data buttons
				return html;
			}
			
			function setContributorButtons(snippet, key) {
				// set the contributor name
				if (snippet.contributor_company) {
					var contributor_name = snippet.contributor_company;
				} else if (snippet.contributor_name) {
					var contributor_name = snippet.contributor_name;
				} else {
					var contributor_name = Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY');
				}
				// set the contributor url
				if (snippet.contributor_website) {
					var contributor_url = snippet.contributor_website;
				} else if (snippet.contributor_email) {
					var contributor_url = 'mailto:'+snippet.contributor_email;
				} else {
					var contributor_url = 'https://github.com/vdm-io/Joomla-Component-Builder-Snippets';
				}
				var html = '<div class=\"uk-button-group uk-width-1-1\">';
				html += '<button class=\"uk-button uk-button-primary uk-width-1-10 uk-button-mini getreaction\" data-type=\"contributor\" data-path=\"'+key+'\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS')+'\"><i class=\"uk-icon-user\"></i></button>';
				html += '<a  class=\"uk-button uk-button-primary uk-width-5-10 uk-button-mini\" href=\"'+contributor_url+'\" target=\"_blank\"  title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR')+'\"><i class=\"uk-icon-external-link\"></i> ' + contributor_name + '</a>';
				html += '<a class=\"uk-button uk-button-primary uk-width-4-10 uk-button-mini\" href=\"https://github.com/vdm-io/Joomla-Component-Builder-Snippets/blame/master/'+key+'\" target=\"_blank\" title=\"'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_SNIPPET')+'\"><i class=\"uk-icon-external-link\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_BLAME')+'</a>';
				html += '</div>';
				// return contributor buttons
				return html;
			}
			
			// do a bulk update
			function checkBulkSnippetGithub() {
				// check if there is new items
				if (bulkItems.new.length === 0) {
					jQuery('#bulk-button-new').prop('disabled', true);
					jQuery('#bulk-button-new').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_SNIPPETS_AT_THIS_TIME'));
					jQuery('#bulk-notice-new').show();
				}
				// check if there is diverged items
				if (bulkItems.diverged.length === 0) {
					jQuery('#bulk-button-diverged').prop('disabled', true);
					jQuery('#bulk-button-diverged').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_SNIPPETS_AT_THIS_TIME'));
					jQuery('#bulk-notice-diverged').show();
				}
				// check if there is ahead items
				if (bulkItems.ahead.length === 0) {
					jQuery('#bulk-button-ahead').prop('disabled', true);
					jQuery('#bulk-button-ahead').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_SNIPPETS_AT_THIS_TIME'));
					jQuery('#bulk-notice-ahead').show();
				}
				// check if there is behind items
				if (bulkItems.behind.length === 0) {
					jQuery('#bulk-button-behind').prop('disabled', true);
					jQuery('#bulk-button-behind').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_SNIPPETS_AT_THIS_TIME'));
					jQuery('#bulk-notice-behind').show();
				}
				// check if all we should close the all button
				if (bulkItems.behind.length === 0 && bulkItems.new.length === 0 && bulkItems.ahead.length === 0 && bulkItems.diverged.length === 0) {
					jQuery('#bulk-button-all').prop('disabled', true);
					jQuery('#bulk-button-all').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_SNIPPETS_TO_UPDATE_AT_THIS_TIME'));
					jQuery('#bulk-notice-all').show();
				}
			}
			
			// do a bulk update
			function bulkSnippetGithub(status) {
				// if all then trigger those with values
				if ('all' === status) {
					bulkSnippetGithub('behind');
					bulkSnippetGithub('new');
					bulkSnippetGithub('ahead');
					bulkSnippetGithub('diverged');
				} else if (bulkItems[status].length > 0) {
					jQuery.each(bulkItems[status], function(i, key){
						setTimeout(function(){
							doBulkUpdate_server(key, status).done(function(result) {
								if (result.message) {
									// only show errors
									if ('error' === result.status || 'warning' === result.status) {
										UIkit.notify(result.message, {status: result.status});
									}
									// update local items
									if ('success' === result.status) {
										// get key ID
										var keyID = getKeyID(key);
										// update snippet if we can
										updateSnippetDisplay(keyID, 'equal');
									}
								} else {
									UIkit.notify(Joomla.JText._('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED'), {status:'danger'});
								}
							});
						}, 200);
					});
					// reset array
					bulkItems[status].length = 0;
					// update the buttons (since we only do the bulk update once)
					checkBulkSnippetGithub();
				}
			}
			
			function doBulkUpdate_server(path, status) {
				// set the ajax scope
				ajaxcall = null;
				var getUrl = \"index.php?option=com_componentbuilder&task=ajax.setSnippetGithub&format=json\";
				if (token.length > 0 && path.length > 0 && status.length > 0) {
					var request = 'token='+token+'&path='+path+'&status='+status;
				}
				return jQuery.ajax({
					type: 'POST',
					url: getUrl,
					dataType: 'jsonp',
					data: request,
					jsonp: 'callback'
				});
			}
			
			// set the snippet from gitHub
			function setSnippetGithub(key, status) {
				var message = getConfirmUpdate(status);
				UIkit.modal.confirm(message, function(){
					// will be executed on confirm.
					setSnippetGithub_server(key, status).done(function(result) {
						if (result.message) {
							UIkit.notify(result.message, {status: result.status});
							if ('success' === result.status) {
								// get key ID
								var keyID = getKeyID(key);
								// update snippet if we can
								updateSnippetDisplay(keyID, 'equal');
							}
						} else {
							UIkit.notify(Joomla.JText._('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED'), {status:'danger'});
						}
					});
				});
			}
			
			function setSnippetGithub_server(path, status) {
				// set the ajax scope
				ajaxcall = null;
				var getUrl = \"index.php?option=com_componentbuilder&task=ajax.setSnippetGithub&format=json\";
				if (token.length > 0 && path.length > 0 && status.length > 0) {
					var request = 'token='+token+'&path='+path+'&status='+status;
				}
				return jQuery.ajax({
					type: 'POST',
					url: getUrl,
					dataType: 'jsonp',
					data: request,
					jsonp: 'callback'
				});
			}
			
			// update the snippet display
			function updateSnippetDisplay(keyID, status) {
				// update badge
				jQuery('#'+keyID+'-badge').html('<i class=\"uk-icon-info\"></i> ' +status);
				jQuery('#'+keyID+'-badge').attr('href' , '#'+status+'-meaning');
				// update button
				if ('equal' === status) {
					// update notice
					jQuery('#'+keyID+'-getbutton').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION'));
					jQuery('#'+keyID+'-getbutton').prop('disabled', true);
					jQuery('#'+keyID+'-getbutton').html('<i class=\"uk-icon-check-square-o\"></i> ' + Joomla.JText._('COM_COMPONENTBUILDER_LOCAL_SNIPPET'));
					// counter delay just incase
					setTimeout(function(){
						jQuery('#'+keyID+'-getbutton').prop('disabled', true);
					}, 2000);
				}
				// update the data filter
				jQuery('#'+keyID+'-panel').attr('data-uk-filter', status);
				// tell the grid to update
				jQuery('#snippets-grid').trigger('display.uk.check');
			}
			
			// set the modal
			function getSnippetModal(key, type) {
				// set the ajax scope
				ajaxcall = 'snippets';
				var _snippet = jQuery.jStorage.get(key, null);
				if (_snippet) {
					// show modal
					showSnippetModal(_snippet, type);
				} else {
					jQuery.get('https://raw.githubusercontent.com/vdm-io/Joomla-Component-Builder-Snippets/master/'+key)
					.success(function(snippet) {
						// convert the string to json.object
						snippet = jQuery.parseJSON(snippet);
						jQuery.jStorage.set(key, snippet, {TTL: expire});
						// show modal
						showSnippetModal(snippet, type);
					})
					.error(function(jqXHR, textStatus, errorThrown) { 
						// we could do more
					});
				}
			}
			
			// show the modal
			function showSnippetModal(snippet, type) {
				var html = '<div class=\"uk-modal-dialog uk-modal-dialog-lightbox\">';
				html += '<a href=\"\" class=\"uk-modal-close uk-close uk-close-alt\"></a>';
				html += '<h3>' + snippet.library + ' - (' + snippet.type + ') ' + snippet.name + '</h3>';
				if ('contributor' === type) {
					html += '<dl class=\"uk-description-list-line\">';
					html += '<dt><i class=\"uk-icon-institution\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_COMPANY_NAME')+'</dt>';
					html += '<dd>'+snippet.contributor_company+'</dd>';
					html += '<dt><i class=\"uk-icon-user\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_NAME')+'</dt>';
					html += '<dd>'+snippet.contributor_name+'</dd>';
					html += '<dt><i class=\"uk-icon-envelope-o\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_EMAIL')+'</dt>';
					html += '<dd>'+snippet.contributor_email+'</dd>';
					html += '<dt><i class=\"uk-icon-laptop\"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_WEBSITE')+'</dt>';
					html += '<dd>'+snippet.contributor_website+'</dd>';
					html += '</dl>';
				} else {
					html += '<br /><textarea class=\"uk-width-1-1\" rows=\"15\" readonly>'+snippet[type]+'</textarea>';
				}
				html += '<br /><small>C: ' + snippet.created + ' | M: ' + snippet.modified + '</small>';
				html += '</div>';
				// get current page position
				var scroll = jQuery(window).scrollTop();
				// add html to modal
				var modal = UIkit.modal.blockUI(html, {center:true, bgclose:true}).on({
					'hide.uk.modal': function(){
						// scroll fix since the modal pops to the top of the page
						jQuery(window).scrollTop(scroll);
					}
				});
				// show modal
				modal.show();
			}
			
			// get key ID
			function getKeyID(key) {
				// get useful ID
				var keyID = key.replace('-', '');
				keyID = keyID.replace('.json', '');
				keyID = keyID.replace(/\s+/ig, '-');
				keyID = keyID.replace(/\(/g, '');
				keyID = keyID.replace(/\)/g, '');
				// return the id build
				return keyID;
			}
		");
        }

	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// hide the main menu
                $this->app->input->set('hidemainmenu', true);
		// add title to the page
		JToolbarHelper::title(JText::_('COM_COMPONENTBUILDER_GET_SNIPPETS'),'search');
                // add the back button
                // JToolBarHelper::custom('get_snippets.back', 'undo-2', '', 'COM_COMPONENTBUILDER_BACK', false);
                // add cpanel button
		JToolBarHelper::custom('get_snippets.dashboard', 'grid-2', '', 'COM_COMPONENTBUILDER_DASH', false);
		if ($this->canDo->get('get_snippets.custom_admin_views'))
		{
			// add Custom Admin Views button.
			JToolBarHelper::custom('get_snippets.openCustomAdminViews', 'screen', '', 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.site_views'))
		{
			// add Site Views button.
			JToolBarHelper::custom('get_snippets.openSiteViews', 'palette', '', 'COM_COMPONENTBUILDER_SITE_VIEWS', false);
		}
		if ($this->canDo->get('get_snippets.templates'))
		{
			// add Templates button.
			JToolBarHelper::custom('get_snippets.openTemplates', 'brush', '', 'COM_COMPONENTBUILDER_TEMPLATES', false);
		}
		if ($this->canDo->get('get_snippets.layouts'))
		{
			// add Layouts button.
			JToolBarHelper::custom('get_snippets.openLayouts', 'brush', '', 'COM_COMPONENTBUILDER_LAYOUTS', false);
		}
		if ($this->canDo->get('get_snippets.snippets'))
		{
			// add Snippets button.
			JToolBarHelper::custom('get_snippets.openSnippets', 'pin', '', 'COM_COMPONENTBUILDER_SNIPPETS', false);
		}
		if ($this->canDo->get('get_snippets.libraries'))
		{
			// add Libraries button.
			JToolBarHelper::custom('get_snippets.openLibraries', 'puzzle', '', 'COM_COMPONENTBUILDER_LIBRARIES', false);
		}

		// set help url for this view if found
                $help_url = ComponentbuilderHelper::getHelpUrl('get_snippets');
                if (ComponentbuilderHelper::checkString($help_url))
                {
                        JToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $help_url);
                }

                // add the options comp button
                if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			JToolBarHelper::preferences('com_componentbuilder');
		}
	}

        /**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
                // use the helper htmlEscape method instead.
		return ComponentbuilderHelper::htmlEscape($var, $this->_charset);
	}
}
