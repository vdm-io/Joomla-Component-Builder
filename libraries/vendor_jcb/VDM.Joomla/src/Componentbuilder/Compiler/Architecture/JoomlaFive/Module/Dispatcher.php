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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\Module;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne as Builder;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\LibraryInterface as Library;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\DispatcherInterface;


/**
 * Module Dispatcher Class for Joomla 5
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
	 * The Namespace Prefix
	 *
	 * @var    string
	 * @since 5.0.0
	 */
	protected string $NamespacePrefix;

	/**
	 * Constructor.
	 *
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Builder       $builder       The ContentOne Class.
	 * @param Library       $library       The Library Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Placeholder $placeholder, Builder $builder, Library $library)
	{
		$this->placeholder = $placeholder;
		$this->builder = $builder;
		$this->library = $library;

		// set some global values
		$this->NamespacePrefix = $this->placeholder->get('NamespacePrefix');
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
		$dispatcher = [];
		$dispatcher[] =  "/**";
		$dispatcher[] =  " *" . Line::_(__LINE__, __CLASS__) . " Dispatcher class for {$module->official_name}";
		$dispatcher[] =  " *";
		$dispatcher[] =  " * @since  5.3.0";
		$dispatcher[] =  " */";

		$library = $this->library->get($module);

		if (empty($module->layout_data) && empty($module->add_class_helper) && empty($module->custom_get) && empty($library))
		{
			$dispatcher[] =  "class Dispatcher extends AbstractModuleDispatcher {}";
			return implode(PHP_EOL, $dispatcher). PHP_EOL;
		}

		if ($module->add_class_helper == 1 || $module->custom_get)
		{
			$dispatcher[] =  "class Dispatcher extends AbstractModuleDispatcher implements HelperFactoryAwareInterface";
			$dispatcher[] =  "{";
			$dispatcher[] =  Indent::_(1) . "use HelperFactoryAwareTrait;";
		}
		else
		{
			$dispatcher[] =  "class Dispatcher extends AbstractModuleDispatcher";
			$dispatcher[] =  "{";
		}

		$dispatcher[] =  "";
		$dispatcher[] =  Indent::_(1) . "/**";
		$dispatcher[] =  Indent::_(1) . " *" . Line::_(__LINE__, __CLASS__) . " Returns the layout data.";
		$dispatcher[] =  Indent::_(1) . " *";
		$dispatcher[] =  Indent::_(1) . " * @return  array";
		$dispatcher[] =  Indent::_(1) . " *";
		$dispatcher[] =  Indent::_(1) . " * @since   5.3.0";
		$dispatcher[] =  Indent::_(1) . " */";
		$dispatcher[] =  Indent::_(1) . "protected function getLayoutData(): array";
		$dispatcher[] =  Indent::_(1) . "{";
		$dispatcher[] =  Indent::_(2) . "\$data = parent::getLayoutData();";
		$dispatcher[] =  "";

		if ($module->add_class_helper == 1)
		{
			$dispatcher[] =  Indent::_(2) . "\$data['helper'] = \$this->getHelperFactory()->getHelper('{$module->class_helper_name}', \$data);";
		}
		elseif ($module->add_class_helper == 2)
		{
			$dispatcher[] =  Indent::_(2) . "\$data['helper'] = \\{$this->NamespacePrefix}\\Module\\{$module->namespace}\\{$module->target_client_namespace}\\Helper\\{$module->class_helper_name}::class;";
		}

		if ($module->custom_get)
		{
			$dispatcher[] =  Indent::_(2) . "\$data['data'] = \$this->getHelperFactory()->getHelper('{$module->class_data_name}', \$data);";
		}

		// load the libraries
		if (!empty($library))
		{
			$dispatcher[] =  "";
			$dispatcher[] =  Indent::_(2) . $library;
		}

		// load the custom code here
		if (!empty($module->layout_data))
		{
			$dispatcher[] =  "";
			$dispatcher[] = $module->layout_data;
		}

		$dispatcher[] =  "";
		$dispatcher[] =  Indent::_(2) . "return \$data;";
		$dispatcher[] =  Indent::_(1) . "}";
		$dispatcher[] = "}";

		return $this->placeholder->update(
			implode(PHP_EOL, $dispatcher). PHP_EOL,
			$this->builder->allActive()
		);
	}
}

