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
 * Help_documents Api Controller
 *
 * The read-only list resource of the help_documents view. The item resource
 * of the help_document view carries the create, update and delete tasks.
 *
 * @since  4.0.0
 */
class Help_documentsController extends ApiController
{
	/**
	 * The content type of the item.
	 *
	 * @var    string
	 * @since  4.0.0
	 */
	protected $contentType = 'help_documents';

	/**
	 * The default view for the display method.
	 *
	 * @var    string
	 * @since  3.0
	 */
	protected $default_view = 'help_documents';

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
		$name = 'help_documents';

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

		if (isset($filters['type']))
		{
			$this->modelState->set('filter.type', $this->cleanFilter($filters['type']));
		}

		if (isset($filters['location']))
		{
			$this->modelState->set('filter.location', $this->cleanFilter($filters['location']));
		}

		if (isset($filters['admin_view']))
		{
			$this->modelState->set('filter.admin_view', $this->cleanFilter($filters['admin_view']));
		}

		if (isset($filters['site_view']))
		{
			$this->modelState->set('filter.site_view', $this->cleanFilter($filters['site_view']));
		}

		// Map the requested ordering onto the list model state.
		$list = $this->input->get('list', [], 'array');
		$ordering = [
			'id' => 'a.id',
			'published' => 'a.published',
			'ordering' => 'a.ordering',
			'created_by' => 'a.created_by',
			'modified_by' => 'a.modified_by',
			'title' => 'a.title',
			'type' => 'a.type',
			'location' => 'a.location',
			'admin_view' => 'a.admin_view',
			'site_view' => 'a.site_view',
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
