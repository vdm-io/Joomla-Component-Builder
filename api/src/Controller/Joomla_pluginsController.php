<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Api\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filter\InputFilter;
use Joomla\CMS\MVC\Controller\ApiController;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Joomla_plugins Api Controller
 *
 * The read-only list resource of the joomla_plugins view. The item resource
 * of the joomla_plugin view carries the create, update and delete tasks.
 *
 * @since  4.0.0
 */
class Joomla_pluginsController extends ApiController
{
	/**
	 * The content type of the item.
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	protected $contentType = 'joomla_plugins';

	/**
	 * The default view for the display method.
	 *
	 * @var    string
	 * @since  3.0
	 */
	protected $default_view = 'joomla_plugins';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel|boolean  Model object on success; otherwise false on failure.
	 *
	 * @since   4.0.0
	 */
	public function getModel($name = '', $prefix = '', $config = [])
	{
		// The controller role selects its explicit native model.
		$name = 'joomla_plugins';

		// The API carries no request state for the model, as the form controller does not:
		// the id a save sets must never be replaced by a later read of the request.
		if (!array_key_exists('ignore_request', $config))
		{
			$config['ignore_request'] = true;
		}

		return parent::getModel($name, $prefix, $config);
	}

	/**
	 * Basic display of a list view
	 *
	 * @return  static  A \JControllerLegacy object to support chaining.
	 *
	 * @since   4.0.0
	 */
	public function displayList()
	{
		// Map the request filters onto the list model state.
		$filters = $this->input->get('filter', [], 'array');
		$this->modelState->set('filter.search', $this->cleanFilter($filters['search'] ?? ''));
		$this->modelState->set('filter.published', $this->cleanFilter($filters['published'] ?? ''));

		if (isset($filters['access']))
		{
			$this->modelState->set('filter.access', $this->cleanFilter($filters['access']));
		}

		if (isset($filters['class_extends']))
		{
			$this->modelState->set('filter.class_extends', $this->cleanFilter($filters['class_extends']));
		}

		if (isset($filters['joomla_plugin_group']))
		{
			$this->modelState->set('filter.joomla_plugin_group', $this->cleanFilter($filters['joomla_plugin_group']));
		}

		// Map the requested ordering onto the list model state.
		$list = $this->input->get('list', [], 'array');
		$ordering = [
			'id' => 'a.id',
			'published' => 'a.published',
			'ordering' => 'a.ordering',
			'created_by' => 'a.created_by',
			'modified_by' => 'a.modified_by',
			'access' => 'a.access',
			'system_name' => 'a.system_name',
			'class_extends' => 'g.name',
			'joomla_plugin_group' => 'h.name',
		];

		if (isset($list['ordering'], $ordering[$list['ordering']]))
		{
			$this->modelState->set('list.ordering', $ordering[$list['ordering']]);
		}

		if (isset($list['direction']) && in_array(strtolower((string) $list['direction']), ['asc', 'desc'], true))
		{
			$this->modelState->set('list.direction', strtolower((string) $list['direction']));
		}

		return parent::displayList();
	}

	/**
	 * The list resource does not serve one item.
	 *
	 * @param   integer  $id  The primary key to display.
	 *
	 * @return  static  A \JControllerLegacy object to support chaining.
	 *
	 * @throws  \RuntimeException
	 * @since   4.0.0
	 */
	public function displayItem($id = null)
	{
		throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 405);
	}

	/**
	 * The list resource is read-only.
	 *
	 * @return  void
	 *
	 * @throws  \RuntimeException
	 * @since   4.0.0
	 */
	public function add()
	{
		throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 405);
	}

	/**
	 * The list resource is read-only.
	 *
	 * @return  static  A \JControllerLegacy object to support chaining.
	 *
	 * @throws  \RuntimeException
	 * @since   4.0.0
	 */
	public function edit()
	{
		throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 405);
	}

	/**
	 * The list resource is read-only.
	 *
	 * @param   integer  $id  The primary key to delete item.
	 *
	 * @return  void
	 *
	 * @throws  \RuntimeException
	 * @since   4.0.0
	 */
	public function delete($id = null)
	{
		throw new \RuntimeException(Text::_('JLIB_APPLICATION_ERROR_ACCESS_FORBIDDEN'), 405);
	}

	/**
	 * Clean one request filter value, or each value of a multi select filter.
	 *
	 * @param   mixed  $value  The request value.
	 *
	 * @return  mixed  The clean string, or the array of clean strings.
	 *
	 * @since   4.0.0
	 */
	protected function cleanFilter($value)
	{
		$filter = InputFilter::getInstance();

		if (is_array($value))
		{
			$clean = [];

			foreach ($value as $one)
			{
				$clean[] = $filter->clean($one, 'STRING');
			}

			return $clean;
		}

		return $filter->clean($value, 'STRING');
	}
}
