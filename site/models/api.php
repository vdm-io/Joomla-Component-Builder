<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2019 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Componentbuilder Api Model
 */
class ComponentbuilderModelApi extends JModelItem
{
	/**
	 * Model context string.
	 *
	 * @var        string
	 */
	protected $_context = 'com_componentbuilder.api';

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
		$this->app = JFactory::getApplication();
		$this->input = $this->app->input;
		// Get the itme main id
		$id = $this->input->getInt('id', null);
		$this->setState('api.id', $id);

		// Load the parameters.
		$params = $this->app->getParams();
		$this->setState('params', $params);
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
		$this->user = JFactory::getUser();
		$this->userId = $this->user->get('id');
		$this->guest = $this->user->get('guest');
		$this->groups = $this->user->get('groups');
		$this->authorisedGroups = $this->user->getAuthorisedGroups();
		$this->levels = $this->user->getAuthorisedViewLevels();
		$this->initSet = true;

		$pk = (!empty($pk)) ? $pk : (int) $this->getState('api.id');
		
		if ($this->_item === null)
		{
			$this->_item = array();
		}

		if (!isset($this->_item[$pk]))
		{
			try
			{
				// Get a db connection.
				$db = JFactory::getDbo();

				// Create a new query object.
				$query = $db->getQuery(true);

				// Get from #__componentbuilder_joomla_component as a
				$query->select($db->quoteName(
			array('a.ordering'),
			array('ordering')));
				$query->from($db->quoteName('#__componentbuilder_joomla_component', 'a'));

				// Reset the query using our newly populated query object.
				$db->setQuery($query);
				// Load the results as a stdClass object.
				$data = $db->loadObject();

				if (empty($data))
				{
					$app = JFactory::getApplication();
					// If no data is found redirect to default page and show warning.
					$app->enqueueMessage(JText::_('COM_COMPONENTBUILDER_NOT_FOUND_OR_ACCESS_DENIED'), 'warning');
					$app->redirect(JURI::root());
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
					JError::raiseWaring(404, $e->getMessage());
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
	 * Get the uikit needed components
	 *
	 * @return mixed  An array of objects on success.
	 *
	 */
	public function getUikitComp()
	{
		if (isset($this->uikitComp) && ComponentbuilderHelper::checkArray($this->uikitComp))
		{
			return $this->uikitComp;
		}
		return false;
	}

	public $messages = array();
	public $model;

	protected $compiler;

	public function getTranslationLinkedComponents()
	{
		// Get a db connection.
		$db = JFactory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		// for now we only have crowdin
		$query->select($db->quoteName(array('id', 'translation_tool', 'crowdin_account_api_key', 'crowdin_project_api_key' ,'crowdin_project_identifier', 'crowdin_username')));
		$query->from($db->quoteName('#__componentbuilder_joomla_component'));
		$query->where($db->quoteName('translation_tool') . ' > 0');
		$query->where($db->quoteName('published') . ' >= 1');
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			return $db->loadObjectList();
		}
		return false;
	}

	public function translate($component)
	{
		$this->messages[] = JText::_('COM_COMPONENTBUILDER_TRANSLATOR_MODULE_NOT_READYBR_THIS_AREA_IS_STILL_UNDER_PRODUCTION_HOPEFULLY_WITH_NEXT_UPDATE');
		return false;
	}

	public function compileInstall($component)
	{
		$values = array(
			'version' => 3,
			'install' => 1,
			'component' => 0,
			'backup' => 0,
			'repository' => 0,
			'placeholders' => 2,
			'debuglinenr' => 2,
			'minify' => 2
		);
		// set the values
		foreach ($values as $key => $val)
		{
			if (isset($component->{$key}))
			{
				$values[$key] = $component->{$key};
			}
		}
		// make sure we have a component
		if (isset($values['component']) && $values['component'] > 1)
		{
			// make sure the component is published
			$published = ComponentbuilderHelper::getVar('joomla_component', (int) $values['component'], 'id', 'published');
			// make sure the component is checked in
			$checked_out = ComponentbuilderHelper::getVar('joomla_component', (int) $values['component'], 'id', 'checked_out');
			if (1 == $published && $checked_out == 0)
			{
				// start up Compiler
				$this->compiler = new Compiler($values);
				if($this->compiler)
				{
					// component was compiled
					$this->messages[] = JText::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_SUCCESSFULLY_COMPILED', $this->compiler->componentFolderName);
					// get compiler model to run the installer
					$model = ComponentbuilderHelper::getModel('compiler', JPATH_COMPONENT_ADMINISTRATOR);
					// now install components
					if (1 == $values['install'] && $model->install($this->compiler->componentFolderName.'.zip'))
					{
						// component was installed
						$this->messages[] = JText::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_SUCCESSFULLY_INSTALLED_AND_REMOVED_FROM_TEMP_FOLDER', $this->compiler->componentFolderName);
					}
					elseif (1 != $values['install'])
					{
						jimport('joomla.filesystem.file');
						$config = JFactory::getConfig();
						$package = $config->get('tmp_path') . '/' . $this->compiler->componentFolderName.'.zip';
						// just remove from temp
						if (JFile::delete($package) && !is_file($package))
						{
							// component was installed
							$this->messages[] = JText::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_NOT_INSTALLED_BY_YOUR_REQUEST_AND_IS_ALSO_REMOVED_FROM_TEMP_FOLDER', $this->compiler->componentFolderName);
						}
						else
						{
							// component was not installed
							$this->messages[] = JText::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_NOT_INSTALLED_BY_YOUR_REQUEST_AND_IS_STILL_IN_THE_TEMP_FOLDER', $this->compiler->componentFolderName);
						}
					}
					else
					{
						// component was not installed
						$this->messages[] = JText::sprintf('COM_COMPONENTBUILDER_THE_S_WAS_NOT_INSTALLED_AND_IS_STILL_IN_THE_TEMP_FOLDER', $this->compiler->componentFolderName);
					}
					// get all the messages from application (TODO)
					return true;
				}
				// set that the component was not found
				$this->messages[] = JText::_('COM_COMPONENTBUILDER_COMPONENT_DID_NOT_COMPILE');
				return false;
			}
			// set that the component was not found
			$this->messages[] = JText::_('COM_COMPONENTBUILDER_COMPONENT_IS_NOT_PUBLISHED_OR_IS_CHECKED_OUT');
			return false;
		}
		// set that the component was not found
		$this->messages[] = JText::_('COM_COMPONENTBUILDER_COMPONENT_WAS_NOT_FOUND');
		return false;
	}
}
