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
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;


/**
 * Email Helper Builder.
 * 
 * Responsible for conditionally generating and registering the component
 * email helper during compilation.
 * 
 * This class:
 * - Creates the emailer helper folder structure
 * - Forces helper file regeneration
 * - Returns Joomla 3 autoload registration code when required
 * 
 * @since 5.1.4
 */
final class EmailHelper
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.4
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 5.1.4
	 */
	protected Component $component;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 5.1.4
	 */
	protected Structure $structure;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.4
	 */
	protected ContentOne $contentone;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.4
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param Component      $component      The Component Class.
	 * @param Structure      $structure      The Structure Class.
	 * @param ContentOne     $contentone     The ContentOne Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 *
	 * @since 5.1.4
	 */
	public function __construct(Config $config, Component $component, Structure $structure,
		ContentOne $contentone, ContentMulti $contentmulti)
	{
		$this->config = $config;
		$this->component = $component;
		$this->structure = $structure;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Conditionally get the email helper for the component.
	 *
	 * This method:
	 * - Checks whether the email helper feature is enabled
	 * - Builds the required helper structure
	 * - Forces the helper file to be recompiled
	 * - Returns Joomla 3 class registration code when applicable
	 *
	 * @return string  PHP source code required to register the email helper,
	 *                 or an empty string when not applicable.
	 *
	 * @since  5.1.1
	 */
	public function get(): string
	{
		// Feature disabled
		if (!$this->component->get('add_email_helper'))
		{
			return '';
		}

		$component = $this->config->component_code_name;
		$Component = $this->contentone->get('Component');

		// Build helper structure
		$target = ['admin' => 'emailer'];
		$done   = $this->structure->build($target, 'emailer', $component);

		if (!$done)
		{
			return '';
		}

		// Force helper regeneration
		$this->contentmulti->set('emailer_' . $component . '|BAKING', '');

		// Joomla 3 autoload support
		if ($this->config->get('joomla_version', 3) == 3)
		{
			return PHP_EOL
				. "\\JLoader::register('"
				. $Component
				. "Email', JPATH_ADMINISTRATOR . '/components/com_{$component}/helpers/"
				. $component
				. "email.php'); ";
		}

		return '';
	}
}

