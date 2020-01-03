<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JHtml::_('jquery.framework');
JHtml::_('bootstrap.tooltip');
JHtml::_('script', 'system/core.js', false, true);
JHtml::_('behavior.keepalive');
?>
<script type="text/javascript">
<?php if (isset($this->hasPackage) && $this->hasPackage && $this->dataType === 'smart_package'): ?>
	Joomla.continueExtImport = function()
	{
		var form = document.getElementById('adminForm');
		jQuery('#loading').css('display', 'block');
		form.gettype.value = 'continue-ext';
		form.submit();
	};
	Joomla.cancelImport = function()
	{
		var form = document.getElementById('adminForm');
		jQuery('#loading').css('display', 'block');
		form.gettype.value = 'cancel-ext';
		form.submit();
	};
<?php else: ?>
	Joomla.submitbutton = function(task)
	{
		if ('joomla_component.refresh' === task){
			jQuery('#loading').css('display', 'block');
			// clear the history
			jQuery.jStorage.flush();
			// now start the update
			autoJCBpackageInfo();
			// also clear the session memory around the component list
			Joomla.submitform(task);
		} else {
			var form = document.getElementById('adminForm');
			// do field validation
			if (form.import_package.value == "")
			{
				alert("<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_PLEASE_SELECT_A_FILE', true); ?>");
			}
			else
			{
				jQuery('#loading').css('display', 'block');
				form.gettype.value = 'upload';
				form.submit();
			}
		}
	};
	Joomla.submitbuttonDir = function()
	{
		var form = document.getElementById('adminForm');
		// do field validation
		if (form.import_directory.value == ""){
			alert("<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY', true); ?>");
		}
		else
		{
			jQuery('#loading').css('display', 'block');
			form.gettype.value = 'folder';
			form.submit();
		}
	};
	Joomla.submitbuttonUrl = function()
	{
		var form = document.getElementById('adminForm');
		// do field validation
		if (form.import_url.value == "" || form.import_url.value == "http://")
		{
			alert("<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_MSG_ENTER_A_URL', true); ?>");
		}
		else
		{
			jQuery('#loading').css('display', 'block');
			form.gettype.value = 'url';
			form.submit();
		}
	};
	Joomla.submitbuttonVDM = function()
	{
		var form = document.getElementById('adminForm');
		// do field validation
		if (form.vdm_package.value == "" || form.vdm_package.value == "http://")
		{
			alert("<?php echo JText::_('COM_COMPONENTBUILDER_SELECT_THE_COMPONENT_YOUR_WOULD_LIKE_TO_IMPORT', true); ?>");
		}
		else
		{
			// set the url
			form.import_url.value = form.vdm_package.value;
			jQuery('#loading').css('display', 'block');
			jQuery('#noticeboard').show();
			jQuery('#installer-import').hide();
			form.checksum.value = 'vdm';
			form.gettype.value = 'url';
			form.submit();
		}
	};
	Joomla.submitbuttonJCB = function()
	{
		var form = document.getElementById('adminForm');
		// do field validation
		if (form.jcb_package.value == "" || form.jcb_package.value == "http://")
		{
			alert("<?php echo JText::_('COM_COMPONENTBUILDER_SELECT_THE_COMPONENT_YOUR_WOULD_LIKE_TO_IMPORT', true); ?>");
		}
		else
		{
			// set the url
			form.import_url.value = form.jcb_package.value;
			jQuery('#loading').css('display', 'block');
			jQuery('#noticeboard').show();
			jQuery('#installer-import').hide();
			form.checksum.value = 'jcb';
			form.gettype.value = 'url';
			form.submit();
		}
	};
<?php endif; ?>


// Add spindle-wheel for importations:
jQuery(document).ready(function($) {
	var outerDiv = $('body');

	$('<div id="loading"></div>')
		.css("background", "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat")
		.css("top", outerDiv.position().top - $(window).scrollTop())
		.css("left", outerDiv.position().left - $(window).scrollLeft())
		.css("width", outerDiv.width())
		.css("height", outerDiv.height())
		.css("position", "fixed")
		.css("opacity", "0.80")
		.css("-ms-filter", "progid:DXImageTransform.Microsoft.Alpha(Opacity = 80)")
		.css("filter", "alpha(opacity = 80)")
		.css("display", "none")
		.appendTo(outerDiv);
});
</script>

<?php $formats = ($this->dataType === 'smart_package') ? '.zip' : 'none'; ?>
<div class="clearfix">
<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_componentbuilder&view=import_joomla_components');?>" method="post" name="adminForm" id="adminForm" class="form-horizontal form-validate">

	<?php if (!empty( $this->sidebar)) : ?>
		<div id="j-sidebar-container" class="span2">
			<?php echo $this->sidebar; ?>
		</div>
		<div id="j-main-container" class="span10">
	<?php else : ?>
		<div id="j-main-container">
	<?php endif;?>
	<div id="noticeboard" class="well well-small" style="display: none;">
		<h2 class="module-title nav-header"><?php echo JText::_('COM_COMPONENTBUILDER_VDM_NOTICE_BOARD'); ?><span class="vdm-new-notice" style="display:none; color:red;"> (<?php echo JText::_('COM_COMPONENTBUILDER_NEW_NOTICE'); ?>)</span></h2>
		<div class="noticeboard-md"><small><?php echo JText::_('COM_COMPONENTBUILDER_THE_NOTICE_BOARD_IS_LOADING'); ?><span class="loading-dots">.</span></small></div>
		<div style="text-align:right;"><small><a href="https://github.com/Llewellynvdm" target="_blank" style="color:gray">&lt;&lt;ewe&gt;&gt;yn</a></small></div>
	</div>
	<div id="installer-import">
	<?php if (isset($this->hasPackage) && $this->hasPackage && $this->dataType === 'smart_package') : ?>
		<?php
			if (isset($this->packageInfo['name']) && ComponentbuilderHelper::checkArray($this->packageInfo['name'])) 
			{
				$cAmount = count($this->packageInfo['name']);
				$comP = ($cAmount == 1) ? 'Component' : 'Components';
			}
			else
			{
				$cAmount = 1;
				$comP = 'Component';
			}
			$hasOwner = (isset($this->packageInfo['getKeyFrom']) && ComponentbuilderHelper::checkArray($this->packageInfo['getKeyFrom'])) ? true:false;
			$class1 = ($hasOwner) ? 'span6' : 'span12';
		?>
		<h3 style="color: #1F73BA;"><?php echo JText::_('COM_COMPONENTBUILDER_CONFIRMATION_STEP_BEFORE_IMPORTING'); ?></h3>
		<p style="color: #1F73BA;"><?php echo JText::_('COM_COMPONENTBUILDER_YOU_SHOULD_ONLY_CONTINUE_THIS_IMPORT_IF_YOU_HAVE_BACKUP_YOUR_COMPONENTS_AND_INSURED_THAT_THE_PACKAGE_OWNER_IS_REPUTABLE'); ?></p>
		<?php echo JHtml::_('bootstrap.startTabSet', 'jcbImportTab', array('active' => 'advanced')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'advanced', JText::sprintf('COM_COMPONENTBUILDER_IMPORT_S', $comP)); ?>
		<div class="<?php echo $class1; ?>">
		<fieldset class="uploadform">
			<legend><?php echo JText::_('COM_COMPONENTBUILDER_SMART_PACKAGE_OPTIONS'); ?></legend>
				<?php if ($this->formPackage): ?>
					<?php foreach ($this->formPackage as $field): ?>
					<div class="control-group">
						<div class="control-label"><?php echo $field->label;?></div>
						<div class="controls"><?php echo $field->input;?></div>
					</div>
					<?php endforeach; ?>
				<?php endif; ?>
			<div class="form-actions">
				<div class="btn-group">
					<input class="btn btn-primary" type="button" value="<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_CONTINUE'); ?>" onclick="Joomla.continueExtImport()" />
					<input class="btn" type="button" value="<?php echo JText::_('COM_COMPONENTBUILDER_CANCEL'); ?>" onclick="Joomla.cancelImport()" />
				</div>
			</div>
		</fieldset>
		<?php if (!$hasOwner): ?>
			<p style="color: #922924;"><?php echo JText::_('COM_COMPONENTBUILDER_BE_CAUTIOUS_DO_NOT_CONTINUE_UNLESS_YOU_TRUST_THE_ORIGIN_OF_THIS_PACKAGE'); ?></p>
		<?php endif; ?>
		</div>
		<?php if ($hasOwner): ?>
		<div class="well span6">
			<?php echo ComponentbuilderHelper::getPackageOwnerDetailsDisplay($this->packageInfo); ?>
		</div>
		<?php endif; ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if (isset($this->packageInfo['name']) && ComponentbuilderHelper::checkArray($this->packageInfo['name'])) : ?>
		<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'info', JText::sprintf('COM_COMPONENTBUILDER_S_BEING_IMPORTED', $comP)); ?>
			<?php echo ComponentbuilderHelper::getPackageComponentsDetailsDisplay($this->packageInfo); ?>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		<input type="hidden" name="gettype" value="continue" />
	<?php else: ?>
		<?php if ($this->dataType === 'smart_package'): ?>
			<h1 style="color: #922924;"><?php echo JText::_('COM_COMPONENTBUILDER_BACKUP_LOCAL_DATA_FIRST'); ?></h1>
			<p style="color: #922924;"><?php echo JText::sprintf('COM_COMPONENTBUILDER_ALWAYS_INSURE_THAT_YOU_HAVE_YOUR_LOCAL_COMPONENTS_BACKED_UP_BY_MAKING_AN_EXPORT_OF_ALL_YOUR_LOCAL_COMPONENTS_BEFORE_IMPORTING_ANY_NEW_COMPONENTS_SMALLMAKE_BSUREB_TO_MOVE_THIS_ZIPPED_BACKUP_PACKAGE_OUT_OF_THE_TMP_FOLDER_BEFORE_DOING_AN_IMPORTSMALLBR_IF_YOU_ARE_IMPORTING_A_PACKAGE_OF_A_THREERD_PARTY_JCB_PACKAGE_DEVELOPER_BMAKE_SURE_IT_IS_A_REPUTABLE_JCB_PACKAGE_DEVELOPERSB_A_SFIND_OUT_WHYA', 'href="https://vdm.bz/jcb-package-import-safety" target="_blank" title="Watch tutorial"'); ?></p>
		<?php endif; ?>
		<?php echo JHtml::_('bootstrap.startTabSet', 'jcbImportTab', array('active' => 'upload')); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'upload', JText::_('COM_COMPONENTBUILDER_IMPORT_FROM_UPLOAD', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_UPDATE_DATA'); ?></legend>
				<div class="control-group">
					<label for="import_package" class="control-label"><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE'); ?></label>
					<div class="controls">
						<input class="input_box" id="import_package" name="import_package" type="file" size="57" />
					</div>
				</div>
				<div class="form-actions">
					<input class="btn btn-primary" type="button" value="<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_UPLOAD_BOTTON'); ?>" onclick="Joomla.submitbutton()" />&nbsp;&nbsp;&nbsp;<small><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_FORMATS_ACCEPTED'); ?> (<?php echo $formats; ?>)</small>
				</div>
			</fieldset>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
		
		<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'directory', JText::_('COM_COMPONENTBUILDER_IMPORT_FROM_DIRECTORY', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_UPDATE_DATA'); ?></legend>
				<div class="control-group">
					<label for="import_directory" class="control-label"><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_DIRECTORY'); ?></label>
					<div class="controls">
						<input type="text" id="import_directory" name="import_directory" class="span5 input_box" size="70" value="<?php echo $this->state->get('import.directory'); ?>" />
					</div>
				</div>
				<div class="form-actions">
					<input type="button" class="btn btn-primary" value="<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_GET_BOTTON'); ?>" onclick="Joomla.submitbuttonDir()" />&nbsp;&nbsp;&nbsp;<small><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_FORMATS_ACCEPTED'); ?> (<?php echo $formats; ?>)</small>
				</div>
				</fieldset>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'url', JText::_('COM_COMPONENTBUILDER_IMPORT_FROM_URL', true)); ?>
			<fieldset class="uploadform">
				<legend><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_UPDATE_DATA'); ?></legend>
				<div class="control-group">
					<label for="import_url" class="control-label"><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_URL'); ?></label>
					<div class="controls">
						<input type="text" id="import_url" name="import_url" class="span5 input_box" size="70" value="http://" />
					</div>
				</div>
				<div class="form-actions">
					<input type="button" class="btn btn-primary" value="<?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_GET_BOTTON'); ?>" onclick="Joomla.submitbuttonUrl()" />&nbsp;&nbsp;&nbsp;<small><?php echo JText::_('COM_COMPONENTBUILDER_IMPORT_FORMATS_ACCEPTED'); ?> (<?php echo $formats; ?>)</small>
				</div>
			</fieldset>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if (isset($this->vdmPackages) && ComponentbuilderHelper::checkArray($this->vdmPackages)): ?>
			<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'url_vdm', JText::_('COM_COMPONENTBUILDER_VDM_PACKAGES', true)); ?>
				<div class="span12" id="vdm_packages_installer">
					<div class="alert alert-success">
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_ALL_OF_THESE_PACKAGES_ARE_A_FULLY_DEVELOPEDMAPPED_COMPONENTS_FOR_JCB_THEY_CAN_BE_SEEN_AS_DEMO_CONTENT_OR_BASE_IMAGES_FROM_WHICH_TO_START_YOUR_PROJECTBR_ALWAYS_MAKE_SURE_YOU_ARE_ON_THE_LATEST_VERSION_OF_JCB_BEFORE_IMPORTING_ANY_OF_THESE_PACKAGES_SHOULD_ANY_OF_THEM_FAIL_TO_IMPORT_A_S_PLEASE_LET_US_KNOWA', 'href="https://www.joomlacomponentbuilder.com/package-support" target="_blank" title="Should any of these packages fail to import please let us know, some need a key of course."'); ?></p>
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_THESE_ARE_THE_SAME_PACKAGES_FOUND_ON_A_S_GITHUBA_AND_CAN_BE_IMPORTED_BY_SIMPLY_MAKING_A_SELECTION_AND_THEN_CLICKING_THE_BGET_PACKAGEB_BUTTONBR_SOME_OF_THESE_PACKAGES_WOULD_REQUIRE_A_KEY_SINCE_THEY_ARE_NOT_FREE_A_S_GET_A_KEY_TODAYA', 'href="https://github.com/vdm-io/JCB-Packages" target="_blank" title="gitHub Reposetory"', 'href="http://vdm.bz/jcb-packages" target="_blank" title="get a key to import the paid packages."'); ?></p>
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_HOW_TO_GET_A_S_FREE_KEYSA_FROM_VDM', 'href="https://vdm.bz/how-to-get-free-vdm-package-keys" target="_blank" title="see how easy it is to get access keys from VDM"'); ?></p>
					</div>
					<fieldset class="uploadform">
						<legend><?php echo JText::_("COM_COMPONENTBUILDER_PACKAGES_FROM_VAST_DEVELOPMENT_METHOD"); ?></legend>
						<?php foreach ($this->vdmPackages as $field): ?>
						<div class="control-group">
							<div class="control-label"><?php echo $field->label;?></div>
							<div class="controls"><?php echo $field->input;?></div>
						</div>
						<?php endforeach; ?>
						<div class="form-actions">
							<input type="button" class="btn btn-primary" value="<?php echo JText::_('COM_COMPONENTBUILDER_GET_PACKAGE'); ?>" onclick="Joomla.submitbuttonVDM()" />&nbsp;&nbsp;&nbsp;<small><span class="icon-shield"> </span><?php echo JText::_('COM_COMPONENTBUILDER_OFFICIAL_VDM_PACKAGES'); ?></small>
						</div>
						<div class="control-group"><small><?php echo JText::sprintf('COM_COMPONENTBUILDER_A_S_SPAN_CLASSICONFLAG_SPANREPORT_BROKEN_PACKAGEA', 'href="https://www.joomlacomponentbuilder.com/package-support" target="_blank" title="Should any of these packages fail to import please let us know"'); ?></small></div>
					</fieldset>
				</div>
				<div id="vdm_packages_display">
					<div id="vdm_packages_details">
					</div><br />
					<div id="vdm_package_owner_details">
					</div>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php if (isset($this->jcbPackages) && ComponentbuilderHelper::checkArray($this->jcbPackages)) : ?>
			<?php echo JHtml::_('bootstrap.addTab', 'jcbImportTab', 'url_jcb', JText::_('COM_COMPONENTBUILDER_JCB_COMMUNITY_PACKAGES', true)); ?>
				<div class="span12" id="jcb_packages_installer">
					<div class="alert alert-success">
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_ALL_OF_THESE_PACKAGES_ARE_A_FULLY_DEVELOPEDMAPPED_COMPONENTS_FOR_JCB_THEY_CAN_BE_SEEN_AS_DEMO_CONTENT_OR_BASE_IMAGES_FROM_WHICH_TO_START_YOUR_PROJECTBR_ALWAYS_MAKE_SURE_YOU_ARE_ON_THE_LATEST_VERSION_OF_JCB_BEFORE_IMPORTING_ANY_OF_THESE_PACKAGES_SHOULD_ANY_OF_THEM_FAIL_TO_IMPORT_A_S_PLEASE_LET_US_KNOWA', 'href="https://www.joomlacomponentbuilder.com/package-support" target="_blank" title="Should any of these packages fail to import please let us know, some need a key of course."'); ?></p>
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_THESE_ARE_THE_SAME_PACKAGES_FOUND_ON_A_S_GITHUBA_AND_CAN_BE_IMPORTED_BY_SIMPLY_MAKING_A_SELECTION_AND_THEN_CLICKING_THE_BGET_PACKAGEB_BUTTONBR_SOME_OF_THESE_PACKAGES_WOULD_REQUIRE_A_KEY_SINCE_THEY_ARE_NOT_FREE', 'href="https://github.com/vdm-io/JCB-Community-Packages" target="_blank" title="gitHub Reposetory"'); ?></p>
						<p><?php echo JText::sprintf('COM_COMPONENTBUILDER_ADD_YOUR_OWN_JCB_PACKAGES_TO_THE_COMMUNITY_A_S_GITHUBA_REPOSITORYBR_WATCH_THIS_A_S_TUTORIALA_TO_SEE_HOW', 'href="https://github.com/vdm-io/JCB-Community-Packages" target="_blank" title="gitHub Reposetory"',  'href="https://vdm.bz/add-jcb-community-package" target="_blank" title="watch the quick tutorial on how to add your own packages to this list of community packages"'); ?></p>
					</div>
					<fieldset class="uploadform">
						<legend><?php echo JText::_("COM_COMPONENTBUILDER_PACKAGES_FROM_JCB_COMMUNITY"); ?></legend>
						<?php foreach ($this->jcbPackages as $field): ?>
						<div class="control-group">
							<div class="control-label"><?php echo $field->label;?></div>
							<div class="controls"><?php echo $field->input;?></div>
						</div>
						<?php endforeach; ?>
						<div class="form-actions">
							<input type="button" class="btn btn-primary" value="<?php echo JText::_('COM_COMPONENTBUILDER_GET_PACKAGE'); ?>" onclick="Joomla.submitbuttonJCB()" />&nbsp;&nbsp;&nbsp;<small><span class="icon-shield"> </span><?php echo JText::_('COM_COMPONENTBUILDER_COMMUNITY_PACKAGES'); ?></small>
						</div>
						<div class="control-group"><small><?php echo JText::sprintf('COM_COMPONENTBUILDER_A_S_SPAN_CLASSICONFLAG_SPANREPORT_BROKEN_PACKAGEA', 'href="https://www.joomlacomponentbuilder.com/package-support" target="_blank" title="Should any of these packages fail to import please let us know"'); ?></small></div>
					</fieldset>
				</div>
				<div id="jcb_packages_display">
					<div id="jcb_packages_details">
					</div><br />
					<div id="jcb_package_owner_details">
					</div>
				</div>
			<?php echo JHtml::_('bootstrap.endTab'); ?>
		<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>
		<input type="hidden" name="gettype" value="upload" />
		<input type="hidden" name="checksum" value="0" />
	<?php endif; ?>
	<input type="hidden" name="task" value="import_joomla_components.import" />
	<?php echo JHtml::_('form.token'); ?>
	</div>
</form>
</div>
<script type="text/javascript">
<?php if ((isset($this->vdmPackages) && $this->vdmPackages && ComponentbuilderHelper::checkArray($this->vdmPackages)) || (isset($this->jcbPackages) && $this->jcbPackages && ComponentbuilderHelper::checkArray($this->jcbPackages))): ?>
// set packages that are on the page
var packages = {};
jQuery(document).ready(function($)
{
<?php if (isset($this->jcbPackages) && $this->jcbPackages && ComponentbuilderHelper::checkArray($this->jcbPackages)): ?>
	// get all jcb packages
	jQuery("#jcb_package option").each(function()
	{
		var key =  jQuery(this).val();
		packages[key] = 'jcb';
	});
<?php endif; ?>
<?php if (isset($this->vdmPackages) && $this->vdmPackages && ComponentbuilderHelper::checkArray($this->vdmPackages)): ?>
	// get all vdm packages
	jQuery("#vdm_package option").each(function()
	{
		var key =  jQuery(this).val();
		packages[key] = 'vdm';
	});
<?php endif; ?>
	// no start behind the scene getting of package info
	autoJCBpackageInfo();
});

function autoJCBpackageInfo(){
	jQuery.each( packages, function( url, type ) {
		var key = url.replace(/\W/g, '');
		// check if the values are local
		var result = jQuery.jStorage.get('JCB-packages-details'+key, null);
		if (!result && url.length > 0) {
			 autoJCBpackageInfoAgain(url, key, type);
		}
	});
}

function autoJCBpackageInfoAgain(url, key,type){
	getJCBpackageInfo_server(url).done(function(result) {
		if(result.owner || result.packages){
			jQuery.jStorage.set('JCB-packages-details'+key, result, {TTL: expire});
		}
	});
}

function getJCBpackageInfo(type){
	// show spinner
	jQuery('#loading').css('display', 'block');
	jQuery('#noticeboard').show();
	jQuery('#installer-import').hide();
	// get value
	var url = jQuery('#'+type+'_package').val();
	if (url) {
		var key = url.replace(/\W/g, '');
		// check if the values are local
		var result = jQuery.jStorage.get('JCB-packages-details'+key, null);
		if (result) {
			showJCBpackageInfo(result, key, type);
		} else {
			getJCBpackageInfoAgain(url, key, type);
		}
	} else {
		// hide spinner
		jQuery('#loading').hide();
		jQuery('#noticeboard').hide();
		jQuery('#installer-import').show();
		jQuery('#'+type+'_package_owner_details').html(' ');
		jQuery('#'+type+'_packages_details').html(' ');
		// some display moves
		jQuery('#'+type+'_packages_installer').removeClass('span6').addClass('span12');
		jQuery('#'+type+'_packages_display').removeClass('span6');
	}
}

function getJCBpackageInfoAgain(url, key,type){
	getJCBpackageInfo_server(url).done(function(result) {
		showJCBpackageInfo(result, key,type);
	});
}

function showJCBpackageInfo(result, key,type){
	if(result.owner || result.packages){
		jQuery('#'+type+'_packages_details').html(result.packages);
		jQuery('#'+type+'_package_owner_details').html(result.owner);
		jQuery.jStorage.set('JCB-packages-details'+key, result, {TTL: expire});
		// some display moves
		jQuery('#'+type+'_packages_installer').removeClass('span12').addClass('span6');
		jQuery('#'+type+'_packages_display').addClass('span6');
	} else {
		if (result.error) {
			jQuery('#'+type+'_packages_details').html(result.error);
		}
		jQuery('#'+type+'_package_owner_details').html(' ');
		jQuery('#'+type+'_noticeboard').show();
		// some display moves
		jQuery('#'+type+'_packages_installer').removeClass('span6').addClass('span12');
		jQuery('#'+type+'_packages_display').removeClass('span6');
	}
	// stop spinner
	jQuery('#loading').hide();
	jQuery('#noticeboard').hide();
	jQuery('#installer-import').show();
}

function getJCBpackageInfo_server(url){
	var getUrl = "index.php?option=com_componentbuilder&task=ajax.getJCBpackageInfo&format=json";
	if(token.length > 0 && url.length > 0){
		var request = 'token='+token+'&url=' + url;
	}
	return jQuery.ajax({
		type: 'GET',
		url: getUrl,
		dataType: 'jsonp',
		data: request,
		jsonp: 'callback'
	});
}
<?php endif; ?>

var noticeboard = "https://www.vdm.io/componentbuilder-noticeboard-md";
jQuery(document).ready(function () {
	jQuery.get(noticeboard)
	.success(function(board) { 
		if (board.length > 5) {
			jQuery(".noticeboard-md").html(marked(board));
			getIS(1,board).done(function(result) {
				if (result){
					jQuery(".vdm-new-notice").show();
					getIS(2,board);
				}
			});
		} else {
			jQuery(".noticeboard-md").html(all_is_good);
		}
	})
	.error(function(jqXHR, textStatus, errorThrown) { 
		jQuery(".noticeboard-md").html(all_is_good);
	});
});
// to check is READ/NEW
function getIS(type,notice){
	if (type == 1) {
		var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.isNew&format=json");
	} else if (type == 2) {
		var getUrl = JRouter("index.php?option=com_componentbuilder&task=ajax.isRead&format=json");
	}	
	if(token.length > 0 && notice.length){
		var request = "token="+token+"&notice="+notice;
	}
	return jQuery.ajax({
		type: "POST",
		url: getUrl,
		dataType: "jsonp",
		data: request,
		jsonp: "callback"
	});
}

jQuery('#adminForm').on('change', '#haskey',function (e)
{
	e.preventDefault();
	var haskey = jQuery("#haskey input[type='radio']:checked").val();
	if (haskey == 1) {
		jQuery("#sleutle").closest('.control-group').show();
	} else {
		jQuery("#sleutle").closest('.control-group').hide();
	}
});

// nice little dot trick :)
jQuery(document).ready( function($) {
  var x=0;
  setInterval(function() {
	var dots = "";
	x++;
	for (var y=0; y < x%8; y++) {
		dots+=".";
	}
	$(".loading-dots").text(dots);
  } , 500);
});

<?php
	$app = JFactory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'.JURI::root().'";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
