<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\ImageType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\ContentTypesInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Component Post Update Script Class.
 * 
 * Builds what the install script of the component runs when it is updated
 * rather than installed.
 * 
 * @since 6.1.7
 */
final class PostUpdateScript
{
	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Image Type Class.
	 *
	 * @var   ImageType
	 * @since 6.1.7
	 */
	protected ImageType $imagetype;

	/**
	 * The Content Types Class.
	 *
	 * @var   ContentTypesInterface
	 * @since 6.1.7
	 */
	protected ContentTypesInterface $contenttypes;

	/**
	 * Constructor.
	 *
	 * @param ContentOne $contentone The Content One Builder Class.
	 * @param Component  $component  The Component Class.
	 * @param Config     $config     The Config Class.
	 * @param Dispenser  $dispenser  The Customcode Dispenser Class.
	 * @param ImageType  $imagetype  The Image Type Class.
	 *
	 * @param ContentTypesInterface $contenttypes      The Content Types Class.
	 * @since 6.1.7
	 */
	public function __construct(ContentOne $contentone,
		Component $component,
		Config $config,
		Dispenser $dispenser,
		ImageType $imagetype,
		ContentTypesInterface $contenttypes)
	{
		$this->contentone = $contentone;
		$this->component = $component;
		$this->config = $config;
		$this->dispenser = $dispenser;
		$this->imagetype = $imagetype;
		$this->contenttypes = $contenttypes;
	}

	/**
	 * Build the post update script of the component.
	 *
	 * The content types its views declare are refreshed, whatever the component
	 * was given to run afterwards is run, and a component with views of its own
	 * says who built it.
	 *
	 * @return  string  The script.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		// reset script
		$script = $this->contenttypes->get('update');
		// add the custom script
		$script .= $this->dispenser->get(
			'php_postflight', 'update', PHP_EOL . PHP_EOL, null, true
		);
		if ($this->component->isArray('admin_views'))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. 'echo \'<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="'
				. $this->contentone->get('AUTHORWEBSITE') . '" title="'
				. $this->contentone->get('Component_name') . '">';
			$script .= PHP_EOL . Indent::_(4) . '<img src="components/com_'
				. $this->config->component_code_name . '/assets/images/vdm-component.'
				. $this->imagetype->get() . '"/>';
			$script .= PHP_EOL . Indent::_(4) . '</a>';
			$script .= PHP_EOL . Indent::_(4) . "<h3>Upgrade to Version "
				. $this->contentone->get('ACTUALVERSION')
				. " Was Successful! Let us know if anything is not working as expected.</h3></div>';";
		}

		if (StringHelper::check($script))
		{
			return $script;
		}

		return PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " noting to update.";
	}
}

