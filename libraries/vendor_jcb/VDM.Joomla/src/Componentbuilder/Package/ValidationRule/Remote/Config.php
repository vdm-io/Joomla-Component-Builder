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

namespace VDM\Joomla\Componentbuilder\Package\ValidationRule\Remote;


use VDM\Joomla\Interfaces\Remote\ConfigInterface;
use VDM\Joomla\Abstraction\Remote\Config as ExtendingConfig;


/**
 * Base Configure values for the remote classes
 * 
 * @since 5.1.4
 */
final class Config extends ExtendingConfig implements ConfigInterface
{
	/**
	 * Table Name
	 *
	 * @var    string
	 * @since  5.1.4
	 */
	protected string $table = 'validation_rule';

	/**
	 * Area Name
	 *
	 * @var   string|null
	 * @since 5.1.4
	 */
	protected ?string $area = 'ValidationRule';

	/**
	 * The item guid=unique field
	 *
	 * @var    string
	 * @since  5.1.4
	 */
	protected string $guid_field = 'name';

	/**
	 * The main readme file path
	 *
	 * @var    string
	 * @since  5.1.4
	 */
	protected string $main_readme_path = 'README_VALIDATION_RULE.md';

	/**
	 * The index file path (index of all items)
	 *
	 * @var    string
	 * @since 5.1.4
	 */
	protected string $index_path = 'index/validation_rule.json';

	/**
	 * The item (files) source path
	 *
	 * @var    string
	 * @since  5.1.4
	 */
	protected string $src_path = 'src/validation_rule';
}

