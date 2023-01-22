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

namespace VDM\Joomla\Componentbuilder\Compiler\Model;


use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Customview\Data as Customview;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Model Site Views Class
 * 
 * @since 3.2.0
 */
class Siteviews
{
	/**
	 * Component Site view Data
	 *
	 * @var    Customview
	 * @since 3.2.0
	 **/
	protected Customview $site;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Constructor
	 *
	 * @param Customview|null    $site        The site view data object.
	 * @param Config|null        $config      The compiler config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Customview $site = null, ?Config $config = null)
	{
		$this->site = $site ?: Compiler::_('Customview.Data');
		$this->config = $config ?: Compiler::_('Config');
	}

	/**
	 * Set site view data
	 *
	 * @param   object  $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addsite_views = (isset($item->addsite_views)
			&& JsonHelper::check($item->addsite_views))
			? json_decode((string) $item->addsite_views, true) : null;

		if (ArrayHelper::check($item->addsite_views))
		{
			$this->config->lang_target = 'site';
			$this->config->build_target = 'site';

			// build the site_views settings
			$item->site_views = array_map(
				function ($array) {
					// has become a legacy issue, can't remove this
					$array['view']     = $array['siteview'];
					$array['settings'] = $this->site->get(
						$array['view']
					);

					return array_map(
						function ($value) {
							if (!ArrayHelper::check($value)
								&& !ObjectHelper::check($value)
								&& strval($value) === strval(intval($value)))
							{
								return (int) $value;
							}

							return $value;
						}, $array
					);
				}, array_values($item->addsite_views)
			);

			// unset original value
			unset($item->addsite_views);
		}
	}

}

