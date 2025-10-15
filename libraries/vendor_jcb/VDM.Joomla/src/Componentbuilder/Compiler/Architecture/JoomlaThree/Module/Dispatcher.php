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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Builder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\LibraryInterface as Library;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\DispatcherInterface;


/**
 * Module Dispatcher Class for Joomla 3
 * 
 * @since 5.1.2
 */
final class Dispatcher implements DispatcherInterface
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   Builder
	 * @since 5.1.2
	 */
	protected Builder $builder;

	/**
	 * The Library Class.
	 *
	 * @var   Library
	 * @since 5.1.2
	 */
	protected Library $library;

	/**
	 * Constructor.
	 *
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Builder       $builder       The ContentOne Class.
	 * @param Library       $library       The Library Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Placeholder $placeholder, Builder $builder,
		Library $library)
	{
		$this->placeholder = $placeholder;
		$this->builder = $builder;
		$this->library = $library;
	}

	/**
	 * Get the updated placeholder content for the given module.
	 *
	 * @param  object  $module   The module object containing the necessary data.
	 *
	 * @return string  The updated placeholder content.
	 * @since 5.1.2
	 */
	public function get(object $module): string
	{
		$Helper    = $this->builder->get('Component') . 'Helper';
		$component = $this->builder->get('component');
		$_helper   = '';

		$libraries = [Placefix::_('MOD_LIBRARIES') => $this->library->get($module)];
		$code      = $this->placeholder->update($module->mod_code, $libraries);

		if (strpos((string) $code, $Helper . '::') !== false
			&& strpos(
				(string) $code,
				"/components/com_" . $component . "/helpers/" . $component
				. ".php"
			) === false)
		{
			$_helper = '//' . Line::_(__Line__, __Class__)
				. ' Include the component helper functions only once';
			$_helper .= PHP_EOL . "JLoader::register('" . $Helper
				. "', JPATH_ADMINISTRATOR . '/components/com_" . $component
				. "/helpers/" . $component . ".php');";
		}

		return $this->placeholder->update(
			$_helper . PHP_EOL . $code . PHP_EOL,
			$this->builder->allActive()
		);
	}
}

