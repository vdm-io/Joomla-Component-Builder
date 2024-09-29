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
namespace VDM\Component\Componentbuilder\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\MVC\Model\ItemModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\User\User;
use Joomla\Input\Input;
use Joomla\Utilities\ArrayHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\CMS\Helper\TagsHelper;
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Search Item Model
 *
 * @since  1.6
 */
class SearchModel extends ItemModel
{
	/**
	 * Model context string.
	 *
	 * @var     string
	 * @since   1.6
	 */
	protected $_context = 'com_componentbuilder.search';

	/**
	 * Represents the current user object.
	 *
	 * @var   User  The user object representing the current user.
	 * @since 3.2.0
	 */
	protected User $user;

	/**
	 * The unique identifier of the current user.
	 *
	 * @var   int|null  The ID of the current user.
	 * @since 3.2.0
	 */
	protected ?int $userId;

	/**
	 * Flag indicating whether the current user is a guest.
	 *
	 * @var   int  1 if the user is a guest, 0 otherwise.
	 * @since 3.2.0
	 */
	protected int $guest;

	/**
	 * An array of groups that the current user belongs to.
	 *
	 * @var   array|null  An array of user group IDs.
	 * @since 3.2.0
	 */
	protected ?array $groups;

	/**
	 * An array of view access levels for the current user.
	 *
	 * @var   array|null  An array of access level IDs.
	 * @since 3.2.0
	 */
	protected ?array $levels;

	/**
	 * The application object.
	 *
	 * @var   CMSApplicationInterface  The application instance.
	 * @since 3.2.0
	 */
	protected CMSApplicationInterface $app;

	/**
	 * The input object, providing access to the request data.
	 *
	 * @var   Input  The input object.
	 * @since 3.2.0
	 */
	protected Input $input;

	/**
	 * The styles array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $styles = [
		'administrator/components/com_componentbuilder/assets/css/admin.css',
		'administrator/components/com_componentbuilder/assets/css/search.css'
 	];

	/**
	 * The scripts array.
	 *
	 * @var    array
	 * @since  4.3
	 */
	protected array $scripts = [
		'administrator/components/com_componentbuilder/assets/js/admin.js'
 	];

	/**
	 * A custom property for UI Kit components.
	 *
	 * @var   mixed  Property for storing UI Kit component-related data or objects.
	 * @since 3.2.0
	 */
	protected $uikitComp = [];

	/**
	 * @var     object item
	 * @since   1.6
	 */
	protected $item;

	/**
	 * Constructor
	 *
	 * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   ?MVCFactoryInterface  $factory  The factory.
	 *
	 * @since   3.0
	 * @throws  \Exception
	 */
	public function __construct($config = [], MVCFactoryInterface $factory = null)
	{
		parent::__construct($config, $factory);

		$this->app ??= Factory::getApplication();
		$this->input ??= $this->app->getInput();

		// Set the current user for authorisation checks (for those calling this model directly)
		$this->user ??= $this->getCurrentUser();
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();

		// will be removed
		$this->initSet = true;
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function populateState()
	{
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
	 * @since   1.6
	 */
	public function getItem($pk = null)
	{
		// check if this user has permission to access item
		if (!$this->user->authorise('search.access', 'com_componentbuilder'))
		{
			$this->app->enqueueMessage(Text::_('Not authorised!'), 'error');
			// redirect away if not a correct to cPanel/default view
			$this->app->redirect('index.php?option=com_componentbuilder');
			return false;
		}

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
				$db = $this->getDatabase();

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
			catch (\Exception $e)
			{
				if ($e->getCode() == 404)
				{
					// Need to go thru the error handler to allow Redirect to work.
					throw $e;
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
	 * Method to get the styles that have to be included on the view
	 *
	 * @return  array    styles files
	 * @since   4.3
	 */
	public function getStyles(): array
	{
		return $this->styles;
	}

	/**
	 * Method to set the styles that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setStyles(string $path): void
	{
		$this->styles[] = $path;
	}

	/**
	 * Method to get the script that have to be included on the view
	 *
	 * @return  array    script files
	 * @since   4.3
	 */
	public function getScripts(): array
	{
		return $this->scripts;
	}

	/**
	 * Method to set the script that have to be included on the view
	 *
	 * @return  void
	 * @since   4.3
	 */
	public function setScript(string $path): void
	{
		$this->scripts[] = $path;
	}

	/**
	 * Custom Method
	 *
	 * @return mixed  item data object on success, false on failure.
	 *
	 */
	public function getUrlValues()
	{
		// Get a db connection.
		$db = $this->getDatabase();

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
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function getComponents(): ?array
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
		return $db->loadObjectList() ?? null;
	}
}
