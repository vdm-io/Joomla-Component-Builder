<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Discovery;


use VDM\Joomla\Componentbuilder\Extrusion\Config;
use VDM\Joomla\Componentbuilder\Extrusion\Interfaces\LayoutInterface;
use VDM\Joomla\Componentbuilder\Extrusion\Registry\Source;


/**
 * Chooses the layout that describes the tree being extruded.
 * 
 * Every target-version layout is injected, so the selection happens here and no
 * consumer ever branches on a Joomla major version. All four version keys are
 * retained even though the modern three currently share one placement map.
 * 
 * @since 6.1.6
 */
final class Selector
{
	/**
	 * The Config Class.
	 *
	 * @var    Config
	 * @since  6.1.6
	 */
	protected Config $config;

	/**
	 * The Source Registry.
	 *
	 * @var    Source
	 * @since  6.1.6
	 */
	protected Source $source;

	/**
	 * The Joomla 3 layout.
	 *
	 * @var    LayoutInterface
	 * @since  6.1.6
	 */
	protected LayoutInterface $three;

	/**
	 * The Joomla 4 layout.
	 *
	 * @var    LayoutInterface
	 * @since  6.1.6
	 */
	protected LayoutInterface $four;

	/**
	 * The Joomla 5 layout.
	 *
	 * @var    LayoutInterface
	 * @since  6.1.6
	 */
	protected LayoutInterface $five;

	/**
	 * The Joomla 6 layout.
	 *
	 * @var    LayoutInterface
	 * @since  6.1.6
	 */
	protected LayoutInterface $six;

	/**
	 * Constructor.
	 *
	 * @param   Config           $config  The extrusion configuration.
	 * @param   Source           $source  The source identity registry.
	 * @param   LayoutInterface  $three   The Joomla 3 layout.
	 * @param   LayoutInterface  $four    The Joomla 4 layout.
	 * @param   LayoutInterface  $five    The Joomla 5 layout.
	 * @param   LayoutInterface  $six     The Joomla 6 layout.
	 *
	 * @since   6.1.6
	 */
	public function __construct(
		Config $config,
		Source $source,
		LayoutInterface $three,
		LayoutInterface $four,
		LayoutInterface $five,
		LayoutInterface $six
	)
	{
		$this->config = $config;
		$this->source = $source;
		$this->three = $three;
		$this->four = $four;
		$this->five = $five;
		$this->six = $six;
	}

	/**
	 * The layout that should be used for this run.
	 *
	 * @return  LayoutInterface  The selected layout.
	 * @since   6.1.6
	 */
	public function layout(): LayoutInterface
	{
		$requested = strtolower((string) $this->config->get('layout', 'auto'));

		if ($requested !== 'auto')
		{
			return $this->byKey($requested);
		}

		return $this->byKey(strtolower((string) $this->source->get('layout', 'j4')));
	}

	/**
	 * Every layout, so a caller can try each in turn.
	 *
	 * @return  array<string, LayoutInterface>  Version identity keyed to its layout.
	 * @since   6.1.6
	 */
	public function all(): array
	{
		return [
			'J3' => $this->three,
			'J4' => $this->four,
			'J5' => $this->five,
			'J6' => $this->six
		];
	}

	/**
	 * Resolve one layout by its version key.
	 *
	 * @param   string  $key  A version key such as j3 or J4.
	 *
	 * @return  LayoutInterface  The matching layout, defaulting to the modern one.
	 * @since   6.1.6
	 */
	protected function byKey(string $key): LayoutInterface
	{
		switch (strtolower($key))
		{
			case 'j3':
				return $this->three;
			case 'j5':
				return $this->five;
			case 'j6':
				return $this->six;
			default:
				return $this->four;
		}
	}
}

