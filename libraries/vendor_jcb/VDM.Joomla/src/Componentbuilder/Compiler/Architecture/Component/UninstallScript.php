<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Component;


use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\AssetsTableInterface;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\UninstallScriptInterface;


/**
 * Component Uninstall Script Class.
 * 
 * Generates the uninstall method body of the script.php: the removal of
 * the component's related data per view, the assets table intelligent
 * reversal, and the component's own custom uninstall script. Joomla 3
 * carries its own class, because its generated code removes the content
 * types, fields and history the Joomla 3 target registered.
 * 
 * @since  6.1.7
 */
class UninstallScript implements UninstallScriptInterface
{
	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The AssetsTable Class.
	 *
	 * @var   AssetsTableInterface
	 * @since 6.1.7
	 */
	protected AssetsTableInterface $assetstable;

	/**
	 * The uninstall script builder of views to remove.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $uninstallScriptBuilder = [];

	/**
	 * The uninstall script views that have field relations.
	 *
	 * @var   array
	 * @since 6.1.7
	 */
	protected array $uninstallScriptFields = [];

	/**
	 * Constructor.
	 *
	 * @param Dispenser             $dispenser     The Dispenser Class.
	 * @param AssetsTableInterface  $assetstable   The AssetsTable Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Dispenser $dispenser, AssetsTableInterface $assetstable)
	{
		$this->dispenser = $dispenser;
		$this->assetstable = $assetstable;
	}

	/**
	 * Get the generated uninstall method body of the script.php.
	 *
	 * A component that registered nothing to remove still carries the
	 * assets table reversal and the custom uninstall script when set.
	 *
	 * @param   array  $uninstallScriptBuilder  The views to remove, keyed by view code name.
	 * @param   array  $uninstallScriptFields   The views that have field relations.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   6.1.7
	 */
	public function get(array $uninstallScriptBuilder = [], array $uninstallScriptFields = []): string
	{
		$this->uninstallScriptBuilder = $uninstallScriptBuilder;
		$this->uninstallScriptFields = $uninstallScriptFields;

		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder)
			&& ArrayHelper::check(
				$this->uninstallScriptBuilder
			))
		{
			// start loading the data to delete
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Remove Related Component Data.";
			foreach ($this->uninstallScriptBuilder as $viewsCodeName => $context)
			{
				// set a var value
				$View = StringHelper::safe($viewsCodeName, 'Ww');
				// First check if data is till in table
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__)
					. " Remove $View Data";
				$field = '';
				// check if it has field relations
				if (isset($this->uninstallScriptFields)
					&& isset($this->uninstallScriptFields[$viewsCodeName]))
				{
					$field = ', true';
				}
				// First check if data is till in table
				$script .= PHP_EOL . Indent::_(2) . "\$this->removeViewData(\"$context\"$field);";
			}

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Remove Asset Data.";
			$script .= PHP_EOL . Indent::_(2) . "\$this->removeAssetData();";
			// done
			$script .= PHP_EOL;
		}

		// add the Intelligent Reversal script if needed
		$script .= $this->assetstable->uninstall();

		// add the custom uninstallation script
		$script .= $this->dispenser->get(
			'php_method', 'uninstall', "", null, true, null, PHP_EOL
		);

		return $script;
	}
}

