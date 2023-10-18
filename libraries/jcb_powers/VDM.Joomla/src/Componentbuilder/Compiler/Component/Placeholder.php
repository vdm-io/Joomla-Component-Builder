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

namespace VDM\Joomla\Componentbuilder\Compiler\Component;


use Joomla\CMS\Factory;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Component\PlaceholderInterface;


/**
 * Get a Components Global Placeholders
 * 
 * @since 3.2.0
 */
final class Placeholder implements PlaceholderInterface
{
	/**
	 * Placeholders
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected $placeholders = null;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected $config;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Constructor.
	 *
	 * @param   Config                $config    The compiler config object.
	 * @param   \JDatabaseDriver      $db        The Database Driver object.
	 *
	 * @since 3.2.0
	 **/
	public function __construct(?Config $config = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * get all System Placeholders
	 *
	 * @return  array   The global placeholders
	 *
	 * @since 3.2.0
	 */
	public function get(): array
	{
		// set only once
		if (is_array($this->placeholders))
		{
			return $this->placeholders;
		}

		// load the config
		$config = $this->config;
		// load the db
		$db = $this->db;
		// reset bucket
		$bucket = [];
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.target', 'a.value')));
		// from these tables
		$query->from('#__componentbuilder_placeholder AS a');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the items
		$db->execute();
		if ($db->getNumRows())
		{
			$bucket = $db->loadAssocList('target', 'value');
			// open all the code
			foreach ($bucket as $key => &$code)
			{
				$code = base64_decode((string) $code);
			}
		}

		// set component place holders
		$bucket[Placefix::_h('component')] = $config->component_code_name;
		$bucket[Placefix::_h('Component')] = StringHelper::safe($config->component_code_name, 'F');
		$bucket[Placefix::_h('COMPONENT')] = StringHelper::safe($config->component_code_name, 'U');
		$bucket[Placefix::_('component')]   = $bucket[Placefix::_h('component')];
		$bucket[Placefix::_('Component')]   = $bucket[Placefix::_h('Component')];
		$bucket[Placefix::_('COMPONENT')]   = $bucket[Placefix::_h('COMPONENT')];
		$bucket[Placefix::_h('LANG_PREFIX')] = $config->lang_prefix;
		$bucket[Placefix::_('LANG_PREFIX')] = $bucket[Placefix::_h('LANG_PREFIX')];

		// get the current components overrides
		if (($_placeholders = GetHelper::var(
				'component_placeholders', $config->component_id,
				'joomla_component', 'addplaceholders'
			)) !== false
			&& JsonHelper::check($_placeholders))
		{
			$_placeholders = json_decode((string) $_placeholders, true);
			if (ArrayHelper::check($_placeholders))
			{
				foreach ($_placeholders as $row)
				{
					$bucket[$row['target']] = $row['value'];
				}
			}
		}

		$this->placeholders = $bucket;

		return $bucket;
	}
}

