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
namespace VDM\Component\Componentbuilder\Administrator\View\Admin_fields;

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
 * Admin_fields Html View class
 *
 * @since  1.6
 */
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
	 * Admin_fields view display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
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
		$this->canDo = ComponentbuilderHelper::getActions('admin_fields', $this->item);
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

		ToolbarHelper::title( Text::_($isNew ? 'COM_COMPONENTBUILDER_ADMIN_FIELDS_NEW' : 'COM_COMPONENTBUILDER_ADMIN_FIELDS_EDIT'), 'pencil-2 article-add');
		// Built the actions for new and existing records.
		if (StringHelper::check($this->referral))
		{
			if ($this->canDo->get('admin_fields.create') && $isNew)
			{
				// We can create the record.
				ToolbarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
			}
			elseif ($this->canDo->get('admin_fields.edit'))
			{
				// We can save the record.
				ToolbarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
			}
			if ($isNew)
			{
				// Do not creat but cancel.
				ToolbarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				// We can close it.
				ToolbarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		else
		{
			if ($isNew)
			{
				// For new records, check the create permission.
				if ($this->canDo->get('admin_fields.create'))
				{
					ToolbarHelper::apply('admin_fields.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
					ToolbarHelper::custom('admin_fields.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
				};
				ToolbarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CANCEL');
			}
			else
			{
				if ($this->canDo->get('admin_fields.edit'))
				{
					// We can save the new record
					ToolbarHelper::apply('admin_fields.apply', 'JTOOLBAR_APPLY');
					ToolbarHelper::save('admin_fields.save', 'JTOOLBAR_SAVE');
					// We can save this record, but check the create permission to see
					// if we can return to make a new one.
					if ($this->canDo->get('admin_fields.create'))
					{
						ToolbarHelper::custom('admin_fields.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
					}
				}
				$canVersion = ($this->canDo->get('core.version') && $this->canDo->get('admin_fields.version'));
				if ($this->state->params->get('save_history', 1) && $this->canDo->get('admin_fields.edit') && $canVersion)
				{
					ToolbarHelper::versions('com_componentbuilder.admin_fields', $this->item->id);
				}
				if ($this->canDo->get('admin_fields.create'))
				{
					ToolbarHelper::custom('admin_fields.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
				}
				ToolbarHelper::cancel('admin_fields.cancel', 'JTOOLBAR_CLOSE');
			}
		}
		ToolbarHelper::divider();
		ToolbarHelper::inlinehelp();
		// set help url for this view if found
		$this->help_url = ComponentbuilderHelper::getHelpUrl('admin_fields');
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
		$this->getDocument()->setTitle(Text::_($isNew ? 'COM_COMPONENTBUILDER_ADMIN_FIELDS_NEW' : 'COM_COMPONENTBUILDER_ADMIN_FIELDS_EDIT'));
		// add styles
		foreach ($this->styles as $style)
		{
			Html::_('stylesheet', $style, ['version' => 'auto']);
		}
		// add scripts
		foreach ($this->scripts as $script)
		{
			Html::_('script', $script, ['version' => 'auto']);
		}


		// add the Uikit v2 style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/uikit.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/uikit.min.js', ['version' => 'auto']);

		// add the Uikit v2 extra style sheets
		Html::_('stylesheet', 'media/com_componentbuilder/uikit-v2/css/components/notify.gradient.min.css', ['version' => 'auto']);
		// add Uikit v2 extra JavaScripts
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/lightbox.min.js', ['version' => 'auto']);
		Html::_('script', 'media/com_componentbuilder/uikit-v2/js/components/notify.min.js', ['version' => 'auto']);
		Text::script('COM_COMPONENTBUILDER_THE_BNONE_DBB_OPTION_WILL_REMOVE_THIS_FIELD_FROM_BEING_SAVED_IN_THE_DATABASE');
		Text::script('COM_COMPONENTBUILDER_ONLY_USE_THE_BNONE_DBB_OPTION_IF_YOU_ARE_PLANNING_ON_TARGETING_THIS_FIELD_WITH_JAVASCRIPTCUSTOM_PHP_TO_MOVE_ITS_VALUE_INTO_ANOTHER_FIELD_THAT_DOES_GET_SAVED_TO_THE_DATABASE');
		Text::script('COM_COMPONENTBUILDER_THE_BSHOW_IN_ALL_LIST_VIEWSB_OPTION_WILL_ADD_THIS_FIELD_TO_ALL_LIST_VIEWS_ADMIN_AMP_LINKED');
		Text::script('COM_COMPONENTBUILDER_THE_BONLY_IN_ADMIN_LIST_VIEWB_OPTION_WILL_ONLY_ADD_THIS_FIELD_TO_THE_ADMIN_LIST_VIEW_NOT_TO_ANY_LINKED_VIEWS');
		Text::script('COM_COMPONENTBUILDER_THE_BONLY_IN_LINKED_LIST_VIEWSB_OPTION_WILL_ONLY_ADD_THIS_FIELD_TO_THE_LINKED_LIST_VIEW_IF_THIS_VIEW_GETS_LINKED_TO_OTHER_VIEW_NOT_TO_THIS_ADMIN_LIST_VIEW');
		Text::script('COM_COMPONENTBUILDER_THESE_OPTIONS_ARE_NOT_AVAILABLE_TO_THE_FIELD_IF_BNONE_DBB_OPTION_IS_SELECTED');
		Text::script('COM_COMPONENTBUILDER_THESE_OPTIONS_ARE_ONLY_AVAILABLE_TO_THE_FIELD_IF_BSHOW_IN_LIST_VIEWB_OPTION_IS_SELECTED');
		Text::script('COM_COMPONENTBUILDER_THE_BMULTI_FILTERB_SELECTION_OPTION_ALLOWS_THE_USER_TO_SELECT_MORE_THEN_ONE_VALUE_IN_THIS_FILTERFIELD_PLEASE_NOTE_THAT_THIS_OPTION_BONLY_WORKSB_WITH_THE_BNEWB_FILTERS_THAT_LOAD_ABOVE_THE_ADMIN_LIST_VIEW_YOU_CAN_SELECT_THE_NEW_FILTER_OPTION_WHENWHERE_YOU_ADD_THE_VIEW_TO_THE_COMPONENT');
		Text::script('COM_COMPONENTBUILDER_THE_BSINGLE_FILTERB_SELECTION_OPTION_ALLOWS_THE_USER_TO_SELECT_JUST_ONE_VALUE_IN_THIS_FILTERFIELD');
	}
}
