<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Extension;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UpdateMysql;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HistoryInterface as History;
use VDM\Joomla\Interfaces\Data\ItemInterface as Item;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Extension Version Update Class.
 * 
 * Builds the component's version-update output: the update-server XML
 * entries, the changelog server manifest values, the per-version SQL
 * update files, and, when dynamic SQL updates exist, the persisted
 * component version and version-update rows.
 * 
 * @since  6.1.7
 */
final class VersionUpdate
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The UpdateMysql Class.
	 *
	 * @var   UpdateMysql
	 * @since 6.1.7
	 */
	protected UpdateMysql $updatemysql;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The Item Class.
	 *
	 * @var   Item
	 * @since 6.1.7
	 */
	protected Item $item;

	/**
	 * The History Class.
	 *
	 * @var   History
	 * @since 6.1.7
	 */
	protected History $history;

	/**
	 * The last update URL discovered for the active component version.
	 *
	 * @var   string|null
	 * @since 6.1.7
	 */
	protected ?string $lastUpdateUrl = null;

	/**
	 * Constructor.
	 *
	 * @param Config        $config         The Config Class.
	 * @param Component     $component      The Component Class.
	 * @param Placeholder   $placeholder    The Placeholder Class.
	 * @param ContentOne    $contentone     The ContentOne Class.
	 * @param ContentMulti  $contentmulti   The ContentMulti Class.
	 * @param UpdateMysql   $updatemysql    The UpdateMysql Class.
	 * @param Structure     $structure      The Structure Class.
	 * @param Item          $item           The Item Class.
	 * @param History       $history        The History Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Component $component,
		Placeholder $placeholder, ContentOne $contentone,
		ContentMulti $contentmulti, UpdateMysql $updatemysql,
		Structure $structure, Item $item, History $history)
	{
		$this->config = $config;
		$this->component = $component;
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
		$this->updatemysql = $updatemysql;
		$this->structure = $structure;
		$this->item = $item;
		$this->history = $history;
	}

	/**
	 * Get the last update URL discovered for the active component version.
	 *
	 * @return  string|null  The last update URL, or null when none was found.
	 *
	 * @since   6.1.7
	 */
	public function getLastUpdateUrl(): ?string
	{
		return $this->lastUpdateUrl;
	}

	/**
	 * Set the last update URL used for dynamic update URL projection.
	 *
	 * @param   string|null  $url  The last update URL, or null to clear it.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setLastUpdateUrl(?string $url): void
	{
		$this->lastUpdateUrl = $url;
	}

	/**
	 * Set the complete version-update output of the component.
	 *
	 * Builds the update XML entries and SQL update files for every stored
	 * version update, appends the dynamic SQL update entries when active,
	 * writes the update/changelog server manifest values, and persists the
	 * updated component version rows when dynamic SQL updates were added.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(): void
	{
		if ($this->component->isArray('version_update')
			|| $this->updatemysql->isActive())
		{
			$updateXML = [];
			// add the update server
			if ($this->component->get('update_server_target', 3) != 3)
			{
				$updateXML[] = '<?xml version="1.0" encoding="utf-8"?>';
				$updateXML[] = '<updates>';
			}

			// add the dynamic sql switch
			$addDynamicSQL = true;
			$addActive     = true;
			if ($this->component->isArray('version_update'))
			{
				$updates = $this->component->get('version_update');
				foreach ($updates as $nr => &$update)
				{
					$this->setUpdateXmlSql($update, $updateXML, $addDynamicSQL);

					if ($update['version']
						== $this->component->get('component_version'))
					{
						$addActive = false;
					}
				}
				$this->component->set('version_update', $updates);
			}
			// add the dynamic sql if not already added
			if ($addDynamicSQL
				&& $this->updatemysql->isActive())
			{
				// add the dynamic sql
				$this->setDynamicUpdateXmlSql($updateXML);
			}
			// add the new active version if needed
			if ($addActive && $this->updatemysql->isActive())
			{
				// add the dynamic sql
				$this->setDynamicUpdateXmlSql($updateXML, $addActive);
			}
			// add the update server file
			if ($this->component->get('update_server_target', 3) != 3)
			{
				$updateXML[] = '</updates>';
				// UPDATE_SERVER_XML
				$name = $this->component->get('update_server_file_name');
				$target = array('admin' => $name);
				$this->structure->build($target, 'update_server');
				$this->contentmulti->set($name . '|UPDATE_SERVER_XML', implode(PHP_EOL, $updateXML));
			}
		}

		// add the update server link to component XML
		if ($this->component->get('add_update_server')
			&& $this->component->isString('update_server_url'))
		{
			// UPDATESERVER
			$updateServer   = [];
			$updateServer[] = PHP_EOL . Indent::_(1) . "<updateservers>";
			$updateServer[] = Indent::_(2)
				. '<server type="extension" enabled="1" element="com_'
				. $this->config->component_code_name . '" name="'
				. $this->contentone->get('Component_name') . '">' . $this->component->get('update_server_url')
				. '</server>';
			$updateServer[] = Indent::_(1) . '</updateservers>';
			// return the array to string
			$updateServer = implode(PHP_EOL, $updateServer);
			// add update server details to component XML file
			$this->contentone->set('UPDATESERVER', $updateServer);
		}
		else
		{
			// add update server details to component XML file
			$this->contentone->set('UPDATESERVER', '');
		}

		// add the changelog server to component XML
		if ($this->component->get('add_changelog_server')
			&& $this->component->isString('changelog_server_url'))
		{
			// CHANGELOGSERVER
			$changelogServer = PHP_EOL . Indent::_(1) . "<changelogurl>" . $this->component->get('changelog_server_url')
				. "</changelogurl>";
			// add changelog server to component XML file
			$this->contentone->set('CHANGELOGSERVER', $changelogServer);

			// CHANGELOG_SERVER_XML
			$name = $this->component->get('changelog_server_file_name');
			$target = array('admin' => $name);
			$this->structure->build($target, 'changelog_server');
			$this->contentmulti->set($name . '|CHANGELOG_SERVER_XML',
				$this->component->get('changelogxml', '<changelogs></changelogs>')
			);
		}
		else
		{
			// add update server details to component XML file
			$this->contentone->set('CHANGELOGSERVER', '');
		}

		// ensure to update Component version data
		if ($this->updatemysql->isActive())
		{
			$buket = [];
			$nr    = 0;
			foreach ($this->component->get('version_update') as $values)
			{
				$buket['version_update' . $nr] = $values;
				$nr++;
			}
			// update the joomla component table
			$newJ       = [];
			$newJ['id'] = (int) $this->config->component_id;
			$newJ['component_version']
				= $this->component->get('component_version');
			// update the component with the new dynamic SQL
			$this->item->table('joomla_component')->set((object) $newJ, 'id'); // <-- to insure the history is also updated
			// reset the watch here
			$this->history->get('joomla_component', $this->config->component_id);

			// update the component update table
			$newU = [];
			if ($this->component->get('version_update_id', 0)  > 0)
			{
				$newU['id'] = (int) $this->component->get('version_update_id', 0);
				$key = 'id';
			}
			else
			{
				$newU['joomla_component'] = (string) $this->config->component_guid;
				$key = 'guid';
			}
			$newU['version_update'] = $buket;
			// update the component with the new dynamic SQL
			$this->item->table('component_updates')->set((object) $newU, $key); // <-- to insure the history is also updated
		}
	}

	/**
	 * Set the dynamic update XML and SQL entry.
	 *
	 * Builds one version-update entry from the active dynamic SQL state
	 * and appends it to the component's stored version updates. When
	 * `$currentVersion` is true the entry represents the new active
	 * component version rather than the previous one.
	 *
	 * @param   array  $updateXML       The update XML lines (mutated by reference).
	 * @param   bool   $currentVersion  Build the entry for the current component version.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setDynamicUpdateXmlSql(array &$updateXML, bool $currentVersion = false): void
	{
		// start building the update
		$update_ = [];
		if ($currentVersion)
		{
			// setup new version
			$update_['version'] = $this->component->get('component_version');
			// setup SQL
			$update_['mysql'] = '';
			// setup URL
			$update_['url'] = 'http://domain.com/demo.zip';
		}
		else
		{
			// setup new version
			$update_['version'] = $this->component->get('old_component_version');
			// setup SQL
			$update_['mysql'] = trim(
				implode(PHP_EOL . PHP_EOL, $this->updatemysql->allActive())
			);
			// setup URL
			if ($this->lastUpdateUrl !== null)
			{
				$placeholders   = array(
					$this->component->get('component_version') => $this->component->get('old_component_version'),
					str_replace(
						'.', '-', (string) $this->component->get('component_version')
					)                                       => str_replace(
						'.', '-', (string) $this->component->get('old_component_version')
					),
					str_replace(
						'.', '_', (string) $this->component->get('component_version')
					)                                       => str_replace(
						'.', '_', (string) $this->component->get('old_component_version')
					),
					str_replace(
						'.', '', (string) $this->component->get('component_version')
					)                                       => str_replace(
						'.', '', (string) $this->component->get('old_component_version')
					)
				);
				$update_['url'] = $this->placeholder->update(
					$this->lastUpdateUrl, $placeholders
				);
			}
			else
			{
				// setup URL
				$update_['url'] = 'http://domain.com/demo.zip';
			}
		}
		// stop it from being added double
		$addDynamicSQL = false;
		// add dynamic SQL
		$this->setUpdateXmlSql($update_, $updateXML, $addDynamicSQL);

		$this->component->appendArray('version_update', $update_);
	}

	/**
	 * Set one version-update XML and SQL entry.
	 *
	 * Normalizes the version, updates SQL placeholders, merges the active
	 * dynamic SQL into the entry that matches the previous component
	 * version, builds the SQL update file for historic versions, records
	 * the last update URL for the active version, and appends the
	 * update-server XML block when the update server is enabled.
	 *
	 * @param   array  $update         The version-update entry (mutated by reference).
	 * @param   array  $updateXML      The update XML lines (mutated by reference).
	 * @param   bool   $addDynamicSQL  Whether the dynamic SQL must still be merged (mutated by reference).
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function setUpdateXmlSql(array &$update, array &$updateXML, bool &$addDynamicSQL): void
	{
		// ensure version naming is correct
		$update['version'] = preg_replace('/^v/i', '', (string) $update['version']);
		// setup SQL
		if (StringHelper::check($update['mysql']))
		{
			$update['mysql'] = $this->placeholder->update_(
				$update['mysql']
			);
		}
		// add dynamic SQL
		if ($addDynamicSQL
			&& $this->updatemysql->isActive()
			&& $this->component->get('old_component_version') == $update['version'])
		{
			$searchMySQL = preg_replace('/\s+/', '', (string) $update['mysql']);
			// add the updates to the SQL only if not found
			foreach ($this->updatemysql->allActive() as $search => $query)
			{
				if (strpos($searchMySQL, $search) === false)
				{
					$update['mysql'] .= PHP_EOL . PHP_EOL . $query;
				}
			}
			// make sure no unneeded white space is added
			$update['mysql'] = trim((string) $update['mysql']);
			// update has been added
			$addDynamicSQL = false;
		}
		// setup import files
		if ($update['version'] != $this->component->get('component_version'))
		{
			$name   = StringHelper::safe($update['version']);
			$target = ['admin' => $name];
			$_name = preg_replace('/[\.]+/', '_', (string) $update['version']);
			$this->structure->build($target, 'sql_update', $_name);
			$this->contentmulti->set($name . '_' . $_name . '|UPDATE_VERSION_MYSQL',
				$update['mysql']
			);
		}
		elseif (isset($update['url'])
			&& StringHelper::check(
				$update['url']
			))
		{
			$this->lastUpdateUrl = $update['url'];
		}
		// add the update server
		if ($this->component->get('add_update_server', 3) != 3)
		{
			// we set the defaults
			$u_element = 'com_' . $this->config->component_code_name;
			$u_server_type = 'component';
			$u_state = 'stable';
			$u_target_version = '5.*';
			$u_client = null;
			// check if we have advance options set
			if (isset($update['update_server_adv']) && $update['update_server_adv'])
			{
				$u_element = (isset($update['update_element']) && strlen((string) $update['update_element']) > 0)
					? $update['update_element'] : $u_element;
				$u_server_type = (isset($update['update_server_type']) && strlen((string) $update['update_server_type']) > 0)
					? $update['update_server_type'] : $u_server_type;
				$u_state = (isset($update['update_state']) && strlen((string) $update['update_state']) > 0)
					? $update['update_state'] : $u_state;
				$u_target_version = (isset($update['update_target_version']) && strlen((string) $update['update_target_version']) > 0)
					? $update['update_target_version'] : $u_target_version;
				$u_client = (isset($update['update_client']) && strlen((string) $update['update_client']) > 0)
					? $update['update_client'] : $u_client;
			}
			// build update xml
			$updateXML[] = Indent::_(1) . "<update>";
			$updateXML[] = Indent::_(2) . "<name>"
				. $this->contentone->get('Component_name') . "</name>";
			$updateXML[] = Indent::_(2) . "<description>"
				. $this->contentone->get('SHORT_DESCRIPTION') . "</description>";
			$updateXML[] = Indent::_(2) . "<element>$u_element</element>";
			$updateXML[] = Indent::_(2) . "<type>$u_server_type</type>";
			// check if we should add the target client value
			if ($u_client)
			{
				$updateXML[] = Indent::_(2) . "<client>$u_client</client>";
			}
			$updateXML[] = Indent::_(2) . "<version>" . $update['version']
				. "</version>";
			$updateXML[] = Indent::_(2) . '<infourl title="'
				. $this->contentone->get('Component_name') . '!">' . $this->contentone->get('AUTHORWEBSITE') . '</infourl>';
			$updateXML[] = Indent::_(2) . "<downloads>";
			if (!isset($update['url'])
				|| !StringHelper::check(
					$update['url']
				))
			{
				$update['url'] = 'http://domain.com/demo.zip';
			}
			$updateXML[] = Indent::_(3)
				. '<downloadurl type="full" format="zip">' . $update['url']
				. '</downloadurl>';
			$updateXML[] = Indent::_(2) . "</downloads>";
			$updateXML[] = Indent::_(2) . "<tags>";
			$updateXML[] = Indent::_(3) . "<tag>$u_state</tag>";
			$updateXML[] = Indent::_(2) . "</tags>";
			$updateXML[] = Indent::_(2) . "<maintainer>"
				. $this->contentone->get('AUTHOR')
				. "</maintainer>";
			$updateXML[] = Indent::_(2) . "<maintainerurl>"
				. $this->contentone->get('AUTHORWEBSITE') . "</maintainerurl>";
			$updateXML[] = Indent::_(2)
				. '<targetplatform name="joomla" version="' . $u_target_version . '"/>';
			$updateXML[] = Indent::_(1) . "</update>";
		}
	}
}

