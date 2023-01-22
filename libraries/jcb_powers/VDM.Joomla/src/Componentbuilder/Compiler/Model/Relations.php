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


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

	/**
	 * Compiler Language
	 *
	 * @var    Language
	 * @since 3.2.0
	 **/
	protected Language $language;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null              $registry        The compiler registry object.
	 * @param Language|null             $language         The compiler Language object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Language $language = null, ?Customcode $customcode = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->language = $language ?: Compiler::_('Language');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
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
					$this->registry->set('builder.field_relations.'
						. $item->name_list_code . '.' . (int) $relationsValue['listfield']
						. '.' . (int) $relationsValue['area'], $relationsValue);

					// load the list joints
					if (isset($relationsValue['joinfields'])
						&& ArrayHelper::check(
							$relationsValue['joinfields']
						))
					{
						foreach ($relationsValue['joinfields'] as $join)
						{
							$this->registry->set('builder.list_join.' . $item->name_list_code . '.' . (int) $join, (int) $join);
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
							$this->registry->set('builder.list_head_override.' .
								$item->name_list_code . '.' . (int) $relationsValue['listfield'],
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

