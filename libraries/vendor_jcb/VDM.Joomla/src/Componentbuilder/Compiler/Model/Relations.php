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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListJoin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ListHeadOverride;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldRelations;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Model Relations Class
 * 
 * @since 3.2.0
 */
class Relations
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The ListJoin Class.
	 *
	 * @var   ListJoin
	 * @since 3.2.0
	 */
	protected ListJoin $listjoin;

	/**
	 * The ListHeadOverride Class.
	 *
	 * @var   ListHeadOverride
	 * @since 3.2.0
	 */
	protected ListHeadOverride $listheadoverride;

	/**
	 * The FieldRelations Class.
	 *
	 * @var   FieldRelations
	 * @since 3.2.0
	 */
	protected FieldRelations $fieldrelations;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Language           $language           The Language Class.
	 * @param Customcode         $customcode         The Customcode Class.
	 * @param ListJoin           $listjoin           The ListJoin Class.
	 * @param ListHeadOverride   $listheadoverride   The ListHeadOverride Class.
	 * @param FieldRelations     $fieldrelations     The FieldRelations Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language, Customcode $customcode, ListJoin $listjoin,
		ListHeadOverride $listheadoverride, FieldRelations $fieldrelations)
	{
		$this->config = $config;
		$this->language = $language;
		$this->customcode = $customcode;
		$this->listjoin = $listjoin;
		$this->listheadoverride = $listheadoverride;
		$this->fieldrelations = $fieldrelations;
	}

	/**
	 * Set the relations
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addrelations = (isset($item->addrelations)
			&& JsonHelper::check($item->addrelations))
			? json_decode((string) $item->addrelations, true) : null;

		if (ArrayHelper::check($item->addrelations))
		{
			foreach ($item->addrelations as $nr => $relationsValue)
			{
				// only add if list view field is selected and joined fields are set
				if (isset($relationsValue['listfield'])
					&& is_numeric(
						$relationsValue['listfield']
					)
					&& $relationsValue['listfield'] > 0
					&& isset($relationsValue['area'])
					&& is_numeric($relationsValue['area'])
					&& $relationsValue['area'] > 0)
				{
					// do a dynamic update on the set values
					if (isset($relationsValue['set'])
						&& StringHelper::check(
							$relationsValue['set']
						))
					{
						$relationsValue['set'] = $this->customcode->update(
							$relationsValue['set']
						);
					}

					// load the field relations
					$this->fieldrelations->set($item->name_list_code . '.' . (int) $relationsValue['listfield']
						. '.' . (int) $relationsValue['area'], $relationsValue);

					// load the list joints
					if (isset($relationsValue['joinfields'])
						&& ArrayHelper::check(
							$relationsValue['joinfields']
						))
					{
						foreach ($relationsValue['joinfields'] as $join)
						{
							$this->listjoin->set($item->name_list_code . '.' . (int) $join, (int) $join);
						}
					}

					// set header over-ride
					if (isset($relationsValue['column_name'])
						&& StringHelper::check(
							$relationsValue['column_name']
						))
					{
						$check_column_name = trim(
							strtolower((string) $relationsValue['column_name'])
						);

						// confirm it should really make the over ride
						if ('default' !== $check_column_name)
						{
							$column_name_lang = $this->config->lang_prefix . '_'
								. StringHelper::safe(
									$item->name_list_code, 'U'
								) . '_' . StringHelper::safe(
									$relationsValue['column_name'], 'U'
								);
							$this->language->set(
								'admin', $column_name_lang,
								$relationsValue['column_name']
							);
							$this->listheadoverride->
								set($item->name_list_code . '.' . (int) $relationsValue['listfield'],
									$column_name_lang
							);

						}
					}
				}
			}
		}

		unset($item->addrelations);
	}
}

