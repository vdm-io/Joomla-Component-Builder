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
use VDM\Joomla\Componentbuilder\Compiler\Builder\AssetsRules;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\AssetsTableInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\ContentTypesInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\PostInstallScriptInterface;


/**
 * Component Post Install Script Class.
 * 
 * Builds what the install script of the component runs once the files are in
 * place.
 * 
 * How the extension permissions and params are installed is what the compile
 * target decides, and it is the extension point below.
 * 
 * @since 6.1.7
 */
class PostInstallScript implements PostInstallScriptInterface
{
	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

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
	 * The Assets Rules Builder Class.
	 *
	 * @var   AssetsRules
	 * @since 6.1.7
	 */
	protected AssetsRules $assetsrules;

	/**
	 * The Extensions Params Builder Class.
	 *
	 * @var   ExtensionsParams
	 * @since 6.1.7
	 */
	protected ExtensionsParams $extensionsparams;

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
	 * The Assets Table Class.
	 *
	 * @var   AssetsTableInterface
	 * @since 6.1.7
	 */
	protected AssetsTableInterface $assetstable;

	/**
	 * Constructor.
	 *
	 * @param ContentOne       $contentone       The Content One Builder Class.
	 * @param Config           $config           The Config Class.
	 * @param Dispenser        $dispenser        The Customcode Dispenser Class.
	 * @param AssetsRules      $assetsrules      The Assets Rules Builder Class.
	 * @param ExtensionsParams $extensionsparams The Extensions Params Builder Class.
	 * @param ImageType        $imagetype        The Image Type Class.
	 *
	 * @param ContentTypesInterface $contenttypes      The Content Types Class.
	 * @param AssetsTableInterface $assetstable       The Assets Table Class.
	 * @since 6.1.7
	 */
	public function __construct(ContentOne $contentone,
		Config $config,
		Dispenser $dispenser,
		AssetsRules $assetsrules,
		ExtensionsParams $extensionsparams,
		ImageType $imagetype,
		ContentTypesInterface $contenttypes,
		AssetsTableInterface $assetstable)
	{
		$this->contentone = $contentone;
		$this->config = $config;
		$this->dispenser = $dispenser;
		$this->assetsrules = $assetsrules;
		$this->extensionsparams = $extensionsparams;
		$this->imagetype = $imagetype;
		$this->contenttypes = $contenttypes;
		$this->assetstable = $assetstable;
	}

	/**
	 * Build the post install script of the component.
	 *
	 * What the component was built with decides what it does on install: the
	 * content types its views declare, the assets table fix, the permissions
	 * and params of the extension itself, and whatever the component was given
	 * to run afterwards.
	 *
	 * @return  string  The script, or a note that there is nothing to install.
	 *
	 * @since   6.1.7
	 */
	public function get(): string
	{
		// reset script
		$script = $this->contenttypes->get('install');

		// add the Intelligent Fix script if needed
		$script .= $this->assetstable->install();

		$script .= $this->extensionSetup();

		// add the custom script
		$script .= $this->dispenser->get(
			'php_postflight', 'install', PHP_EOL . PHP_EOL, null, true
		);

		// add the component installation notice
		if (StringHelper::check($script))
		{
			$script .= PHP_EOL . PHP_EOL . Indent::_(3)
				. 'echo \'<div style="background-color: #fff;" class="alert alert-info"><a target="_blank" href="'
				. $this->contentone->get('AUTHORWEBSITE') . '" title="'
				. $this->contentone->get('Component_name') . '">';
			$script .= PHP_EOL . Indent::_(4) . '<img src="components/com_'
				. $this->config->component_code_name . '/assets/images/vdm-component.'
				. $this->imagetype->get() . '"/>';
			$script .= PHP_EOL . Indent::_(4) . '</a></div>\';';

			return $script;
		}

		return PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
			. " noting to install.";
	}
	/**
	 * Build the statements that install the permissions and params of the
	 * extension itself.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	protected function extensionSetup(): string
	{
		// reset script
		$script = '';

		// add the assets table update for permissions rules
		if ($this->assetsrules->isArray('site'))
		{
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Install the global extension assets permission.";
			$script .= PHP_EOL . Indent::_(3) . "\$this->setAssetsRules(";
			$script .= PHP_EOL . Indent::_(4) . "'{" . implode(
					',', $this->assetsrules->get('site')
				) . "}'";
			$script .= PHP_EOL . Indent::_(3) . ");" . PHP_EOL;
		}

		// add the global params for the component global settings
		if ($this->extensionsparams->isArray('component'))
		{
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Install the global extension params.";
			$script .= PHP_EOL . Indent::_(3) . "\$this->setExtensionsParams(";
			$script .= PHP_EOL . Indent::_(4) . "'{"
				. implode(',', $this->extensionsparams->get('component')
				) . "}'";
			$script .= PHP_EOL . Indent::_(3) . ");" . PHP_EOL;
		}

		return $script;
	}
}

