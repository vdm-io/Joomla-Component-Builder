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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OrderZero;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TabCounter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Layout as BuilderLayout;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MovedPublishingFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\NewPublishingFields;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Layout Creator Class
 * 
 * @since 3.2.0
 */
final class Layout
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The OrderZero Class.
	 *
	 * @var   OrderZero
	 * @since 3.2.0
	 */
	protected OrderZero $orderzero;

	/**
	 * The TabCounter Class.
	 *
	 * @var   TabCounter
	 * @since 3.2.0
	 */
	protected TabCounter $tabcounter;

	/**
	 * The Builder Layout Class.
	 *
	 * @var   BuilderLayout
	 * @since 3.2.0
	 */
	protected BuilderLayout $layout;

	/**
	 * The MovedPublishingFields Class.
	 *
	 * @var   MovedPublishingFields
	 * @since 3.2.0
	 */
	protected MovedPublishingFields $movedpublishingfields;

	/**
	 * The NewPublishingFields Class.
	 *
	 * @var   NewPublishingFields
	 * @since 3.2.0
	 */
	protected NewPublishingFields $newpublishingfields;

	/**
	 * Constructor.
	 *
	 * @param Config                  $config                  The Config Class.
	 * @param OrderZero               $orderzero               The OrderZero Class.
	 * @param TabCounter              $tabcounter              The TabCounter Class.
	 * @param BuilderLayout           $layout                  The Layout Class.
	 * @param MovedPublishingFields   $movedpublishingfields   The MovedPublishingFields Class.
	 * @param NewPublishingFields     $newpublishingfields     The NewPublishingFields Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, OrderZero $orderzero,
		TabCounter $tabcounter, BuilderLayout $layout,
		MovedPublishingFields $movedpublishingfields,
		NewPublishingFields $newpublishingfields)
	{
		$this->config = $config;
		$this->orderzero = $orderzero;
		$this->tabcounter = $tabcounter;
		$this->layout = $layout;
		$this->movedpublishingfields = $movedpublishingfields;
		$this->newpublishingfields = $newpublishingfields;
	}

	/**
	 * set the layout builders
	 *
	 * @param   string  $nameSingleCode  The single edit view code name
	 * @param   string  $tabName         The tab code name
	 * @param   string  $name            The field code name
	 * @param   array   $field           The field details
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(string $nameSingleCode, string $tabName, string $name, array &$field): void
	{
		// first fix the zero order
		// to insure it lands before all the other fields
		// as zero is expected to behave
		if ($field['order_edit'] == 0)
		{
			// get the value
			$zero_counter = $this->orderzero->get($nameSingleCode . '.' . $field['tab'], -999);
			if ($zero_counter != -999)
			{
				$zero_counter++;
			}
			$field['order_edit'] = $zero_counter;
			// set the value
			$this->orderzero->set($nameSingleCode . '.' . $field['tab'], $zero_counter);
		}
		// get the default fields
		$default_fields = $this->config->default_fields;
		// now build the layout
		if (StringHelper::check($tabName)
			&& strtolower($tabName) != 'publishing')
		{
			$this->tabcounter->set($nameSingleCode . '.' . $field['tab'], $tabName);
			if ($this->layout->exists($nameSingleCode . '.' . $tabName . '.'
				. $field['alignment'] . '.' . $field['order_edit']))
			{
				$size = $this->layout->count($nameSingleCode . '.' . $tabName . '.'
							. $field['alignment']) + 1;
				while ($this->layout->exists($nameSingleCode . '.' . $tabName . '.'
					. $field['alignment'] . '.' . $size))
				{
					$size++;
				}
				$this->layout->set($nameSingleCode . '.' . $tabName . '.'
					. $field['alignment'] . '.' . $size, $name);
			}
			else
			{
				$this->layout->set($nameSingleCode . '.'
					. $tabName . '.' . $field['alignment'] . '.' . $field['order_edit'], $name);
			}
			// check if default fields were overwritten
			if (in_array($name, $default_fields))
			{
				// just to eliminate
				$this->movedpublishingfields->set($nameSingleCode . '.' . $name, true);
			}
		}
		elseif ($tabName === 'publishing' || $tabName === 'Publishing')
		{
			if (!in_array($name, $default_fields))
			{
				if ($this->newpublishingfields->exists($nameSingleCode . '.' .
					$field['alignment'] . '.' . $field['order_edit']))
				{
					$size = $this->newpublishingfields->count($nameSingleCode . '.' .
								$field['alignment']) + 1;
					while ($this->newpublishingfields->exists($nameSingleCode . '.' .
						$field['alignment'] . '.' . $size))
					{
						$size++;
					}
					$this->newpublishingfields->set($nameSingleCode . '.' .
						$field['alignment'] . '.' . $size, $name);
				}
				else
				{
					$this->newpublishingfields->set($nameSingleCode . '.' .
						$field['alignment'] . '.' . $field['order_edit'], $name);
				}
			}
		}
		else
		{
			$this->tabcounter->set($nameSingleCode . '.1', 'Details');
			if ($this->layout->exists($nameSingleCode . '.Details.'
				. $field['alignment'] . '.' . $field['order_edit']))
			{
				$size = $this->layout->count($nameSingleCode . '.Details.'
						. $field['alignment']) + 1;
				while ($this->layout->exists($nameSingleCode . '.Details.'
					. $field['alignment'] . '.' . $size))
				{
					$size++;
				}
				$this->layout->set($nameSingleCode . '.Details.'
					. $field['alignment'] . '.' . $size, $name);
			}
			else
			{
				$this->layout->set($nameSingleCode . '.Details.' . $field['alignment'] . '.'
					. $field['order_edit'], $name);
			}
			// check if default fields were overwritten
			if (in_array($name, $default_fields))
			{
				// just to eliminate
				$this->movedpublishingfields->set($nameSingleCode . '.' . $name, true);
			}
		}
	}
}

