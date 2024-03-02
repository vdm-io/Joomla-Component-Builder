<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class componentbuilderHeaderCheck
{
	protected $document = null;
	protected $app = null;

	function js_loaded($script_name)
	{
		// UIkit check point
		if (strpos($script_name,'uikit') !== false)
		{
			if (!$this->app)
			{
				$this->app = Factory::getApplication();
			}

			$getTemplateName = $this->app->getTemplate('template')->template;
			if (strpos($getTemplateName,'yoo') !== false)
			{
				return true;
			}
		}

		if (!$this->document)
		{
			$this->document = Factory::getDocument();
		}

		$head_data = $this->document->getHeadData();
		foreach (array_keys($head_data['scripts']) as $script)
		{
			if (stristr($script, $script_name))
			{
				return true;
			}
		}

		return false;
	}

	function css_loaded($script_name)
	{
		// UIkit check point
		if (strpos($script_name,'uikit') !== false)
		{
			if (!$this->app)
			{
				$this->app = Factory::getApplication();
			}

			$getTemplateName = $this->app->getTemplate('template')->template;
			if (strpos($getTemplateName,'yoo') !== false)
			{
				return true;
			}
		}

		if (!$this->document)
		{
			$this->document = Factory::getDocument();
		}

		$head_data = $this->document->getHeadData();
		foreach (array_keys($head_data['styleSheets']) as $script)
		{
			if (stristr($script, $script_name))
			{
				return true;
			}
		}

		return false;
	}
}
