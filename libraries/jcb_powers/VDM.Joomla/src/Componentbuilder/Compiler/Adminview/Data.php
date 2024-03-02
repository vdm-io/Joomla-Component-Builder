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

namespace VDM\Joomla\Componentbuilder\Compiler\Adminview;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Model\CustomtabsInterface as Customtabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Tabs;
use VDM\Joomla\Componentbuilder\Compiler\Model\Fields;
use VDM\Joomla\Componentbuilder\Compiler\Model\Historyadminview as History;
use VDM\Joomla\Componentbuilder\Compiler\Model\Permissions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Conditions;
use VDM\Joomla\Componentbuilder\Compiler\Model\Relations;
use VDM\Joomla\Componentbuilder\Compiler\Model\Linkedviews;
use VDM\Joomla\Componentbuilder\Compiler\Model\Javascriptadminview as Javascript;
use VDM\Joomla\Componentbuilder\Compiler\Model\Cssadminview as Css;
use VDM\Joomla\Componentbuilder\Compiler\Model\Phpadminview as Php;
use VDM\Joomla\Componentbuilder\Compiler\Model\Custombuttons;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customimportscripts;
use VDM\Joomla\Componentbuilder\Compiler\Model\Ajaxadmin as Ajax;
use VDM\Joomla\Componentbuilder\Compiler\Model\Customalias;
use VDM\Joomla\Componentbuilder\Compiler\Model\Sql;
use VDM\Joomla\Componentbuilder\Compiler\Model\Mysqlsettings;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteEditView;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Admin View Data Class
 * 
 * @since 3.2.0
 */
class Data
{
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
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 3.2.0
	 */
	protected Dispenser $dispenser;

	/**
	 * The Customtabs Class.
	 *
	 * @var   Customtabs
	 * @since 3.2.0
	 */
	protected Customtabs $customtabs;

	/**
	 * The Tabs Class.
	 *
	 * @var   Tabs
	 * @since 3.2.0
	 */
	protected Tabs $tabs;

	/**
	 * The Fields Class.
	 *
	 * @var   Fields
	 * @since 3.2.0
	 */
	protected Fields $fields;

	/**
	 * The Historyadminview Class.
	 *
	 * @var   History
	 * @since 3.2.0
	 */
	protected History $history;

	/**
	 * The Permissions Class.
	 *
	 * @var   Permissions
	 * @since 3.2.0
	 */
	protected Permissions $permissions;

	/**
	 * The Conditions Class.
	 *
	 * @var   Conditions
	 * @since 3.2.0
	 */
	protected Conditions $conditions;

	/**
	 * The Relations Class.
	 *
	 * @var   Relations
	 * @since 3.2.0
	 */
	protected Relations $relations;

	/**
	 * The Linkedviews Class.
	 *
	 * @var   Linkedviews
	 * @since 3.2.0
	 */
	protected Linkedviews $linkedviews;

	/**
	 * The Javascriptadminview Class.
	 *
	 * @var   Javascript
	 * @since 3.2.0
	 */
	protected Javascript $javascript;

	/**
	 * The Cssadminview Class.
	 *
	 * @var   Css
	 * @since 3.2.0
	 */
	protected Css $css;

	/**
	 * The Phpadminview Class.
	 *
	 * @var   Php
	 * @since 3.2.0
	 */
	protected Php $php;

	/**
	 * The Custombuttons Class.
	 *
	 * @var   Custombuttons
	 * @since 3.2.0
	 */
	protected Custombuttons $custombuttons;

	/**
	 * The Customimportscripts Class.
	 *
	 * @var   Customimportscripts
	 * @since 3.2.0
	 */
	protected Customimportscripts $customimportscripts;

	/**
	 * The Ajaxadmin Class.
	 *
	 * @var   Ajax
	 * @since 3.2.0
	 */
	protected Ajax $ajax;

	/**
	 * The Customalias Class.
	 *
	 * @var   Customalias
	 * @since 3.2.0
	 */
	protected Customalias $customalias;

	/**
	 * The Sql Class.
	 *
	 * @var   Sql
	 * @since 3.2.0
	 */
	protected Sql $sql;

	/**
	 * The Mysqlsettings Class.
	 *
	 * @var   Mysqlsettings
	 * @since 3.2.0
	 */
	protected Mysqlsettings $mysqlsettings;

	/**
	 * The SiteEditView Class.
	 *
	 * @var   SiteEditView
	 * @since 3.2.0
	 */
	protected SiteEditView $siteeditview;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Event                 $event                 The EventInterface Class.
	 * @param Placeholder           $placeholder           The Placeholder Class.
	 * @param Dispenser             $dispenser             The Dispenser Class.
	 * @param Customtabs            $customtabs            The Customtabs Class.
	 * @param Tabs                  $tabs                  The Tabs Class.
	 * @param Fields                $fields                The Fields Class.
	 * @param History               $history               The Historyadminview Class.
	 * @param Permissions           $permissions           The Permissions Class.
	 * @param Conditions            $conditions            The Conditions Class.
	 * @param Relations             $relations             The Relations Class.
	 * @param Linkedviews           $linkedviews           The Linkedviews Class.
	 * @param Javascript            $javascript            The Javascriptadminview Class.
	 * @param Css                   $css                   The Cssadminview Class.
	 * @param Php                   $php                   The Phpadminview Class.
	 * @param Custombuttons         $custombuttons         The Custombuttons Class.
	 * @param Customimportscripts   $customimportscripts   The Customimportscripts Class.
	 * @param Ajax                  $ajax                  The Ajaxadmin Class.
	 * @param Customalias           $customalias           The Customalias Class.
	 * @param Sql                   $sql                   The Sql Class.
	 * @param Mysqlsettings         $mysqlsettings         The Mysqlsettings Class.
	 * @param SiteEditView          $siteeditview          The SiteEditView Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Event $event, Placeholder $placeholder, Dispenser $dispenser, Customtabs $customtabs, Tabs $tabs, Fields $fields,
		History $history, Permissions $permissions, Conditions $conditions, Relations $relations, Linkedviews $linkedviews, Javascript $javascript,
		Css $css, Php $php, Custombuttons $custombuttons, Customimportscripts $customimportscripts, Ajax $ajax, Customalias $customalias, Sql $sql,
		Mysqlsettings $mysqlsettings, SiteEditView $siteeditview)
	{
		$this->config = $config;
		$this->event = $event;
		$this->placeholder = $placeholder;
		$this->dispenser = $dispenser;
		$this->customtabs = $customtabs;
		$this->tabs = $tabs;
		$this->fields = $fields;
		$this->history = $history;
		$this->permissions = $permissions;
		$this->conditions = $conditions;
		$this->relations = $relations;
		$this->linkedviews = $linkedviews;
		$this->javascript = $javascript;
		$this->css = $css;
		$this->php = $php;
		$this->custombuttons = $custombuttons;
		$this->customimportscripts = $customimportscripts;
		$this->ajax = $ajax;
		$this->customalias = $customalias;
		$this->sql = $sql;
		$this->mysqlsettings = $mysqlsettings;
		$this->siteeditview = $siteeditview;
		$this->db = Factory::getDbo();
	}

	/**
	 * Get Admin View Data
	 *
	 * @param   int  $id  The view ID
	 *
	 * @return  object|null The view data
	 * @since 3.2.0
	 */
	public function get(int $id): ?object
	{
		if (!isset($this->data[$id]))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'b.addfields',
						'b.id',
						'c.addconditions',
						'c.id',
						'r.addrelations',
						't.tabs'
					), array(
						'addfields',
						'addfields_id',
						'addconditions',
						'addconditions_id',
						'addrelations',
						'customtabs'
					)
				)
			);

			$query->from('#__componentbuilder_admin_view AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_admin_fields', 'b')
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('b.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_conditions', 'c'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('c.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_fields_relations', 'r'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('r.admin_view') . ')'
			);

			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_admin_custom_tabs', 't'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('t.admin_view') . ')'
			);

			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);

			// Trigger Event: jcb_ce_onBeforeQueryViewData
			$this->event->trigger(
				'jcb_ce_onBeforeQueryViewData', [&$id, &$query, &$this->db]
			);

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			$view = $this->db->loadObject();

			// setup single view code names to use in storing the data
			$view->name_single_code = 'oops_hmm_' . $id;
			if (isset($view->name_single) && $view->name_single != 'null')
			{
				$view->name_single_code = StringHelper::safe(
					$view->name_single
				);
			}

			// setup list view code name to use in storing the data
			$view->name_list_code = 'oops_hmmm_' . $id;
			if (isset($view->name_list) && $view->name_list != 'null')
			{
				$view->name_list_code = StringHelper::safe(
					$view->name_list
				);
			}

			// check the length of the view name (+5 for com_ and _)
			$name_length = $this->config->component_code_name_length + strlen(
					(string) $view->name_single_code
				) + 5;
			// when the name is larger than 49 we need to add the assets' table name fix
			if ($name_length > 49)
			{
				$this->config->set('add_assets_table_name_fix', true);
			}

			// setup token check
			if (!isset($this->dispenser->hub['token']))
			{
				$this->dispenser->hub['token'] = [];
			}
			$this->dispenser->hub['token'][$view->name_single_code] = false;
			$this->dispenser->hub['token'][$view->name_list_code] = false;

			// set some placeholders
			$this->placeholder->set('view', $view->name_single_code);
			$this->placeholder->set('views', $view->name_list_code);
			$this->placeholder->set('View', StringHelper::safe(
				$view->name_single, 'F'
			));
			$this->placeholder->set('Views', StringHelper::safe(
				$view->name_list, 'F'
			));
			$this->placeholder->set('VIEW', StringHelper::safe(
				$view->name_single, 'U'
			));
			$this->placeholder->set('VIEWS', StringHelper::safe(
				$view->name_list, 'U'
			));

			// Trigger Event: jcb_ce_onBeforeModelViewData
			$this->event->trigger(
				'jcb_ce_onBeforeModelViewData', [&$view]
			);

			// add the tables
			$view->addtables = (isset($view->addtables)
				&& JsonHelper::check($view->addtables))
				? json_decode((string) $view->addtables, true) : null;
			if (ArrayHelper::check($view->addtables))
			{
				$view->tables = array_values($view->addtables);
			}
			unset($view->addtables);

			// set custom tabs
			$this->customtabs->set($view);

			// set the local tabs
			$this->tabs->set($view);

			// set permissions
			$this->permissions->set($view);

			// set fields
			$this->fields->set($view);

			// build update SQL
			$this->history->set($view);

			// set the conditions
			$this->conditions->set($view);

			// set the relations
			$this->relations->set($view);

			// set linked views
			$this->linkedviews->set($view);

			// set the lang target
			$this->config->lang_target = 'admin';
			if ($this->siteeditview->exists($id))
			{
				$this->config->lang_target = 'both';
			}

			// set javascript
			$this->javascript->set($view);

			// set css
			$this->css->set($view);

			// set php
			$this->php->set($view);

			// set custom buttons
			$this->custombuttons->set($view);

			// set custom import scripts
			$this->customimportscripts->set($view);

			// set Ajax for this view
			$this->ajax->set($view);

			// activate alias builder
			$this->customalias->set($view);

			// set sql
			$this->sql->set($view);

			// set mySql Table Settings
			$this->mysqlsettings->set($view);

			// Trigger Event: jcb_ce_onAfterModelViewData
			$this->event->trigger(
				'jcb_ce_onAfterModelViewData', [&$view]
			);

			// clear placeholders
			$this->placeholder->remove('view');
			$this->placeholder->remove('views');
			$this->placeholder->remove('View');
			$this->placeholder->remove('Views');
			$this->placeholder->remove('VIEW');
			$this->placeholder->remove('VIEWS');

			// store this view to class object
			$this->data[$id] = $view;
		}

		// return the found view data
		return $this->data[$id];
	}
}

