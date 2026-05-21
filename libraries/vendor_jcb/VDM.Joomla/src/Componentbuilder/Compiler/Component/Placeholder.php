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


use Joomla\Database\DatabaseInterface;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
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
	 * @var   ?array
	 * @since 3.2.0
	 */
	protected ?array $placeholders = null;

	/**
	 * Compiler Config
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * Joomla Database Class.
	 *
	 * @var   DatabaseInterface
	 * @since 5.1.2
	 */
	protected DatabaseInterface $db;

	/**
	 * Constructor.
	 *
	 * @param  Config             $config  The compiler config object.
	 * @param  DatabaseInterface  $db      The Joomla Database Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, DatabaseInterface $db)
	{
		$this->config = $config;
		$this->db = $db;
	}

	/**
	 * Get all system placeholders.
	 *
	 * @return  array  The global placeholders.
	 * @since   3.2.0
	 */
	public function get(): array
	{
		if ($this->placeholders !== null)
		{
			return $this->placeholders;
		}

		$this->placeholders = [];

		$this->loadStoredPlaceholders();
		$this->addCorePlaceholders();
		$this->applyComponentOverrides();

		return $this->placeholders;
	}

	/**
	 * Load stored placeholders from the database.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function loadStoredPlaceholders(): void
	{
		$query = $this->db->getQuery(true);
		$query->select(
			$this->db->quoteName(['a.target', 'a.value'])
		);
		$query->from(
			$this->db->quoteName('#__componentbuilder_placeholder', 'a')
		);

		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getNumRows())
		{
			return;
		}

		$placeholders = $this->db->loadAssocList('target', 'value');

		foreach ($placeholders as $target => $value)
		{
			$target = $this->sanitize((string) $target);
			$value = base64_decode((string) $value);

			$this->setPlaceholders($target, $value);
		}
	}

	/**
	 * Add the core component placeholders.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function addCorePlaceholders(): void
	{
		$component = $this->config->component_code_name;
		$componentSafe = StringHelper::safe($component, 'F');
		$componentUpper = StringHelper::safe($component, 'U');
		$componentNamespace = NamespaceHelper::safeSegment($componentSafe);
		$langPrefix = $this->config->lang_prefix;
		$namespacePrefix = $this->config->namespace_prefix;
		$powerLoaderPath = $this->config->component_autoloader_path;

		$this->setPlaceholders('component', $component);
		$this->setPlaceholders('Component', $componentSafe);
		$this->setPlaceholders('COMPONENT', $componentUpper);
		$this->setPlaceholders('LANG_PREFIX', $langPrefix);
		$this->setPlaceholders('ComponentNamespace', $componentNamespace);
		$this->setPlaceholders('NamespacePrefix', $namespacePrefix);
		$this->setPlaceholders('NAMESPACEPREFIX', $namespacePrefix);
		$this->setPlaceholders('POWERLOADERPATH', $powerLoaderPath);
	}

	/**
	 * Apply component-specific placeholder overrides.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function applyComponentOverrides(): void
	{
		$query = $this->db->getQuery(true);
		$query->select(
			$this->db->quoteName('addplaceholders')
		);
		$query->from(
			$this->db->quoteName('#__componentbuilder_component_placeholders')
		);
		$query->where(
			$this->db->quoteName('joomla_component') . ' = ' . $this->db->quote($this->config->component_guid)
		);

		$this->db->setQuery($query);
		$this->db->execute();

		if (!$this->db->getNumRows())
		{
			return;
		}

		$placeholders = $this->db->loadResult();

		if ($placeholders === false || !JsonHelper::check($placeholders))
		{
			return;
		}

		$rows = json_decode((string) $placeholders, true);

		if (!ArrayHelper::check($rows))
		{
			return;
		}

		foreach ($rows as $row)
		{
			if (!isset($row['target'], $row['value']))
			{
				continue;
			}

			$target = $this->sanitize((string) $row['target']);

			// Yes update placeholder values in the placeholders :)
			$value = str_replace(
				array_keys($this->placeholders), 
				array_values($this->placeholders), 
				(string) $row['value']
			);

			$this->setPlaceholders($target, $value);
		}
	}

	/**
	 * Set both normal and hashed placeholder keys.
	 *
	 * @param   string  $target   The placeholder target.
	 * @param   string  $value    The placeholder value.
	 *
	 * @return  void
	 * @since   6.1.6
	 */
	protected function setPlaceholders(string $target, string $value): void
	{
		$this->placeholders[Placefix::_($target)] = $value;
		$this->placeholders[Placefix::_h($target)] = $value;
	}

	/**
	 * Sanitize the input string by removing supported wrapper patterns.
	 *
	 * The wrapper is only removed if both the prefix and suffix exist.
	 * Partial matches are ignored.
	 *
	 * @param   string  $value  The input string to sanitize.
	 *
	 * @return  string  The sanitized string.
	 * @since   6.1.6
	 */
	protected function sanitize(string $value): string
	{
		if (strlen($value) < 6)
		{
			return $value;
		}

		if ($this->isTripleSquareBracketWrapped($value))
		{
			return substr($value, 3, -3);
		}

		if ($this->isTripleHashWrapped($value))
		{
			return substr($value, 3, -3);
		}

		return $value;
	}

	/**
	 * Check whether the value is wrapped in triple square brackets.
	 *
	 * @param   string  $value  The input string.
	 *
	 * @return  bool
	 * @since   6.1.6
	 */
	protected function isTripleSquareBracketWrapped(string $value): bool
	{
		return str_starts_with($value, '['.'['.'[') && str_ends_with($value, ']'.']'.']');
	}

	/**
	 * Check whether the value is wrapped in triple hash symbols.
	 *
	 * @param   string  $value  The input string.
	 *
	 * @return  bool
	 * @since   6.1.6
	 */
	protected function isTripleHashWrapped(string $value): bool
	{
		return str_starts_with($value, '#'.'#'.'#') && str_ends_with($value, '#'.'#'.'#');
	}
}

