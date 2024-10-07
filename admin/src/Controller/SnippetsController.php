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
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Snippets Admin Controller
 *
 * @since  1.6
 */
class SnippetsController extends AdminController
{
	/**
	 * The prefix to use with controller messages.
	 *
	 * @var    string
	 * @since  1.6
	 */
	protected $text_prefix = 'COM_COMPONENTBUILDER_SNIPPETS';

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
	public function getModel($name = 'Snippet', $prefix = 'Administrator', $config = ['ignore_request' => true])
	{
		return parent::getModel($name, $prefix, $config);
	}

	public function getSnippets()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// redirect to the import snippets custom admin view
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=get_snippets', false));
		return;
	}

	public function shareSnippets()
	{
		// Check for request forgeries
		Session::checkToken() or die(Text::_('JINVALID_TOKEN'));
		// Get the model
		$model = $this->getModel('snippets');
		// check if import is allowed for this user.
		$model->user = Factory::getUser();
		if ($model->user->authorise('snippet.import', 'com_componentbuilder') && $model->user->authorise('core.export', 'com_componentbuilder'))
		{			
			// Get the input
			$input = Factory::getApplication()->input;
			$pks = $input->post->get('cid', array(), 'array');
			// Sanitize the input
			ArrayHelper::toInteger($pks);
			// check if there is any selections
			if (!UtilitiesArrayHelper::check($pks))
			{
				// Redirect to the list screen with error.
				$message = Text::_('COM_COMPONENTBUILDER_NO_SNIPPETS_WERE_SELECTED_PLEASE_MAKE_A_SELECTION_AND_TRY_AGAIN');
				$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
				return;
			}
			// set auto loader
			ComponentbuilderHelper::autoLoader('smart');
			// get the data to export
			if ($model->shareSnippets($pks))
			{
				// Message of successful build
				if (count($pks) > 1)
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_THE_SNIPPETS_WERE_SUCCESSFULLY_EXPORTED') . '</h1>';
					$message .= '<p>' . Text::sprintf('COM_COMPONENTBUILDER_TO_SHARE_THESE_SNIPPETS_WITH_THE_REST_OF_THE_JCB_COMMUNITY');
				}
				else
				{
					$message = '<h1>' . Text::_('COM_COMPONENTBUILDER_THE_SNIPPET_WAS_SUCCESSFULLY_EXPORTED') . '</h1>';
					$message .= '<p>' . Text::sprintf('COM_COMPONENTBUILDER_TO_SHARE_THIS_SNIPPET_WITH_THE_REST_OF_THE_JCB_COMMUNITY');
				}
				$message .= Text::sprintf('COM_COMPONENTBUILDER_YOU_WILL_NEED_TO_KNOW_HOW_S_WORKS_BASIC_YOU_WILL_ALSO_NEED_A_S_ACCOUNT_AND_KNOW_HOW_TO_MAKE_A_PULL_REQUEST_ON_GITHUB', 
					'<a href="https://try.github.io" target="_blank">git</a>',
					'<a href="https://github.com/join" target="_blank">github.com</a>') . '</p>';

				$message .= '<h2>' . Text::_('COM_COMPONENTBUILDER_NEED_HELP') . '</h2>';
				$message .= '<ul>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_GENERAL_OVERVIEW_OF_HOW_THINGS_WORK_BSB', '<a href="https://www.youtube.com/watch?v=qr4I1jeCp7I&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/qr4I1jeCp7I</a>').'</li>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_BASIC_TUTORIAL_ON_GIT_BSB', '<a href="https://www.udemy.com/git-quick-start/" target="_blank">https://www.udemy.com/git-quick-start/</a>').'</li>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_GET_AN_ACCOUNT_WITH_GITHUB_BSB', '<a href="https://github.com/join" target="_blank">https://github.com/join</a>').'</li>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_TUTORIAL_ON_FORKING_JCB_SNIPPETS_BSB', '<a href="https://www.youtube.com/watch?v=0hgHeQVTLOk&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/0hgHeQVTLOk</a>').'</li>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_TUTORIAL_ON_MAKING_A_PULL_REQUEST_BSB', '<a href="https://www.youtube.com/watch?v=vQ-yxVtc-Co&list=PLQRGFI8XZ_wtGvPQZWBfDzzlERLQgpMRE" target="_blank">https://youtu.be/vQ-yxVtc-Co</a>').'</li>';
				$message .= '<li>'.Text::sprintf('COM_COMPONENTBUILDER_REPORT_AN_ISSUE_BSB', '<a href="https://github.com/vdm-io/Joomla-Component-Builder-Snippets/issues" target="_blank">https://github.com/vdm-io/Joomla-Component-Builder-Snippets/issues</a>').'</li>';
				$message .= '</ul>';
				$message .= '<h2>' . Text::_('COM_COMPONENTBUILDER_ZIPPED_FILE_LOCATION') . '</h2>';
				$message .= '<p>' . Text::sprintf('COM_COMPONENTBUILDER_PATH_CODESCODE', $model->zipPath). '</p>';
				$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=snippets', false), $message);
				return;
			}
		}
		// Redirect to the list screen with error.
		$message = Text::_('COM_COMPONENTBUILDER_YOU_DO_NOT_HAVE_PERMISSION_TO_SHARE_THE_SNIPPETS_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_MORE_HELP');
		$this->setRedirect(Route::_('index.php?option=com_componentbuilder&view=snippets', false), $message, 'error');
		return;
	}  
}