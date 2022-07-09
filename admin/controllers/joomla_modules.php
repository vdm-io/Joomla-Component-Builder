<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @gitea      Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;

/**
 * Joomla_modules Admin Controller
 */
class ComponentbuilderControllerJoomla_modules extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_JOOMLA_MODULES';

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JModelLegacy  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Joomla_module', $prefix = 'ComponentbuilderModel', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function exportData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if export is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_module.export', 'com_componentbuilder') && $user->authorise('core.export', 'com_componentbuilder'))
		{
			// Get the input
			$input = JFactory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			$pks = ArrayHelper::toInteger($pks);
			// Get the model
			$model = $this->getModel('Joomla_modules');
			// get the data to export
			$data = $model->getExportData($pks);
			if (ComponentbuilderHelper::checkArray($data))
			{
				// now set the data to the spreadsheet
				$date = JFactory::getDate();
				ComponentbuilderHelper::xls($data,'Joomla_modules_'.$date->format('jS_F_Y'),'Joomla modules exported ('.$date->format('jS F, Y').')','joomla modules');
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_EXPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_modules', false), $message, 'error');
		return;
	}


	public function importData()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// check if import is allowed for this user.
		$user = JFactory::getUser();
		if ($user->authorise('joomla_module.import', 'com_componentbuilder') && $user->authorise('core.import', 'com_componentbuilder'))
		{
			// Get the import model
			$model = $this->getModel('Joomla_modules');
			// get the headers to import
			$headers = $model->getExImPortHeaders();
			if (ComponentbuilderHelper::checkObject($headers))
			{
				// Load headers to session.
				$session = JFactory::getSession();
				$headers = json_encode($headers);
				$session->set('joomla_module_VDM_IMPORTHEADERS', $headers);
				$session->set('backto_VDM_IMPORT', 'joomla_modules');
				$session->set('dataType_VDM_IMPORTINTO', 'joomla_module');
				// Redirect to import view.
				$message = JText::_('COM_COMPONENTBUILDER_IMPORT_SELECT_FILE_FOR_JOOMLA_MODULES');
				$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=import', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = JText::_('COM_COMPONENTBUILDER_IMPORT_FAILED');
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=joomla_modules', false), $message, 'error');
		return;
	}

	public function getSnippets()
	{
		// Check for request forgeries
		JSession::checkToken() or die(JText::_('JINVALID_TOKEN'));
		// redirect to the import snippets custom admin view
		$this->setRedirect(JRoute::_('index.php?option=com_componentbuilder&view=get_snippets', false));
		return;
	}
}
