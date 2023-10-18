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

namespace VDM\Joomla\Componentbuilder\Compiler\Language;


use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitchList;


/**
 * Compiler Language Fieldset
 * 
 * @since 3.2.0
 */
class Fieldset
{
	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The MetaData Class.
	 *
	 * @var   MetaData
	 * @since 3.2.0
	 */
	protected MetaData $metadata;

	/**
	 * The AccessSwitch Class.
	 *
	 * @var   AccessSwitch
	 * @since 3.2.0
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The AccessSwitchList Class.
	 *
	 * @var   AccessSwitchList
	 * @since 3.2.0
	 */
	protected AccessSwitchList $accessswitchlist;

	/**
	 * Constructor.
	 *
	 * @param Language           $language           The Language Class.
	 * @param MetaData           $metadata           The MetaData Class.
	 * @param AccessSwitch       $accessswitch       The AccessSwitch Class.
	 * @param AccessSwitchList   $accessswitchlist   The AccessSwitchList Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Language $language, MetaData $metadata,
		AccessSwitch $accessswitch,
		AccessSwitchList $accessswitchlist)
	{
		$this->language = $language;
		$this->metadata = $metadata;
		$this->accessswitch = $accessswitch;
		$this->accessswitchlist = $accessswitchlist;
	}

	/**
	 * Set the fieldset language
	 *
	 * @param   bool    $access          The access switch
	 * @param   bool    $metadata        The metadata switch
	 * @param   string  $langTarget      The language target
	 * @param   string  $langView        The single language view name
	 * @param   string  $langViews       The list language view name
	 * @param   string  $nameSingle      The single view name
	 * @param   string  $nameList        The list view name
	 * @param   string  $nameSingleCode  The single view code name
	 * @param   string  $nameListCode    The list view code name
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(bool $access, bool $metadata, string $langTarget, string $langView, string $langViews,
		string $nameSingle, string $nameList, string $nameSingleCode, string $nameListCode): void
	{
		// add metadata to the view
		if ($metadata)
		{
			$this->metadata->set($nameSingleCode, $nameListCode);
		}

		// add access to the view
		if ($access)
		{
			$this->accessswitch->set($nameSingleCode, true);
			$this->accessswitchlist->set($nameListCode, true);
		}

		// set default lang
		$this->language->set(
			$langTarget, $langView, $nameSingle
		);
		$this->language->set(
			$langTarget, $langViews, $nameList
		);
		// set global item strings
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_ARCHIVED',
			"%s " . $nameList . " archived."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_ARCHIVED_1',
			"%s " . $nameSingle . " archived."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_CHECKED_IN_0',
			"No " . $nameSingle
			. " successfully checked in."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_CHECKED_IN_1',
			"%d " . $nameSingle
			. " successfully checked in."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_CHECKED_IN_MORE',
			"%d " . $nameList
			. " successfully checked in."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_DELETED',
			"%s " . $nameList . " deleted."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_DELETED_1',
			"%s " . $nameSingle . " deleted."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_FEATURED',
			"%s " . $nameList . " featured."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_FEATURED_1',
			"%s " . $nameSingle . " featured."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_PUBLISHED',
			"%s " . $nameList . " published."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_PUBLISHED_1',
			"%s " . $nameSingle . " published."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_TRASHED',
			"%s " . $nameList . " trashed."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_TRASHED_1',
			"%s " . $nameSingle . " trashed."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_UNFEATURED',
			"%s " . $nameList . " unfeatured."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_UNFEATURED_1',
			"%s " . $nameSingle . " unfeatured."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_UNPUBLISHED',
			"%s " . $nameList . " unpublished."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_UNPUBLISHED_1',
			"%s " . $nameSingle . " unpublished."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_FAILED_PUBLISHING',
			"%s " . $nameList . " failed publishing."
		);
		$this->language->set(
			$langTarget, $langViews . '_N_ITEMS_FAILED_PUBLISHING_1',
			"%s " . $nameSingle . " failed publishing."
		);
		$this->language->set(
			$langTarget, $langViews . '_BATCH_OPTIONS',
			"Batch process the selected " . $nameList
		);
		$this->language->set(
			$langTarget, $langViews . '_BATCH_TIP',
			"All changes will be applied to all selected "
			. $nameList
		);
		// set some basic defaults
		$this->language->set(
			$langTarget, $langView . '_ERROR_UNIQUE_ALIAS',
			"Another " . $nameSingle
			. " has the same alias."
		);
		$this->language->set(
			$langTarget, $langView . '_CREATED_DATE_LABEL', "Created Date"
		);
		$this->language->set(
			$langTarget, $langView . '_CREATED_DATE_DESC',
			"The date this " . $nameSingle
			. " was created."
		);
		$this->language->set(
			$langTarget, $langView . '_MODIFIED_DATE_LABEL', "Modified Date"
		);
		$this->language->set(
			$langTarget, $langView . '_MODIFIED_DATE_DESC',
			"The date this " . $nameSingle
			. " was modified."
		);
		$this->language->set(
			$langTarget, $langView . '_CREATED_BY_LABEL', "Created By"
		);
		$this->language->set(
			$langTarget, $langView . '_CREATED_BY_DESC',
			"The user that created this " . $nameSingle
			. "."
		);
		$this->language->set(
			$langTarget, $langView . '_MODIFIED_BY_LABEL', "Modified By"
		);
		$this->language->set(
			$langTarget, $langView . '_MODIFIED_BY_DESC',
			"The last user that modified this "
			. $nameSingle . "."
		);
		$this->language->set(
			$langTarget, $langView . '_ORDERING_LABEL', "Ordering"
		);
		$this->language->set(
			$langTarget, $langView . '_VERSION_LABEL', "Version"
		);
		$this->language->set(
			$langTarget, $langView . '_VERSION_DESC',
			"A count of the number of times this "
			. $nameSingle . " has been revised."
		);
		$this->language->set(
			$langTarget, $langView . '_SAVE_WARNING',
			"Alias already existed so a number was added at the end. You can re-edit the "
			. $nameSingle . " to customise the alias."
		);
	}
}

