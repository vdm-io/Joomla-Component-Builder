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


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Adminview\Data as Admin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteEditView;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;


/**
 * Model Admin Views Class
 * 
 * @since 3.2.0
 */
class Adminviews
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Data Class.
	 *
	 * @var   Admin
	 * @since 3.2.0
	 */
	protected Admin $admin;

	/**
	 * The SiteEditView Class.
	 *
	 * @var   SiteEditView
	 * @since 3.2.0
	 */
	protected SiteEditView $siteeditview;

	/**
	 * The AdminFilterType Class.
	 *
	 * @var   AdminFilterType
	 * @since 3.2.0
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param Admin             $admin             The Data Class.
	 * @param SiteEditView      $siteeditview      The SiteEditView Class.
	 * @param AdminFilterType   $adminfiltertype   The AdminFilterType Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Admin $admin, SiteEditView $siteeditview, AdminFilterType $adminfiltertype)
	{
		$this->config = $config;
		$this->admin = $admin;
		$this->siteeditview = $siteeditview;
		$this->adminfiltertype = $adminfiltertype;
	}

	/**
	 * Set admin view data
	 *
	 * @param   object  $item  The extension data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->addadmin_views = (isset($item->addadmin_views)
			&& JsonHelper::check($item->addadmin_views))
			? json_decode((string) $item->addadmin_views, true) : null;

		if (ArrayHelper::check($item->addadmin_views))
		{
			$this->config->lang_target = 'admin';
			$this->config->build_target = 'admin';

			// sort the views according to order
			usort(
				$item->addadmin_views, function ($a, $b) {
					if ($a['order'] != 0 && $b['order'] != 0)
					{
						return $a['order'] <=> $b['order'];
					}
					elseif ($b['order'] != 0 && $a['order'] == 0)
					{
						return 1;
					}
					elseif ($a['order'] != 0 && $b['order'] == 0)
					{
						return 0;
					}

					return 1;
				}
			);

			// build the admin_views settings
			$item->admin_views = array_map(
				function ($array) {
					$array = array_map(
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

					// check if we must add to site
					if (isset($array['edit_create_site_view'])
						&& is_numeric($array['edit_create_site_view'])
						&& $array['edit_create_site_view'] > 0)
					{
						$this->siteeditview->set($array['adminview'], true);
						$this->config->lang_target = 'both';
					}

					// set the import/export option for this view
					if (isset($array['port']) && $array['port'])
					{
						$this->config->set('add_eximport', true);
					}

					// set the history tracking option for this view
					if (isset($array['history']) && $array['history'])
					{
						$this->config->set('set_tag_history', true);
					}

					// set the custom field integration for this view
					if (isset($array['joomla_fields']) && $array['joomla_fields'])
					{
						$this->config->set('set_joomla_fields', true);
					}

					// has become a legacy issue, can't remove this
					$array['view'] = $array['adminview'];

					// get the admin settings/data
					$array['settings'] = $this->admin->get(
						$array['view']
					);

					// set the filter option for this view | Side (old) [default for now]
					$this->adminfiltertype->set($array['settings']->name_list_code, 1);

					if (isset($array['filter'])
						&& is_numeric(
							$array['filter']
						) && $array['filter'] > 0)
					{
						$this->adminfiltertype->set($array['settings']->name_list_code,
								(int) $array['filter']);
					}

					return $array;

				}, array_values($item->addadmin_views)
			);
		}
	}
}

