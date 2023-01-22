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

namespace VDM\Joomla\Componentbuilder\Compiler\Library;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Field\Data as FieldData;
use VDM\Joomla\Componentbuilder\Compiler\Model\Filesfolders;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Library Data Class
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
	 * Compiler Field Data
	 *
	 * @var    FieldData
	 * @since 3.2.0
	 */
	protected FieldData $field;

	/**
	 * Compiler Files Folders
	 *
	 * @var    Filesfolders
	 * @since 3.2.0
	 */
	protected Filesfolders $filesFolders;

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
	 * @param FieldData|null            $field            The compiler field data object.
	 * @param Filesfolders|null         $filesFolders     The compiler files folders object.
	 * @param \JDatabaseDriver|null     $db               The database object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Registry $registry = null,
		?Customcode $customcode = null, ?Gui $gui = null,
		?FieldData $field = null, ?Filesfolders $filesFolders = null,
		?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->registry = $registry ?: Compiler::_('Registry');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->field = $field ?: Compiler::_('Field.Data');
		$this->filesFolders = $filesFolders ?: Compiler::_('Model.Filesfolders');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Get Media Library Data and store globally in registry
	 *
	 * @param   int  $id  the library id
	 *
	 * @return  object|bool    object on success
	 * @since 3.2.0
	 */
	public function get(int $id)
	{
		// check if the lib has already been set
		if (!$this->registry->exists("builder.libraries.$id"))
		{
			// get some switches
			$uikit = $this->config->get('uikit', 0);
			$footable_version = $this->config->get('footable_version', 0);

			// make sure we should continue and that the lib is not already being loaded
			switch ($id)
			{
				case 1: // No Library
					return false;
					break;
				case 3: // Uikit v3
					if (2 == $uikit || 3 == $uikit)
					{
						// already being loaded
						$this->registry->set("builder.libraries.$id", false);
					}
					break;
				case 4: // Uikit v2
					if (2 == $uikit || 1 == $uikit)
					{
						// already being loaded
						$this->registry->set("builder.libraries.$id", false);
					}
					break;
				case 5: // FooTable v2
					if (2 == $footable_version)
					{
						// already being loaded
						$this->registry->set("builder.libraries.$id", false);
					}
					break;
				case 6: // FooTable v3
					if (3 == $footable_version)
					{
						// already being loaded
						$this->registry->set("builder.libraries.$id", false);
					}
					break;
			}
		}

		// check if the lib has already been set
		if (!$this->registry->exists("builder.libraries.$id"))
		{
			$query = $this->db->getQuery(true);

			$query->select('a.*');
			$query->select(
				$this->db->quoteName(
					array(
						'a.id',
						'a.name',
						'a.how',
						'a.type',
						'a.addconditions',
						'b.addconfig',
						'c.addfiles',
						'c.addfolders',
						'c.addfilesfullpath',
						'c.addfoldersfullpath',
						'c.addurls',
						'a.php_setdocument'
					), array(
						'id',
						'name',
						'how',
						'type',
						'addconditions',
						'addconfig',
						'addfiles',
						'addfolders',
						'addfilesfullpath',
						'addfoldersfullpath',
						'addurls',
						'php_setdocument'
					)
				)
			);

			// from these tables
			$query->from('#__componentbuilder_library AS a');
			$query->join(
				'LEFT',
				$this->db->quoteName('#__componentbuilder_library_config', 'b')
				. ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('b.library') . ')'
			);
			$query->join(
				'LEFT', $this->db->quoteName(
					'#__componentbuilder_library_files_folders_urls', 'c'
				) . ' ON (' . $this->db->quoteName('a.id') . ' = '
				. $this->db->quoteName('c.library') . ')'
			);
			$query->where($this->db->quoteName('a.id') . ' = ' . (int) $id);
			$query->where($this->db->quoteName('a.target') . ' = 1');

			// Reset the query using our newly populated query object.
			$this->db->setQuery($query);

			// Load the results as a list of stdClass objects
			$library = $this->db->loadObject();

			// check if this lib uses build-in behaviour
			if ($library->how == 4)
			{
				// fall back on build-in features
				$buildin = [
					3 => ['uikit' => 3],
					4 => ['uikit' => 1],
					5 => ['footable_version' => 2, 'footable' => true],
					6 => ['footable_version' => 3, 'footable' => true]
				];

				if (isset($buildin[$library->id])
					&& ArrayHelper::check(
						$buildin[$library->id]
					))
				{
					// set the lib switch
					foreach ($buildin[$library->id] as $lib => $val)
					{
						// ---- we are targeting these ----
						// $this->config->uikit
						// $this->config->footable_version
						// $this->config->footable
						$this->config->set($lib, $val);
					}
					// since we are falling back on build-in feature
					$library->how = 0;
				}
				else
				{
					// since we did not find build in behaviour we must load always.
					$library->how = 1;
				}
			}

			// check if this lib has dynamic behaviour
			if ($library->how > 0)
			{
				// set files and folders
				$this->filesFolders->set($library);
	
				// add config fields only if needed
				if ($library->how > 1)
				{
					// set the config data
					$library->addconfig = (isset($library->addconfig)
						&& JsonHelper::check(
							$library->addconfig
						)) ? json_decode((string) $library->addconfig, true) : null;

					if (ArrayHelper::check($library->addconfig))
					{
						$library->config = array_map(
							function ($array) {
								$array['alias']    = 0;
								$array['title']    = 0;
								$array['settings'] = $this->field->get(
									$array['field']
								);

								return $array;
							}, array_values($library->addconfig)
						);
					}
				}
				// if this lib is controlled by custom script
				if (3 == $library->how)
				{
					// set Needed PHP
					if (isset($library->php_setdocument)
						&& StringHelper::check(
							$library->php_setdocument
						))
					{
						$library->document = $this->gui->set(
							$this->customcode->update(
								base64_decode((string) $library->php_setdocument)
							),
							array(
								'table' => 'library',
								'field' => 'php_setdocument',
								'id'    => (int) $id,
								'type'  => 'php')
						);
					}
				}
				// if this lib is controlled by conditions
				elseif (2 == $library->how)
				{
					// set the addconditions data
					$library->addconditions = (isset($library->addconditions)
						&& JsonHelper::check(
							$library->addconditions
						)) ? json_decode((string) $library->addconditions, true) : null;

					if (ArrayHelper::check(
						$library->addconditions
					))
					{
						$library->conditions = array_values(
							$library->addconditions
						);
					}
				}

				unset($library->php_setdocument);
				unset($library->addconditions);
				unset($library->addconfig);

				// load to global lib
				$this->registry->set("builder.libraries.$id", $library);
			}
			else
			{
				$this->registry->set("builder.libraries.$id", false);
			}
		}

		// if set return
		return $this->registry->get("builder.libraries.$id", false);
	}

}

