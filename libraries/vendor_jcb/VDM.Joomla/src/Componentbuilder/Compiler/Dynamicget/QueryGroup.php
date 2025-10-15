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
use VDM\Joomla\Componentbuilder\Compiler\Builder\OtherGroup;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteMainGet;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;


/**
 * Dynamic Get Query Group
 * 
 * @since 5.1.2
 */
final class QueryGroup
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The OtherGroup Class.
	 *
	 * @var   OtherGroup
	 * @since 5.1.2
	 */
	protected OtherGroup $othergroup;

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
	 * @param OtherGroup    $othergroup    The OtherGroup Class.
	 * @param SiteMainGet   $sitemainget   The SiteMainGet Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, OtherGroup $othergroup,
		SiteMainGet $sitemainget)
	{
		$this->config = $config;
		$this->othergroup = $othergroup;
		$this->sitemainget = $sitemainget;
	}

	/**
	 * Generate GROUP BY code for the query.
	 *
	 * @param  array   $group  The grouping configuration array.
	 * @param  string  $code   The component code.
	 * @param  string  $tab    The indentation tab characters.
	 *
	 * @return string  The generated GROUP BY code.
	 * @since  5.1.2
	 */
	public function get(array $group, string $code, string $tab = ''): string
	{
		if (empty($group) || empty($code))
		{
			return '';
		}

		$grouping = '';

		foreach ($group as $gr)
		{
			if (empty($gr['table_key']))
			{
				continue;
			}

			list($as, $field) = array_map(
				'trim',
				explode('.', (string) $gr['table_key'])
			);

			// Build the GROUP BY string
			$string = "\$query->group('" . $gr['table_key'] . "');";

			// Determine where to place the GROUP BY
			if (
				$as === 'a' ||
				$this->sitemainget ->exists($this->config->build_target . '.' . $code . '.' . $as)
			)
			{
				$grouping .= PHP_EOL
					. Indent::_(1) . $tab
					. Indent::_(1) . $string;
			}
			else
			{
				$this->othergroup->set(
					$this->config->build_target . '.' . $code . '.' . $as . '.' . $field,
					PHP_EOL . Indent::_(2) . $string
				);
			}
		}

		return $grouping;
	}
}

