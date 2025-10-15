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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDynamicGet;
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherJoin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\GetAsLookup;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\JoinStructure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Dynamic Get Custom Join
 * 
 * @since 5.1.2
 */
final class CustomJoin
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The SiteDynamicGet Class.
	 *
	 * @var   SiteDynamicGet
	 * @since 5.1.2
	 */
	protected SiteDynamicGet $sitedynamicget;

	/**
	 * The OtherJoin Class.
	 *
	 * @var   OtherJoin
	 * @since 5.1.2
	 */
	protected OtherJoin $otherjoin;

	/**
	 * The GetAsLookup Class.
	 *
	 * @var   GetAsLookup
	 * @since 5.1.2
	 */
	protected GetAsLookup $getaslookup;

	/**
	 * The JoinStructure Class.
	 *
	 * @var   JoinStructure
	 * @since 5.1.2
	 */
	protected JoinStructure $joinstructure;

	/**
	 * Constructor.
	 *
	 * @param Config           $config           The Config Class.
	 * @param SiteDynamicGet   $sitedynamicget   The SiteDynamicGet Class.
	 * @param OtherJoin        $otherjoin        The OtherJoin Class.
	 * @param GetAsLookup      $getaslookup      The GetAsLookup Class.
	 * @param JoinStructure    $joinstructure    The JoinStructure Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, SiteDynamicGet $sitedynamicget,
		OtherJoin $otherjoin, GetAsLookup $getaslookup,
		JoinStructure $joinstructure)
	{
		$this->config = $config;
		$this->sitedynamicget = $sitedynamicget;
		$this->otherjoin = $otherjoin;
		$this->getaslookup = $getaslookup;
		$this->joinstructure = $joinstructure;
	}

	/**
	 * Get the dynamic get custom join code.
	 *
	 * @param  array   $gets      The array of join definitions.
	 * @param  string  $string    The target variable name in generated code.
	 * @param  string  $code      The code identifier for the join.
	 * @param  array   $asBucket  The array of already processed join aliases.
	 * @param  string  $tab       The indentation tab string for formatting (optional).
	 *
	 * @return string  The generated custom join code block or an empty string.
	 * @since  5.1.2
	 */
	public function get(array $gets, string $string, string $code, array $asBucket, string $tab = ''): string
	{
		if (empty($gets) || empty($string) || empty($code))
		{
			return '';
		}

		$customJoin = '';

		foreach ($gets as $get)
		{
			// Retrieve join structure
			$default = $this->joinstructure->get($get, $code);

			if ($default === null)
			{
				continue;
			}

			if ($this->check($default, $get, $asBucket))
			{
				// Build 'other join' string
				$otherJoin  = PHP_EOL . Indent::_(1) . Placefix::_h('TAB')
					. Indent::_(1) . '//' . Line::_( __LINE__, __CLASS__)
					. ' set ' . $default['valueName'] . ' to the '
					. Placefix::_h('STRING') . ' object.';

				$otherJoin .= PHP_EOL . Indent::_(1) . Placefix::_h('TAB')
					. Indent::_(1) . Placefix::_h('STRING') . '->'
					. $default['valueName'] . ' = $this->get'
					. $default['methodName'] . '(' . Placefix::_h('STRING') . '->'
					. $this->getaslookup
						->get($get['key'] . '.' . $get['on_field'], 'Error')
					. ');';

				$join_field_ = $this->sitedynamicget->get(
						$this->config->build_target .
						'.' . $default['code'] . '.' . $default['as'] . '.' . $default['join_field'],
						'ZZZ'
					);

				// Store in other join collection
				$this->otherjoin->add(
					$this->config->build_target .
					'.' . $default['code'] . '.' . $join_field_ . '.' . $default['valueName'],
					$otherJoin,
					false
				);
			}
			else
			{
				// Build custom join string
				$customJoin .= PHP_EOL . Indent::_(1) . $tab
					. Indent::_(1) . '//' . Line::_( __LINE__, __CLASS__)
					. ' set ' . $default['valueName'] . ' to the '
					. $string . ' object.';

				$customJoin .= PHP_EOL . Indent::_(1) . $tab
					. Indent::_(1) . $string . '->'
					. $default['valueName'] . ' = $this->get'
					. $default['methodName'] . '(' . $string . '->'
					. $this->getaslookup->get($get['key'] . '.' . $get['on_field'], 'Error')
					. ');';
			}
		}

		return $customJoin;
	}

	/**
	 * Determine whether a join should be processed as a separate join.
	 *
	 * @param  array  $default   The join structure details (passed by reference).
	 * @param  array  $get       The current join definition (passed by reference).
	 * @param  array  $asBucket  The list of already processed join aliases (passed by reference).
	 *
	 * @return bool  True if the join should be processed separately, false otherwise.
	 * @since  5.1.2
	 */
	public function check(array $default, array $get, array $asBucket): bool
	{
		// Extract alias from on_field
		list($aJoin) = explode('.', (string) $get['on_field']);

		// If alias already in bucket, skip
		if (in_array($aJoin, $asBucket))
		{
			return false;
		}

		// Check if join exists in dynamic config
		if ($this->sitedynamicget->exists(
			$this->config->build_target . '.' . $default['code'] . '.' .
			$default['as'] . '.' . $default['join_field']
		))
		{
			return true;
		}

		return false;
	}
}

