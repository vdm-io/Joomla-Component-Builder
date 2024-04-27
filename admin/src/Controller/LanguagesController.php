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
namespace VDM\Component\Componentbuilder\Administrator\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Languages Admin Controller
 *
 * @since  1.6
 */
class LanguagesController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_LANGUAGES';

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  \Joomla\CMS\MVC\Model\BaseDatabaseModel
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Language', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function buildLanguages()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// check if user has the right
		$user = Factory::getUser();
		if($user->authorise('core.create', 'com_componentbuilder'))
		{
			// get the model
			$model = $this->getModel('languages');
			if ($model->buildLanguages())
			{
				// set success message
				$message = '<h1>'.Text::_('COM_COMPONENTBUILDER_IMPORT_SUCCESS').'</h1>';
				$message .= '<p>'.Text::_('COM_COMPONENTBUILDER_ALL_THE_LANGUAGES_FOUND_IN_JOOMLA_WERE_SUCCESSFULLY_IMPORTED').'</p>';
				// set redirect
				$redirect_url = Route::_('index.php?option=com_componentbuilder&view=languages', false);
				$this->setRedirect($redirect_url, $message);
				return true;
			}
		}
		// set redirect
		$redirect_url = Route::_('index.php?option=com_componentbuilder&view=languages', false);
		$this->setRedirect($redirect_url);
		return false;
	}
}