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
			$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit/css/uikit'.$style.$size.'.css');
		}
		// The uikit js.
		if ((!$HeaderCheck->js_loaded('uikit.min') || $uikit == 1) && $uikit != 2 && $uikit != 3)
		{
			$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit/js/uikit'.$size.'.js');
		}

		// Load the script to find all uikit components needed.
		if ($uikit != 2)
		{
			// Set the default uikit components in this view.
			$uikitComp = array();
			$uikitComp[] = 'UIkit.notify';
			$uikitComp[] = 'data-uk-tooltip';
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
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit/css/components/'.$name.$style.$size.'.css'))
					{
						// load the css.
						$this->document->addStyleSheet(JURI::root(true) .'/media/com_componentbuilder/uikit/css/components/'.$name.$style.$size.'.css');
					}
					// check if the JavaScript file exists.
					if (JFile::exists(JPATH_ROOT.'/media/com_componentbuilder/uikit/js/components/'.$name.$size.'.js'))
					{
						// load the js.
						$this->document->addScript(JURI::root(true) .'/media/com_componentbuilder/uikit/js/components/'.$name.$size.'.js', 'text/javascript', true);
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
			$expire = 30000;
		}
		// token
		$this->document->addScriptDeclaration("var token = '". JSession::getFormToken() ."';");
		// set an error message if needed
		$this->document->addScriptDeclaration("var returnError = '<div class=\"uk-alert uk-alert-warning\"><h1>".JText::_('COM_COMPONENTBUILDER_AN_ERROR_HAS_OCCURRED')."!</h1><p>".JText::_('COM_COMPONENTBUILDER_PLEASE_TRY_AGAIN_LATER').".</p></div>';");
		// need to add some language strings
		$this->document->addScriptDeclaration("var lang_Snippets = '".JText::_('COM_COMPONENTBUILDER_SNIPPETS')."';");
		$this->document->addScriptDeclaration("var lang_Snippet = '".JText::_('COM_COMPONENTBUILDER_SNIPPET')."';");
		$this->document->addScriptDeclaration("var lang_Snippet_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_SNIPPET_OF_COMMUNITY_VERSION')."';");
		$this->document->addScriptDeclaration("var lang_Get_Snippet = '".JText::_('COM_COMPONENTBUILDER_GET_SNIPPET')."';");
		$this->document->addScriptDeclaration("var lang_Get_Snippet_Tooltip = '".JText::_('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION')."';");
		$this->document->addScriptDeclaration("var lang_Get_Snippet_New_Tooltip = '".JText::_('COM_COMPONENTBUILDER_GET_THE_SNIPPET_FROM_GITHUB_AND_INSTALL_IT_LOCALLY')."';");
		$this->document->addScriptDeclaration("var lang_Get_Snippet_Dont_Tooltip = '".JText::_('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION')."';");
		$this->document->addScriptDeclaration("var lang_Usage = '".JText::_('COM_COMPONENTBUILDER_USAGE')."';");
		$this->document->addScriptDeclaration("var lang_Usage_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION')."';");
		$this->document->addScriptDeclaration("var lang_Description = '".JText::_('COM_COMPONENTBUILDER_DESCRIPTION')."';");
		$this->document->addScriptDeclaration("var lang_Description_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION')."';");
		$this->document->addScriptDeclaration("var lang_View_Blame = '".JText::_('COM_COMPONENTBUILDER_VIEW_BLAME')."';");
		$this->document->addScriptDeclaration("var lang_View_Blame_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_SNIPPET')."';");
		$this->document->addScriptDeclaration("var lang_URL_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_SNIPPET_REFERENCE_URL')."';");
		$this->document->addScriptDeclaration("var lang_Update_Error_Tooltip = '".JText::_('COM_COMPONENTBUILDER_SNIPPET_COULD_NOT_BE_UPDATEDSAVED')."';");
		$this->document->addScriptDeclaration("var lang_Contributor_URL_Tooltip = '".JText::_('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR')."';");
		$this->document->addScriptDeclaration("var lang_Contributor_Modal_Tooltip = '".JText::_('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS')."';");
		$this->document->addScriptDeclaration("var lang_JCB_Community = '".JText::_('COM_COMPONENTBUILDER_JCB_COMMUNITY')."';");
		$this->document->addScriptDeclaration("var lang_Company_Name = '".JText::_('COM_COMPONENTBUILDER_COMPANY_NAME')."';");
		$this->document->addScriptDeclaration("var lang_Author_Name = '".JText::_('COM_COMPONENTBUILDER_AUTHOR_NAME')."';");
		$this->document->addScriptDeclaration("var lang_Author_Email = '".JText::_('COM_COMPONENTBUILDER_AUTHOR_EMAIL')."';");
		$this->document->addScriptDeclaration("var lang_Author_Website = '".JText::_('COM_COMPONENTBUILDER_AUTHOR_WEBSITE')."';");
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
				getSnippets('https://api.github.com/repos/vdm-io/Joomla-Component-Builder-Snippets/git/trees/master');
			});
			jQuery(document).ready(function(){
				jQuery('body').on('click','.getreaction',function(){
					// Ajax request
					var btn = jQuery(this);
					btn.prop('disabled', true);
					setTimeout(function(){
						btn.prop('disabled', false);
					}, 3000);
					var path = btn.data('path');
					var type = btn.data('type');
					if ('get' === type) {
						var status = btn.data('status');
						setSnippetGithub(path, status);
					} else {
						getSnippetModal(path, type);
					}
				});
			});
			// load every thing once ready
			jQuery(document).ajaxStop(function () {
				if (0 === jQuery.active) {
					setTimeout( function() {
						//do something special
						jQuery('#snippets-github').html('<h1>'+lang_Snippets+'</h1>');
						jQuery('#snippets-display').show();
						jQuery('#snippets-grid').trigger('display.uk.check');
					}, 1000);
				}
			});
			
			// get unix time stamp
			function unixTimeStamp(_theDate) {
				// check if JCB already has this snippet
				var aDate = new Date(_theDate);
				return Math.round(aDate.getTime()/1000);
			}
			
			// set the snippet status
			function getSnippetStatus(snippet, key) {
				// check if JCB already has this snippet
				if(local_snippets.hasOwnProperty(key)){
					// first get local time stamp
					var local_created = unixTimeStamp(local_snippets[key].created);
					var local_modified = unixTimeStamp(local_snippets[key].modified);
					// now get github time stamps					
					var created = unixTimeStamp(snippet.created);
					var modified = unixTimeStamp(snippet.modified);
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
			
			// get the snippets
			function getSnippets(path) {
				var _paths = jQuery.jStorage.get('JCB-Snippets-Paths', null);
				if (_paths) {
					setSnippets(_paths);
					jQuery('#snippets-github').html('<h1>'+lang_Snippets+'</h1>');
					jQuery('#snippets-display').show();
				} else {
					jQuery.get(path)
					.success(function(paths) {
						jQuery.jStorage.set('JCB-Snippets-Paths', paths, {TTL: expire});
						setSnippets(paths);
					})
					.error(function(jqXHR, textStatus, errorThrown) { 
						jQuery('#snippets-github').html(returnError);
					});
				}
			}
			
			// set the snippets
			function setSnippets(paths) {
				jQuery.each(paths.tree, function(key,value){
					if (value.path.indexOf('.json') >= 0) {
						var _snippet = jQuery.jStorage.get(value.path, null);
						if (_snippet) {
							setSnippet(_snippet, value.path);
							jQuery('#snippets-grid').trigger('display.uk.check');
						} else {
							jQuery.get('https://raw.githubusercontent.com/vdm-io/Joomla-Component-Builder-Snippets/master/'+value.path)
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
				// build the snippet display
				var html = '<div id=\"'+keyID+'-panel\" class=\"uk-panel\" data-uk-filter=\"'+status+'\" data-snippet-libraries=\"'+snippet.library+'\" data-snippet-types=\"'+snippet.type+'\" data-snippet-name=\"'+snippet.name+'\">';
				html += '<div class=\"uk-panel uk-panel-box uk-width-1-1\">';
				html += '<div id=\"'+keyID+'-badge\" class=\"uk-panel-badge uk-badge\">'+status+'</div><br />';
				html += '<h3 class=\"uk-panel-title\">' + snippet.library+ ' - (' + snippet.type + ') ' + snippet.name + '</h3>';
				html += snippet.heading + '<hr />';
				// set the data buttons
				html += setDataButtons(snippet, key, status)
				// set the snippet ref button
				html += setRefButtons(snippet, key, status, keyID)
				// set the contributor buttons
				html += setContributorButtons(snippet, key);
				// close the box panel
				html += '</div>';
				html += '</div>';
				// now we have the snippet
				jQuery('#snippets-grid').append(html);
			}
			
			function setDataButtons(snippet, key, status) {
				var html = '<div class=\"uk-button-group uk-width-1-1 uk-margin-small-bottom\">';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"usage\" data-uk-tooltip title=\"'+lang_Usage_Tooltip+'\"><i class=\"uk-icon-info\"></i> '+lang_Usage+'</button>';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"description\" data-uk-tooltip title=\"'+lang_Description_Tooltip+'\"><i class=\"uk-icon-sticky-note-o\"></i> '+lang_Description+'</button>';
				html += '<button class=\"uk-button uk-button-small uk-button-success uk-width-1-3 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"snippet\" data-uk-tooltip title=\"'+lang_Snippet_Tooltip+'\"><i class=\"uk-icon-code\"></i> '+lang_Snippet+'</button>';
				html += '</div>';
				// return data buttons
				return html;
			}
			
			function setRefButtons(snippet, key, status, keyID) {
				var html = '<div><a class=\"uk-button uk-button-mini uk-button-success uk-margin-small-bottom uk-width-1-1\" href=\"'+snippet.url+'\" target=\"_blank\" data-uk-tooltip title=\"'+lang_URL_Tooltip+'\"><i class=\"uk-icon-external-link\"></i> ' + snippet.name + '</a></div>';
				// set the update and review button
				html += '<div class=\"uk-button-group uk-width-1-1 uk-margin-small-bottom\">';
				html += '<a class=\"uk-button uk-button-small uk-button-primary uk-width-1-2\" href=\"https://github.com/vdm-io/Joomla-Component-Builder-Snippets/blame/master/'+key+'\" target=\"_blank\" data-uk-tooltip title=\"'+lang_View_Blame_Tooltip+'\"><i class=\"uk-icon-external-link\"></i> '+lang_View_Blame+'</a>';
				if ('equal' !== status) {
					if ('new' === status) {
						var tooltip = lang_Get_Snippet_New_Tooltip;
					} else {
						var tooltip = lang_Get_Snippet_Tooltip;
					}
					html += '<button id=\"'+keyID+'-getbutton\" class=\"uk-button uk-button-small uk-button-primary uk-width-1-2 getreaction\" data-status=\"'+status+'\" data-path=\"'+key+'\" data-type=\"get\"  data-uk-tooltip title=\"'+tooltip+'\"><i class=\"uk-icon-cloud-download\"></i> '+lang_Get_Snippet+'</button>';
				} else {
					html += '<button class=\"uk-button uk-button-small uk-width-1-2\" type=\"button\" disabled data-uk-tooltip title=\"'+lang_Get_Snippet_Dont_Tooltip+'\"><i class=\"uk-icon-cloud-download\"></i> '+lang_Get_Snippet+'</button>';
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
					var contributor_name = lang_JCB_Community;
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
				html += '<button class=\"uk-button uk-width-1-5 uk-button-mini getreaction\" data-type=\"contributor\" data-path=\"'+key+'\" data-uk-tooltip title=\"'+lang_Contributor_Modal_Tooltip+'\"><i class=\"uk-icon-user\"></i></button>';
				html += '<a  class=\"uk-button uk-width-4-5 uk-button-mini\" href=\"'+contributor_url+'\" target=\"_blank\"  data-uk-tooltip title=\"'+lang_Contributor_URL_Tooltip+'\"><i class=\"uk-icon-external-link\"></i> ' + contributor_name + '</a>';
				html += '</div>';
				// return contributor buttons
				return html;
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
							UIkit.notify(lang_Update_Error_Tooltip, {status:'danger'});
						}
					});
				});
			}
			
			function setSnippetGithub_server(path, status) {
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
				jQuery('#'+keyID+'-badge').html(status);
				// update button
				if ('equal' === status) {
					// update notice
					jQuery('#'+keyID+'-getbutton').attr('title', lang_Get_Snippet_Dont_Tooltip);
					jQuery('#'+keyID+'-getbutton').prop('disabled', true);
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
					html += '<dt><i class=\"uk-icon-institution\"></i> '+lang_Company_Name+'</dt>';
					html += '<dd>'+snippet.contributor_company+'</dd>';
					html += '<dt><i class=\"uk-icon-user\"></i> '+lang_Author_Name+'</dt>';
					html += '<dd>'+snippet.contributor_name+'</dd>';
					html += '<dt><i class=\"uk-icon-envelope-o\"></i> '+lang_Author_Email+'</dt>';
					html += '<dd>'+snippet.contributor_email+'</dd>';
					html += '<dt><i class=\"uk-icon-laptop\"></i> '+lang_Author_Website+'</dt>';
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
				keyID = key.replace('-', '');
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
		if ($this->canDo->get('get_snippets.snippets'))
		{
			// add Snippets button.
			JToolBarHelper::custom('get_snippets.openSnippets', 'pin', '', 'COM_COMPONENTBUILDER_SNIPPETS', false);
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
