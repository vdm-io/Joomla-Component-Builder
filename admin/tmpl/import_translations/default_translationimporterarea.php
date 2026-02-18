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

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

// No direct access to this file
defined('_JEXEC') or die;

if (!empty($this->item->file_type))
{
$target = base64_encode('import_translations');

		$app = $this->app ?? Factory::getApplication();

		// set the url as needed
		$url = '';
		if (method_exists($app, 'isClient') && $app->isClient('site'))
		{
			$url = Uri::root();
		}

		// get the form token
		$token = Session::getFormToken();
		$entity ??= $this->item->guid ?? 0;
		$target ??= base64_encode('joomla_plugin_files_folders_urls');

		// Define the configuration for the uploader
		$uploaderConfig = [
			"endpoint_type" => "{$url}index.php?option=com_componentbuilder&task=ajax.getTranslationDetails&format=json&raw=true&{$token}=1&target={$target}",
			"target_class" => "vdm-uikit-uploader",
			"file_vdm_uploader" => [
				"endpoint_upload" => "{$url}index.php?option=com_componentbuilder&task=ajax.uploadTranslation&format=json&raw=true&{$token}=1&entity={$entity}&target={$target}",
				"endpoint_display" => "{$url}index.php?option=com_componentbuilder&task=ajax.displayTranslationColumns&format=json&raw=true&{$token}=1&entity={$entity}&target={$target}",
				"endpoint_delete" => "{$url}index.php?option=com_componentbuilder&task=ajax.deleteTranslation&format=json&raw=true&{$token}=1",
			],
		];

		// Convert the PHP array to a JavaScript object
		$uploaderConfigJson = json_encode($uploaderConfig);
		$script = "(window.VDM ??= {}).uikit ??= {}; window.VDM.uikit.config = {$uploaderConfigJson};";

		/** @var \Joomla\CMS\Document\Document $document */
		$document ??= ($this->getDocument() ?? $app->getDocument());

		// Use WebAssetManager if available (Joomla 4+), otherwise fallback
		if (method_exists($document, 'getWebAssetManager'))
		{
			/** @var \Joomla\CMS\WebAsset\WebAssetManager $wa */
			$wa = $document -> getWebAssetManager(); // note the ...ment[space]->[space]getWebAs... convention (without it JCB will convert the call to $this->getDocument())
			$wa->addInlineScript($script);
		}
		else
		{
			$document -> addScriptDeclaration($script);
		}

		Html::_('script', 'media/com_componentbuilder/uikit-v3/js/uikit.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v3/js/uikit-icons.min.js', ['version' => 'auto']);
		Html::_('script', 'https://cdn.jsdelivr.net/gh/joomengine/uikit@3.0.2/dist/js/vdm.min.js', ['version' => 'auto']);
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v3/css/uikit.min.css', ['version' => 'auto']);
}

?>
<?php if (empty($this->item->file_type)): ?>
<div class="alert alert-warning" role="alert">
	<?php echo Text::_('COM_COMPONENTBUILDER_THE_IMPORT_FILE_TYPE_HAS_NOT_BEEN_CONFIGURED_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_ASSISTANCE'); ?>
</div>
<?php else: ?>
<select id="file_type" name="file_type" style="display: none;">
	<option value="<?php echo $this->item->file_type; ?>" selected><?php echo Text::_('COM_COMPONENTBUILDER_IMPORT_TYPE'); ?></option>
</select>
<div id='file_vdm_uploader' class='vdm-uikit-uploader uk-placeholder uk-text-center'
	data-type-id='file_type'
	data-progressbar-id='file_vdm_progressbar'
	data-display-id='file_vdm_display'
	data-success-id='file_vdm_success'
	data-error-id='file_vdm_error'
	data-allowed-format-id='file_vdm_allowed_format'
	data-file-type-id='file_vdm_file_type'
>
    <span uk-icon='icon: cloud-upload'></span>
    <span class='uk-text-middle'><?php echo Text::_('COM_COMPONENTBUILDER_IMPORT'); ?> <span id='file_vdm_file_type'>translations</span> <?php echo Text::_('COM_COMPONENTBUILDER_BY_DROPPING_IT_HERE_OR'); ?></span>
    <div uk-form-custom>
	   <input type='file'>
	   <span class='uk-link'><?php echo Text::_('COM_COMPONENTBUILDER_SELECTING_ONE'); ?></span> <span id='file_vdm_allowed_format'></span>
    </div>
</div>
<progress id='file_vdm_progressbar' class='uk-progress' value='0' max='100' hidden></progress>
<br>
<div id='file_vdm_success' hidden></div>
<div id='file_vdm_error' hidden></div>
<div id='file_vdm_display' hidden></div>
<script type="text/javascript">
document.addEventListener('vdm.uikit.display.beforeFilesDisplay', function(event) {
    let state = event.detail?.result?.state ?? 0;
    if (state === 1 && window.VDM?.uikit?.config?.target_class) {
        let targetClass = window.VDM.uikit.config.target_class;
        let elements = document.getElementsByClassName(targetClass);

        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = 'none';
        }
    }
});
document.addEventListener('vdm.uikit.uploader.complete', function(event) {
    let response = event.detail?.xhr?.responseText ?? null;
    if (response) {
        try {
            // Parse the response JSON
            response = JSON.parse(response);
            // Check for the 'error' property in the response
            if (response.error) {
                // Show a Uikit notification for the error
                window.UIkit.notification({
                    message: response.error,  // Display the error message
                    status: 'danger',          // Set the notification type to 'error'
                    pos: 'top-center',         // Position of the notification
                    timeout: 7000              // Display time in milliseconds
                });
            }
        } catch (e) {
            console.error('Error parsing JSON response:', e);
        }
    }
});
document.addEventListener('vdm.uikit.delete.beforeFileRemoveFromUI', function(event) {
    if (window.VDM?.uikit?.config?.target_class) {
        let targetClass = window.VDM.uikit.config.target_class;
        let elements = document.getElementsByClassName(targetClass);
        for (let i = 0; i < elements.length; i++) {
            elements[i].style.display = '';
        }
        let subformArea = document.getElementById('subform-display-area');
        if (subformArea) {
            subformArea.style.display = 'none';
        }
    }
});
</script>
<?php endif; ?>
