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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\CMS\Factory;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\External;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\CustomcodeInterface;


/**
 * Compiler Custom Code
 * 
 * @since 3.2.0
 */
class Customcode implements CustomcodeInterface
{
	/**
	 * The function name memory ids
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $functionNameMemory = [];

	/**
	 * The active custom code
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	public $active = [];

	/**
	 * The custom code memory
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	public $memory = [];

	/**
	 * The placeholders for custom code keys
	 *
	 * @var     array
	 */
	protected $keys
		= array(
			'&#91;' => '[',
			'&#93;' => ']',
			'&#44;' => ',',
			'&#43;' => '+',
			'&#61;' => '='
		);

	/**
	 * The custom code to be added
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected $data = [];

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
	 * Compiler Language Extractor
	 *
	 * @var    Extractor
	 * @since 3.2.0
	 **/
	protected Extractor $extractor;

	/**
	 * Compiler Custom Code External
	 *
	 * @var    External
	 * @since 3.2.0
	 **/
	protected External $external;

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
	 * @param Config|null          $config          The compiler config object.
	 * @param Placeholder|null     $placeholder     The compiler placeholder object.
	 * @param Extractor|null       $extractor       The compiler language extractor object.
	 * @param External|null        $external       The compiler external custom code object.
	 * @param \JDatabaseDriver     $db              The Database Driver object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Placeholder $placeholder = null,
		?Extractor $extractor = null, ?External $external = null, ?\JDatabaseDriver $db = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->extractor = $extractor ?: Compiler::_('Language.Extractor');
		$this->external = $external ?: Compiler::_('Customcode.External');
		$this->db = $db ?: Factory::getDbo();
	}

	/**
	 * Update **ALL** dynamic values in a strings here
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *                           We can now at any time debug the
	 *                           dynamic build values if it gets broken
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function update(string $string, int $debug = 0): string
	{
		if (StringHelper::check($string))
		{
			$string = $this->extractor->engine(
				$this->set(
					$this->external->set($string, $debug), $debug
				)
			);
		}
		// if debug
		if ($debug)
		{
			jexit();
		}

		return $string;
	}

	/**
	 * Set the custom code data & can load it in to string
	 *
	 * @param   string     $string  The content to check
	 * @param   int          $debug   The switch to debug the update
	 * @param   int|null   $not       The not switch
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, int $debug = 0, ?int $not = null): string
	{
		// insure the code is loaded
		$loaded = false;
		// check if content has custom code place holder
		if (strpos($string, '[CUSTO' . 'MCODE=') !== false)
		{
			// if debug
			if ($debug)
			{
				echo 'Custom Code String:';
				var_dump($string);
			}
			// the ids found in this content
			$bucket = array();
			$found  = GetHelper::allBetween(
				$string, '[CUSTO' . 'MCODE=', ']'
			);
			if (ArrayHelper::check($found))
			{
				foreach ($found as $key)
				{
					// if debug
					if ($debug)
					{
						echo '$key before update:';
						var_dump($key);
					}
					// check if we have args
					if (is_numeric($key))
					{
						$id = (int) $key;
					}
					elseif (StringHelper::check($key)
						&& strpos($key, '+') === false)
					{
						$getFuncName = trim($key);
						if (!isset($this->functionNameMemory[$getFuncName]))
						{
							if (!$found_local = GetHelper::var(
								'custom_code', $getFuncName, 'function_name',
								'id'
							))
							{
								continue;
							}
							$this->functionNameMemory[$getFuncName]
								= $found_local;
						}
						$id = (int) $this->functionNameMemory[$getFuncName];
					}
					elseif (StringHelper::check($key)
						&& strpos(
							$key, '+'
						) !== false)
					{
						$array = explode('+', $key);
						// set ID
						if (is_numeric($array[0]))
						{
							$id = (int) $array[0];
						}
						elseif (StringHelper::check($array[0]))
						{
							$getFuncName = trim($array[0]);
							if (!isset($this->functionNameMemory[$getFuncName]))
							{
								if (!$found_local
									= GetHelper::var(
									'custom_code', $getFuncName,
									'function_name', 'id'
								))
								{
									continue;
								}
								$this->functionNameMemory[$getFuncName]
									= $found_local;
							}
							$id = (int) $this->functionNameMemory[$getFuncName];
						}
						else
						{
							continue;
						}
						// load args for this ID
						if (isset($array[1]))
						{
							if (!isset($this->data[$id]['args']))
							{
								$this->data[$id]['args'] = array();
							}
							// only load if not already loaded
							if (!isset($this->data[$id]['args'][$key]))
							{
								if (strpos($array[1], ',') !== false)
								{
									// update the function values with the custom code key placeholders (this allow the use of [] + and , in the values)
									$this->data[$id]['args'][$key]
										= array_map(
										function ($_key) {
											return $this->placeholder->update(
												$_key,
												$this->keys
											);
										}, (array) explode(',', $array[1])
									);
								}
								elseif (StringHelper::check(
									$array[1]
								))
								{
									$this->data[$id]['args'][$key]
										= array();
									// update the function values with the custom code key placeholders (this allow the use of [] + and , in the values)
									$this->data[$id]['args'][$key][]
										= $this->placeholder->update(
										$array[1],
										$this->keys
									);
								}
							}
						}
					}
					else
					{
						continue;
					}
					// make sure to remove the not if set
					if ($not && is_numeric($not) && $not > 0 && $not == $id)
					{
						continue;
					}
					$bucket[$id] = $id;
				}
			}
			// if debug
			if ($debug)
			{
				echo 'Bucket:';
				var_dump($bucket);
			}
			// check if any custom code placeholders where found
			if (ArrayHelper::check($bucket))
			{
				$_tmpLang = $this->config->lang_target;
				// insure we add the langs to both site and admin
				$this->config->lang_target = 'both';
				// now load the code to memory
				$loaded = $this->get($bucket, false, $debug);
				// revert lang to current setting
				$this->config->lang_target = $_tmpLang;
			}
			// if debug
			if ($debug)
			{
				echo 'Loaded:';
				var_dump($loaded);
			}
			// when the custom code is loaded
			if ($loaded === true)
			{
				$string = $this->insert($bucket, $string, $debug);
			}
			// if debug
			if ($debug)
			{
				echo 'Custom Code String After Update:';
				var_dump($string);
			}
		}

		return $string;
	}

	/**
	 * Load the custom code from the system
	 *
	 * @param   array|null     $ids           The custom code ides if known
	 * @param   bool           $setLang       The set lang switch
	 * @param   int            $debug         The switch to debug the update
	 *
	 * @return  bool
	 * @since 3.2.0
	 */
	public function get(?array $ids = null, bool $setLang = true, $debug = 0): bool
	{
		// should the result be stored in memory
		$loadInMemory = false;
		// Create a new query object.
		$query = $this->db->getQuery(true);
		$query->from(
			$this->db->quoteName('#__componentbuilder_custom_code', 'a')
		);
		if (ArrayHelper::check($ids))
		{
			if (($idArray = $this->check($ids)) !== false)
			{
				$query->select(
					$this->db->quoteName(
						array('a.id', 'a.code', 'a.comment_type')
					)
				);
				$query->where(
					$this->db->quoteName('a.id') . ' IN (' . implode(
						',', $idArray
					) . ')'
				);
				$query->where(
					$this->db->quoteName('a.target') . ' = 2'
				); // <--- to load the correct target
				$loadInMemory = true;
			}
			else
			{
				// all values are already in memory continue
				return true;
			}
		}
		else
		{
			$query->select(
				$this->db->quoteName(
					array('a.id', 'a.code', 'a.comment_type', 'a.component',
						'a.from_line', 'a.hashtarget', 'a.hashendtarget',
						'a.path', 'a.to_line', 'a.type')
				)
			);
			$query->where(
				$this->db->quoteName('a.component') . ' = '
				. (int) $this->config->component_id
			);
			$query->where(
				$this->db->quoteName('a.target') . ' = 1'
			); // <--- to load the correct target
			$query->order(
				$this->db->quoteName('a.from_line') . ' ASC'
			); // <--- insure we always add code from top of file
			// reset custom code
			$this->active = array();
		}
		$query->where($this->db->quoteName('a.published') . ' >= 1');
		$this->db->setQuery($query);
		$this->db->execute();
		if ($this->db->getNumRows())
		{
			$bucket = $this->db->loadAssocList('id');
			// open the code
			foreach ($bucket as $nr => &$customCode)
			{
				$customCode['code'] = base64_decode($customCode['code']);
				// always insure that the external code is loaded
				$customCode['code'] = $this->external->set(
					$customCode['code']
				);

				// set the lang only if needed (we do the other later when we add it to the correct position)
				if ($setLang)
				{
					$customCode['code'] = $this->extractor->engine(
						$customCode['code']
					);
				}
				// check for more custom code (since this is a custom code placeholder)
				else
				{
					$customCode['code'] = $this->set(
						$customCode['code'], $debug, $nr
					);
				}

				// build the hash array
				if (isset($customCode['hashtarget']))
				{
					$customCode['hashtarget'] = explode(
						"__", $customCode['hashtarget']
					);
					// is this a replace code, set end has array
					if ($customCode['type'] == 1
						&& strpos($customCode['hashendtarget'], '__') !== false)
					{
						$customCode['hashendtarget'] = explode(
							"__", $customCode['hashendtarget']
						);

						// NOW see if this is an end of page target (TODO not sure if the string is always d41d8cd98f00b204e9800998ecf8427e)
						// I know this fix is not air-tight, but it should work as the value of an empty line when md5'ed is ^^^^
						// Then if the line number is only >>>one<<< it is almost always end of the page.
						// So I am using those two values to detect end of page replace ending, to avoid mismatching the ending target hash.
						if ($customCode['hashendtarget'][0] == 1
							&& 'd41d8cd98f00b204e9800998ecf8427e' === $customCode['hashendtarget'][1])
						{
							// unset since this will force the replacement unto end of page.
							unset($customCode['hashendtarget']);
						}
					}
				}
			}

			// load this code into memory if needed
			if ($loadInMemory === true)
			{
				$this->memory = $this->memory + $bucket;
			}

			// add to active set
			$this->active = array_merge($this->active, $bucket);

			return true;
		}

		return false;
	}

	/**
	 * Insert the custom code into the string
	 *
	 * @param   array|null     $ids           The custom code ides if known
	 * @param   string         $string        The string to insert custom code into
	 * @param   int            $debug         The switch to debug the update
	 *
	 * @return  string on success
	 * @since 3.2.0
	 */
	protected function insert(array $ids, string $string, int $debug = 0): string
	{
		$code = array();
		// load the code
		foreach ($ids as $id)
		{
			$this->buildPlaceholders(
				$this->memory[$id], $code, $debug
			);
		}
		// if debug
		if ($debug)
		{
			echo 'Place holders to Update String:';
			var_dump($code);
			echo 'Custom Code String Before Update:';
			var_dump($string);
		}

		// now update the string
		return $this->placeholder->update($string, $code);
	}

	/**
	 * Build custom code placeholders
	 *
	 * @param   array   $item    The memory item
	 * @param   array   $code    The custom code bucket
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function buildPlaceholders(array $item, array &$code, int $debug = 0)
	{
		// check if there is args for this code
		if (isset($this->data[$item['id']]['args'])
			&& ArrayHelper::check(
				$this->data[$item['id']]['args']
			))
		{
			// since we have args we cant update this code via IDE (TODO)
			$placeholder = $this->placeholder->keys(3, null);
			// if debug
			if ($debug)
			{
				echo 'Custom Code Placeholders:';
				var_dump($placeholder);
			}
			// we have args and so need to load each
			foreach (
				$this->data[$item['id']]['args'] as $key => $args
			)
			{
				$this->placeholder->setType('arg', $args);
				// if debug
				if ($debug)
				{
					echo 'Custom Code Global Placeholders:';
					var_dump($this->placeholder->active);
				}
				$code['[CUSTOM' . 'CODE=' . $key . ']'] = $placeholder['start']
					. PHP_EOL . $this->placeholder->update(
						$item['code'], $this->placeholder->active
					) . $placeholder['end'];
			}
			// always clear the args
			$this->placeholder->clearType('arg');
		}
		else
		{
			if (($keyPlaceholder = array_search(
					$item['id'], $this->functionNameMemory
				)) === false)
			{
				$keyPlaceholder = $item['id'];
			}
			// check what type of place holders we should load here
			$placeholderType = (int) $item['comment_type'] . '2';
			if (stripos($item['code'], Placefix::b() . 'view') !== false
				|| stripos($item['code'], Placefix::b() . 'sview') !== false
				|| stripos($item['code'], Placefix::b() . 'arg') !== false)
			{
				// if view is being set dynamicly then we can't update this code via IDE (TODO)
				$placeholderType = 3;
			}
			// if now ars were found, clear it
			$this->placeholder->clearType('arg');
			// load args for this code
			$placeholder = $this->placeholder->keys(
				$placeholderType, $item['id']
			);
			$code['[CUSTOM' . 'CODE=' . $keyPlaceholder . ']']
			             = $placeholder['start'] . PHP_EOL
				. $this->placeholder->update(
					$item['code'], $this->placeholder->active
				) . $placeholder['end'];
		}
	}

	/**
	 * check if we already have these ids in local memory
	 *
	 * @param   array     $ids The custom code ids
	 *
	 * @return  Mixed
	 * @since 3.2.0
	 */
	protected function check(array $ids)
	{
		// reset custom code
		$this->active = [];

		foreach ($ids as $pointer => $id)
		{
			if (isset($this->memory[$id]))
			{
				$this->active[] = $this->memory[$id];
				unset($ids[$pointer]);
			}
		}

		// check if any ids left to fetch
		if (ArrayHelper::check($ids))
		{
			return $ids;
		}

		return false;
	}

}

