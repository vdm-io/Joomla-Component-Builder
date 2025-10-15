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
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherOrder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Dynamic Get Query Order
 * 
 * @since 5.1.2
 */
final class QueryOrder
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The OtherOrder Class.
	 *
	 * @var   OtherOrder
	 * @since 5.1.2
	 */
	protected OtherOrder $otherorder;

	/**
	 * The SiteMainGet Class.
	 *
	 * @var   SiteMainGet
	 * @since 5.1.2
	 */
	protected SiteMainGet $sitemainget;

	/**
	 * Constructor.
	 *
	 * @param Config        $config        The Config Class.
	 * @param OtherOrder    $otherorder    The OtherOrder Class.
	 * @param SiteMainGet   $sitemainget   The SiteMainGet Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, OtherOrder $otherorder,
		SiteMainGet $sitemainget)
	{
		$this->config = $config;
		$this->otherorder = $otherorder;
		$this->sitemainget = $sitemainget;
	}

	/**
	 * Get the ordering part of a query for a dynamic get.
	 *
	 * @param  array   $order  The ordering rules array (passed by reference).
	 * @param  string  $code   The code identifier (passed by reference).
	 * @param  string  $tab    The tab indentation.
	 *
	 * @return string  The generated ordering query part.
	 * @since  5.1.2
	 */
	public function get(array $order, string $code, string $tab = ''): string
	{
		if (empty($order) || empty($code))
		{
			return '';
		}

		$ordering = '';

		foreach ($order as $or)
		{
			if (empty($or['table_key']) || empty($or['direction']))
			{
				continue;
			}

			list($as, $field) = array_map(
				'trim',
				explode('.', (string) $or['table_key'])
			);

			// Determine ordering direction
			if ('RAND' === $or['direction'])
			{
				$string = "\$query->order('RAND()');";
			}
			else
			{
				$string = "\$query->order('" . $or['table_key'] . " " . $or['direction'] . "');";
			}

			// Sort placement logic
			if (
				$as === 'a' ||
				$this->sitemainget->exists($this->config->build_target . '.' . $code . '.' . $as)
			)
			{
				$ordering .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . $string;
			}
			else
			{
				$this->otherorder->set(
					$this->config->build_target . '.' . $code . '.' . $as . '.' . $field,
					PHP_EOL . Indent::_(2) . $string
				);
			}
		}

		return $ordering;
	}
}

