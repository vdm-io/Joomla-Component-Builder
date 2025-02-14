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
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
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
use VDM\Joomla\Utilities\GuidHelper;


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
	 * @since  3.2.0
	 */
	protected array $data = [];

	/**
	 *  Tracking GUID index
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $index = [];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Libraries Class.
	 *
	 * @var   Libraries
	 * @since 3.2.0
	 */
	protected Libraries $libraries;

	/**
	 * The Data Class.
	 *
	 * @var   Templatelayout
	 * @since 3.2.0
	 */
	protected Templatelayout $templatelayout;

	/**
	 * The Data Class.
	 *
	 * @var   Dynamicget
	 * @since 3.2.0
	 */
	protected Dynamicget $dynamic;

	/**
	 * The Loader Class.
	 *
	 * @var   Loader
	 * @since 3.2.0
	 */
	protected Loader $loader;

	/**
	 * The Javascriptcustomview Class.
	 *
	 * @var   Javascriptcustomview
	 * @since 3.2.0
	 */
	protected Javascriptcustomview $javascript;

	/**
	 * The Csscustomview Class.
	 *
	 * @var   Csscustomview
	 * @since 3.2.0
	 */
	protected Csscustomview $css;

	/**
	 * The Phpcustomview Class.
	 *
	 * @var   Phpcustomview
	 * @since 3.2.0
	 */
	protected Phpcustomview $php;

	/**
	 * The Ajaxcustomview Class.
	 *
	 * @var   Ajaxcustomview
	 * @since 3.2.0
	 */
	protected Ajaxcustomview $ajax;

	/**
	 * The Custombuttons Class.
	 *
	 * @var   Custombuttons
	 * @since 3.2.0
	 */
	protected Custombuttons $custombuttons;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param Config                 $config                 The Config Class.
	 * @param Event                  $event                  The EventInterface Class.
	 * @param Customcode             $customcode             The Customcode Class.
	 * @param Gui                    $gui                    The Gui Class.
	 * @param Libraries              $libraries              The Libraries Class.
	 * @param Templatelayout         $templatelayout         The Data Class.
	 * @param Dynamicget             $dynamicget             The Data Class.
	 * @param Loader                 $loader                 The Loader Class.
	 * @param Javascriptcustomview   $javascriptcustomview   The Javascriptcustomview Class.
	 * @param Csscustomview          $csscustomview          The Csscustomview Class.
	 * @param Phpcustomview          $phpcustomview          The Phpcustomview Class.
	 * @param Ajaxcustomview         $ajaxcustomview         The Ajaxcustomview Class.
	 * @param Custombuttons          $custombuttons          The Custombuttons Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Event $event, Customcode $customcode,
		Gui $gui, Libraries $libraries,
		Templatelayout $templatelayout, Dynamicget $dynamicget,
		Loader $loader,
		Javascriptcustomview $javascriptcustomview,
		Csscustomview $csscustomview,
		Phpcustomview $phpcustomview,
		Ajaxcustomview $ajaxcustomview,
		Custombuttons $custombuttons)
	{
		$this->config = $config;
		$this->event = $event;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->libraries = $libraries;
		$this->templatelayout = $templatelayout;
		$this->dynamic = $dynamicget;
		$this->loader = $loader;
		$this->javascript = $javascriptcustomview;
		$this->css = $csscustomview;
		$this->php = $phpcustomview;
		$this->ajax = $ajaxcustomview;
		$this->custombuttons = $custombuttons;
		$this->db = Factory::getDbo();
	}

	/**
	 * Get Custom/Site View Data
	 *
	 * @param   mixed  $view  The view ID/GUID
	 * @param   string $table The view table
	 *
	 * @return  object|null The custom/site view data
	 * @since   3.2.0
	 */
	public function get($view, string $table = 'site_view'): ?object
	{
		$key = $view . $table;
		if (isset($this->index[$key]))
		{
			$key_id = $this->index[$key];

			return $this->data[$key_id];
		}

		$this->set($view, $table);

		if (isset($this->index[$key]))
		{
			$key_id = $this->index[$key];

			return $this->data[$key_id];
		}

		return null;
	}

	/**
	 * Set the admin view
	 *
	 * @param   mixed  $view  The view ID/GUID
	 * @param   string $table The view table
	 *
	 * @return  void
	 * @since   5.0.4
	 */
	private function set($view, string $table): void
	{
		if (GuidHelper::valid($view))
		{
			$query = $this->getQuery($view, $table, 'guid');
		}
		else
		{
			$query = $this->getQuery($view, $table);
		}

		$data = $this->getData($query, $table);

		if ($data !== null)
		{
			$key_id = $data->id . $table;
			$key_guid = $data->guid . $table;

			$this->data[$key_id] = $data;
			$this->index[$key_id] = $key_id;
			$this->index[$key_guid] = $key_id;
		}
	}

	/**
	 * get current custom/site view data query
	 *
	 * @param   mixed    $value   The field ID/GUID
	 * @param   string   $table   The view table
	 * @param   string   $key     The type of value
	 *
	 * @return  string  The custom/site view data query
	 * @since   5.0.4
	 */
	private function getQuery($value, string $table, string $key = 'id')
	{
		// Create a new query object.
		$query = $this->db->getQuery(true);

		$query->select('a.*');
		$query->from('#__componentbuilder_' . $table . ' AS a');
		$query->where($this->db->quoteName('a.' . $key) . ' = ' . $this->db->quote($value));

		// Trigger Event: jcb_ce_onBeforeQueryCustomViewData
		$this->event->trigger(
			'jcb_ce_onBeforeQueryCustomViewData', [&$value, &$table, &$query, &$this->db]
		);

		return $query;
	}

	/**
	 * get custom/site view data
	 *
	 * @param   string   $query   The field query
	 * @param   string   $table   The view table
	 *
	 * @return  object|null  The custom/site view data
	 * @since   5.0.4
	 */
	private function getData($query, string $table): ?object
	{
		// Reset the query using our newly populated query object.
		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			$item = $this->db->loadObject();
			$id = $item->id;

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
			if (isset($item->icon) && strpos($item->icon, '#') !== false)
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
			$this->templatelayout->set($item->default, $item->code);

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
			$item->custom_get = (isset($item->custom_get) && JsonHelper::check($item->custom_get))
				? json_decode((string) $item->custom_get, true)
				: null;

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

			return $item;
		}

		return null;
	}
}

