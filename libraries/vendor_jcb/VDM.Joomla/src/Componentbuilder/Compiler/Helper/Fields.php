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

namespace VDM\Joomla\Componentbuilder\Compiler\Helper;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Factory as CFactory;


/**
 * Fields class
 * 
 * @since 3.2.0
 * @deprecated 3.3
 */
class Fields
{
	/**
	 * The app
	 *
	 * @var     object
	 * @since   3.2.0
	 */
	protected $app;

	/**
	 * Constructor
	 *
	 * @since   3.2.0
	 */
	public function __construct()
	{
		// load application
		$this->app = Factory::getApplication();

		return true;
	}

	/**
	 * This is just to get the code.
	 * Don't use this to build the field
	 *
	 * @param   array  $custom  The field complete data set
	 *
	 * @return  array with the code
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.Field.CustomFieldCode service.
	 */
	public function getCustomFieldCode($custom)
	{
		return CFactory::_('Architecture.Field.CustomFieldCode')->get($custom);
	}

	/**
	 * set the Filter Field set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterSet service.
	 */
	public function setFieldFilterSet(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.FilterSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set the Filter List set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterListSet service.
	 */
	public function setFieldFilterListSet(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.FilterListSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set the Filter Field set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterSet service.
	 */
	public function setFieldFilterSetJ3(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.J3.FilterSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set the Filter List set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterListSet service.
	 */
	public function setFieldFilterListSetJ3(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.J3.FilterListSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set the Filter Field set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterSet service.
	 */
	public function setFieldFilterSetJ4(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.Shared.FilterSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set the Filter List set of a view
	 *
	 * @param   string  $nameSingleCode  The single view name
	 * @param   string  $nameListCode    The list view name
	 *
	 * @return  string The fields set in xml
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterListSet service.
	 */
	public function setFieldFilterListSetJ4(&$nameSingleCode, &$nameListCode)
	{
		return CFactory::_('Architecture.AdminViews.Shared.FilterListSet')
			->get($nameSingleCode, $nameListCode);
	}

	/**
	 * set Custom Field for Filter
	 *
	 * @param   string  $getOptions  The get options php string/code
	 * @param   array   $filter      The filter details
	 *
	 * @return  void
	 *
	 * @since   3.2.0
	 * @deprecated 6.1.7 Use the Architecture.AdminViews.FilterFieldFile service.
	 */
	public function setFilterFieldFile($getOptions, $filter)
	{
		CFactory::_('Architecture.AdminViews.FilterFieldFile')
			->set($getOptions, $filter);
	}
}

