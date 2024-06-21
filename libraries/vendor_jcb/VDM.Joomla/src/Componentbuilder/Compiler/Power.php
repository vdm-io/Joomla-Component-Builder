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
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Utilities\String\ClassfunctionHelper;
use VDM\Joomla\Utilities\String\NamespaceHelper;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Power\Super as Superpower;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\PowerInterface;


/**
 * Compiler Power
 * 
 * @since 3.2.0
 */
class Power implements PowerInterface
{
	/**
	 * All loaded powers
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $active = [];

	/**
	 * All power namespaces
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $namespace = [];

	/**
	 * All composer namespaces
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $composer = [];

	/**
	 * All super powers of this build
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $superpowers = [];

	/**
	 * Old super powers found in the local repos
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $old_superpowers = [];

	/**
	 * The url to the power, if there is an error.
	 *
	 * @var   string
	 * @since 3.2.0
	 **/
	protected string $fixUrl;

	/**
	 * The state of all loaded powers
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $state = [];

	/**
	 * The state of retry to loaded powers
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	protected array $retry = [];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * The Gui Class.
	 *
	 * @var   Gui
	 * @since 3.2.0
	 */
	protected Gui $gui;

	/**
	 * The Super Class.
	 *
	 * @var   Superpower
	 * @since 3.2.0
	 */
	protected Superpower $superpower;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $app;

	/**
	 * Constructor.
	 *
	 * @param Config        $config        The Config Class.
	 * @param Placeholder   $placeholder   The Placeholder Class.
	 * @param Customcode    $customcode    The Customcode Class.
	 * @param Gui           $gui           The Gui Class.
	 * @param Superpower    $superpower    The Super Class.
	 *
	 * @since 3.2.0
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
	 * @since 3.2.0
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
	 * @since 3.2.0
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
	 * Set a power
	 *
	 * @param string   $guid    The global unique id of the power
	 *
	 * @return bool  true on successful setting of a power
	 * @since 3.2.0
	 */
	private function set(string $guid): bool
	{
		// check if we have been here before
		if ($this->isPowerSet($guid))
		{
			return $this->state[$guid];
		}
		elseif ($this->isGuidValid($guid))
		{
			// get the power data
			$this->active[$guid] = $this->getPowerData($guid);

			if (is_object($this->active[$guid]))
			{
				// make sure that in recursion we
				// don't try to load this power again
				// since during the load of a power we also load
				// all powers linked to it
				$this->state[$guid] = true;

				// make sure to add any language strings found to all language files
				// since we can't know where this is used at this point
				$tmp_lang_target = $this->config->lang_target;
				$this->config->lang_target = 'both';

				// we set the fix url if needed
				$this->fixUrl
					= '"index.php?option=com_componentbuilder&view=powers&task=power.edit&id='
					. $this->active[$guid]->id . '" target="_blank"';

				// set some keys
				$this->active[$guid]->target_type = 'P0m3R!';
				$this->active[$guid]->key         = $this->active[$guid]->id . '_' . $this->active[$guid]->target_type;

				// reserve some values for the linker
				$this->active[$guid]->unchanged_namespace = $this->active[$guid]->namespace;
				$this->active[$guid]->unchanged_description = $this->active[$guid]->description;

				// now set the name
				$this->active[$guid]->name = $this->placeholder->update_(
					$this->customcode->update($this->active[$guid]->name)
				);

				// now set the code_name and class name
				$this->active[$guid]->code_name = $this->active[$guid]->class_name = ClassfunctionHelper::safe(
					$this->active[$guid]->name
				);

				// set official name
				$this->active[$guid]->official_name = StringHelper::safe(
					$this->active[$guid]->name, 'W'
				);

				// set name space
				if (!$this->setNamespace($guid))
				{
					$this->state[$guid] = false;
					unset($this->active[$guid]);
					// reset back to starting value
					$this->config->lang_target = $tmp_lang_target;

					return false;
				}

				// load use ids
				$use = [];
				$as = [];

				// set extra classes
				$this->setLoadSelection($guid);

				// set use classes
				$this->setUseSelection($guid, $use, $as);

				// set implement interfaces
				$this->setImplements($guid, $use);

				// set extend class
				$this->setExtend($guid, $use, $as);

				// set GUI mapper
				$guiMapper = [
					'table' => 'power',
					'id' => (int) $this->active[$guid]->id,
					'type' => 'php'
				];

				// add the licensing template 
				$this->setLicensingTemplate($guid, $guiMapper);

				// add the header script
				$this->setHeader($guid, $guiMapper);

				// set composer
				$this->setComposer($guid);

				// now set the description
				$this->active[$guid]->description = (StringHelper::check($this->active[$guid]->description)) ? $this->placeholder->update_(
					$this->customcode->update($this->active[$guid]->description),
				) : '';

				// add the main code if set
				$this->setMainClassCode($guid, $guiMapper);

				// load the use classes
				$this->setUseAs($guid, $use, $as);

				// reset back to starting value
				$this->config->lang_target = $tmp_lang_target;

				// set the approved super power values
				$this->setSuperPowers($guid);

				return true;
			}
		}

		// we failed to get the power,
		// so we raise an error message
		// only if guid is valid
		if ($this->isGuidValid($guid))
		{
			// now we search for it via the super power paths
			if (empty($this->retry[$guid]) && $this->superpower->load($guid, ['remote', 'local']))
			{
				// we found it and it was loaded into the database
				unset($this->state[$guid]);
				unset($this->active[$guid]);

				// we make sure that this retry only happen once! (just in-case...)
				$this->retry[$guid] = true;

				// so we try to load it again
				return $this->set($guid);
			}

			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PPOWER_BGUIDSB_NOT_FOUNDP', $guid),
				'Error'
			);
		}

		// let's not try again
		$this->state[$guid] = false;

		return false;
	}

	/**
	 * Check if the power is already set
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return bool true if the power is already set
	 * @since 3.2.0
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
	 * @since 3.2.0
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
	 * @since 3.2.0
	 */
	private function getPowerData(string $guid): ?object
	{
		$query = $this->db->getQuery(true);
		$query->select('a.*');
		$query->from('#__componentbuilder_power AS a');
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
	 * Set the namespace for this power
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	private function setNamespace(string $guid): bool
	{
		// set namespace
		$this->active[$guid]->namespace = $this->placeholder->update_(
			$this->active[$guid]->namespace
		);

		// validate namespace
		if (strpos($this->active[$guid]->namespace, '\\') === false)
		{
			// we raise an error message
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_HTHREES_NAMESPACE_ERROR_SHTHREEPYOU_MUST_ATLEAST_HAVE_TWO_SECTIONS_IN_YOUR_NAMESPACE_YOU_JUST_HAVE_ONE_THIS_IS_AN_UNACCEPTABLE_ACTION_PLEASE_SEE_A_HREFS_PSRFOURA_FOR_MORE_INFOPPTHIS_S_WAS_THEREFORE_REMOVED_A_HREFSCLICK_HEREA_TO_FIX_THIS_ISSUEP',
					ucfirst((string) $this->active[$guid]->type), $this->active[$guid]->name, $this->active[$guid]->namespace,
					'"https://www.php-fig.org/psr/psr-4/" target="_blank"', $this->active[$guid]->type,
					$this->fixUrl),
				'Error'
			);

			// we break out here
			return false;
		}

		// setup the path array
		$path_array = (array) explode('\\', $this->active[$guid]->namespace);

		// make sure all sub folders in src dir is set and remove all characters that will not work in folders naming
		$this->active[$guid]->namespace = $this->getCleanNamespace(str_replace('.', '\\', $this->active[$guid]->namespace));

		// make sure it has two or more
		if (ArrayHelper::check($path_array) <= 1)
		{
			// we raise an error message
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_HTHREES_NAMESPACE_ERROR_SHTHREEPYOU_MUST_ATLEAST_HAVE_TWO_SECTIONS_IN_YOUR_NAMESPACE_YOU_JUST_HAVE_ONE_S_THIS_IS_AN_UNACCEPTABLE_ACTION_PLEASE_SEE_A_HREFS_PSRFOURA_FOR_MORE_INFOPPTHIS_S_WAS_THEREFORE_REMOVED_A_HREFSCLICK_HEREA_TO_FIX_THIS_ISSUEP',
					ucfirst((string) $this->active[$guid]->type), $this->active[$guid]->name, $this->active[$guid]->namespace,
					'"https://www.php-fig.org/psr/psr-4/" target="_blank"', $this->active[$guid]->type,
					$this->fixUrl),
				'Error'
			);

			// we break out here
			return false;
		}

		// get the file and class name (the last value in array)
		$file_name = array_pop($path_array);

		// src array bucket
		$src_array = [];

		// do we have src folders
		if (strpos($file_name, '.') !== false)
		{
			// we have src folders in the namespace
			$src_array = (array) explode('.', $file_name);

			// get the file and class name (the last value in array)
			$this->active[$guid]->file_name = array_pop($src_array);

			// namespace array
			$namespace_array = [...$path_array, ...$src_array];
		}
		else
		{
			// set the file name
			$this->active[$guid]->file_name = $file_name;

			// namespace array
			$namespace_array = $path_array;
		}

		// the last value is the same as the class name
		if ($this->active[$guid]->file_name !== $this->active[$guid]->class_name)
		{
			// we raise an error message
			$this->app->enqueueMessage(
				Text::sprintf('COM_COMPONENTBUILDER_PS_NAMING_MISMATCH_ERROR_SPPTHE_S_NAME_IS_BSB_AND_THE_ENDING_FILE_NAME_IN_THE_NAMESPACE_IS_BSB_THIS_IS_BAD_CONVENTION_PLEASE_SEE_A_HREFS_PSRFOURA_FOR_MORE_INFOPPA_HREFSCLICK_HEREA_TO_FIX_THIS_ISSUEP',
					ucfirst((string) $this->active[$guid]->type), $this->active[$guid]->name, $this->active[$guid]->type, $this->active[$guid]->class_name, $this->active[$guid]->file_name,
					'"https://www.php-fig.org/psr/psr-4/" target="_blank"',
					$this->fixUrl),
				'Error'
			);

			// we break out here
			return false;
		}

		// make sure the arrays are namespace safe
		$path_array =
			array_map(
				fn($val) => $this->getCleanNamespace($val),
				$path_array
			);
		$namespace_array =
			array_map(
				fn($val) => $this->getCleanNamespace($val),
				$namespace_array
			);

		// set the actual class namespace
		$this->active[$guid]->_namespace = implode('\\', $namespace_array);

		// set global namespaces for autoloader
		$this->namespace[implode('.', $path_array)] = $path_array;

		// get the parent folder (the first value in array)
		$prefix_folder = implode('.', $path_array);

		// make sub folders if still found
		$sub_folder = '';
		if (ArrayHelper::check($src_array))
		{
			// make sure the arrays are namespace safe
			$sub_folder = '/' . implode('/',
				array_map(
					fn($val) => $this->getCleanNamespace($val),
					$src_array
				)
			);
		}

		// now we set the paths
		$this->active[$guid]->path_jcb    = $this->config->get('jcb_powers_path', 'libraries/jcb_powers');
		$this->active[$guid]->path_parent = $this->active[$guid]->path_jcb . '/' . $prefix_folder;
		$this->active[$guid]->path        = $this->active[$guid]->path_parent . '/src' . $sub_folder;

		return true;
	}

	/**
	 * Set Use Classes
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setUseSelection(string $guid, array &$use, array &$as)
	{
		// check if we have use selection
		$this->active[$guid]->use_selection = (isset($this->active[$guid]->use_selection)
			&& JsonHelper::check(
				$this->active[$guid]->use_selection
			)) ? json_decode((string) $this->active[$guid]->use_selection, true) : null;

		if (ArrayHelper::check($this->active[$guid]->use_selection))
		{
			$use = array_values(array_map(function ($u) use(&$as) {
				// track the AS options
				$as[$u['use']] = empty($u['as']) ? 'default' : (string) $u['as'];
				// return the guid
				return $u['use'];
			}, $this->active[$guid]->use_selection));
		}
		else
		{
			$this->active[$guid]->use_selection = null;
		}
	}

	/**
	 * Load Extra Classes
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setLoadSelection(string $guid)
	{
		// check if we have load selection
		$this->active[$guid]->load_selection = (isset($this->active[$guid]->load_selection)
			&& JsonHelper::check(
				$this->active[$guid]->load_selection
			)) ? json_decode((string) $this->active[$guid]->load_selection, true) : null;

		if (ArrayHelper::check($this->active[$guid]->load_selection))
		{
			// load use ids
			array_map(
				// just load it directly and be done with it
				fn($power) => $this->set($power['load']),
				$this->active[$guid]->load_selection
			);
		}
		else
		{
			$this->active[$guid]->load_selection = null;
		}
	}

	/**
	 * Set Composer Linked Use and Access Point
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setComposer(string $guid)
	{
		// does this have composer powers
		$_composer = (isset($this->active[$guid]->composer)
			&& JsonHelper::check(
				$this->active[$guid]->composer
			)) ? json_decode((string) $this->active[$guid]->composer, true) : null;

		unset($this->active[$guid]->composer);

		if (ArrayHelper::check($_composer))
		{
			// reserve composer values for the linker
			$this->active[$guid]->unchanged_composer = $_composer;

			foreach ($_composer as $composer)
			{
				if (isset($composer['access_point']) && StringHelper::check($composer['access_point']) &&
					isset($composer['namespace']) && ArrayHelper::check($composer['namespace']))
				{
					foreach ($composer['namespace'] as $_namespace)
					{
						// make sure we have a valid namespace
						if (isset($_namespace['use']) && StringHelper::check($_namespace['use']) &&
							strpos((string) $_namespace['use'], '\\') !== false)
						{
							// add the namespace to this access point
							$as = 'default';
							if (strpos((string) $_namespace['use'], ' as ') !== false)
							{
								$namespace_as = explode(' as ', (string) $_namespace['use']);
								// make sure the AS value is set
								if (count($namespace_as) == 2)
								{
									$as = trim(trim($namespace_as[1], ';'));
								}
								$namespace = $this->getCleanNamespace($namespace_as[0]);
							}
							else
							{
								// trim possible use or ; added to the namespace
								$namespace = $this->getCleanNamespace($_namespace['use']);
							}

							// check if still valid
							if (!StringHelper::check($namespace))
							{
								continue;
							}

							// add to the header of the class
							$this->addToHeader($guid, $this->getUseNamespace($namespace, $as));

							// add composer namespaces for autoloader
							$this->composer[$namespace] = $composer['access_point'];
						}
					}
				}
			}
		}
		else
		{
			// reserve composer values for the linker
			$this->active[$guid]->unchanged_composer = '';
		}
	}

	/**
	 * Set Implements Interface classes
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setImplements(string $guid, array &$use)
	{
		// see if we have implements
		$this->active[$guid]->implement_names = [];

		// does this implement
		$this->active[$guid]->implements = (isset($this->active[$guid]->implements)
			&& JsonHelper::check(
				$this->active[$guid]->implements
			)) ? json_decode((string) $this->active[$guid]->implements, true) : null;

		if ($this->active[$guid]->implements)
		{
			foreach ($this->active[$guid]->implements as $implement)
			{
				if ($implement == -1
					&& StringHelper::check($this->active[$guid]->implements_custom))
				{
					// reserve implements custom for the linker
					$this->active[$guid]->unchanged_implements_custom = $this->active[$guid]->implements_custom;

					$this->active[$guid]->implement_names[] = $this->placeholder->update_(
						$this->customcode->update($this->active[$guid]->implements_custom)
					);

					// just add this once
					unset($this->active[$guid]->implements_custom);
				}
				// does this extend existing
				elseif (GuidHelper::valid($implement))
				{
					// check if it was set
					if ($this->set($implement))
					{
						// get the name
						$this->active[$guid]->implement_names[] = $this->get($implement, 1)->class_name;
						// add to use
						$use[] = $implement;
					}
				}
			}
		}
	}

	/**
	 * Set Extend
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setExtend(string $guid, array &$use, array &$as)
	{
		// build the interface extends details
		if ($this->active[$guid]->type === 'interface')
		{
			$this->setExtendInterface($guid, $use, $as);
		}
		else
		{
			$this->setExtendClass($guid, $use, $as);
		}
	}

	/**
	 * Set Extend Class
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setExtendClass(string $guid, array &$use, array &$as)
	{
		// we first check for custom extending options
		if ($this->active[$guid]->extends == -1
			&& StringHelper::check($this->active[$guid]->extends_custom))
		{
			// reserve extends custom for the linker
			$this->active[$guid]->unchanged_extends_custom = $this->active[$guid]->extends_custom;

			$this->active[$guid]->extends_name = $this->placeholder->update_(
				$this->customcode->update($this->active[$guid]->extends_custom)
			);

			// just add once
			unset($this->active[$guid]->extends_custom);
		}
		// does this extend existing
		elseif (GuidHelper::valid($this->active[$guid]->extends))
		{
			// check if it was set
			if ($this->set($this->active[$guid]->extends))
			{
				// get the name
				$this->active[$guid]->extends_name = $this->get($this->active[$guid]->extends, 1)->class_name;
				// add to use
				$use[] = $this->active[$guid]->extends;

				// add padding if the two names are the same
				if ($this->active[$guid]->extends_name === $this->active[$guid]->class_name)
				{
					$this->active[$guid]->extends_name = $as[$this->active[$guid]->extends]
						= 'Extending' . $this->active[$guid]->class_name;
				}
			}
		}
		// reset it not found
		else
		{
			$this->active[$guid]->extends = '';
			$this->active[$guid]->extends_custom = '';
		}
		// always rest these for normal classes
		$this->active[$guid]->extendsinterfaces = null;
		$this->active[$guid]->extendsinterfaces_custom = '';
	}

	/**
	 * Set Extend Interface
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.2
	 */
	private function setExtendInterface(string $guid, array &$use, array &$as)
	{
		// does this extends interfaces
		$this->active[$guid]->extendsinterfaces = (isset($this->active[$guid]->extendsinterfaces)
			&& JsonHelper::check(
				$this->active[$guid]->extendsinterfaces
			)) ? json_decode((string)$this->active[$guid]->extendsinterfaces, true) : null;

		if (ArrayHelper::check($this->active[$guid]->extendsinterfaces))
		{
			$bucket = [];
			foreach ($this->active[$guid]->extendsinterfaces as $extend)
			{
				// we first check for custom extending options
				if ($extend == -1
					&& isset($this->active[$guid]->extendsinterfaces_custom)
					&& StringHelper::check($this->active[$guid]->extendsinterfaces_custom))
				{
					// reserve extends custom for the linker
					$this->active[$guid]->unchanged_extendsinterfaces_custom = $this->active[$guid]->extendsinterfaces_custom;

					$bucket[] = $this->placeholder->update_(
						$this->customcode->update($this->active[$guid]->extendsinterfaces_custom)
					);

					// just add once
					unset($this->active[$guid]->extendsinterfaces_custom);
				}
				// does this extend existing
				elseif (GuidHelper::valid($extend))
				{
					// check if it was set
					if ($this->set($extend))
					{
						$extends_name = $this->get($extend, 1)->class_name;
						// add to use
						$use[] = $extend;

						// add padding if the two names are the same
						if ($extends_name === $this->active[$guid]->class_name)
						{
							$extends_name = $as[$extend]
								= 'Extending' . $extends_name;
						}
						// get the name
						$bucket[] = $extends_name;
					}
				}
			}
			if ($bucket !== [])
			{
				$this->active[$guid]->extends_name = implode(', ', $bucket);
			}
		}
		else
		{
			$this->active[$guid]->extendsinterfaces = null;
			$this->active[$guid]->extendsinterfaces_custom = '';
		}
		// always rest these for interfaces
		$this->active[$guid]->extends = '';
		$this->active[$guid]->extends_custom = '';
	}

	/**
	 * Set Extra Use Classes
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setUseAs(string $guid, array $use, array $as)
	{
		// now add all the extra use statements
		if (ArrayHelper::check($use))
		{
			foreach (array_unique($use) as $u)
			{
				if ($this->set($u))
				{
					// get the namespace
					$namespace = $this->get($u, 1)->namespace;

					// check if it has an AS option
					if (isset($as[$u]) && StringHelper::check($as[$u]))
					{
						// add to the header of the class
						$this->addToHeader($guid, $this->getUseNamespace($namespace, $as[$u]));
					}
					else
					{
						// add to the header of the class
						$this->addToHeader($guid, $this->getUseNamespace($namespace));
					}
				}
			}
		}
	}

	/**
	 * Get Clean Namespace without use or ; as part of the name space
	 *
	 * @param string  $namespace        The actual name space
	 * @param bool    $removeNumbers    The switch to remove numbers
	 *
	 * @return string
	 * @since 3.2.0
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
	 * @since 3.2.0
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
	 * Add to class header
	 *
	 * @param string  $guid      The global unique id of the power
	 * @param string  $string    The string to add to header
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function addToHeader(string $guid, string $string)
	{
		// check if it is already added manually
		if (isset($this->active[$guid]->head) &&
			strpos((string) $this->active[$guid]->head, $string) === false)
		{
			$this->active[$guid]->head .= $string . PHP_EOL;
		}
	}

	/**
	 * Set the power licensing template
	 *
	 * @param string  $guid       The global unique id of the power
	 * @param array   $guiMapper  The gui mapper array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setLicensingTemplate(string $guid, array $guiMapper): void
	{
		if ($this->active[$guid]->add_licensing_template == 2 &&
			StringHelper::check($this->active[$guid]->licensing_template))
		{
			// set GUI mapper field
			$guiMapper['field'] = 'licensing_template';

			// reserve licensing template for the linker
			$this->active[$guid]->unchanged_licensing_template = base64_decode(
				(string) $this->active[$guid]->licensing_template
			);

			// base64 Decode code
			$this->active[$guid]->licensing_template = $this->gui->set(
				$this->placeholder->update_(
					$this->customcode->update(
						$this->active[$guid]->unchanged_licensing_template
					)
				),
				$guiMapper
			);
		}
		else
		{
			$this->active[$guid]->add_licensing_template = 1;
			$this->active[$guid]->licensing_template = '';
			$this->active[$guid]->unchanged_licensing_template = '';
		}
	}

	/**
	 * Set the power header script
	 *
	 * @param string  $guid       The global unique id of the power
	 * @param array   $guiMapper  The gui mapper array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setHeader(string $guid, array $guiMapper): void
	{
		if ($this->active[$guid]->add_head == 1)
		{
			// set GUI mapper field
			$guiMapper['field'] = 'head';

			// reserve header for the linker
			$this->active[$guid]->unchanged_head = base64_decode(
				(string) $this->active[$guid]->head
			);

			// base64 Decode code
			$this->active[$guid]->head = $this->gui->set(
				$this->placeholder->update_(
					$this->customcode->update(
						$this->active[$guid]->unchanged_head
					)
				),
				$guiMapper
			) . PHP_EOL;
		}
		else
		{
			$this->active[$guid]->head = '';
			$this->active[$guid]->unchanged_head = '';
		}
	}

	/**
	 * Set the power main class code
	 *
	 * @param string  $guid       The global unique id of the power
	 * @param array   $guiMapper  The gui mapper array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setMainClassCode(string $guid, array $guiMapper): void
	{
		if (StringHelper::check($this->active[$guid]->main_class_code))
		{
			// reserve main class code for the linker
			$this->active[$guid]->unchanged_main_class_code = base64_decode(
				(string) $this->active[$guid]->main_class_code
			);

			// set GUI mapper field
			$guiMapper['field'] = 'main_class_code';

			// base64 Decode code
			$this->active[$guid]->main_class_code = $this->gui->set(
				$this->placeholder->update_(
					$this->customcode->update(
						$this->active[$guid]->unchanged_main_class_code
					)
				),
				$guiMapper
			);
		}
		else
		{
			$this->active[$guid]->unchanged_main_class_code = '';
			$this->active[$guid]->main_class_code = '';
		}
	}

	/**
	 * Set the super powers of this power
	 *
	 * @param string  $guid   The global unique id of the power
	 *
	 * @return void
	 * @since 3.2.0
	 */
	private function setSuperPowers(string $guid): void
	{
		// set the approved super power values
		if ($this->config->add_super_powers && $this->active[$guid]->approved == 1)
		{
			$this->active[$guid]->approved_paths = (isset($this->active[$guid]->approved_paths)
				&& JsonHelper::check(
					$this->active[$guid]->approved_paths
				)) ? json_decode((string) $this->active[$guid]->approved_paths, true) : null;

			if (ArrayHelper::check($this->active[$guid]->approved_paths))
			{
				$global_path = $this->config->local_powers_repository_path;

				// update all paths
				$this->active[$guid]->super_power_paths = array_map(function($path) use($global_path, $guid) {

					// remove branch
					if (($pos = strpos($path, ':')) !== false)
					{
						$path = substr($path, 0, $pos);
					}

					// set the repo path
					$repo = $global_path . '/' . $path;

					// set SuperPowerKey (spk)
					$spk = 'Super_'.'_' . str_replace('-', '_', $guid) . '_'.'_Power';

					// set the global super power
					$this->superpowers[$repo][$guid] = [
						'name' => $this->active[$guid]->code_name,
						'type' => $this->active[$guid]->type,
						'namespace' => $this->active[$guid]->_namespace,
						'code' => 'src/' . $guid . '/code.php',
						'power' => 'src/' . $guid . '/code.power',
						'settings' => 'src/' . $guid . '/settings.json',
						'path' => 'src/' . $guid,
						'spk' => $spk,
						'guid' => $guid
					];

					return  $repo . '/src/' . $guid;
				}, array_values($this->active[$guid]->approved_paths));

				return;
			}
		}

		// reset all to avoid any misunderstanding down steam
		$this->active[$guid]->super_power_paths = null;
		$this->active[$guid]->approved_paths = null;
		$this->active[$guid]->approved = null;
	}
}

