<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Database\Get;
use VDM\Joomla\Componentbuilder\Search\Database\Set;
use VDM\Joomla\Componentbuilder\Search\Agent\Find;
use VDM\Joomla\Componentbuilder\Search\Agent\Replace;
use VDM\Joomla\Componentbuilder\Search\Agent\Search;
use VDM\Joomla\Componentbuilder\Search\Agent\Update;
use VDM\Joomla\Componentbuilder\Search\Table;


/**
 * Search Agent
 * 
 * @since 3.2.0
 */
class Agent
{
	/**
	 * Search Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Search Get Database
	 *
	 * @var    Get
	 * @since 3.2.0
	 */
	protected Get $get;

	/**
	 * Search Set Database
	 *
	 * @var    Set
	 * @since 3.2.0
	 */
	protected Set $set;

	/**
	 * Search Find
	 *
	 * @var    Find
	 * @since 3.2.0
	 */
	protected Find $find;

	/**
	 * Search Replace
	 *
	 * @var    Replace
	 * @since 3.2.0
	 */
	protected Replace $replace;

	/**
	 * Search
	 *
	 * @var    Search
	 * @since 3.2.0
	 */
	protected Search $search;

	/**
	 * Update
	 *
	 * @var    Update
	 * @since 3.2.0
	 */
	protected Update $update;

	/**
	 * Table
	 *
	 * @var    Table
	 * @since 3.2.0
	 */
	protected Table $table;

	/**
	 * Return value to search view
	 *
	 * @var    string
	 * @since 3.2.0
	 */
	protected string $return;

	/**
	 * Marker start and end values
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $marker;

	/**
	 * Marker start and end html values
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	protected array $markerHtml;

	/**
	 * Constructor
	 *
	 * @param Config|null      $config        The search config object.
	 * @param Get|null         $get           The search get database object.
	 * @param Set|null         $set           The search get database object.
	 * @param Find|null        $find          The search find object.
	 * @param Replace|null     $replace       The search replace object.
	 * @param Search|null      $search        The search object.
	 * @param Update|null      $update        The update object.
	 * @param Table|null       $table         The table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Get $get = null,
		?Set$set = null, ?Find $find = null, ?Replace $replace = null,
		?Search $search = null, ?Update $update = null, ?Table $table = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->get = $get ?: Factory::_('Get.Database');
		$this->set = $set ?: Factory::_('Set.Database');
		$this->find = $find ?: Factory::_('Agent.Find');
		$this->replace = $replace ?: Factory::_('Agent.Replace');
		$this->search = $search ?: Factory::_('Agent.Search');
		$this->update = $update ?: Factory::_('Agent.Update');
		$this->table = $table ?: Factory::_('Table');
	}

	/**
	 * Get the value of a field in a row and table
	 *
	 * @param   int          $id       The item ID
	 * @param   string       $field    The field key
	 * @param   mixed        $line     The field line
	 * @param   string|null  $table    The table
	 * @param   bool         $update   The switch to triger an update (default is false)
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function getValue(int $id, string $field, $line = null,
		?string $table = null, bool $update = false): string
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (($value = $this->get->value($id, $field, $table)) !== null)
		{
			// we only return strings that can load in an editor
			if (is_string($value))
			{
				// try to update the value if required
				if ($update && ($updated_value = $this->update->value($value, $line)) !== null)
				{
					return $updated_value;
				}

				return $value;
			}

			return '// VALUE CAN NOT BE LOADED (AT THIS TIME) SINCE ITS NOT A STRING';
		}

		return null;
	}

	/**
	 * Set the value of a field in a row and table
	 *
	 * @param   mixed        $value    The field value
	 * @param   int          $id       The item ID
	 * @param   string       $field    The field key
	 * @param   string|null  $table    The table
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function setValue($value, int $id, string $field, ?string $table = null): bool
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		return $this->set->value($value, $id, $field, $table);
	}

	/**
	 * Return Table Ready Search Results
	 *
	 * @param string|null    $table           The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function table(?string $table = null): ?array
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if(($values = $this->find($table)) !== null)
		{
			$table_rows = [];

			// set the return value
			$this->return = urlencode(base64_encode('index.php?option=com_componentbuilder&view=search'));

			// set the markers
			$this->marker = [$this->config->marker_start,  $this->config->marker_end];
			$this->markerHtml = ['<span class="found_code">','</span>'];

			foreach ($values as $id => $fields)
			{
				foreach ($fields as $field => $lines)
				{
					foreach ($lines as $line => $code)
					{
						$table_rows[] = $this->getRow($code, $table, $field, $id, $line);
					}
				}
			}
			return $table_rows;
		}
		return null;
	}

	/**
	 * Search the posted table for the search value and return all
	 *
	 * @param string|null     $table    The table being searched
	 *
	 * @return  array|null
	 * @since 3.2.0
	 */
	public function find(?string $table = null): ?array
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		$set = 1;

		// continue loading items until all are searched
		while(($items = $this->get->items($table, $set)) !== null)
		{
			$this->find->items($items, $table);
			$set++;
		}

		return $this->search->get($table);
	}

	/**
	 * Search the posted table for the search value, and replace all
	 *
	 * @param string|null     $table    The table being searched
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function replace(?string $table = null)
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		$set = 1;

		// continue loading items until all was loaded
		while(($items = $this->get->items($table, $set)) !== null)
		{
			// search for items
			$this->find->items($items, $table);

			// update those found
			$this->replace->items($this->find->get($table), $table);

			// update the database
			$this->set->items($this->replace->get($table), $table);

			// reset found items
			$this->find->reset($table);
			$this->replace->reset($table);

			$set++;
		}
	}

	/**
	 * Return prepared code string for table
	 *
	 * @param   string       $code     The code value fro the table
	 * @param   string|null  $table    The table
	 * @param   string       $field    The field key
	 * @param   int          $id       The the row id
	 * @param   mixed        $line     The code line where found
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	protected function getRow(string $code, string $table, string $field, int $id, $line): array
	{
		return [
			'edit' => $this->getRowEditButton($table, $field, $id, $line),
			'code' => $this->getRowCode($code),
			'table' => $table,
			'field' => $field,
			'id' => $id,
			'line' => $line
		];
	}

	/**
	 * Return prepared code string for table
	 *
	 * @param   string       $code     The code value fro the table
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getRowCode(string $code): string
	{
		return str_replace($this->marker, $this->markerHtml, htmlentities($code));
	}

	/**
	 * Get the Item button to edit an item
	 *
	 * @param   string|null  $view     The single view
	 * @param   string       $field    The field key
	 * @param   int          $id       The the row id
	 * @param   mixed        $line     The code line where found
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function getRowEditButton(string $view, string $field, int $id, $line): string
	{
		// get list view
		$views = $this->table->get($view, $field, 'list');

		// return edit link	
		return '<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder&view=' . 
			$views . '&task=' . 
			$view . '.edit&id=' .
			$id . '&return=' .
			$this->return . '" title="' .
			Text::_('COM_COMPONENTBUILDER_EDIT') . '" ><span class="icon-edit"></span></a>';
	}

}

