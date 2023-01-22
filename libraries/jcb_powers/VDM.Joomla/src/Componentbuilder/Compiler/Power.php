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
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
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
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Compiler Customcode
	 *
	 * @var    Customcode
	 * @since 3.2.0
	 **/
	protected Customcode $customcode;

	/**
	 * Compiler Customcode in Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * Database object to query local DB
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Config|null             $config       The compiler config object.
	 * @param Placeholder|null        $placeholder  The compiler placeholder object.
	 * @param Customcode|null         $customcode   The compiler customcode object.
	 * @param Gui|null                $gui          The compiler customcode gui object.
	 * @param \JDatabaseDriver|null   $db           The Database Driver object.
	 * @param CMSApplication|null     $app          The CMS Application object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Placeholder $placeholder = null,
		?Customcode $customcode = null, ?Gui $gui = null,
		?\JDatabaseDriver $db = null, ?CMSApplication $app = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->db = $db ?: Factory::getDbo();
		$this->app = $app ?: Factory::getApplication();
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
	 * @param string   $guid    The global unique id of the power
	 * @param int        $build    Force build switch (to override global switch)
	 *
	 * @return mixed
	 * @since 3.2.0
	 */
	public function get(string $guid, int $build = 0)
	{
		if (($this->config->get('add_power', true) || $build == 1) && $this->set($guid))
		{
			return $this->active[$guid];
		}

		return false;
	}

	/**
	 * Set a power
	 *
	 * @param string   $guid    The global unique id of the power
	 *
	 * @return bool  true on successful setting of a power
	 * @since 3.2.0
	 */
	protected function set(string $guid): bool
	{
		// check if we have been here before
		if (isset($this->state[$guid]))
		{
			return $this->state[$guid];
		}
		elseif (GuidHelper::valid($guid))
		{
			// Create a new query object.
			$query = $this->db->getQuery(true);

			// select all values
			$query->select('a.*');

			// from this table
			$query->from('#__componentbuilder_power AS a');
			$query->where($this->db->quoteName('a.guid') . ' = ' . $this->db->quote($guid));

			$this->db->setQuery($query);
			$this->db->execute();

			if ($this->db->getNumRows())
			{
				// make sure that in recursion we
				// don't try to load this power again
				// since during the load of a power we also load
				// all powers linked to it
				$this->state[$guid] = true;

				// get the power data
				$this->active[$guid] = $this->db->loadObject();

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
				$this->setExtend($guid, $use);

				// set GUI mapper
				$guiMapper = array('table' => 'power', 'id' => (int) $this->active[$guid]->id, 'type' => 'php');

				// add the licensing template 
				if ($this->active[$guid]->add_licensing_template == 2 &&
					StringHelper::check($this->active[$guid]->licensing_template))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'licensing_template';
					// base64 Decode code
					$this->active[$guid]->licensing_template = $this->gui->set(
							$this->placeholder->update_(
								$this->customcode->update(
									base64_decode(
										(string) $this->active[$guid]->licensing_template
									)
								)
							),
							$guiMapper
						);
				}
				else
				{
					$this->active[$guid]->add_licensing_template = 1;
					$this->active[$guid]->licensing_template = '';
				}

				// add the header script
				if ($this->active[$guid]->add_head == 1)
				{
					// set GUI mapper field
					$guiMapper['field'] = 'head';

					// base64 Decode code
					$this->active[$guid]->head = $this->gui->set(
							$this->placeholder->update_(
								$this->customcode->update(
									base64_decode(
										(string) $this->active[$guid]->head
									)
								)
							),
							$guiMapper
						) . PHP_EOL;
				}
				else
				{
					$this->active[$guid]->head = '';
				}

				// set composer
				$this->setComposer($guid);

				// now set the description
				$this->active[$guid]->description = (StringHelper::check($this->active[$guid]->description)) ? $this->placeholder->update_(
					$this->customcode->update($this->active[$guid]->description),
				) : '';

				// add the main code if set
				if (StringHelper::check($this->active[$guid]->main_class_code))
				{
					// set GUI mapper field
					$guiMapper['field'] = 'main_class_code';
					// base64 Decode code
					$this->active[$guid]->main_class_code = $this->gui->set(
						$this->placeholder->update_(
							$this->customcode->update(
								base64_decode(
									(string) $this->active[$guid]->main_class_code
								)
							)
						),
						$guiMapper
					);
				}

				// load the use classes
				$this->setUseAs($guid, $use, $as);

				// reset back to starting value
				$this->config->lang_target = $tmp_lang_target;

				return true;
			}
		}

		// we failed to get the power,
		// so we raise an error message
		// only if guid is valid
		if (GuidHelper::valid($guid))
		{
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
	 * Set the namespace for this power
	 *
	 * @param string  $guid  The global unique id of the power
	 *
	 * @return bool
	 * @since 3.2.0
	 */
	protected function setNamespace(string $guid): bool
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
	 * Set Use Classess
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 * @param array   $as    The use as array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function setUseSelection(string $guid, array &$use, array &$as)
	{
		// check if we have use selection
		$this->active[$guid]->use_selection = (isset($this->active[$guid]->use_selection)
			&& JsonHelper::check(
				$this->active[$guid]->use_selection
			)) ? json_decode((string) $this->active[$guid]->use_selection, true) : null;

		if ($this->active[$guid]->use_selection)
		{
			$use = array_values(array_map(function ($u) use(&$as) {
				// track the AS options
				$as[$u['use']] = empty($u['as']) ? 'default' : (string) $u['as'];
				// return the guid
				return $u['use'];
			}, $this->active[$guid]->use_selection));
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
	protected function setLoadSelection(string $guid)
	{
		// check if we have load selection
		$this->active[$guid]->load_selection = (isset($this->active[$guid]->load_selection)
			&& JsonHelper::check(
				$this->active[$guid]->load_selection
			)) ? json_decode((string) $this->active[$guid]->load_selection, true) : null;

		if ($this->active[$guid]->load_selection)
		{
			// load use ids
			array_map(
				// just load it directly and be done with it
				fn($power) => $this->set($power['load']),
				$this->active[$guid]->load_selection
			);
		}
	}

	/**
	 * Set Composer Linked Use and Access Point
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function setComposer(string $guid)
	{
		// does this have composer powers
		$_composer = (isset($this->active[$guid]->composer)
			&& JsonHelper::check(
				$this->active[$guid]->composer
			)) ? json_decode((string) $this->active[$guid]->composer, true) : null;

		unset($this->active[$guid]->composer);

		if (ArrayHelper::check($_composer))
		{
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
								$namespace = $this->getCleanNamespace($namespace_as[0], false);
							}
							else
							{
								// trim possible use or ; added to the namespace
								$namespace = $this->getCleanNamespace($_namespace['use'], false);
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
	protected function setImplements(string $guid, array &$use)
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
	 * Set Extend Class
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function setExtend(string $guid, array &$use)
	{
		// does this extend something
		$this->active[$guid]->extends_name = null;

		// we first check for custom extending options
		if ($this->active[$guid]->extends == -1
			&& StringHelper::check($this->active[$guid]->extends_custom))
		{
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
			}
		}
	}

	/**
	 * Set Extra Use Classes
	 *
	 * @param string  $guid  The global unique id of the power
	 * @param array   $use   The use array
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function setUseAs($guid, $use, $as)
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
	 * @input bool    $removeNumbers    The switch to remove numers
	 *
	 * @return string
	 * @since 3.2.0
	 */
	protected function getCleanNamespace(string $namespace, bool $removeNumbers = true): string
	{
		// trim possible (use) or (;) or (starting or ending \) added to the namespace
		return NamespaceHelper::safe(str_replace(['use ', ';'], '', $namespace), $removeNumbers);
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
	protected function getUseNamespace(string $namespace, string $as = 'default'): string
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
	protected function addToHeader(string $guid, string $string)
	{
		// check if it is already added manually
		if (isset($this->active[$guid]->head) &&
			strpos((string) $this->active[$guid]->head, $string) === false)
		{
			$this->active[$guid]->head .= $string . PHP_EOL;
		}
	}

}

