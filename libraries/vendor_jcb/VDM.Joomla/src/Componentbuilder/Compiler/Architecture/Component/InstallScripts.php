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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass\UikitMethods;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\PostUpdateScript;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptContext;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UninstallScriptFields;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\MoveFolderMethodInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\MoveFolderScriptInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\PostInstallScriptInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\UninstallScriptInterface;


/**
 * The install, update and uninstall scripts of the component.
 * 
 * @since 6.1.7
 */
final class InstallScripts
{
	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Uninstall Script Context Builder Class.
	 *
	 * @var   UninstallScriptContext
	 * @since 6.1.7
	 */
	protected UninstallScriptContext $uninstallscriptcontext;

	/**
	 * The Uninstall Script Fields Builder Class.
	 *
	 * @var   UninstallScriptFields
	 * @since 6.1.7
	 */
	protected UninstallScriptFields $uninstallscriptfields;

	/**
	 * The Component PostInstallScript Class.
	 *
	 * @var   PostInstallScriptInterface
	 * @since 6.1.7
	 */
	protected PostInstallScriptInterface $postinstallscript;

	/**
	 * The Component PostUpdateScript Class.
	 *
	 * @var   PostUpdateScript
	 * @since 6.1.7
	 */
	protected PostUpdateScript $postupdatescript;

	/**
	 * The Component UninstallScript Class.
	 *
	 * @var   UninstallScriptInterface
	 * @since 6.1.7
	 */
	protected UninstallScriptInterface $uninstallscript;

	/**
	 * The Component MoveFolderScript Class.
	 *
	 * @var   MoveFolderScriptInterface
	 * @since 6.1.7
	 */
	protected MoveFolderScriptInterface $movefolderscript;

	/**
	 * The Component MoveFolderMethod Class.
	 *
	 * @var   MoveFolderMethodInterface
	 * @since 6.1.7
	 */
	protected MoveFolderMethodInterface $movefoldermethod;

	/**
	 * The ComHelperClass UikitMethods Class.
	 *
	 * @var   UikitMethods
	 * @since 6.1.7
	 */
	protected UikitMethods $uikitmethods;

	/**
	 * Constructor.
	 *
	 * @param Dispenser                  $dispenser                      The Customcode Dispenser Class.
	 * @param ContentOne                 $contentone                     The Content One Builder Class.
	 * @param UninstallScriptContext     $uninstallscriptcontext         The Uninstall Script Context Builder Class.
	 * @param UninstallScriptFields      $uninstallscriptfields          The Uninstall Script Fields Builder Class.
	 * @param PostInstallScriptInterface $postinstallscript              The Component PostInstallScript Class.
	 * @param PostUpdateScript           $postupdatescript               The Component PostUpdateScript Class.
	 * @param UninstallScriptInterface   $uninstallscript                The Component UninstallScript Class.
	 * @param MoveFolderScriptInterface  $movefolderscript               The Component MoveFolderScript Class.
	 * @param MoveFolderMethodInterface  $movefoldermethod               The Component MoveFolderMethod Class.
	 * @param UikitMethods               $uikitmethods                   The ComHelperClass UikitMethods Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Dispenser $dispenser,
		ContentOne $contentone,
		UninstallScriptContext $uninstallscriptcontext,
		UninstallScriptFields $uninstallscriptfields,
		PostInstallScriptInterface $postinstallscript,
		PostUpdateScript $postupdatescript,
		UninstallScriptInterface $uninstallscript,
		MoveFolderScriptInterface $movefolderscript,
		MoveFolderMethodInterface $movefoldermethod,
		UikitMethods $uikitmethods)
	{
		$this->dispenser = $dispenser;
		$this->contentone = $contentone;
		$this->uninstallscriptcontext = $uninstallscriptcontext;
		$this->uninstallscriptfields = $uninstallscriptfields;
		$this->postinstallscript = $postinstallscript;
		$this->postupdatescript = $postupdatescript;
		$this->uninstallscript = $uninstallscript;
		$this->movefolderscript = $movefolderscript;
		$this->movefoldermethod = $movefoldermethod;
		$this->uikitmethods = $uikitmethods;
	}

	/**
	 * Set the install, update and uninstall scripts of the component.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(): void
	{
		// PREINSTALLSCRIPT
		$this->contentone->add('PREINSTALLSCRIPT',
			$this->dispenser->get(
			'php_preflight', 'install', PHP_EOL, null, true
		));

		// PREUPDATESCRIPT
		$this->contentone->add('PREUPDATESCRIPT',
			$this->dispenser->get(
			'php_preflight', 'update', PHP_EOL, null, true
		));

		// POSTINSTALLSCRIPT
		$this->contentone->add('POSTINSTALLSCRIPT', $this->postinstallscript->get());

		// POSTUPDATESCRIPT
		$this->contentone->add('POSTUPDATESCRIPT', $this->postupdatescript->get());

		// UNINSTALLSCRIPT
		$this->contentone->add('UNINSTALLSCRIPT', $this->uninstallscript->get(
			$this->uninstallscriptcontext->allActive(),
			$this->uninstallscriptfields->allActive()
		));

		// INSTALLERMETHODS
		$this->contentone->add('INSTALLERMETHODS', $this->dispenser->get(
			'php_method', 'install', PHP_EOL
		));

		// MOVEFOLDERSSCRIPT
		$this->contentone->set('MOVEFOLDERSSCRIPT', $this->movefolderscript->get());

		// INSTALLERMETHODS2
		$this->contentone->add('INSTALLERMETHODS', $this->movefoldermethod->get());

		// HELPER_UIKIT
		$this->contentone->set('HELPER_UIKIT', $this->uikitmethods->get());
	}
}

