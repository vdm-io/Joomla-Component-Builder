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
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\User\User;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder List Model for Get_snippets
 *
 * @since  1.6
 */
class Get_snippetsModel extends ListModel
{
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
		'administrator/components/com_componentbuilder/assets/css/get_snippets.css'
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
	 * Constructor
	 *
	 * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   ?MVCFactoryInterface  $factory  The factory.
	 *
	 * @since   1.6
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
	 * Method to build an SQL query to load the list data.
	 *
	 * @return  string  An SQL query
	 * @since   1.6
	 */
	protected function getListQuery()
	{
		// Make sure all records load, since no pagination allowed.
		$this->setState('list.limit', 0);
		// Get a db connection.
		$db = $this->getDatabase();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Get from #__componentbuilder_snippet as a
		$query->select($db->quoteName(
			array('a.id','a.heading','a.name','a.url','a.created','a.modified'),
			array('id','heading','name','url','created','modified')));
		$query->from($db->quoteName('#__componentbuilder_snippet', 'a'));

		// Get from #__componentbuilder_snippet_type as b
		$query->select($db->quoteName(
			array('b.name'),
			array('type')));
		$query->join('LEFT', ($db->quoteName('#__componentbuilder_snippet_type', 'b')) . ' ON (' . $db->quoteName('a.type') . ' = ' . $db->quoteName('b.id') . ')');

		// Get from #__componentbuilder_library as c
		$query->select($db->quoteName(
			array('c.name'),
			array('library')));
		$query->join('LEFT', ($db->quoteName('#__componentbuilder_library', 'c')) . ' ON (' . $db->quoteName('a.library') . ' = ' . $db->quoteName('c.id') . ')');

		// return the query object
		return $query;
	}

	/**
	 * Method to get an array of data items.
	 *
	 * @return  mixed  An array of data items on success, false on failure.
	 * @since   1.6
	 */
	public function getItems()
	{
		$user = $this->user;
		// check if this user has permission to access items
		if (!$user->authorise('get_snippets.access', 'com_componentbuilder'))
		{
			$this->app->enqueueMessage(Text::_('Not authorised!'), 'error');
			// redirect away if not a correct to default view
			$this->app->redirect('index.php?option=com_componentbuilder');
			return false;
		}
		// load parent items
		$items = parent::getItems();

		// Get the global params
		$globalParams = ComponentHelper::getParams('com_componentbuilder', true);

		// Insure all item fields are adapted where needed.
		if (UtilitiesArrayHelper::check($items))
		{
			foreach ($items as $nr => &$item)
			{
				// Always create a slug for sef URL's
				$item->slug = ($item->id ?? '0') . (isset($item->alias) ? ':' . $item->alias : '');
			}
		}

		// return items
		return $items;
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
}
