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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\View;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\DocumentMetadata as SharedDocumentMetadata;


/**
 * Joomla 3 View Document Metadata Class.
 * 
 * A Joomla 3 view holds its document in a property of its own, and sets the
 * description of the item it read straight on it.
 * 
 * @since  6.1.7
 */
final class DocumentMetadata extends SharedDocumentMetadata
{
	/**
	 * How the generated view reaches its document.
	 *
	 * @return  string  The expression the metadata statements are called on.
	 *
	 * @since   6.1.7
	 */
	protected function document(): string
	{
		return "\$this->document";
	}

	/**
	 * Build the statement that sets the description of a view reading one item.
	 *
	 * @param   string  $value  The expression the description is read from.
	 *
	 * @return  string  The statement.
	 *
	 * @since   6.1.7
	 */
	protected function itemDescription(string $value): string
	{
		return "\$this->document->setDescription(" . $value . ");";
	}
}

