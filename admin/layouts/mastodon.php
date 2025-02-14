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

// Extract all keys from $displayData as individual variables.
extract($displayData ?? []);

// Default fallback values
$defaultValues = [
	[ // Llewellyn
		'account' => '112766899254600077',
		'instance' => 'https://joomla.social',
		'invite_url' => 'https://joomla.social/invite/gzAvC48K',
		'invite_heading' => Text::_("COM_COMPONENTBUILDER_LLEWELLYNS_JOOMLA_SOCIAL_FEED"),
		'invite_title' => Text::_("COM_COMPONENTBUILDER_JOIN_JCBS_LEAD_DEVELOPER_ON_JOOMLA_SOCIAL_A_MASTODON_INSTANCE")
//	], // removed since the feed is inactive at this time. if active, we can add it back in.
//	[ // Joomla
//		'account' => '112755435087541569',
//		'instance' => 'https://joomla.social',
//		'invite_url' => 'https://joomla.social/invite/PCXktw8g',
//		'invite_heading' => Text::_("COM_COMPONENTBUILDER_JOOMLA_SOCIAL_FEED"),
//		'invite_title' => Text::_("COM_COMPONENTBUILDER_JOIN_JOOMLA_SOCIAL_A_MASTODON_INSTANCE")
	]
];

// List of default accounts
$defaultAccounts ??= $defaultValues;

// function to retrieve active account
$getActiveAccount = function ($accounts, array $defaults): object {
	if (!empty($accounts) && is_array($accounts)) {
		// Select a random account and return it as an object
		return (object) $accounts[array_rand($accounts)];
	}
	// Return defaults as an object if no accounts are available
	return (object) $defaults;
};

// Get the active account
$activeAccount = $getActiveAccount($defaultAccounts, $defaultValues[0]);

// Assign values

// The 'id' parameter, defaulting to mastodon-feed.
$id ??= 'mastodon-feed';

// The button 'id' parameter, defaulting to refresh-feed.
$button_id ??= 'refresh-feed';

// The number of post to load
$posts ??= 5;

// The URL of the Mastodon instance to use; defaults to the instance of the selected account.
$instance ??= $activeAccount->instance;

// The unique account ID for the selected Mastodon account; defaults to the ID of the selected account.
$account ??= $activeAccount->account;

// The invitation URL for the Mastodon instance, used to invite others to join; defaults to the invite URL of the selected account.
$invite_url ??= $activeAccount->invite_url;

// The heading displayed for the invitation; defaults to the invite heading of the selected account.
$invite_heading ??= $activeAccount->invite_heading;

// The title displayed for the invitation; defaults to the invite title of the selected account.
$invite_title ??= $activeAccount->invite_title;


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
