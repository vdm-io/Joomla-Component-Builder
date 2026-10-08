<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    2nd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic;


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * The document meta of a dynamic get list resource
 * 
 * The custom gets of a list view belong to the view and not to a row, so
 * they ride along as document meta, under the names the HTML view uses.
 * 
 * @since 6.1.7
 */
class Meta
{
	/**
	 * Get the meta lines of displayList() before the parent call.
	 *
	 * @param   array  $resource  The resource, as the resources map names it.
	 *
	 * @return  string  The lines, none when the view has no custom get.
	 * @since   6.1.7
	 */
	public function get(array $resource): string
	{
		$code = (string) $resource['code'];
		$body = '';

		foreach (PrepareItem::customs($resource['settings']) as $name => $method)
		{
			$body .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
				. " The {$name} custom get of the {$code} view rides along as meta.";
			$body .= PHP_EOL . Indent::_(2) . "\$this->getDocument()->addMeta('{$name}', \$this->getModel()->{$method}());";
		}

		return $body;
	}
}

