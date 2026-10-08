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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GetModule;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * View Get Modules Class.
 * 
 * Builds the method a view is given to render the modules published in a
 * position, and registers the import that method needs. Only a view that was
 * found to call for modules gets it.
 * 
 * @since  6.1.7
 */
final class GetModules
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Get Module Builder Class.
	 *
	 * @var   GetModule
	 * @since 6.1.7
	 */
	protected GetModule $getmodule;

	/**
	 * Constructor.
	 *
	 * @param Config        $config        The Config Class.
	 * @param ContentMulti  $contentmulti  The Content Multi Builder Class.
	 * @param GetModule     $getmodule     The Get Module Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		ContentMulti $contentmulti,
		GetModule $getmodule)
	{
		$this->config = $config;
		$this->contentmulti = $contentmulti;
		$this->getmodule = $getmodule;
	}

	/**
	 * Build the module loader of a view.
	 *
	 * @param   array   $view    The view being built.
	 * @param   string  $TARGET  The upper case build target of the view.
	 *
	 * @return  string  The method, or nothing when the view calls for no modules.
	 *
	 * @since   6.1.7
	 */
	public function get($view, string $TARGET): string
	{
		if ($this->getmodule->
			exists($this->config->build_target . '.' . $view['settings']->code))
		{
			$addModule   = [];
			$addModule[] = PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$addModule[] = Indent::_(1)
				. " * Get the modules published in a position";
			$addModule[] = Indent::_(1) . " */";
			$addModule[] = Indent::_(1)
				. "public function getModules(\$position, \$seperator = '', \$class = '')";
			$addModule[] = Indent::_(1) . "{";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " set default";
			$addModule[] = Indent::_(2) . "\$found = false;";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if we aleady have these modules loaded";
			$addModule[] = Indent::_(2)
				. "if (isset(\$this->setModules[\$position]))";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "\$found = true;";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "else";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " this is where you want to load your module position";
			$addModule[] = Indent::_(3)
				. "\$modules = Joomla__"."_f15d556d_33dd_4ee3_a0f7_0653e4a7a1e4___Power::getModules(\$position);";
			$addModule[] = Indent::_(3) . "if ("
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$modules, true))";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4) . "//" . Line::_(__Line__, __Class__)
				. " set the place holder";
			$addModule[] = Indent::_(4)
				. "\$this->setModules[\$position] = [];";
			$addModule[] = Indent::_(4) . "foreach(\$modules as \$module)";
			$addModule[] = Indent::_(4) . "{";
			$addModule[] = Indent::_(5)
				. "\$this->setModules[\$position][] = Joomla__"."_f15d556d_33dd_4ee3_a0f7_0653e4a7a1e4___Power::renderModule(\$module);";
			$addModule[] = Indent::_(4) . "}";
			$addModule[] = Indent::_(4) . "\$found = true;";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " check if modules were found";
			$addModule[] = Indent::_(2)
				. "if (\$found && isset(\$this->setModules[\$position]) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$this->setModules[\$position]))";
			$addModule[] = Indent::_(2) . "{";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " set class";
			$addModule[] = Indent::_(3) . "if ("
				. "Super_" . "__1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check(\$class))";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4)
				. "\$class = ' class=\"'.\$class.'\" ';";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " set seperating return values";
			$addModule[] = Indent::_(3) . "switch(\$seperator)";
			$addModule[] = Indent::_(3) . "{";
			$addModule[] = Indent::_(4) . "case 'none':";
			$addModule[] = Indent::_(5)
				. "return implode('', \$this->setModules[\$position]);";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'div':";
			$addModule[] = Indent::_(5)
				. "return '<div'.\$class.'>'.implode('</div><div'.\$class.'>', \$this->setModules[\$position]).'</div>';";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'list':";
			$addModule[] = Indent::_(5)
				. "return '<ul'.\$class.'><li>'.implode('</li><li>', \$this->setModules[\$position]).'</li></ul>';";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "case 'array':";
			$addModule[] = Indent::_(4) . "case 'Array':";
			$addModule[] = Indent::_(5)
				. "return \$this->setModules[\$position];";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(4) . "default:";
			$addModule[] = Indent::_(5)
				. "return implode('<br />', \$this->setModules[\$position]);";
			$addModule[] = Indent::_(5) . "break;";
			$addModule[] = Indent::_(3) . "}";
			$addModule[] = Indent::_(2) . "}";
			$addModule[] = Indent::_(2) . "return false;";
			$addModule[] = Indent::_(1) . "}";

			$this->contentmulti->set($view['settings']->code . '|' . $TARGET . '_GET_MODULE_JIMPORT',
				PHP_EOL . "use Joomla\CMS\Helper\ModuleHelper;"
			);

			return implode(PHP_EOL, $addModule);
		}
		$this->contentmulti->set($view['settings']->code . '|' . $TARGET . '_GET_MODULE_JIMPORT', '');

		return '';
	}
}

