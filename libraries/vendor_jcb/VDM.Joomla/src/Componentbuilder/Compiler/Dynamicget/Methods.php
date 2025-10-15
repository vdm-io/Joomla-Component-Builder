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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItem;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItems;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\ListQuery;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\CustomGetMethods;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\UikitLoader;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use Joomla\CMS\Factory;


/**
 * Dynamic Get Methods
 * 
 * @since 5.1.2
 */
final class Methods
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The GetItem Class.
	 *
	 * @var   GetItem
	 * @since 5.1.2
	 */
	protected GetItem $getitem;

	/**
	 * The GetItems Class.
	 *
	 * @var   GetItems
	 * @since 5.1.2
	 */
	protected GetItems $getitems;

	/**
	 * The ListQuery Class.
	 *
	 * @var   ListQuery
	 * @since 5.1.2
	 */
	protected ListQuery $listquery;

	/**
	 * The CustomGetMethods Class.
	 *
	 * @var   CustomGetMethods
	 * @since 5.1.2
	 */
	protected CustomGetMethods $customgetmethods;

	/**
	 * The UikitLoader Class.
	 *
	 * @var   UikitLoader
	 * @since 5.1.2
	 */
	protected UikitLoader $uikitloader;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Placeholder        $placeholder        The Placeholder Class.
	 * @param GetItem            $getitem            The GetItem Class.
	 * @param GetItems           $getitems           The GetItems Class.
	 * @param ListQuery          $listquery          The ListQuery Class.
	 * @param CustomGetMethods   $customgetmethods   The CustomGetMethods Class.
	 * @param UikitLoader        $uikitloader        The UikitLoader Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Placeholder $placeholder, GetItem $getitem,
		GetItems $getitems, ListQuery $listquery,
		CustomGetMethods $customgetmethods,
		UikitLoader $uikitloader)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->getitem = $getitem;
		$this->getitems = $getitems;
		$this->listquery = $listquery;
		$this->customgetmethods = $customgetmethods;
		$this->uikitloader = $uikitloader;
	}

	/**
	 * Get the required data to generate dynamicget methods.
	 *
	 * @param  array|object   $mainView  The main view data
	 * @param  string         $code      The component code
	 *
	 * @return string  The generated methods
	 * @since  5.1.2
	 */
	public function get($mainView, string $code): string
	{
		if (empty($mainView) || empty($code))
		{
			return '';
		}

		$methods = '';

		if (
			ArrayHelper::check($mainView)
			&& isset($mainView['settings'])
			&& ObjectHelper::check($mainView['settings'])
			&& isset($mainView['settings']->custom_get)
		) {
			$_dynamic_get = $mainView['settings']->custom_get;
		} elseif (ObjectHelper::check($mainView) && isset($mainView->custom_get)) {
			$_dynamic_get = $mainView->custom_get;
		}

		if (isset($_dynamic_get) && ArrayHelper::check($_dynamic_get))
		{
			foreach ($_dynamic_get as $view)
			{
				$view->code = StringHelper::safe($code);
				$view->Code = StringHelper::safe($view->code, 'F');
				$view->CODE = StringHelper::safe($view->code, 'U');
				$main = '';

				if ($view->gettype == 3)
				{
					if ($this->config->get('joomla_version', 3) == 3)
					{
						$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (!isset(\$this->initSet) || !\$this->initSet)";
						$main .= PHP_EOL . Indent::_(2) . "{";
						$main .= PHP_EOL . Indent::_(3) . "\$this->user = Factory::getUser();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->userId = \$this->user->get('id');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->guest = \$this->user->get('guest');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->groups = \$this->user->get('groups');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->levels = \$this->user->getAuthorisedViewLevels();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->initSet = true;";
						$main .= PHP_EOL . Indent::_(2) . "}";
					}

					$main .= $this->getitem->get($view, $view->code, '', 'custom');
					$type = 'mixed  item data object on success, false on failure.';
				}
				elseif ($view->gettype == 4)
				{
					if ($this->config->get('joomla_version', 3) == 3)
					{
						$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (!isset(\$this->initSet) || !\$this->initSet)";
						$main .= PHP_EOL . Indent::_(2) . "{";
						$main .= PHP_EOL . Indent::_(3) . "\$this->user = Factory::getUser();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->userId = \$this->user->get('id');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->guest = \$this->user->get('guest');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->groups = \$this->user->get('groups');";
						$main .= PHP_EOL . Indent::_(3) . "\$this->authorisedGroups = \$this->user->getAuthorisedGroups();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->levels = \$this->user->getAuthorisedViewLevels();";
						$main .= PHP_EOL . Indent::_(3) . "\$this->initSet = true;";
						$main .= PHP_EOL . Indent::_(2) . "}";
					}

					$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Get the global params";
					$main .= PHP_EOL . Indent::_(2) . "\$globalParams = ComponentHelper::getParams('com_" . $this->config->component_code_name . "', true);";

					if (
						isset($view->add_php_getlistquery)
						&& $view->add_php_getlistquery == 1
						&& isset($view->php_getlistquery)
						&& StringHelper::check($view->php_getlistquery)
					) {
						$main .= $this->placeholder->update_($view->php_getlistquery);
					}

					$main .= $this->listquery->get($view, $view->code, false);

					if (
						isset($view->add_php_before_getitems)
						&& $view->add_php_before_getitems == 1
						&& isset($view->php_before_getitems)
						&& StringHelper::check($view->php_before_getitems)
					) {
						$main .= $this->placeholder->update_($view->php_before_getitems);
					}

					$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " Reset the query using our newly populated query object.";
					$main .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
					$main .= PHP_EOL . Indent::_(2) . "\$items = \$db->loadObjectList();";
					$main .= PHP_EOL . PHP_EOL . Indent::_(2) . "if (empty(\$items))";
					$main .= PHP_EOL . Indent::_(2) . "{";
					$main .= PHP_EOL . Indent::_(3) . "return false;";
					$main .= PHP_EOL . Indent::_(2) . "}";

					$main .= $this->getitems->get($view, $view->code);

					if (
						isset($view->add_php_after_getitems)
						&& $view->add_php_after_getitems == 1
						&& isset($view->php_after_getitems)
						&& StringHelper::check($view->php_after_getitems)
					) {
						$main .= $this->placeholder->update_($view->php_after_getitems);
					}

					$main .= PHP_EOL . Indent::_(2) . "//" . Line::_(__LINE__, __CLASS__) . " return items";
					$main .= PHP_EOL . Indent::_(2) . "return \$items;";

					$type = 'mixed  An array of objects on success, false on failure.';
				}

				$methods .= $this->getMethod($main, $view->getcustom, $type);
				$methods .= $this->customgetmethods->get($view, $view->code);
			}
		}

		if (ArrayHelper::check($mainView) && isset($mainView['settings']))
		{
			$methods .= $this->uikitloader->getUikitComp();
		}

		return $methods;
	}

	/**
	 * Get the main custom method block.
	 *
	 * @param  string  $body   The PHP code body
	 * @param  string  $name   The function name
	 * @param  string  $type   The doc return type
	 *
	 * @return string  The built method block
	 * @since  5.1.2
	 */
	public function getMethod(string $body, string $name, string $type): string
	{
		$method = '';

		if (StringHelper::check($body))
		{
			$method .= PHP_EOL . PHP_EOL . Indent::_(1) . "/**";
			$method .= PHP_EOL . Indent::_(1) . " * Custom Method";
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " * @return " . $type;
			$method .= PHP_EOL . Indent::_(1) . " *";
			$method .= PHP_EOL . Indent::_(1) . " */";
			$method .= PHP_EOL . Indent::_(1) . "public function " . $name . "()";
			$method .= PHP_EOL . Indent::_(1) . "{" . $body;
			$method .= PHP_EOL . Indent::_(1) . "}";
		}

		return $method;
	}
}

