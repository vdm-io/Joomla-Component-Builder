/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

/* JS Document */

var noticeboard = "https://vdm.bz/componentbuilder-noticeboard-md";
var proboard = "https://vdm.bz/componentbuilder-pro-noticeboard-md";
jQuery(document).ready(function () {
	jQuery.get(noticeboard)
	.success(function(board) { 
		if (board.length > 5) {
			jQuery("#noticeboard-md").html(marked(board));
			getIS(1,board).done(function(result) {
				if (result){
					jQuery("#vdm-new-notice").show();
					getIS(2,board);
				}
			});
		} else {
			jQuery("#noticeboard-md").html(all_is_good);
		}
	})
	.error(function(jqXHR, textStatus, errorThrown) { 
		jQuery("#noticeboard-md").html(all_is_good);
	});
	jQuery.get(proboard)
	.success(function(board) { 
		if (board.length > 5) {
			jQuery("#proboard-md").html(marked(board));
		} else {
			jQuery("#proboard-md").html(all_is_good);
		}
	})
	.error(function(jqXHR, textStatus, errorThrown) { 
		jQuery("#proboard-md").html(all_is_good);
	});
});
// to check is READ/NEW
function getIS(type,notice){
	if (type == 1) {
		var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.isNew&format=json&raw=true");
	} else if (type == 2) {
		var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.isRead&format=json&raw=true");
	}	
	if(token.length > 0 && notice.length){
		var request = token+"=1&notice="+notice;
	}
	return jQuery.ajax({
		type: "POST",
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}


// start the moment the document is ready
jQuery(document).ready(function () {
	// just get the available categories
	getCategories(plansPath);
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
		if ('getCategories' === type) {
			getCategories(plansPath);
		} else if ('getPlans' === type) {
			var name = btn.data('name');
			getPlans(plansPath, name);
		} else if ('all' === type) {
			var status = btn.data('status');
			bulkPlanGithub(status);
		} else if ('bulk' === type) {
			checkBulkPlanGithub();
		} else if ('get' === type) {
			var path = btn.data('path');
			var status = btn.data('status');
			setPlanGithub(path, status);
		} else {
			var path = btn.data('path');
			getPlanModal(path, type);
		}
	});
});

// load every thing once ready
jQuery(document).ajaxStop(function () {
	if (0 === jQuery.active) {
		//do something special
		if ('plans' === ajaxcall) {
			setTimeout( function() {
				jQuery('#plans-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY_PLANS')+'</h1>');
				jQuery('#plans-display').show();
				jQuery('#plans-grid').trigger('display.uk.check');
				jQuery('#loading').hide();
			}, 1000);
		} 
	}
});

// get the categories
function getCategories(path) {
	var _paths = jQuery.jStorage.get('JCB-Plans-Paths', null);
	// always hide the plans display
	jQuery('#plans-display').hide();
	// always reset the grid
	jQuery('#categories-grid').html('');
	// set the ajax scope
	ajaxcall = 'categories';
	if (_paths) {
		buildCategories(_paths);
	} else {
		jQuery.get(path)
		.success(function(paths) {
			// load only this category paths
			jQuery.jStorage.set('JCB-Plans-Paths', paths, {TTL: expire});
			buildCategories(paths);
		})
		.error(function(jqXHR, textStatus, errorThrown) { 
			jQuery('#plans-github').html(returnError);
		});
	}
}

// build the ibraries object
function buildCategories(paths) {
	var _temp = jQuery.jStorage.get('JCB-Categories', null);
	if (_temp) {
		setCategories(_temp);
	} else {
		var temp = {};
		jQuery.each(paths.tree, function(key,value) {
			if (value.path.match(".json$")) {
				var categoryName = value.path.split(/ -(.+)/)[0];
				categoryName = categoryName.trim()
				temp[categoryName] = categoryName;
			}
		});
		// load only this category paths
		jQuery.jStorage.set('JCB-Categories', temp, {TTL: expire});
		setCategories(temp);
	}
}

// set the categories
function setCategories(names) {
	// now load the category buttons
	jQuery.each(names, function(value) {
		setCategory(value);
	});
	setTimeout( function() {
		jQuery('#plans-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_AVAILABLE_CATEGORIES')+'</h1>');
		jQuery('#categories-display').show();
		jQuery('#categories-grid').trigger('display.uk.check');
	}, 1000);
}

// set the plans
function setCategory(name) {
	// get useful ID
	var keyID = getKeyID(name);
	// build the category display
	var html = '<div id="'+keyID+'-panel" class="uk-panel">';
	html += '<div class="uk-panel uk-panel-box uk-width-1-1">';
	html += '<h3 class="uk-panel-title">' + name + '</h3>';
	html += '<hr />';
	// set the data buttons
	html += setCategoryButtons(name);
	// close the box panel
	html += '</div>';
	html += '</div>';
	// now we have the category
	jQuery('#categories-grid').append(html);
}

function setCategoryButtons(name) {
	return  '<button class="uk-button uk-button-small uk-button-success uk-width-1-1 getreaction" data-name="'+name+'" data-type="getPlans" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION')+'"><i class="uk-icon-thumb-tack"></i><span class="uk-hidden-small"> '+Joomla.JText._('COM_COMPONENTBUILDER_OPEN_CATEGORY_PLANS')+'</span></button>';
}

// get the plans
function getPlans(path, categoryName) {
	jQuery('#loading').show();
	// get local values if set
	var _paths = jQuery.jStorage.get('JCB-Plans-Paths', null);
	// always reset the grid
	jQuery('#plans-grid').html('');
	// always hide categories
	jQuery('#categories-display').hide();
	// set the ajax scope
	ajaxcall = 'plans';
	fromLocal = false;
	if (_paths) {
		setPlans(_paths, categoryName);
		jQuery('#plans-github').html('<h1>'+Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY_PLANS')+'</h1>');
	} else {
		jQuery.get(path)
		.success(function(paths) {
			// load only this category paths
			jQuery.jStorage.set('JCB-Plans-Paths', paths, {TTL: expire});
			setPlans(paths, categoryName);
		})
		.error(function(jqXHR, textStatus, errorThrown) { 
			jQuery('#plans-github').html(returnError);
		});
	}
	// only use if loading localy
	if (fromLocal) {
		jQuery('#plans-display').show();
		jQuery('#plans-grid').trigger('display.uk.check');
		jQuery('#loading').hide();
	}
}

// set the plans
function setPlans(paths, categoryName) {
	// set the ajax scope
	ajaxcall = 'plans';
	jQuery.each(paths.tree, function(key,value) {
		if (value.path.match(".json$") && value.path.match("^"+categoryName)) {
			var _plan = jQuery.jStorage.get(value.path, null);
			if (_plan) {
				setPlan(_plan, value.path);
				fromLocal = true;
			} else {
				jQuery.get(planPath+value.path)
				.success(function(plan) {
					// convert the string to json.object
					plan = jQuery.parseJSON(plan);
					jQuery.jStorage.set(value.path, plan, {TTL: expire});
					setPlan(plan, value.path);
				})
				.error(function(jqXHR, textStatus, errorThrown) { 
					// we could do more
				});
			}
		}
	});
}

// set the plans
function setPlan(plan, key) {
	// get useful ID
	var keyID = getKeyID(key);
	// get the status
	var status = getPlanStatus(plan, key);
	// add to bulk updater
	if ('equal' !== status) {
		bulkItems[status].push(key);
	}
	// build the plan display
	var html = '<div id="'+keyID+'-panel" class="uk-panel" data-uk-filter="'+status+'" data-plan-categories="'+plan.category+'" data-plan-types="'+plan.type+'" data-plan-name="'+plan.name+'">';
	html += '<div class="uk-panel uk-panel-box uk-width-1-1">';
	html += '<div class="uk-panel-badge uk-badge" ><a id="'+keyID+'-badge" href="#'+status+'-meaning" data-uk-offcanvas class="uk-text-uppercase uk-text-contrast"><i class="uk-icon-info"></i> '+status+'</a></div><br />';
	html += '<h3 class="uk-panel-title">' + plan.category+ ' - (' + plan.type + ') ' + plan.name + '</h3>';
	html += plan.heading + '<hr />';
	// set the data buttons
	html += setDataButtons(plan, key, status);
	// set the plan ref button
	html += setRefButtons(plan, key, status, keyID);
	// set the contributor buttons
	html += setContributorButtons(plan, key);
	// close the box panel
	html += '</div>';
	html += '</div>';
	// now we have the plan
	jQuery('#plans-grid').append(html);
}

// set the plan status
function getPlanStatus(plan, key) {
	// check if JCB already has this plan
	if(local_plans.hasOwnProperty(key)){
		// first get local time stamp
		var local_created = strtotime(local_plans[key].created);
		var local_modified = strtotime(local_plans[key].modified);
		// now get github time stamps					
		var created = strtotime(plan.created);
		var modified = strtotime(plan.modified);
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

function setDataButtons(plan, key, status) {
	var html = '<div class="uk-button-group uk-width-1-1 uk-margin-small-bottom">';
	html += '<button class="uk-button uk-button-small uk-button-success uk-width-1-3 getreaction" data-status="'+status+'" data-path="'+key+'" data-type="usage" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_USAGE_OF_COMMUNITY_VERSION')+'"><i class="uk-icon-info"></i><span class="uk-hidden-small"> '+Joomla.JText._('COM_COMPONENTBUILDER_USAGE')+'</span></button>';
	html += '<button class="uk-button uk-button-small uk-button-success uk-width-1-3 getreaction" data-status="'+status+'" data-path="'+key+'" data-type="description" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_DESCRIPTION_OF_COMMUNITY_VERSION')+'"><i class="uk-icon-sticky-note-o"></i><span class="uk-hidden-small"> '+Joomla.JText._('COM_COMPONENTBUILDER_DESCRIPTION')+'</span></button>';
	html += '<button class="uk-button uk-button-small uk-button-success uk-width-1-3 getreaction" data-status="'+status+'" data-path="'+key+'" data-type="plan" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_PLAN_OF_COMMUNITY_VERSION')+'"><i class="uk-icon-code"></i><span class="uk-hidden-small"> '+Joomla.JText._('COM_COMPONENTBUILDER_PLAN')+'</span></button>';
	html += '</div>';
	// return data buttons
	return html;
}

function setRefButtons(plan, key, status, keyID) {
	var html = '<div><a class="uk-button uk-button-mini uk-button-success uk-margin-small-bottom uk-width-1-1" href="'+plan.url+'" target="_blank" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_PLAN_REFERENCE_URL')+'"><i class="uk-icon-external-link"></i> ' + plan.name + '</a></div>';
	// set the update button	
	html += '<div>';
	if ('equal' !== status) {
		if ('new' === status) {
			var tooltip = Joomla.JText._('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_INSTALL_IT_LOCALLY');
		} else {
			var tooltip = Joomla.JText._('COM_COMPONENTBUILDER_GET_THE_PLAN_FROM_GITHUB_AND_UPDATE_THE_LOCAL_VERSION');
		}
		html += '<button id="'+keyID+'-getbutton" class="uk-button uk-button-small uk-button-primary uk-width-1-1 uk-margin-small-bottom getreaction" data-status="'+status+'" data-path="'+key+'" data-type="get"  title="'+tooltip+'"><i class="uk-icon-cloud-download"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_GET_PLAN')+'</button>';
	} else {
		html += '<button class="uk-button uk-button-small uk-width-1-1 uk-margin-small-bottom" type="button" disabled title="'+Joomla.JText._('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION')+'"><i class="uk-icon-check-square-o"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_LOCAL_PLAN')+'</button>';
	}
	html += '</div>';
	// return data buttons
	return html;
}

function setContributorButtons(plan, key) {
	// set the contributor name
	if (plan.contributor_company) {
		var contributor_name = plan.contributor_company;
	} else if (plan.contributor_name) {
		var contributor_name = plan.contributor_name;
	} else {
		var contributor_name = Joomla.JText._('COM_COMPONENTBUILDER_JCB_COMMUNITY');
	}
	// set the contributor url
	if (plan.contributor_website) {
		var contributor_url = plan.contributor_website;
	} else if (plan.contributor_email) {
		var contributor_url = 'mailto:'+plan.contributor_email;
	} else {
		var contributor_url = 'https://github.com/vdm-io/Joomla-Component-Builder-Plans';
	}
	var html = '<div class="uk-button-group uk-width-1-1">';
	html += '<button class="uk-button uk-button-primary uk-width-1-10 uk-button-mini getreaction" data-type="contributor" data-path="'+key+'" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_THE_CONTRIBUTOR_DETAILS')+'"><i class="uk-icon-user"></i></button>';
	html += '<a  class="uk-button uk-button-primary uk-width-5-10 uk-button-mini" href="'+contributor_url+'" target="_blank"  title="'+Joomla.JText._('COM_COMPONENTBUILDER_LINK_TO_THE_CONTRIBUTOR')+'"><i class="uk-icon-external-link"></i> ' + contributor_name + '</a>';
	html += '<a class="uk-button uk-button-primary uk-width-4-10 uk-button-mini" href="https://github.com/vdm-io/Joomla-Component-Builder-Plans/blame/master/'+key+'" target="_blank" title="'+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_WHO_CONTRIBUTED_TO_THIS_PLAN')+'"><i class="uk-icon-external-link"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_VIEW_BLAME')+'</a>';
	html += '</div>';
	// return contributor buttons
	return html;
}

// do a bulk update
function checkBulkPlanGithub() {
	// check if there is new items
	if (bulkItems.new.length === 0) {
		jQuery('#bulk-button-new').prop('disabled', true);
		jQuery('#bulk-button-new').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_NEW_PLANS_AT_THIS_TIME'));
		jQuery('#bulk-notice-new').show();
	}
	// check if there is diverged items
	if (bulkItems.diverged.length === 0) {
		jQuery('#bulk-button-diverged').prop('disabled', true);
		jQuery('#bulk-button-diverged').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_DIVERGED_PLANS_AT_THIS_TIME'));
		jQuery('#bulk-notice-diverged').show();
	}
	// check if there is ahead items
	if (bulkItems.ahead.length === 0) {
		jQuery('#bulk-button-ahead').prop('disabled', true);
		jQuery('#bulk-button-ahead').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_AHEAD_PLANS_AT_THIS_TIME'));
		jQuery('#bulk-notice-ahead').show();
	}
	// check if there is behind items
	if (bulkItems.behind.length === 0) {
		jQuery('#bulk-button-behind').prop('disabled', true);
		jQuery('#bulk-button-behind').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_OUT_OF_DATE_PLANS_AT_THIS_TIME'));
		jQuery('#bulk-notice-behind').show();
	}
	// check if all we should close the all button
	if (bulkItems.behind.length === 0 && bulkItems.new.length === 0 && bulkItems.ahead.length === 0 && bulkItems.diverged.length === 0) {
		jQuery('#bulk-button-all').prop('disabled', true);
		jQuery('#bulk-button-all').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_THERE_ARE_NO_PLANS_TO_UPDATE_AT_THIS_TIME'));
		jQuery('#bulk-notice-all').show();
	}
}

// do a bulk update
function bulkPlanGithub(status) {
	// if all then trigger those with values
	if ('all' === status) {
		bulkPlanGithub('behind');
		bulkPlanGithub('new');
		bulkPlanGithub('ahead');
		bulkPlanGithub('diverged');
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
							// update plan if we can
							updatePlanDisplay(keyID, 'equal');
						}
					} else {
						UIkit.notify(Joomla.JText._('COM_COMPONENTBUILDER_PLAN_COULD_NOT_BE_UPDATEDSAVED'), {status:'danger'});
					}
				});
			}, 200);
		});
		// reset array
		bulkItems[status].length = 0;
		// update the buttons (since we only do the bulk update once)
		checkBulkPlanGithub();
	}
}

function doBulkUpdate_server(path, status) {
	// set the ajax scope
	ajaxcall = null;
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.setPlanGithub&format=json&raw=true");
	if (token.length > 0 && path.length > 0 && status.length > 0) {
		var request = token+'=1&path='+path+'&status='+status;
	}
	return jQuery.ajax({
		type: 'POST',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

// set the plan from gitHub
function setPlanGithub(key, status) {
	var message = getConfirmUpdate(status);
	UIkit.modal.confirm(message, function(){
		// will be executed on confirm.
		setPlanGithub_server(key, status).done(function(result) {
			if (result.message) {
				UIkit.notify(result.message, {status: result.status});
				if ('success' === result.status) {
					// get key ID
					var keyID = getKeyID(key);
					// update plan if we can
					updatePlanDisplay(keyID, 'equal');
				}
			} else {
				UIkit.notify(Joomla.JText._('COM_COMPONENTBUILDER_PLAN_COULD_NOT_BE_UPDATEDSAVED'), {status:'danger'});
			}
		});
	});
}

function setPlanGithub_server(path, status) {
	// set the ajax scope
	ajaxcall = null;
	var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.setPlanGithub&format=json&raw=true");
	if (token.length > 0 && path.length > 0 && status.length > 0) {
		var request = token+'=1&path='+path+'&status='+status;
	}
	return jQuery.ajax({
		type: 'POST',
		url: getUrl,
		dataType: 'json',
		data: request,
		jsonp: false
	});
}

// update the plan display
function updatePlanDisplay(keyID, status) {
	// update badge
	jQuery('#'+keyID+'-badge').html('<i class="uk-icon-info"></i> ' +status);
	jQuery('#'+keyID+'-badge').attr('href' , '#'+status+'-meaning');
	// update button
	if ('equal' === status) {
		// update notice
		jQuery('#'+keyID+'-getbutton').attr('title', Joomla.JText._('COM_COMPONENTBUILDER_NO_NEED_TO_GET_IT_SINCE_IT_IS_ALREADY_IN_SYNC_WITH_YOUR_LOCAL_VERSION'));
		jQuery('#'+keyID+'-getbutton').prop('disabled', true);
		jQuery('#'+keyID+'-getbutton').html('<i class="uk-icon-check-square-o"></i> ' + Joomla.JText._('COM_COMPONENTBUILDER_LOCAL_PLAN'));
		// counter delay just incase
		setTimeout(function(){
			jQuery('#'+keyID+'-getbutton').prop('disabled', true);
		}, 2000);
	}
	// update the data filter
	jQuery('#'+keyID+'-panel').attr('data-uk-filter', status);
	// tell the grid to update
	jQuery('#plans-grid').trigger('display.uk.check');
}

// set the modal
function getPlanModal(key, type) {
	// set the ajax scope
	ajaxcall = 'plans';
	var _plan = jQuery.jStorage.get(key, null);
	if (_plan) {
		// show modal
		showPlanModal(_plan, type);
	} else {
		jQuery.get('https://raw.githubusercontent.com/vdm-io/Joomla-Component-Builder-Plans/master/'+key)
		.success(function(plan) {
			// convert the string to json.object
			plan = jQuery.parseJSON(plan);
			jQuery.jStorage.set(key, plan, {TTL: expire});
			// show modal
			showPlanModal(plan, type);
		})
		.error(function(jqXHR, textStatus, errorThrown) { 
			// we could do more
		});
	}
}

// show the modal
function showPlanModal(plan, type) {
	var html = '<div class="uk-modal-dialog uk-modal-dialog-lightbox">';
	html += '<a href="" class="uk-modal-close uk-close uk-close-alt"></a>';
	html += '<h3>' + plan.category + ' - (' + plan.type + ') ' + plan.name + '</h3>';
	if ('contributor' === type) {
		html += '<dl class="uk-description-list-line">';
		html += '<dt><i class="uk-icon-institution"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_COMPANY_NAME')+'</dt>';
		html += '<dd>'+plan.contributor_company+'</dd>';
		html += '<dt><i class="uk-icon-user"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_NAME')+'</dt>';
		html += '<dd>'+plan.contributor_name+'</dd>';
		html += '<dt><i class="uk-icon-envelope-o"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_EMAIL')+'</dt>';
		html += '<dd>'+plan.contributor_email+'</dd>';
		html += '<dt><i class="uk-icon-laptop"></i> '+Joomla.JText._('COM_COMPONENTBUILDER_AUTHOR_WEBSITE')+'</dt>';
		html += '<dd>'+plan.contributor_website+'</dd>';
		html += '</dl>';
	} else {
		html += '<br /><textarea class="uk-width-1-1" rows="15" readonly>'+plan[type]+'</textarea>';
	}
	html += '<br /><small>C: ' + plan.created + ' | M: ' + plan.modified + '</small>';
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

jQuery.string_replace = function (search, replace, subject, countObj) {
  //  discuss at: https://locutus.io/php/str_replace/
  // original by: Kevin van Zonneveld (https://kvz.io)
  // improved by: Gabriel Paderni
  // improved by: Philip Peterson
  // improved by: Simon Willison (https://simonwillison.net)
  // improved by: Kevin van Zonneveld (https://kvz.io)
  // improved by: Onno Marsman (https://twitter.com/onnomarsman)
  // improved by: Brett Zamir (https://brett-zamir.me)
  //  revised by: Jonas Raoni Soares Silva (https://www.jsfromhell.com)
  // bugfixed by: Anton Ongson
  // bugfixed by: Kevin van Zonneveld (https://kvz.io)
  // bugfixed by: Oleg Eremeev
  // bugfixed by: Glen Arason (https://CanadianDomainRegistry.ca)
  // bugfixed by: Glen Arason (https://CanadianDomainRegistry.ca)
  //    input by: Onno Marsman (https://twitter.com/onnomarsman)
  //    input by: Brett Zamir (https://brett-zamir.me)
  //    input by: Oleg Eremeev
  //      note 1: The countObj parameter (optional) if used must be passed in as a
  //      note 1: object. The count will then be written by reference into it's `value` property
  //   example 1: str_replace(' ', '.', 'Kevin van Zonneveld')
  //   returns 1: 'Kevin.van.Zonneveld'
  //   example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars')
  //   returns 2: 'hemmo, mars'
  //   example 3: str_replace(Array('S','F'),'x','ASDFASDF')
  //   returns 3: 'AxDxAxDx'
  //   example 4: var countObj = {}
  //   example 4: str_replace(['A','D'], ['x','y'] , 'ASDFASDF' , countObj)
  //   example 4: var $result = countObj.value
  //   returns 4: 4
    var i = 0
    var j = 0
    var temp = ''
    var repl = ''
    var sl = 0
    var fl = 0
    var f = [].concat(search)
    var r = [].concat(replace)
    var s = subject
    var ra = Object.prototype.toString.call(r) === '[object Array]'
    var sa = Object.prototype.toString.call(s) === '[object Array]'
    s = [].concat(s)

    var $global = (typeof window !== 'undefined' ? window : global)
    $global.$locutus = $global.$locutus || {}
    var $locutus = $global.$locutus
    $locutus.php = $locutus.php || {}

    if (typeof (search) === 'object' && typeof (replace) === 'string') {
        temp = replace
        replace = []
        for (i = 0; i < search.length; i += 1) {
            replace[i] = temp
        }
        temp = ''
        r = [].concat(replace)
        ra = Object.prototype.toString.call(r) === '[object Array]'
    }

    if (typeof countObj !== 'undefined') {
        countObj.value = 0
    }

    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + ''
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0]
            s[i] = (temp).split(f[j]).join(repl)
            if (typeof countObj !== 'undefined') {
                countObj.value += ((temp.split(f[j])).length - 1)
            }
        }
    }
    return sa ? s : s[0]
}

/**
 * @copyright  Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

;(function($){
	"use strict";
	$.subformRepeatableVDM = function(container, options){
		this.$container = $(container);

		// check if already exist
		if(this.$container.data("subformRepeatableVDM")){
			return self;
		}

		// Add a reverse reference to the DOM object
		this.$container.data("subformRepeatableVDM", self);

		// merge options
		this.options = $.extend({}, $.subformRepeatableVDM.defaults, options);

		// template for the repeating group
		this.template = '';

		// prepare a row template, and find available field names
		this.prepareTemplate();

		// check rows container
		this.$containerRows = this.options.rowsContainer ? this.$container.find(this.options.rowsContainer) : this.$container;

		// To avoid scope issues,
		var self = this;

		// bind add button
		this.$container.on('click', this.options.btAdd, function (e) {
			e.preventDefault();
			var after = $(this).parents(self.options.repeatableElement);
			if(!after.length){
				after = null;
			}
			self.addRow(after);
		});

		// bind remove button
		this.$container.on('click', this.options.btRemove, function (e) {
			e.preventDefault();
			var $row = $(this).parents(self.options.repeatableElement);
			self.removeRow($row);
		});

		// bind move button
		if(this.options.btMove){
			this.$containerRows.sortable({
				items: this.options.repeatableElement,
				handle: this.options.btMove,
				tolerance: 'pointer'
			});
		}

		// tell all that we a ready
		this.$container.trigger('subform-ready');
	};

	// prepare a template that we will use repeating
	$.subformRepeatableVDM.prototype.prepareTemplate = function(){
		// create from template
		if (this.options.rowTemplateSelector) {
			// Find the template element and get its HTML content, this is our template.
			var $tmplElement = this.$container.find(this.options.rowTemplateSelector).last();

			this.template = $.trim($tmplElement.html()) || '';

			// This is IE fix for <template>
			$tmplElement.css('display', 'none'); // Make sure it not visible
			var map = {'SUBFORMLT': '<', 'SUBFORMGT': '>'};
			this.template = this.template.replace(/(SUBFORMLT)|(SUBFORMGT)/g, function(match){
				return map[match];
			});
		}
		// create from existing rows
		else {
			//find first available
			var row = this.$container.find(this.options.repeatableElement).get(0),
				$row = $(row).clone();

			// clear scripts that can be attached to the fields
			try {
				this.clearScripts($row);
			} catch (e) {
				if(window.console){
					console.log(e);
				}
			}

			this.template = $row.prop('outerHTML');
		}
	};

	// add new row
	$.subformRepeatableVDM.prototype.addRow = function(after){
		// count how much we already have
		var count = this.$containerRows.find(this.options.repeatableElement).length;
		if(count >= this.options.maximum){
			return null;
		}

		// make new from template
		var row = $.parseHTML(this.template);

		// add to container
		if(after){
			$(after).after(row);
		} else {
			this.$containerRows.append(row);
		}

		var $row = $(row);

		//add marker that it is new
		$row.attr('data-new', 'true');
		// fix names and id`s, and reset values
		this.fixUniqueAttributes($row, count);

		// fix VDM dynamic values (real pain, could they not have made this easier!!!)
		var _vdm_counter = $row.attr('data-group');
		_vdm_counter = _vdm_counter.replace ( /[^\d.]/g, '' );
		$row[0].innerHTML = $.string_replace("VDM-XX", _vdm_counter, $row[0].innerHTML);

		// try find out with related scripts,
		// tricky thing, so be careful
		try {
			this.fixScripts($row);
		} catch (e) {
			if(window.console){
				console.log(e);
			}
		}

		// tell everyone about the new row
		this.$container.trigger('subform-row-add', $row);
		return $row;
	};

	// remove row
	$.subformRepeatableVDM.prototype.removeRow = function($row){
		// count how much we have
		var count = this.$containerRows.find(this.options.repeatableElement).length;
		if(count <= this.options.minimum){
			return;
		}

		// tell everyoune about the row will be removed
		this.$container.trigger('subform-row-remove', $row);
		$row.remove();
	};

	// fix names and id`s for fields in $row
	$.subformRepeatableVDM.prototype.fixUniqueAttributes = function(
		$row, // the jQuery object to do fixes in
		_count, // existing count of rows
		_group, // current group name, e.g. 'optionsX'
		_basename // group base name, without count, e.g. 'options'
	) {
		var group = (typeof _group === 'undefined' ? $row.attr('data-group') : _group),
			basename = (typeof _basename === 'undefined' ? $row.attr('data-base-name') : _basename),
			count    = (typeof _count === 'undefined' ? 0 : _count),
			groupnew = basename + count;

		$row.attr('data-group', groupnew);

		// Fix inputs that have a "name" attribute
		var haveName = $row.find('[name]'),
			ids = {}; // Collect id for fix checkboxes and radio

		for (var i = 0, l = haveName.length; i < l; i++) {
			var $el     = $(haveName[i]),
				name    = $el.attr('name'),
				id      = name.replace(/(\[\]$)/g, '').replace(/(\]\[)/g, '__').replace(/\[/g, '_').replace(/\]/g, ''), // id from name
				nameNew = name.replace('[' + group + '][', '['+ groupnew +']['), // New name
				idNew   = id.replace(group, groupnew).replace(/\W/g, '_'), // Count new id
				countMulti = 0, // count for multiple radio/checkboxes
				forOldAttr = id; // Fix "for" in the labels

			if ($el.prop('type') === 'checkbox' && name.match(/\[\]$/)) { // <input type="checkbox" name="name[]"> fix
				// Recount id
				countMulti = ids[id] ? ids[id].length : 0;
				if (!countMulti) {
					// Set the id for fieldset and group label
					$el.closest('fieldset.checkboxes').attr('id', idNew);
					$row.find('label[for="' + id + '"]').attr('for', idNew).attr('id', idNew + '-lbl');
				}
				forOldAttr = forOldAttr + countMulti;
				idNew = idNew + countMulti;
			}
			else if ($el.prop('type') === 'radio') { // <input type="radio"> fix
				// Recount id
				countMulti = ids[id] ? ids[id].length : 0;
				if (!countMulti) {
					// Set the id for fieldset and group label
					$el.closest('fieldset.radio').attr('id', idNew);
					$row.find('label[for="' + id + '"]').attr('for', idNew).attr('id', idNew + '-lbl');
				}
				forOldAttr = forOldAttr + countMulti;
				idNew = idNew + countMulti;
			}

			// Cache already used id
			if (ids[id]) {
				ids[id].push(true);
			} else {
				ids[id] = [true];
			}

			// Replace the name to new one
			$el.attr('name', nameNew);
			// Set new id
			$el.attr('id', idNew);
			// Guess there a label for this input
			$row.find('label[for="' + forOldAttr + '"]').attr('for', idNew).attr('id', idNew + '-lbl');
		}

		/**
		 * Recursively replace our basename + old group with basename + new group
		 * inside of nested subform template elements. First we try to find such
		 * template elements, then we iterate through them and do the same replacements
		 * that we have made here inside of them.
		 */
		var nestedTemplates = $row.find(this.options.rowTemplateSelector);
		// If we found it, iterate over the found ones (might be more than one!)
		for (var j = 0; j < nestedTemplates.length; j++) {
			// Get the nested templates content (as DocumentFragment) and cast it
			// to a jQuery object
			var nestedTemplate = $($(nestedTemplates[j]).prop('content'));
			// Fix the attributes for this nested template.
			this.fixUniqueAttributes(nestedTemplate, count, group, basename);
		}
	};

	// remove scripts attached to fields
	// @TODO: make thing better when something like that will be accepted https://github.com/joomla/joomla-cms/pull/6357
	$.subformRepeatableVDM.prototype.clearScripts = function($row){
		// destroy chosen if any
		if($.fn.chosen){
			$row.find('select.chzn-done').each(function(){
				var $el = $(this);
				$el.next('.chzn-container').remove();
				$el.show().addClass('fix-chosen');
			});
		}
	};

	// method for hack the scripts that can be related
	// to the one of field that in given $row
	// @TODO Stop using this function. Elements within subforms should initialize themselves
	$.subformRepeatableVDM.prototype.fixScripts = function($row){
		// fix media field
		$row.find('a[onclick*="jInsertFieldValue"]').each(function(){
				var $el = $(this),
				inputId = $el.siblings('input[type="text"]').attr('id'),
				$select = $el.prev(),
				oldHref = $select.attr('href');
			// update the clear button
			$el.attr('onclick', "jInsertFieldValue('', '" + inputId + "');return false;")
			// update select button
			$select.attr('href', oldHref.replace(/&fieldid=(.+)&/, '&fieldid=' + inputId + '&'));
		});
	};

	// defaults
	$.subformRepeatableVDM.defaults = {
		// button selector for "add" action, must be unique per nested subform!
		btAdd: ".group-add",
		// button selector for "remove" action, must be unique per nested subform!
		btRemove: ".group-remove",
		// button selector for "move" action, must be unique per nested subform!
		btMove: ".group-move",
		// minimum repeating
		minimum: 0,
		// maximum repeating
		maximum: 10,
		// selector for the repeatable element inside the main container,
		// must be unique per nested subform!
		repeatableElement: ".subform-repeatable-group",
		// selector for the row template element with URL-encoded template inside it,
		// must *NOT* be unique per nested subform!
		rowTemplateSelector: 'template.subform-repeatable-template-section',
		// container for rows, same as main container by default
		rowsContainer: null
	};

	$.fn.subformRepeatableVDM = function(options){
		return this.each(function(){
			var options = options || {},
				data = $(this).data();

			if(data.subformRepeatableVDM){
				// Alredy initialized, nothing to do here
				return;
			}

			for (var p in data) {
				// check options in the element
				if (data.hasOwnProperty(p)) {
					options[p] = data[p];
				}
			}

			var inst = new $.subformRepeatableVDM(this, options);
			$(this).data('subformRepeatableVDM', inst);
		});
	};

	// initialise all available on load and again within any added row
	$(function ($) {
		initSubform();
		$(document).on('subform-row-add', initSubform);

		function initSubform (event, container) {
			$(container || document).find('div.subform-repeatable-vdm').subformRepeatableVDM();
		}
	});

})(jQuery);
