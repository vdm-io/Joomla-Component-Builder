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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Component;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\PostInstallScript as SharedPostInstallScript;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Joomla 3 Component Post Install Script Class.
 * 
 * A Joomla 3 install script writes the permissions and params of the extension
 * into the database itself, there being no method on the script to hand them to.
 * 
 * @since  6.1.7
 */
final class PostInstallScript extends SharedPostInstallScript
{
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

		// set the component name
		$component = $this->config->component_code_name;

		// add the assets table update for permissions rules
		if ($this->assetsrules->isArray('site'))
		{
			if (StringHelper::check($script))
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extenstion assets permission.";
			}
			else
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension assets permission.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";
			}
			$script .= PHP_EOL . Indent::_(3)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Field to update.";
			$script .= PHP_EOL . Indent::_(3) . "\$fields = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('rules') . ' = ' . \$db->quote('{" . implode(
					',', $this->assetsrules->get('site')
				) . "}'),";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Condition.";
			$script .= PHP_EOL . Indent::_(3) . "\$conditions = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('name') . ' = ' . \$db->quote('com_"
				. $component . "')";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3)
				. "\$query->update(\$db->quoteName('#__assets'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(3) . "\$allDone = \$db->execute();"
				. PHP_EOL;
		}

		// add the global params for the component global settings
		if ($this->extensionsparams->isArray('component'))
		{
			if (StringHelper::check($script))
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension params.";
			}
			else
			{
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Install the global extension params.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";
			}
			$script .= PHP_EOL . Indent::_(3)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Field to update.";
			$script .= PHP_EOL . Indent::_(3) . "\$fields = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('params') . ' = ' . \$db->quote('{"
				. implode(',', $this->extensionsparams->get('component')) . "}'),";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " Condition.";
			$script .= PHP_EOL . Indent::_(3) . "\$conditions = array(";
			$script .= PHP_EOL . Indent::_(4)
				. "\$db->quoteName('element') . ' = ' . \$db->quote('com_"
				. $component . "')";
			$script .= PHP_EOL . Indent::_(3) . ");";
			$script .= PHP_EOL . Indent::_(3)
				. "\$query->update(\$db->quoteName('#__extensions'))->set(\$fields)->where(\$conditions);";
			$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(3) . "\$allDone = \$db->execute();"
				. PHP_EOL;
		}

		return $script;
	}
}

