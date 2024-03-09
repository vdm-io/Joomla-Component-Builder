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

namespace VDM\Joomla\Componentbuilder\Compiler\Customcode;


use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Hash;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\LockBase;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\DispenserInterface;


/**
 * Compiler Custom Code Dispenser
 * 
 * @since 3.2.0
 */
class Dispenser implements DispenserInterface
{
	/**
	 * Customcode Dispenser Hub
	 *
	 * @var    array
	 * @since 3.2.0
	 **/
	public array $hub;

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
	 * Compiler Customcode to Hash
	 *
	 * @var    Hash
	 * @since 3.2.0
	 **/
	protected Hash $hash;

	/**
	 * Compiler Customcode to LockBase
	 *
	 * @var    LockBase
	 * @since 3.2.0
	 **/
	protected LockBase $base64;

	/**
	 * Constructor.
	 *
	 * @param Placeholder|null  $placeholder The compiler placeholder object.
	 * @param Customcode|null   $customcode  The compiler customcode object.
	 * @param Gui|null          $gui         The compiler customcode gui object.
	 * @param Hash|null         $hash        The compiler customcode hash object.
	 * @param LockBase|null     $base64      The compiler customcode lock base64 object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Placeholder $placeholder = null, ?Customcode $customcode = null,
		?Gui $gui = null, ?Hash $hash = null, ?LockBase $base64 = null)
	{
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->customcode = $customcode ?: Compiler::_('Customcode');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->hash = $hash ?: Compiler::_('Customcode.Hash');
		$this->base64 = $base64 ?: Compiler::_('Customcode.LockBase');
	}

	/**
	 * Set the script for the customcode dispenser
	 *
	 * @param   string       $script   The script
	 * @param   string       $first    The first key
	 * @param   string|null  $second   The second key (if not set we use only first key)
	 * @param   string|null  $third    The third key (if not set we use only first and second key)
	 * @param   array        $config   The config options
	 * @param   bool         $base64   The switch to decode base64 the script
	 *                                    default: true
	 * @param   bool         $dynamic  The switch to dynamic update the script
	 *                                    default: true
	 * @param   bool         $add      The switch to add to exiting instead of replace
	 *                                    default: false
	 *
	 * @return  bool    true on success
	 * @since 3.2.0
	 */
	public function set(&$script, string $first, ?string $second = null, ?string $third = null,
		array $config = [], bool $base64 = true, bool $dynamic = true, bool $add = false): bool
	{
		// only load if we have a string
		if (!StringHelper::check($script))
		{
			return false;
		}

		// init all needed arrays
		$this->initHub($first, $second, $third, $add);

		// prep the script string
		if ($base64 && $dynamic)
		{
			$script = $this->customcode->update(base64_decode($script));
		}
		elseif ($base64)
		{
			$script = base64_decode($script);
		}
		elseif ($dynamic) // this does not happen (just in-case)
		{
			$script = $this->customcode->update($script);
		}
		// check if we still have a string
		if (StringHelper::check($script))
		{
			// now load the placeholder snippet if needed
			if ($base64 || $dynamic)
			{
				$script = $this->gui->set($script, $config);
			}

			// add Dynamic HASHING option of a file/string
			$script = $this->hash->set($script);

			// add base64 locking option of a string
			$script = $this->base64->set($script);

			// load the script
			$this->setHub($script, $first, $second, $third, $add);

			return true;
		}

		return false;
	}

	/**
	 * Get the script from the customcode dispenser
	 *
	 * @param string       $first    The first key
	 * @param string       $second   The second key
	 * @param string       $prefix   The prefix to add in front of the script if found
	 * @param string|null  $note     The switch/note to add to the script
	 * @param bool         $unset    The switch to unset the value if found
	 * @param mixed|null   $default  The switch/string to use as default return if script not found
	 * @param string       $suffix   The suffix to add after the script if found
	 *
	 * @return  mixed  The string/script if found or the default value if not found
	 * @since 3.2.0
	 */
	public function get(string $first, string $second, string $prefix = '', ?string $note = null,
	                    bool $unset = false, $default = null, string $suffix = '')
	{
		// default is to return an empty string
		$script = '';
		// check if there is any custom script
		if (isset($this->hub[$first][$second])
			&& StringHelper::check(
				$this->hub[$first][$second]
			))
		{
			// add not if set
			if ($note)
			{
				$script .= $note;
			}
			// load the actual script
			$script .= $prefix . $this->placeholder->update_(
				(string) $this->hub[$first][$second]
			) . $suffix;
			// clear some memory
			if ($unset)
			{
				unset($this->hub[$first][$second]);
			}
		}
		// if not found return default
		if (!StringHelper::check($script) && $default)
		{
			return $default;
		}

		return $script;
	}

	/**
	 * Make sure the hub arrays are all set
	 *
	 * @param   string       $first    The first key
	 * @param   string|null  $second   The second key (if not set we use only first key)
	 * @param   string|null  $third    The third key (if not set we use only first and second key)
	 * @param   bool         $add      The switch to add to exiting instead of replace
	 *                                    default: false
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function initHub(string $first, ?string $second = null, ?string $third = null, bool $add = false)
	{
		if (!isset($this->hub[$first]))
		{
			$this->hub[$first] = ($second !== null || $add) ? ($second !== null ? [] : '') : [];
		}

		if ($second !== null && !isset($this->hub[$first][$second]))
		{
			$this->hub[$first][$second] = ($third !== null || $add) ? ($third !== null ? [] : '') : [];
		}

		if ($third !== null && !isset($this->hub[$first][$second][$third]))
		{
			$this->hub[$first][$second][$third] = $add ? '' : [];
		}
	}

	/**
	 * Set a script in the hub
	 *
	 * @param   string       $script   The script
	 * @param   string       $first    The first key
	 * @param   string|null  $second   The second key (if not set we use only first key)
	 * @param   string|null  $third    The third key (if not set we use only first and second key)
	 * @param   bool         $add      The switch to add to exiting instead of replace
	 *                                    default: false
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setHub(string $script, string $first, ?string $second = null, ?string $third = null, bool $add = false)
	{
		// Load the script
		if ($second !== null)
		{
			if ($third !== null)
			{
				$this->hub[$first][$second][$third] =
					$add ? $this->hub[$first][$second][$third] . $script : $script;
			}
			else
			{
				$this->hub[$first][$second] =
					$add ? $this->hub[$first][$second] . $script : $script;
			}
		}
		else
		{
			$this->hub[$first] =
				$add ? $this->hub[$first] . $script : $script;
		}
	}
}

