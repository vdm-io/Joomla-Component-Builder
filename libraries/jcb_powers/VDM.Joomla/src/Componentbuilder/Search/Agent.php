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

namespace VDM\Joomla\Componentbuilder\Search;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Search\Factory;
use VDM\Joomla\Componentbuilder\Search\Config;
use VDM\Joomla\Componentbuilder\Search\Database\Load;
use VDM\Joomla\Componentbuilder\Search\Database\Insert;
use VDM\Joomla\Componentbuilder\Search\Agent\Find;
use VDM\Joomla\Componentbuilder\Search\Agent\Replace;
use VDM\Joomla\Componentbuilder\Search\Agent\Search;
use VDM\Joomla\Componentbuilder\Search\Agent\Update;
use VDM\Joomla\Componentbuilder\Table;


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
	 * Search Load Database
	 *
	 * @var    Load
	 * @since 3.2.0
	 */
	protected Load $load;

	/**
	 * Search Insert Database
	 *
	 * @var    Insert
	 * @since 3.2.0
	 */
	protected Insert $insert;

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
	 * @param Load|null         $load           The search load database object.
	 * @param Insert|null         $insert           The search insert database object.
	 * @param Find|null        $find          The search find object.
	 * @param Replace|null     $replace       The search replace object.
	 * @param Search|null      $search        The search object.
	 * @param Update|null      $update        The update object.
	 * @param Table|null       $table         The table object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Load $load = null,
		?Insert $insert = null, ?Find $find = null, ?Replace $replace = null,
		?Search $search = null, ?Update $update = null, ?Table $table = null)
	{
		$this->config = $config ?: Factory::_('Config');
		$this->load = $load ?: Factory::_('Load.Database');
		$this->insert = $insert ?: Factory::_('Insert.Database');
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
	 * @return  string|null
	 * @since 3.2.0
	 */
	public function getValue(int $id, string $field, $line = null,
		?string $table = null, bool $update = false): ?string
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		if (($value = $this->load->value($id, $field, $table)) !== null)
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

		return $this->insert->value($value, $id, $field, $table);
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
			// build return value
			$this->setReturnValue();

			// set the markers
			$this->setMarkers();

			// start table bucket
			$table_rows = [];

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
		while(($items = $this->load->items($table, $set)) !== null)
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
	 * @return  int
	 * @since 3.2.0
	 */
	public function replace(?string $table = null): int
	{
		// set the table name
		if (empty($table))
		{
			$table = $this->config->table_name;
		}

		$set = 1;
		$replaced = 0;

		// continue loading items until all was loaded
		while(($items = $this->load->items($table, $set)) !== null)
		{
			// search for items
			$this->find->items($items, $table);

			// update those found
			$this->replace->items($this->find->get($table), $table);

			// update the database
			if ($this->insert->items($this->replace->get($table), $table))
			{
				$replaced++;
			}

			// reset found items
			$this->find->reset($table);
			$this->replace->reset($table);

			$set++;
		}

		// we return the number of times we replaced
		return $replaced;
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
		$tab = $this->table->get($view, $field, 'tab_name');

		// return edit link	
		return '<a class="hasTooltip btn btn-mini" href="index.php?option=com_componentbuilder' .
			'&view=' . $views .
			'&task=' . $view . '.edit' .
			'&id=' . $id .
			'&open_tab=' . $tab .
			'&open_field=' . $field .
			'&return=' . $this->return . '" title="' .
			Text::sprintf('COM_COMPONENTBUILDER_EDIT_S_S_DIRECTLY', $view, $field) . '." ><span class="icon-edit"></span></a>';
	}

	/**
	 * Set the return value for this search
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setReturnValue()
	{
		// set the return value so the search auto load on return
		$this->return = urlencode(base64_encode('index.php?option=com_componentbuilder&view=search' . 
			'&type_search=' . (int) $this->config->type_search .
			'&match_case=' . (int) $this->config->match_case .
			'&whole_word=' . (int) $this->config->whole_word .
			'&regex_search=' . (int) $this->config->regex_search .
			'&search_value=' . (string) urlencode((string) $this->config->search_value) .
			'&replace_value=' . (string) urlencode((string) $this->config->replace_value)));
	}

	/**
	 * Set the markers of the found code
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setMarkers()
	{
		// set the markers
		$this->marker = [$this->config->marker_start,  $this->config->marker_end];
		$this->markerHtml = ['<span class="found_code">','</span>'];
	}

}

