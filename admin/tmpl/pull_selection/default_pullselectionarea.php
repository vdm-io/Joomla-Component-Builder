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
use VDM\Joomla\Utilities\StringHelper;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

// No direct access to this file
defined('_JEXEC') or die;

$area = $this->item['area_class'] ?? 'error';
$area_name = $this->item['area_name'] ?? 'error';
$headers = $this->item['headers'] ?? [];
$table_id = StringHelper::random(10);
$repo_items = $this->item['repos'] ?? [];
$repos = [];
foreach ($repo_items as $repo)
{
	if (!empty($repo->base) && !empty($repo->path))
	{
		$repos[] = LayoutHelper::render('reposelectioncardbody', ['repo' => $repo, 'area' => $area, 'name' => $area_name]);
	}
}
// set the base URL
$url_base = Uri::base() . 'index.php?option=com_componentbuilder';

?>
<?php if ($area !== null && !empty($repos) && !empty($headers)): ?>
<script type="text/javascript">

	// get page body
	var outerBodyDiv = document.querySelector('body');

	// start loading spinner
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';

	// Set CSS properties individually
	loadingDiv.style.background = "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/ajax.gif') 50% 35% no-repeat";
	loadingDiv.style.top = (outerBodyDiv.getBoundingClientRect().top + window.pageYOffset) + "px";
	loadingDiv.style.left = (outerBodyDiv.getBoundingClientRect().left + window.pageXOffset) + "px";
	loadingDiv.style.width = outerBodyDiv.offsetWidth + "px";
	loadingDiv.style.height = outerBodyDiv.offsetHeight + "px";
	loadingDiv.style.position = 'fixed';
	loadingDiv.style.opacity = '0.80';
	loadingDiv.style.msFilter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
	loadingDiv.style.filter = "alpha(opacity=80)";
	loadingDiv.style.display = 'none';

	// add to page body
	outerBodyDiv.appendChild(loadingDiv);
	jQuery.extend( true, jQuery.fn.dataTable.defaults, {
		"searching": false
	});
</script>
<div id="select-repo-area">
	<p><?php echo Text::_('COM_COMPONENTBUILDER_SELECT_A_REPOSITORY_TO_PULL_ITEMS_FROM'); ?>...</p>
	<div class="uk-child-width-1-2@s uk-child-width-1-3@m" uk-grid>
	<?php foreach ($repos as $repo): ?>
		<?php echo $repo; ?>
	<?php endforeach; ?>
	</div>
</div>
<div id="select-powers-area" style="display: none">
	<p><?php echo Text::sprintf('COM_COMPONENTBUILDER_SELECT_THE_S_ITEMS_TO_PULL', $area_name); ?>...</p>
	<?php echo LayoutHelper::render('powerpullselectiontable', ['area' => $area, 'headers' => $headers, 'id' => $table_id]); ?>
	<div class="subhead">
		<div class="btn-toolbar d-flex">
			<joomla-toolbar-button>
				<button type="button" id="pull-selected-powers" class="btn btn-primary" disable><?php echo Text::sprintf('COM_COMPONENTBUILDER_PULL_SELECTED_S_ITEMS', $area_name); ?></button>
			</joomla-toolbar-button>
			<joomla-toolbar-button>
				<button type="button" id="back-to-select-repo" class="btn btn-info"><?php echo Text::_('COM_COMPONENTBUILDER_BACK_TO_REPOSITORY_SELECTION'); ?></button>
			</joomla-toolbar-button>
		</div>
	</div>
</div>
<script type="text/javascript">
// the search Ajax URLs
const UrlAjax = '<?php echo $url_base; ?>&format=json&raw=true&<?php echo Session::getFormToken(); ?>=1&task=ajax.';
// fix the night mode scheme
document.addEventListener("DOMContentLoaded", () => {
	const html = document.documentElement;
	const colorScheme = html.getAttribute('data-color-scheme');
	if (colorScheme === 'dark' || colorScheme === 'light') {
		// Ensure only one scheme class is active
		html.classList.remove('light', 'dark');
		html.classList.add(colorScheme);
		// Update repo selection cards based on color scheme
		document.querySelectorAll('.repo-selection-card').forEach(card => {
			card.classList.remove('uk-light', 'uk-dark', 'uk-background-secondary', 'uk-background-muted');
			if (colorScheme === 'dark') {
				card.classList.add('uk-light', 'uk-background-secondary');
			} else {
				card.classList.add('uk-dark', 'uk-background-muted');
			}
		});
	}
});
</script>
<?php else: ?>
	<div class="uk-alert-primary" uk-alert>
		<?php echo Text::_('COM_COMPONENTBUILDER_NO_ACTIVE_REPOSITORIES_FOUND_FOR_THIS_AREA_YOU_CAN_ADD_REPOSITORIES_IN_THE_REPOSITORIES_SECTION_OF_JCB'); ?>
	</div>
<?php endif; ?>
