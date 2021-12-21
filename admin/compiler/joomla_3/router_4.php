<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Component\Router\RouterView;
use Joomla\CMS\Component\Router\RouterViewConfiguration;
use Joomla\CMS\Component\Router\Rules\MenuRules;
use Joomla\CMS\Component\Router\Rules\StandardRules;
use Joomla\CMS\Component\Router\Rules\NomenuRules;
use Joomla\CMS\Factory;
use Joomla\CMS\Menu\SiteMenu;

/**
 * Routing class from com_###component###
 *
 * @since  3.10
 */
class ###Component###Router extends RouterView
{
	/**
	 * The database driver
	 *
	 * @var    \JDatabaseDriver
	 * @since  1.0
	 */
	protected $db;

	/**
	 * Search Component router constructor
	 *
	 * @param   CMSApplication  $app   The application object
	 * @param   SiteMenu        $menu  The menu object to work with
	 */
	public function __construct($app = null, $menu = null)
	{
		$this->db = Factory::getDbo();###ROUTER_BUILD_VIEWS_CONF###

		parent::__construct($app, $menu);

		$this->attachRule(new MenuRules($this));
		$this->attachRule(new StandardRules($this));
		$this->attachRule(new NomenuRules($this));
	}###ROUTER_BUILD_VIEWS_SEGMENT_ID###
}
