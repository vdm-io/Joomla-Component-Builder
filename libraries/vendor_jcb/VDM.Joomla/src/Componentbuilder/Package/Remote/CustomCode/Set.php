<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Package\Remote\CustomCode;


use VDM\Joomla\Interfaces\Data\LoadInterface as Load;
use VDM\Joomla\Componentbuilder\Package\Dependency\Tracker;
use VDM\Joomla\Componentbuilder\Package\MessageBus as Messages;
use VDM\Joomla\Interfaces\GrepInterface as Grep;
use VDM\Joomla\Interfaces\Remote\Dependency\ResolverInterface as Resolver;
use VDM\Joomla\Interfaces\Remote\ConfigInterface as Config;
use VDM\Joomla\Interfaces\Readme\ItemInterface as ItemReadme;
use VDM\Joomla\Interfaces\Readme\MainInterface as MainReadme;
use VDM\Joomla\Interfaces\Git\Repository\ContentsInterface as Git;
use VDM\Joomla\Interfaces\Data\ItemsInterface as Items;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Remote\Set as ExtendingSet;


/**
 * Set Custom Code based on function names to remote repository
 * 
 * @since 5.1.1
 */
final class Set extends ExtendingSet implements SetInterface
{
	/**
	 * The Data Load Class.
	 *
	 * @var   Load
	 * @since 5.1.1
	 */
	protected Load $load;

	/**
	 * Cache component names
	 *
	 * @var   array
	 * @since 5.1.1
	 **/
	protected array $component_names;

	/**
	 * Constructor.
	 *
	 * @param Load         $load                The Data Load Class.
	 * @param Tracker      $tracker            The Tracker Class.
	 * @param Messages     $messages            The Message Bus Class.
	 * @param Grep         $grep                The Grep Class.
	 * @param Resolver     $resolver            The Resolver Class.
	 * @param Config       $config              The Config Class.
	 * @param ItemReadme   $itemreadme          The Item Readme Class.
	 * @param MainReadme   $mainreadme          The Main Readme Class.
	 * @param Git          $git                 The Contents Git Class.
	 * @param Items        $items               The Items Class.
	 * @param string|null  $table               The table name.
	 * @param string|null  $settingsPath        The settings path.
	 * @param string|null  $settingsIndexPath   The index settings path.
	 *
	 * @since 5.1.1
	 */
	public function __construct(Load $load, Tracker $tracker, Messages $messages, Grep $grep, Resolver $resolver,
		Config $config, ItemReadme $itemreadme, MainReadme $mainreadme,
		Git $git, Items $items, array $repos, ?string $table = null,
		?string $settingsPath = null, ?string $indexPath = null)
	{
		parent::__construct($tracker, $messages, $grep, $resolver, $config, $itemreadme,
			$mainreadme, $git, $items, $repos, $table, $settingsPath, $indexPath);

		$this->load = $load;
	}

	/**
	 * Get the item name for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.1.1
	 */
	protected function index_map_IndexName(object $item): ?string
	{
		if ($item->target == 1)
		{
			if (isset($this->component_names[$item->component]))
			{
				$component_name = $this->component_names[$item->component] ?? '[error loading the name]';
			}
			else
			{
				$this->component_names[$item->component] = $this->load->table('joomla_component')->value(['guid' => $item->component], 'system_name');
				$component_name = $this->component_names[$item->component] ?? '[error loading the name]';
			}
			return "Component: {$component_name}";
		}
		return $item->system_name ?? null;
	}

	/**
	 * Get the item Short Description for the index values
	 *
	 * @param object $item
	 *
	 * @return string|null
	 * @since  5.1.1
	 */
	protected function index_map_ShortDescription(object $item): ?string
	{
		if ($item->target == 1)
		{
			$comment = ($item->comment_type == 1) ? 'PHP/JS' : 'HTML';
			$type = ($item->type == 1) ? 'Replacement' : 'Insertion';
			$version = $item->joomla_version ?? 5;
			return "Hash (automation) | {$comment} [{$type}] | J{$version}";
		}
		return 'JCB (manual)';
	}

	/**
	 * Get the item GUID for the index values
	 *
	 * @param object $item
	 *
	 * @return string
	 * @since  5.1.1
	 */
	protected function index_map_IndexGUID(object $item): string
	{
		if ($item->target == 1)
		{
			$path = str_replace('/', '#', $item->path);
			if (!empty($path))
			{
				return $path;
			}
		}
		$guid_field = $this->getGuidField();
		return  $item->{$guid_field} ?? 'error';
	}
}

