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

// No direct access to this file
defined('JPATH_BASE') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;

// Extract all keys from $displayData as individual variables.
extract($displayData ?? []);

// The 'id' parameter, defaulting to mastodon-feed.
$id ??= 'mastodon-feed';

// The button 'id' parameter, defaulting to refresh-feed.
$button_id ??= 'refresh-feed';

// The mastodon instance URL
$instance ??= 'https://joomla.social';

// The user account ID
$account ??= '112766899254600077';

// The number of post to load
$posts ??= 5;

// The 'invite_url' parameter, defaulting to https://joomla.social/invite/gzAvC48K.
$invite_url ??= 'https://joomla.social/invite/gzAvC48K';

// The 'invite_heading' parameter.
$invite_heading ??= Text::_("COM_COMPONENTBUILDER_LLEWELLYNS_JOOMLA_SOCIAL_FEED");

// The 'invite_title' parameter.
$invite_title ??= Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_LEAD_DEVELOPER_ON_JOOMLA_SOCIAL_A_MASTODON_INSTANCE");

?>
<div  class="well well-small mastadon-display-block">
	<h2>
		<a
			href="<?php echo $invite_url; ?>"
			title="<?php echo $invite_title; ?>">
				<?php echo $invite_heading; ?>
		</a>&nbsp;&nbsp;
		<a
			type="button"
			id="<?php echo $button_id; ?>"
			href="#"
			title="<?php echo Text::_('COM_COMPONENTBUILDER_REFRESH_FEED'); ?>">
				<i class="icon-loop"></i>
		</a>
	</h2>
	<div id="<?php echo $id; ?>"
		data-instance="<?php echo $instance; ?>"
		data-account-id="<?php echo $account; ?>"
		data-post-count="<?php echo $posts; ?>">
	</div>
	<script>
		new MastodonFeed("<?php echo $id; ?>", "<?php echo $button_id; ?>");
	</script>
</div>
