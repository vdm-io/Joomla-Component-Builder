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


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Component Import Custom Scripts Class.
 * 
 * Writes the custom import files a view was given into the component being
 * built, and fills in the parts of each the compiler owns.
 * 
 * @since 6.1.7
 */
final class ImportCustomScripts
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The Header Class.
	 *
	 * @var   HeaderInterface
	 * @since 6.1.7
	 */
	protected HeaderInterface $header;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * Constructor.
	 *
	 * @param Placeholder     $placeholder  The Placeholder Class.
	 * @param ContentMulti    $contentmulti The Content Multi Builder Class.
	 * @param Structure       $structure    The Structure Class.
	 * @param HeaderInterface $header       The Header Class.
	 * @param Dispenser       $dispenser    The Customcode Dispenser Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder,
		ContentMulti $contentmulti,
		Structure $structure,
		HeaderInterface $header,
		Dispenser $dispenser)
	{
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->structure = $structure;
		$this->header = $header;
		$this->dispenser = $dispenser;
	}

	/**
	 * Write the custom import files of a list view.
	 *
	 * A view that was given none has nothing written for it.
	 *
	 * @param   string  $nameListCode  The list view name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set($nameListCode): void
	{
		// setup Ajax files
		$target = array('admin' => 'import_' . $nameListCode);
		$this->structure->build($target, 'customimport');
		// load the custom script to the files
		// IMPORT_EXT_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_EXT_METHOD', $this->dispenser->get(
			'php_import_ext', 'import_' . $nameListCode, PHP_EOL, null,
			true
		));
		// IMPORT_DISPLAY_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_DISPLAY_METHOD_CUSTOM', $this->dispenser->get(
			'php_import_display', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_SETDATA_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_SETDATA_METHOD', $this->dispenser->get(
			'php_import_setdata', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_METHOD_CUSTOM <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_METHOD_CUSTOM', $this->dispenser->get(
			'php_import', 'import_' . $nameListCode, PHP_EOL, null,
			true
		));
		// IMPORT_SAVE_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_SAVE_METHOD', $this->dispenser->get(
			'php_import_save', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));
		// IMPORT_DEFAULT_VIEW_CUSTOM <<<DYNAMIC>>>
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_DEFAULT_VIEW_CUSTOM', $this->dispenser->get(
			'html_import_view', 'import_' . $nameListCode, PHP_EOL,
			null,
			true
		));

		// insure we have the view placeholders setup
		$this->contentmulti->set('import_' . $nameListCode . '|VIEW', 'IMPORT_' . $this->placeholder->get_h('VIEWS'));
		$this->contentmulti->set('import_' . $nameListCode . '|View', 'Import_' . $this->placeholder->get_h('views'));
		$this->contentmulti->set('import_' . $nameListCode . '|view', 'import_' . $this->placeholder->get_h('views'));
		$this->contentmulti->set('import_' . $nameListCode . '|VIEWS', 'IMPORT_' . $this->placeholder->get_h('VIEWS'));
		$this->contentmulti->set('import_' . $nameListCode . '|Views', 'Import_' . $this->placeholder->get_h('views'));
		$this->contentmulti->set('import_' . $nameListCode . '|views', 'import_' . $this->placeholder->get_h('views'));

		// IMPORT_CUSTOM_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_CUSTOM_CONTROLLER_HEADER', $this->header->get(
			'import.custom.controller',
			$nameListCode
		));

		// IMPORT_CUSTOM_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
		$this->contentmulti->set('import_' . $nameListCode . '|IMPORT_CUSTOM_MODEL_HEADER', $this->header->get(
			'import.custom.model',
			$nameListCode
		));
	}
}

