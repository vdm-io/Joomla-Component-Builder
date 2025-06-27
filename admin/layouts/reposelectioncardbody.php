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



use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

$base = $displayData['repo']->base ?? null;
$path = $displayData['repo']->path ?? null;
$type = $displayData['repo']->type ?? 0;
$url = "#";
if (!empty($base) && !empty($path))
{
	// if the type is GitHub = 2
	if ($type == 2)
	{
		$base = 'https://github.com';
	}

	$url = "{$base}/{$path}";
}
$name = $displayData['name'] ?? 'error';
$area = $displayData['area'] ?? 'error';
$organisation = $displayData['repo']->organisation ?? 'error';
$repository = $displayData['repo']->repository ?? 'error';
$read_branch = $displayData['repo']->read_branch ?? 'error';
$guid = $displayData['repo']->guid ?? 'error';

?>
<div>
	<div class="uk-card repo-selection-card">
		<div class="uk-card-header">
			<?php echo $name; ?>: <a class="uk-link-heading" href="<?php echo $url; ?>" target="_blank" title="<?php echo Text::sprintf('COM_COMPONENTBUILDER_OPEN_THIS_REMOTE_S_REPOSITORY', $name); ?>"><?php echo $url; ?></a>
		</div>
		<div class="uk-card-body">
			<ul class="uk-list uk-list-disc">
				<li><?php echo Text::_('COM_COMPONENTBUILDER_ORGANISATION'); ?>: <code><?php echo $organisation; ?></code></li>
				<li><?php echo Text::_('COM_COMPONENTBUILDER_REPOSITORY'); ?>: <code><?php echo $repository; ?></code></li>
				<li><?php echo Text::_('COM_COMPONENTBUILDER_BRANCH'); ?>: <code><?php echo $read_branch; ?></code></li>
			</ul>
		</div>
		<div class="uk-card-footer">
			<button type="button"
				class="uk-button uk-button-primary uk-width-1-1 select-repo-to-initialize"
				data-repo="<?php echo $guid; ?>"
				data-area="<?php echo $area; ?>">
					<?php echo Text::sprintf('COM_COMPONENTBUILDER_LOAD_ITEMS_FROM_THIS_S_REPOSITORY', $name); ?>
			</button>
		</div>
	</div>
</div>
