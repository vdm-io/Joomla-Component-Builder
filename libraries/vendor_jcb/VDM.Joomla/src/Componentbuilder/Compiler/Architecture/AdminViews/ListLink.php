<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAdminAdded;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAdminViewListId;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomAdminViewListLink;
use VDM\Joomla\Componentbuilder\Compiler\Builder\DynamicButtons;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\ListLinkInterface;


/**
 * Admin List View Custom Admin Link Class.
 * 
 * Resolves which custom admin views are reachable from an admin view and
 * records them: views filtered by the item id become per-row list links,
 * every other view becomes a list toolbar button. Also generates the
 * per-row link buttons from the recorded state.
 * 
 * @since  6.1.7
 */
final class ListLink implements ListLinkInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The CustomAdminViewListLink Class.
	 *
	 * @var   CustomAdminViewListLink
	 * @since 6.1.7
	 */
	protected CustomAdminViewListLink $listlink;

	/**
	 * The CustomAdminViewListId Class.
	 *
	 * @var   CustomAdminViewListId
	 * @since 6.1.7
	 */
	protected CustomAdminViewListId $listid;

	/**
	 * The CustomAdminAdded Class.
	 *
	 * @var   CustomAdminAdded
	 * @since 6.1.7
	 */
	protected CustomAdminAdded $added;

	/**
	 * The DynamicButtons Class.
	 *
	 * @var   DynamicButtons
	 * @since 6.1.7
	 */
	protected DynamicButtons $dynamicbuttons;

	/**
	 * Constructor.
	 *
	 * @param Config                    $config           The Config Class.
	 * @param Component                 $component        The Component Class.
	 * @param ContentOne                $contentone       The ContentOne Class.
	 * @param CustomAdminViewListLink   $listlink         The CustomAdminViewListLink Class.
	 * @param CustomAdminViewListId     $listid           The CustomAdminViewListId Class.
	 * @param CustomAdminAdded          $added            The CustomAdminAdded Class.
	 * @param DynamicButtons            $dynamicbuttons   The DynamicButtons Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Component $component,
		ContentOne $contentone, CustomAdminViewListLink $listlink,
		CustomAdminViewListId $listid, CustomAdminAdded $added,
		DynamicButtons $dynamicbuttons)
	{
		$this->config = $config;
		$this->component = $component;
		$this->contentone = $contentone;
		$this->listlink = $listlink;
		$this->listid = $listid;
		$this->added = $added;
		$this->dynamicbuttons = $dynamicbuttons;
	}

	/**
	 * Record the custom admin views reachable from an admin view.
	 *
	 * A custom admin view whose main Dynamic Get filters on the item id
	 * becomes a per-row list link; any other reachable view becomes a list
	 * toolbar button. Every resolved view is recorded as added so the menu
	 * builders do not add it again.
	 *
	 * @param   array   $view          The admin view definition.
	 * @param   string  $nameListCode  The list code name of the view.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(array $view, string $nameListCode): void
	{
		if ($this->component->isArray('custom_admin_views'))
		{
			foreach ($this->component->get('custom_admin_views') as $custom_admin_view)
			{
				if (isset($custom_admin_view['adminviews'])
					&& ArrayHelper::check(
						$custom_admin_view['adminviews']
					))
				{
					foreach ($custom_admin_view['adminviews'] as $adminview)
					{
						if (isset($view['adminview'])
							&& $view['adminview'] == $adminview)
						{
							// set the needed keys
							$setId = false;
							if (ArrayHelper::check(
								$custom_admin_view['settings']->main_get->filter
							))
							{
								foreach (
									$custom_admin_view['settings']->main_get->filter
									as $filter
								)
								{
									if ($filter['filter_type'] == 1
										|| '$id' == $filter['state_key'])
									{
										$setId = true;
									}
								}
							}
							// set the needed array values
							$set = array(
								'icon' => $custom_admin_view['icomoon'],
								'link' => $custom_admin_view['settings']->code,
								'NAME' => $custom_admin_view['settings']->CODE,
								'name' => $custom_admin_view['settings']->name);
							// only load to list if it has id filter
							if ($setId)
							{
								// now load it to the global object for items list
								$this->listlink->add($nameListCode, $set, true);
								// add to set id for list view if needed
								$this->listid->set(
									$custom_admin_view['settings']->code, true
								);
							}
							else
							{
								// now load it to the global object for tool bar
								$this->dynamicbuttons->add($nameListCode, $set);
							}
							// log that it has been added already
							$this->added->set(
								$custom_admin_view['settings']->code, $adminview
							);
						}
					}
				}
			}
		}
	}

	/**
	 * Get the custom admin view buttons of an admin list view row.
	 *
	 * @param   string  $nameListCode  The list code name of the view.
	 * @param   string  $ref           The link referral string.
	 *
	 * @return  string  The generated buttons, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function getButtons(string $nameListCode, string $ref = ''): string
	{
		$customAdminViewButton = '';
		// check if custom links should be added to this list views
		if (($links = $this->listlink->get($nameListCode)) !== null
			&& ArrayHelper::check($links))
		{
			// start building the links
			$customAdminViewButton .= PHP_EOL . Indent::_(3)
				. '<div class="btn-group">';
			foreach ($links as $customLinkView)
			{
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php if (\$canDo->get('" . $customLinkView['link']
					. ".access')): ?>";
				$customAdminViewButton .= PHP_EOL . Indent::_(4)
					. '<a class="hasTooltip btn btn-mini" href="index.php?option=com_'
					. $this->config->component_code_name . '&view='
					. $customLinkView['link'] . '&id=<?php echo $item->id; ?>'
					. $ref . '" title="<?php echo Joomla__' . '_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_(' . "'COM_"
					. $this->contentone->get('COMPONENT') . '_' . $customLinkView['NAME'] . "'"
					. '); ?>" ><span class="icon-' . $customLinkView['icon']
					. '"></span></a>';
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php else: ?>";
				$customAdminViewButton .= PHP_EOL . Indent::_(4)
					. '<a class="hasTooltip btn btn-mini disabled" href="#" title="<?php echo Text:'
					. ':_(' . "'COM_" . $this->contentone->get('COMPONENT') . '_' . $customLinkView['NAME']
					. "'" . '); ?>"><span class="icon-'
					. $customLinkView['icon'] . '"></span></a>';
				$customAdminViewButton .= PHP_EOL . Indent::_(3)
					. "<?php endif; ?>";
			}
			$customAdminViewButton .= PHP_EOL . Indent::_(3) . '</div>';
		}

		return $customAdminViewButton;
	}
}

