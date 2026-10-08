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


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Resources;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * The model resolution of a dynamic get API controller
 * 
 * @since 6.1.7
 */
class GetModel
{
	/**
	 * Get the body of getModel().
	 *
	 * The controller serves the view's own model, from the Site namespace
	 * for a site view and the Administrator namespace for a custom admin
	 * view, with the request state ignored as the API does.
	 *
	 * @param   array  $resource  The resource, as the resources map names it.
	 *
	 * @return  string  The method body.
	 * @since   6.1.7
	 */
	public function get(array $resource): string
	{
		$code = (string) $resource['code'];
		$model = (string) ($resource['settings']->Code ?? ucfirst($code));
		$site = ($resource['area'] === Resources::AREA_SITE);
		$prefix = $site ? 'Site' : 'Administrator';
		$label = $site ? 'site' : 'administrator';

		$body = PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__)
			. " The {$label} model of the {$code} view, its request state ignored.";
		$body .= PHP_EOL . Indent::_(2) . "return parent::getModel('{$model}', '{$prefix}', array_merge(['ignore_request' => true], \$config));";

		return $body;
	}
}

