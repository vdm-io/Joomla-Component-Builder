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


use Joomla\Database\DatabaseInterface;
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
	 * tracking GUID index
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $index = [];

	/**
	 * allowed tables
	 *
	 * @var    array
	 * @since  5.0.4
	 */
	protected array $allowedTables = ['template', 'layout'];

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
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 **/
	protected DatabaseInterface $db;

	/**
	 * Constructor.
	 *
	 * @param Config             $config       The Config Class.
	 * @param Registry           $registry     The Registry Class.
	 * @param Customcode         $customcode   The Customcode Class.
	 * @param Gui                $gui          The Gui Class.
	 * @param Loader             $loader       The Loader Class.
	 * @param Libraries          $libraries    The Libraries Class.
	 * @param DatabaseInterface  $db           The Joomla Database Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Registry $registry, Customcode $customcode,
		Gui $gui, Loader $loader, Libraries $libraries, DatabaseInterface $db)
	{
		$this->config = $config;
		$this->registry = $registry;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->loader = $loader;
		$this->libraries = $libraries;
		$this->db = $db;
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
		if (($id = $this->getAliasId($alias, $table)) === null)
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
	 * Get the id of this alias
	 *
	 * @param   string  $alias  The alias name
	 * @param   string  $table  The table where to find the alias
	 *
	 * @return  int|null
	 * @since   5.0.4
	 */
	protected function getAliasId(string $alias, string $table): ?int
	{
		if ($this->set($table))
		{
			// now check if key is found
			$name = preg_replace("/[^A-Za-z]/", '', $alias);

			return $this->index[$table][$name] ?? $this->index[$table][$alias] ?? null;
		}

		return null;
	}

	/**
	 * Load all alias and ID's of a table
	 *
	 * @param   string  $table  The table where to find the alias
	 *
	 * @return  bool   True if table was loaded
	 * @since 3.2.0
	 */
	protected function set(string $table): bool
	{
		// now check if key is found
		if (empty($this->index[$table]) && in_array($table, $this->allowedTables))
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
				$this->index[$table] = [];
				foreach ($items as $item)
				{
					// build the key
					$k_ey = StringHelper::safe($item->alias);
					$key  = preg_replace("/[^A-Za-z]/", '', (string) $k_ey);

					// set the keys
					$this->index[$table][$item->alias] = $item->id;
					$this->index[$table][$k_ey] = $item->id;
					$this->index[$table][$key] = $item->id;
				}
			}
		}
		return isset($this->index[$table]);
	}
}

