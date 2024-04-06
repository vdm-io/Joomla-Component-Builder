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
 * Model Custom Admin Views Class
 * 
 * @since 3.2.0
 */
class Customadminviews
{
	/**
	 * Component custom admin view Data
	 *
	 * @var    Customview
	 * @since 3.2.0
	 **/
	protected Customview $customadmin;

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
	 * @param Customview|null    $customadmin    The custom admin view data object.
	 * @param Config|null        $config         The compiler config object.
	 *
	 * @since 3.2.0
	 */
	public function __construct(?Customview $customadmin = null, ?Config $config = null)
	{
		$this->customadmin = $customadmin ?: Compiler::_('Customview.Data');
		$this->config = $config ?: Compiler::_('Config');
	}

	/**
	 * Set custom admin view data
	 *
	 * @param   object  $item  The item data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addcustom_admin_views = (isset($item->addcustom_admin_views)
			&& JsonHelper::check($item->addcustom_admin_views))
			? json_decode((string) $item->addcustom_admin_views, true) : null;

		if (ArrayHelper::check($item->addcustom_admin_views))
		{
			$this->config->lang_target = 'admin';
			$this->config->build_target = 'custom_admin';

			// build the site_views settings
			$item->custom_admin_views = array_map(
				function ($array) {
					// has become a legacy issue, can't remove this
					$array['view'] = $array['customadminview'];
					$array['settings'] = $this->customadmin->get(
						$array['view'], 'custom_admin_view'
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
				}, array_values($item->addcustom_admin_views)
			);

			// unset original value
			unset($item->addcustom_admin_views);
		}
	}

}

