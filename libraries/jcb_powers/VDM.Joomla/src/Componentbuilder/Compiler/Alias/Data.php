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

namespace VDM\Joomla\Componentbuilder\Compiler\Alias;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Model\Loader;
use VDM\Joomla\Componentbuilder\Compiler\Model\Libraries;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Alias Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The compiler registry
	 *
	 * @var    Registry
	 * @since 3.2.0
	 */
	protected Registry $registry;

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
	 * Compiler Auto Loader
	 *
	 * @var    Loader
	 * @since 3.2.0
	 */
	protected Loader $loader;

	/**
	 * Compiler Libraries Model
	 *
	 * @var    Libraries
	 * @since 3.2.0
	 */
	protected Libraries $libraries;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Constructor
	 *
	 * @param Config|null               $config           The compiler config object.
	 * @param Registry|null             $registry         The compiler registry object.
	 * @param Customcode|null           $customcode       The compiler customcode object.
	 * @param Gui|null                  $gui              The compiler customcode gui.
	 * @param Loader|null               $load             The compiler loader object.
	 * @param Libraries|null            $libraries        The compiler libraries model object.
	 * @param \JDatabaseDriver|null     $db               The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Customcode $customcode = null, ?Gui $gui = null,
		?Loader $loader = null, ?Libraries $libraries = null,
		?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->loader = $loader ?: Compiler::_('Model.Loader');
		$this->libraries = $libraries ?: Compiler::_('Model.Libraries');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get Data by Alias
	 *
	 * @param   string  $alias  The alias name
	 * @param   string  $table  The table where to find the alias
	 * @param   string  $view   The view code name
	 *
	 * @return  array|null The data found with the alias
	 * @since 3.2.0
	 */
	public function get(string $alias, string $table, string $view): ?array
	{
		// if not set, get all keys in table and set by ID
		$this->set($table);

		// now check if key is found
		$name = preg_replace("/[^A-Za-z]/", '', $alias);

		if (($id = $this->registry->get('builder.data_with_alias_keys.' . $table . '.' . $name, null)) === null &&
			($id = $this->registry->get('builder.data_with_alias_keys.' . $table . '.' . $alias, null)) === null)
		{
			return null;
		}

		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_' . $table . ' AS a');
		$query->where(
			$this->db->quoteName('a.id') . ' = ' . (int) $id
		);

		// get the row
		$this->db->setQuery($query);
		$item = $this->db->loadObject();

		// get the other target if both
		$targets = [$this->config->build_target];

		if ($this->config->lang_target === 'both')
		{
			$targets = ['site', 'admin'];
		}

		// we load this layout
		$php_view = '';
		if ($item->add_php_view == 1
			&& StringHelper::check($item->php_view))
		{
			$php_view = $this->gui->set(
				$this->customcode->update(base64_decode((string) $item->php_view)),
				array(
					'table' => $table,
					'field' => 'php_view',
					'id'    => (int) $item->id,
					'type'  => 'php')
			);
		}

		$content = $this->gui->set(
			$this->customcode->update(base64_decode((string) $item->{$table})),
			array(
				'table' => $table,
				'field' => $table,
				'id'    => (int) $item->id,
				'type'  => 'html')
		);

		// load all targets
		foreach ($targets as $target)
		{
			// set libraries
			$this->libraries->set($view, $item, $target);

			// auto loaders
			$this->loader->set($view, $content, $target);
			$this->loader->set($view, $php_view, $target);
		}

		// load uikit version 2 if required
		$this->loader->uikit($view, $content);
		$this->loader->uikit($view, $php_view);

		return [
			'id'       => $item->id,
			'html'     => $this->gui->set(
				$content,
				[
					'table' => $table,
					'field' => $table,
					'id'    => $item->id,
					'type'  => 'html'
				]
			),
			'php_view' => $this->gui->set(
				$php_view,
				[
					'table' => $table,
					'field' => 'php_view',
					'id'    => $item->id,
					'type'  => 'php'
				]
			)
		];
	}

	/**
	 * Load all alias and ID's of a table
	 *
	 * @param   string  $table  The table where to find the alias
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function set(string $table)
	{
		// now check if key is found
		if (!$this->registry->get('builder.data_with_alias_keys.' . $table, null))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);
			$query->select(array('a.id', 'a.alias'));
			$query->from('#__componentbuilder_' . $table . ' AS a');
			$this->db->setQuery($query);
			$items = $this->db->loadObjectList();

			// check if we have an array
			if (ArrayHelper::check($items))
			{
				foreach ($items as $item)
				{
					// build the key
					$k_ey = StringHelper::safe($item->alias);
					$key  = preg_replace("/[^A-Za-z]/", '', (string) $k_ey);

					// set the keys
					$this->registry->
						set('builder.data_with_alias_keys.' . $table . '.' . $item->alias, $item->id);
					$this->registry->
						set('builder.data_with_alias_keys.' . $table . '.' . $k_ey, $item->id);
					$this->registry->
						set('builder.data_with_alias_keys.' . $table . '.' . $key, $item->id);
				}
			}
		}
	}

}

