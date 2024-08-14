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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Plugin;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Builder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Plugin\ProviderInterface;


/**
 * Plugin Provider Class for Joomla 3
 * 
 * @since 5.0.2
 */
final class Provider implements ProviderInterface
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.0.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Builder
	 * @since 5.0.2
	 */
	protected Builder $builder;

	/**
	 * Constructor.
	 *
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Builder       $builder       The Content One Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Placeholder $placeholder, Builder $builder)
	{
		$this->placeholder = $placeholder;
		$this->builder = $builder;
	}

	/**
	 * Get the updated provider for the given plugin.
	 *
	 * @param  object  $plugin   The plugin object containing the necessary data.
	 *
	 * @return string  The provider content.
	 *
	 * @since 5.0.2
	 */
	public function get(object $plugin): string
	{
		return ''; // no provider in Joomla 3
	}
}

