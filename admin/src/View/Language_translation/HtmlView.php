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
namespace VDM\Component\Componentbuilder\Administrator\View\Language_translation;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Toolbar\Toolbar;
use Joomla\CMS\Form\FormHelper;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\User\User;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Toolbar\ToolbarHelper;
use Joomla\CMS\Document\Document;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Language_translation Html View class
 *
 * @since  1.6
 */
#[\AllowDynamicProperties]
class HtmlView extends BaseHtmlView
{
	/**
	 * The item from the model
	 *
	 * @var    mixed
	 * @since  3.10.11
	 */
	public mixed $item;

	/**
	 * The state object
	 *
	 * @var    mixed
	 * @since  3.10.11
	 */
	public mixed $state;

	/**
	 * The form from the model
	 *
	 * @var    mixed
	 * @since  3.10.11
	 */
	public mixed $form;

	/**
	 * The toolbar object
	 *
	 * @var    Toolbar
	 * @since  3.10.11
	 */
	public Toolbar $toolbar;

	/**
	 * The styles url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $styles;

	/**
	 * The scripts url array
	 *
	 * @var    array
	 * @since  5.0.0
	 */
	protected array $scripts;

	/**
	 * The actions object
	 *
	 * @var    object
	 * @since  3.10.11
	 */
	public object $canDo;

	/**
	 * The origin referral view name
	 *
	 * @var    string
	 * @since  3.10.11
	 */
	public string $ref;

	/**
	 * The origin referral item id
	 *
	 * @var    int
	 * @since  3.10.11
	 */
	public int $refid;

	/**
	 * The referral url suffix values
	 *
	 * @var    string
	 * @since  3.10.11
	 */
	public string $referral;

	/**
	 * Language_translation view display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @throws \Exception
	 * @since  1.6
	 */
	public function display($tpl = null): void
	{
		// set params
		$this->params = ComponentHelper::getParams('com_componentbuilder');
		$this->useCoreUI = true;
		// Assign the variables
		$this->form ??= $this->get('Form');
		$this->item = $this->get('Item');
		$this->styles = $this->get('Styles');
		$this->scripts = $this->get('Scripts');
		$this->state = $this->get('State');
		// get action permissions
		$this->canDo = ComponentbuilderHelper::getActions('language_translation', $this->item);
		// get input
		$jinput = Factory::getApplication()->input;
		$this->ref = $jinput->get('ref', 0, 'word');
		$this->refid = $jinput->get('refid', 0, 'int');
		$return = $jinput->get('return', null, 'base64');
		// set the referral string
		$this->referral = '';
		if ($this->refid && $this->ref)
		{
			// return to the item that referred to this item
			$this->referral = '&ref=' . (string) $this->ref . '&refid=' . (int) $this->refid;
		}
		elseif($this->ref)
		{
			// return to the list view that referred to this item
			$this->referral = '&ref=' . (string) $this->ref;
		}
		// check return value
		if (!is_null($return))
		{
			// add the return value
			$this->referral .= '&return=' . (string) $return;
		}

		// Set the toolbar
		$this->addToolBar();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode("\n", $errors), 500);
		}

		// Set the html view document stuff
		$this->_prepareDocument();

		// Display the template
		parent::display($tpl);
	}


	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function addToolbar(): void
	{
		Factory::getApplication()->input->set('hidemainmenu', true);
		$user = Factory::getApplication()->getIdentity();
		$userId	= $user->id;
		$isNew = $this->item->id == 0;

		ToolbarHelper::title( Text::_($isNew ? 'COM_COMPONENTBUILDER_LANGUAGE_TRANSLATION_NEW' : 'COM_COMPONENTBUILDER_LANGUAGE_TRANSLATION_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (StringHelper::check($this->referral))
		{
			if ($this->canDo->get('language_translation.create') && $isNew)
			{
				// We can create the record.
				ToolbarHelper::save('language_translation.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('language_translation.edit'))
			{
				// We can save the record.
				ToolbarHelper::save('language_translation.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				ToolbarHelper::cancel('language_translation.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				ToolbarHelper::cancel('language_translation.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('language_translation.create'))
				{
					ToolbarHelper::apply('language_translation.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('language_translation.save', 'JTOOLBAR_SAVE');
					ToolbarHelper::custom('language_translation.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				ToolbarHelper::cancel('language_translation.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('language_translation.edit'))
				{
					// We can save the new record
					ToolbarHelper::apply('language_translation.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('language_translation.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('language_translation.create'))
					{
						ToolbarHelper::custom('language_translation.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('language_translation.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('language_translation.edit') && $canVersion)
				{
					ToolbarHelper::versions('com_componentbuilder.language_translation', $this->item->id);
				}
				if ($this->canDo->get('language_translation.create'))
				{
					ToolbarHelper::custom('language_translation.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				ToolbarHelper::cancel('language_translation.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		ToolbarHelper::divider();
		ToolbarHelper::inlinehelp();
		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('language_translation');
		if (StringHelper::check($this->help_url))
		{
			ToolbarHelper::help('COM_COMPONENTBUILDER_HELP_MANAGER', false, $this->help_url);
		}
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var     The output to escape.
	 * @param   bool   $shorten The switch to shorten.
	 * @param   int    $length  The shorting length.
	 *
	 * @return  mixed  The escaped value.
	 * @since   1.6
	 */
	public function escape($var, bool $shorten = true, int $length = 30)
	{
		if (!is_string($var))
		{
			return $var;
		}

		return StringHelper::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{
		// Load jQuery
		Html::_('jquery.framework');
		$isNew = ($this->item->id < 1);
		$this->getDocument()->setTitle(Text::_($isNew ? 'COM_COMPONENTBUILDER_LANGUAGE_TRANSLATION_NEW' : 'COM_COMPONENTBUILDER_LANGUAGE_TRANSLATION_EDIT'));
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// Add Ajax Token
		$this->getDocument()->addScriptDeclaration("var token = '" . Session::getFormToken() . "';");
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}
		// add JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/notify.min.js', ['version' => 'auto']);
		// add the style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css', ['version' => 'auto']);
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css', ['version' => 'auto']);
		// add var key
		$this->getDocument()->addScriptDeclaration("var vastDevMod = '".$this->get('VDM')."';"); 
	}
}
