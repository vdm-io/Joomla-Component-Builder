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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;

/**
 * Componentbuilder Search Item Model
 */
class ComponentbuilderModelSearch extends ItemModel
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_componentbuilder.search';

	/**
	 * Model user data.
	 *
	 * @var        strings
	 */
	protected $user;
	protected $userId;
	protected $guest;
	protected $groups;
	protected $levels;
	protected $app;
	protected $input;
	protected $uikitComp;

	/**
	 * @var object item
	 */
	protected $item;

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @since   1.6
	 *
	 * @return void
	 */
	protected function populateState()
	{
		$this->app = Factory::getApplication();
		$this->input = $this->app->input;
		// Get the item main id
		$id = $this->input->getInt('id', null);
		$this->setState('search.id', $id);

		// Load the parameters.
		parent::populateState();
	}

	/**
	 * Method to get article data.
	 *
	 * @param   integer  $pk  The id of the article.
	 *
	 * @return  mixed  Menu item data object on success, false on failure.
	 */
	public function getItem($pk = null)
	{
		$this->user    = Factory::getUser();
		// check if this user has permission to access item
		if (!$this->user->authorise('search.access', 'com_componentbuilder'))
		{
			$app = Factory::getApplication();
			$app->enqueueMessage(Text::_('Not authorised!'), 'error');
			// redirect away if not a correct to cPanel/default view
			$app->redirect('index.php?option=com_componentbuilder');
			return false;
		}
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->initSet = true;

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('search.id');

		$pk = $this->userId;

		if ($this->_item === null)
		{
			$this->_item = [];
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				// Get a db connection.
				$db = Factory::getDbo();

				// Create a new query object.
				$query = $db->getQuery(true);

				// Get data
				// load the tables and components
				$data = ['tables' => SearchFactory::_('Table')->tables(), 'components' => $this->getComponents()];


				if (empty($data))
				{
					$app = Factory::getApplication();
					// If no data is found redirect to default page and show warning.
					$app->enqueueMessage(Text::_('COM_COMPONENTBUILDER_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
					$app->redirect('index.php?option=com_componentbuilder');
					return false;
				}

				// set data object to item.
				$this->_item[$pk] = $data;
			}
			catch (Exception $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					JError::raiseError(404, $e->getMessage());
				}
				else
				{
					$this->setError($e);
					$this->_item[$pk] = false;
				}
			}
		}

		return $this->_item[$pk];
	}

	/**
	 * Custom Method
	 *
	 * @return mixed  item data object on success, false on failure.
	 *
	 */
	public function getUrlValues()
	{

		if (!isset($this->initSet) || !$this->initSet)
		{
			$this->user = Factory::getUser();
			$this->userId = $this->user->get('id');
			$this->guest = $this->user->get('guest');
			$this->groups = $this->user->get('groups');
			$this->authorisedGroups = $this->user->getAuthorisedGroups();
			$this->levels = $this->user->getAuthorisedViewLevels();
			$this->initSet = true;
		}
		// Get a db connection.
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get data
		$data = [
			'type_search' => SearchFactory::_('Config')->get('type_search', 1),
			'search_value' => SearchFactory::_('Config')->get('search_value', ''),
			'replace_value' => SearchFactory::_('Config')->get('replace_value', ''),
			'match_case' => SearchFactory::_('Config')->get('match_case', 0),
			'whole_word' => SearchFactory::_('Config')->get('whole_word', 0),
			'regex_search' => SearchFactory::_('Config')->get('regex_search', 0),
			'table_name' => SearchFactory::_('Config')->get('table_name', -1)
		];

		if (empty($data))
		{
			return false;
		}

		// return data object.
		return $data;
	}

	/**
	 * Get the uikit needed components
	 *
	 * @return mixed  An array of objects on success.
	 *
	 */
	public function getUikitComp()
	{
		if (isset($this->uikitComp) && UtilitiesArrayHelper::check($this->uikitComp))
		{
			return $this->uikitComp;
		}
		return false;
	}


	/**
	 * Get all components in the system
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	public function getComponents(): array
	{
		// Get a db connection.
		$db = $this->getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select only id and system name
		$query->select($db->quoteName(array('id', 'system_name'),array('id', 'name')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));

		// only the active components
		$query->where($db->quoteName('published') . ' = 1');

		// Order it by the ordering field.
		$query->order('modified DESC');
		$query->order('created DESC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// return the result
		return $db->loadObjectList();
	}

}
