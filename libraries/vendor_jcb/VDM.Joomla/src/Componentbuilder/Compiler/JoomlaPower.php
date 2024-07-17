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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\JoomlaPower\Remote\Get as SuperPower;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PowerInterface;


/**
 * Joomla Power
 * 
 * @since 3.2.1
 */
final class JoomlaPower implements PowerInterface
{
	/**
	 * All loaded powers
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	public array $active = [];

	/**
	 * All power namespaces
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	public array $namespace = [];

	/**
	 * All super powers of this build
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	public array $superpowers = [];

	/**
	 * Old super powers found in the local repos
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	public array $old_superpowers = [];

	/**
	 * The url to the power, if there is an error.
	 *
	 * @var   string
	 * @since 3.2.1
	 **/
	protected string $fixUrl;

	/**
	 * The state of all loaded powers
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	protected array $state = [];

	/**
	 * The state of retry to loaded powers
	 *
	 * @var    array
	 * @since 3.2.1
	 **/
	protected array $retry = [];

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.1
	 **/
	protected Config $config;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.1
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.1
	 **/
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.1
	 **/
	protected Gui $gui;

	/**
	 * The JCB Superpower class
	 *
	 * @var    Superpower
	 * @since 3.2.1
	 **/
	protected Superpower $superpower;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.1
	 **/
	protected $db;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.1
	 **/
	protected $app;

	/**
	 * Constructor.
	 *
	 * @param Config             $config       The compiler config object.
	 * @param Placeholder        $placeholder  The compiler placeholder object.
	 * @param Customcode         $customcode   The compiler customcode object.
	 * @param Gui                $gui          The compiler customcode gui object.
	 * @param Superpower         $superpower   The JCB superpower object.
	 *
	 * @throws \Exception
	 * @since 3.2.1
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		Customcode $customcode, Gui $gui, Superpower $superpower)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->customcode = $customcode;
		$this->gui = $gui;
		$this->superpower = $superpower;
		$this->db = Factory::getDbo();
		$this->app = Factory::getApplication();
	}

	/**
	 * load all the powers linked to this component
	 *
	 * @param array   $guids    The global unique ids of the linked powers
	 *
	 * @return void
	 * @since 3.2.1
	 */
	public function load(array $guids)
	{
		if (ArrayHelper::check($guids))
		{
			foreach ($guids as $guid => $build)
			{
				$this->get($guid, $build);
			}
		}
	}

	/**
	 * Get a power
	 *
	 * @param string    $guid    The global unique id of the power
	 * @param int       $build   Force build switch (to override global switch)
	 *
	 * @return object|null
	 * @since 3.2.1
	 */
	public function get(string $guid, int $build = 0): ?object
	{
		if (($this->config->get('add_power', true) || $build == 1) && $this->set($guid))
		{
			return $this->active[$guid];
		}

		return null;
	}

	/**
	 * Set a Joomla power
	 *
	 * @param string $guid The global unique id of the power
	 *
	 * @return bool true on successful setting of a power
	 * @since 3.2.1
	 */
	private function set(string $guid): bool
	{
		// Check if power is already set
		if ($this->isPowerSet($guid))
		{
			return $this->state[$guid];
		}

		// Validate GUID
		if (!$this->isGuidValid($guid))
		{
			$this->state[$guid] = false;
			return false;
		}

		// Get the power data
		$this->active[$guid] = $this->getPowerData($guid);

		// Validate power data object
		if ($this->active[$guid] ===  null)
		{
			return $this->handlePowerNotFound($guid);
		}

		// Prevent recursive loading of the same power
		$this->state[$guid] = true;

		// Convert settings to array if valid JSON
		$settings = $this->convertSettingsToArray(
			$this->active[$guid]->settings
		);

		// Set the target version if settings array is valid
		if (!$this->setTargetVersion($guid, $settings))
		{
			return false;
		}

		// Set class name and namespace
		$this->setClassAndNamespace($guid);

		return true;
	}

	/**
	 * Convert settings JSON string to array
	 *
	 * @param string $settingsJson
	 *
	 * @return array|null
	 * @since 3.2.2
	 */
	private function convertSettingsToArray(string $settingsJson): ?array
	{
		if (JsonHelper::check($settingsJson))
		{
			return json_decode($settingsJson, true);
		}

		return null;
	}

	/**
	 * Set the target version based on Joomla version and settings
	 *
	 * @param string $guid
	 * @param array|null $settings
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	private function setTargetVersion(string $guid, ?array $settings): bool
	{
		$joomla_version = $this->config->joomla_version;

		if (!$joomla_version || !ArrayHelper::check($settings))
		{
			return false;
		}

		$joomla_version_target = null;
		$target_found = false;

		foreach ($settings as $namespace)
		{
			// Set default values for all versions
			if ($namespace['joomla_version'] == 0)
			{
				$this->setNamespaceAndType($guid, $namespace);
				$target_found = true;
			}

			// Check for direct target version
			if ($joomla_version == $namespace['joomla_version'])
			{
				$joomla_version_target = $namespace;
				break;
			}
		}

		if ($joomla_version_target)
		{
			$this->setNamespaceAndType($guid, $joomla_version_target);
			$target_found = true;
		}

		if (!$target_found)
		{
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PJOOMLA_POWER_BGUIDSB_WAS_FOUND_BUT_MISSING_A_NAMESPACE_VALUE_FOR_JOOMLA_SP', $guid, $joomla_version),
				'Error'
			);

			$this->state[$guid] = false;

			return false;
		}

		return true;
	}

	/**
	 * Set namespace and type for the active power
	 *
	 * @param string $guid
	 * @param array $namespace
	 *
	 * @since 3.2.2
	 */
	private function setNamespaceAndType(string $guid, array $namespace): void
	{
		$this->active[$guid]->namespace = $namespace['namespace'];
		$this->active[$guid]->type = $namespace['type'] ?? 'class';
	}

	/**
	 * Set class name and namespace for the active power
	 *
	 * @param string $guid
	 *
	 * @since 3.2.2
	 */
	private function setClassAndNamespace(string $guid): void
	{
		$this->active[$guid]->class_name = $this->extractLastNameFromNamespace(
			$this->active[$guid]->namespace
		);

		$this->active[$guid]->_namespace = $this->removeLastNameFromNamespace(
			$this->active[$guid]->namespace
		);
	}

	/**
	 * Handle power not found scenario
	 *
	 * @param string $guid
	 *
	 * @return bool
	 * @since 3.2.2
	 */
	private function handlePowerNotFound(string $guid): bool
	{
		if (empty($this->retry[$guid]) && $this->superpower->item($guid, ['remote', 'local']))
		{
			// Retry loading the power
			unset($this->state[$guid]);
			unset($this->active[$guid]);

			$this->retry[$guid] = true;

			return $this->set($guid);
		}

		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_PJOOMLA_POWER_BGUIDSB_NOT_FOUNDP', $guid),
			'Error'
		);

		$this->state[$guid] = false;

		return false;
	}

	/**
	 * Extracts the last part of a namespace string, which is typically the class name.
	 *
	 * @param string $namespace  The namespace string to extract from.
	 *
	 * @return string|null The extracted class name.
	 * @since 3.2.1
	 */
	private function extractLastNameFromNamespace(string $namespace): ?string
	{
		$parts = explode('\\', $namespace);
		$result = end($parts);

		// Remove '\\' from the beginning and end of the resulting string
		$result = trim($result, '\\');

		// If the resulting string is empty, return null
		return empty($result) ? null : $result;
	}

	/**
	 * Removes the last name from the namespace.
	 *
	 * @param string $namespace The namespace
	 *
	 * @return string The namespace shortened
	 * @since 3.2.1
	 */
	private function removeLastNameFromNamespace(string $namespace): string
	{
		// Remove '\\' from the beginning and end of the resulting string
		$namespace = trim($namespace, '\\');

		$parts = explode('\\', $namespace);

		// Remove the last part (the class name)
		array_pop($parts);

		// Reassemble the namespace without the class name
		return implode('\\', $parts);
	}

	/**
	 * Check if the power is already set
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return bool true if the power is already set
	 * @since 3.2.1
	 */
	private function isPowerSet(string $guid): bool
	{
		return isset($this->state[$guid]);
	}

	/**
	 * Validate the GUID
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return bool true if the GUID is valid
	 * @since 3.2.1
	 */
	private function isGuidValid(string $guid): bool
	{
		return GuidHelper::valid($guid);
	}

	/**
	 * Get the power data from the database
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return object|null The power data
	 * @since 3.2.1
	 */
	private function getPowerData(string $guid): ?object
	{
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_joomla_power AS a');
		$query->where($this->db->quoteName('a.guid') . ' = ' . $this->db->quote($guid));

		$this->db->setQuery($query);
		$this->db->execute();

		if ($this->db->getNumRows())
		{
			return $this->db->loadObject();
		}

		return null;
	}

	/**
	 * Get Clean Namespace without use or ; as part of the name space
	 *
	 * @param string  $namespace        The actual name space
	 * @param bool    $removeNumbers    The switch to remove numbers
	 *
	 * @return string
	 * @since 3.2.1
	 */
	private function getCleanNamespace(string $namespace): string
	{
		// trim possible (use) or (;) or (starting or ending \) added to the namespace
		return NamespaceHelper::safe(str_replace(['use ', ';'], '', $namespace));
	}

	/**
	 * Get [use Namespace\Class;]
	 *
	 * @param string  $namespace  The actual name space
	 * @param string   $as                The use as name (default is none)
	 *
	 * @return string
	 * @since 3.2.1
	 */
	private function getUseNamespace(string $namespace, string $as = 'default'): string
	{
		// check if it has an AS option
		if ($as !== 'default')
		{
			 return 'use ' . $namespace . ' as ' . $as . ';';
		}
		return 'use ' . $namespace . ';';
	}

	/**
	 * Set the super powers of this power
	 *
	 * @param string  $guid   The global unique id of the power
	 *
	 * @return void
	 * @since 3.2.1
	 */
	private function setSuperPowers(string $guid): void
	{
		// soon
	}
}

