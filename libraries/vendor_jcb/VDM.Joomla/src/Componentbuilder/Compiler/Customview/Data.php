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

namespace VDM\Joomla\Componentbuilder\Compiler\Customview;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Libraries;
use VDM\Joomla\Componentbuilder\Compiler\Templatelayout\Data as Templatelayout;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Data as Dynamicget;
use VDM\Joomla\Componentbuilder\Compiler\Model\Loader;
use VDM\Joomla\Componentbuilder\Compiler\Model\Javascriptcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Csscustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Phpcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Ajaxcustomview;
use VDM\Joomla\Componentbuilder\Compiler\Model\Custombuttons;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Admin Custom View Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Admin views
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $data;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Compiler Event
	 *
	 * @var    EventInterface
	 * @since 3.2.0
	 */
	protected EventInterface $event;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Libraries Model
	 *
	 * @var    Libraries
	 * @since 3.2.0
	 */
	protected Libraries $libraries;

	/**
	 * Compiler Template Layout
	 *
	 * @var    Templatelayout
	 * @since 3.2.0
	 */
	protected Templatelayout $templateLayout;

	/**
	 * Compiler Dynamic Get Data
	 *
	 * @var    Dynamicget
	 * @since 3.2.0
	 */
	protected Dynamicget $dynamic;

	/**
	 * Compiler Auto Loader
	 *
	 * @var    Loader
	 * @since 3.2.0
	 */
	protected Loader $loader;

	/**
	 * The modelling javascript
	 *
	 * @var    Javascriptcustomview
	 * @since 3.2.0
	 */
	protected Javascriptcustomview $javascript;

	/**
	 * The modelling css
	 *
	 * @var    Csscustomview
	 * @since 3.2.0
	 */
	protected Csscustomview $css;

	/**
	 * The modelling php admin view
	 *
	 * @var    Phpcustomview
	 * @since 3.2.0
	 */
	protected Phpcustomview $php;

	/**
	 * The modelling custom buttons
	 *
	 * @var    Custombuttons
	 * @since 3.2.0
	 */
	protected Custombuttons $custombuttons;

	/**
	 * The modelling ajax
	 *
	 * @var    Ajaxcustomview
	 * @since 3.2.0
	 */
	protected Ajaxcustomview $ajax;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor
	 *
	 * @param Config|null                   $config           The compiler config object.
	 * @param EventInterface|null           $event            The compiler event api object.
	 * @param Customcode|null               $customcode       The compiler customcode object.
	 * @param Gui|null                      $gui              The compiler customcode gui.
	 * @param Libraries|null                $libraries        The compiler libraries model object.
	 * @param Templatelayout|null           $templateLayout   The compiler template layout object.
	 * @param Dynamicget|null               $dynamic          The compiler dynamic get data object.
	 * @param Loader|null                   $loader           The compiler loader object.
	 * @param Javascriptcustomview|null     $javascript       The modelling javascript object.
	 * @param Csscustomview|null            $css              The modelling css object.
	 * @param Phpcustomview|null            $php              The modelling php admin view object.
	 * @param Ajaxcustomview|null           $ajax             The modelling ajax object.
	 * @param Custombuttons|null            $custombuttons    The modelling custombuttons object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?EventInterface $event = null,
		?Customcode $customcode = null, ?Gui $gui = null, ?Libraries $libraries = null,
		?Templatelayout $templateLayout = null, ?Dynamicget $dynamic = null, ?Loader $loader = null,
		?Javascriptcustomview $javascript = null, ?Csscustomview $css = null, ?Phpcustomview $php = null,
		?Ajaxcustomview $ajax = null, ?Custombuttons $custombuttons = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->event = $event ?: Compiler::_('Event');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->libraries = $libraries ?: Compiler::_('Model.Libraries');
		$this->templateLayout = $templateLayout ?: Compiler::_('Templatelayout.Data');
		$this->dynamic = $dynamic ?: Compiler::_('Dynamicget.Data');
		$this->loader = $loader ?: Compiler::_('Model.Loader');
		$this->javascript = $javascript ?: Compiler::_('Model.Javascriptcustomview');
		$this->css = $css ?: Compiler::_('Model.Csscustomview');
		$this->php = $php ?: Compiler::_('Model.Phpcustomview');
		$this->ajax = $ajax ?: Compiler::_('Model.Ajaxcustomview');
		$this->custombuttons = $custombuttons ?: Compiler::_('Model.Custombuttons');
		$this->db = Factory::getDbo();
	}

	/**
	 * Get all Custom View Data
	 *
	 * @param   int     $id     The view ID
	 * @param   string  $table  The view table
	 *
	 * @return  object|null The view data
	 * @since 3.2.0
	 */
	public function get(int $id, string $table = 'site_view'): ?object
	{
		if (!isset($this->data[$id . $table]))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->from('#__componentbuilder_' . $table . ' AS a');
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// Trigger Event: jcb_ce_onBeforeQueryCustomViewData
			$this->event->trigger(
				'jcb_ce_onBeforeQueryCustomViewData', [&$id, &$table, &$query, &$this->db]
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$item = $this->db->loadObject();

			// fix alias to use in code
			$item->code = Unique::code(
				StringHelper::safe($item->codename), $this->config->build_target
			);
			$item->Code = StringHelper::safe($item->code, 'F');
			$item->CODE = StringHelper::safe($item->code, 'U');

			// Trigger Event: jcb_ce_onBeforeModelCustomViewData
			$this->event->trigger(
				'jcb_ce_onBeforeModelCustomViewData', [&$item, &$id, &$table]
			);

			// Make sure the icon is only an icon path
			if (strpos($item->icon, '#') !== false)
			{
				$item->icon = strstr($item->icon, '#', true);
			}

			// set GUI mapper
			$guiMapper = [
				'table' => $table,
				'id' => (int) $id,
				'field' => 'default',
				'type' => 'html'
				];

			// set the default data
			$item->default = $this->gui->set(
				$this->customcode->update(base64_decode((string) $item->default)),
				$guiMapper
			);

			// load context if not set
			if (!isset($item->context)
				|| !StringHelper::check(
					$item->context
				))
			{
				$item->context = $item->code;
			}
			else
			{
				// always make sure context is a safe string
				$item->context = StringHelper::safe($item->context);
			}

			// set the libraries
			$this->libraries->set($item->code, $item);

			// setup template and layout data
			$this->templateLayout->set($item->default, $item->code);

			// set uikit version 2
			$this->loader->uikit($item->code, $item->default);

			// auto loaders
			$this->loader->set($item->code, $item->default);

			// set the main get data
			$main_get = $this->dynamic->get(
				array($item->main_get), $item->code, $item->context
			);
			$item->main_get = ArrayHelper::check($main_get) ? $main_get[0] : null;

			// set the custom_get data
			$item->custom_get = (isset($item->custom_get)
				&& JsonHelper::check($item->custom_get))
				? json_decode((string) $item->custom_get, true) : null;

			if (ArrayHelper::check($item->custom_get))
			{
				$item->custom_get = $this->dynamic->get(
					$item->custom_get, $item->code, $item->context
				);
			}

			// set php scripts
			$this->php->set($item, $table);

			// set javascript scripts
			$this->javascript->set($item, $table);

			// set css scripts
			$this->css->set($item);

			// set Ajax for this view
			$this->ajax->set($item, $table);

			// set the custom buttons
			$this->custombuttons->set($item, $table);

			// Trigger Event: jcb_ce_onAfterModelCustomViewData
			$this->event->trigger(
				'jcb_ce_onAfterModelCustomViewData', [&$item]
			);

			// set the found data
			$this->data[$id . $table] = $item;
		}

		// return the found data
		return $this->data[$id . $table];
	}

}

