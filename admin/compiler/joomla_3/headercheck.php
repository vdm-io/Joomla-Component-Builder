<?php
/*--------------------------------------------------------------------------------------------------------|  www.vdm.io  |------/
	__      __       _     _____                 _                                  _     __  __      _   _               _
	\ \    / /      | |   |  __ \               | |                                | |   |  \/  |    | | | |             | |
	 \ \  / /_ _ ___| |_  | |  | | _____   _____| | ___  _ __  _ __ ___   ___ _ __ | |_  | \  / | ___| |_| |__   ___   __| |
	  \ \/ / _` / __| __| | |  | |/ _ \ \ / / _ \ |/ _ \| '_ \| '_ ` _ \ / _ \ '_ \| __| | |\/| |/ _ \ __| '_ \ / _ \ / _` |
	   \  / (_| \__ \ |_  | |__| |  __/\ V /  __/ | (_) | |_) | | | | | |  __/ | | | |_  | |  | |  __/ |_| | | | (_) | (_| |
		\/ \__,_|___/\__| |_____/ \___| \_/ \___|_|\___/| .__/|_| |_| |_|\___|_| |_|\__| |_|  |_|\___|\__|_| |_|\___/ \__,_|
														| |
														|_|
/-------------------------------------------------------------------------------------------------------------------------------/

	@package        Component Builder
	@subpackage        componentbuilder.php
	@author            Llewellyn van der Merwe <https://www.vdm.io/joomla-component-builder>
	@my wife        Roline van der Merwe <http://www.vdm.io/>
	@copyright        Copyright (C) 2015. All Rights Reserved
	@license        GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html

	Builds Complex Joomla Components

/-----------------------------------------------------------------------------------------------------------------------------*/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;

class ###component###HeaderCheck
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