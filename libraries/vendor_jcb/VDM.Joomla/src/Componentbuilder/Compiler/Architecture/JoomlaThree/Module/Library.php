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


use VDM\Joomla\Componentbuilder\Compiler\Builder\LibraryManager;
use VDM\Joomla\Componentbuilder\Compiler\Library\Document;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\LibraryInterface;


/**
 * Module Library Joomla 3
 * 
 * @since 5.1.2
 */
final class Library implements LibraryInterface
{
	/**
	 * The LibraryManager Class.
	 *
	 * @var   LibraryManager
	 * @since 5.1.2
	 */
	protected LibraryManager $librarymanager;

	/**
	 * The Document Class.
	 *
	 * @var   Document
	 * @since 5.1.2
	 */
	protected Document $document;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 5.1.2
	 */
	protected Registry $registry;

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
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * Constructor.
	 *
	 * @param LibraryManager   $librarymanager   The LibraryManager Class.
	 * @param Document         $document         The Document Class.
	 * @param Registry         $registry         The Registry Class.
	 * @param Placeholder      $placeholder      The Placeholder Class.
	 * @param ContentOne       $contentone       The ContentOne Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(LibraryManager $librarymanager, Document $document,
		Registry $registry, Placeholder $placeholder,
		ContentOne $contentone)
	{
		$this->librarymanager = $librarymanager;
		$this->document = $document;
		$this->registry = $registry;
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
	}

	/**
	 * Get the module's library loading code.
	 *
	 * @param   object  $module  The module object
	 *
	 * @return  string The generated code to load libraries into the document.
	 * @since   5.1.2
	 */
	public function get(object $module): string
	{
		$data = $this->librarymanager->get($module->key . '.' . $module->code_name);

		if ($data === null)
		{
			return '';
		}

		$code = '// ' . Line::_(__LINE__, __CLASS__) . ' get the document object' . PHP_EOL;
		$code .= '$document = Joomla__' . '_39403062_84fb_46e0_bac4_0023f766e827___Power::getDocument();';

		$found = false;

		foreach ($data as $id => $item)
		{
			$library = $this->registry->get("builder.libraries.{$id}");

			if (!is_object($library))
			{
				continue;
			}

			if (!empty($library->document) && StringHelper::check($library->document))
			{
				$code .= PHP_EOL . $library->document;
				$found = true;
			}
			elseif (isset($library->how))
			{
				$code .= $this->document->get($id);
				$found = true;
			}
		}

		if (!$found)
		{
			return '';
		}

		// Normalize and inject placeholders
		$lines = explode(PHP_EOL, $code);
		$trimmed = array_map('trim', $lines);
		$normalized = str_replace('$this->document->', '$document->', implode(PHP_EOL, $trimmed));

		return $this->placeholder->update(
			$this->placeholder->update_($normalized),
			$this->contentone->allActive()
		);
	}
}

