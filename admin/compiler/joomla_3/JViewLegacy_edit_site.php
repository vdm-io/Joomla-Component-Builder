<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <http://www.joomlacomponentbuilder.com>
 * @github     Joomla Component Builder <https://github.com/vdm-io/Joomla-Component-Builder>
 * @copyright  Copyright (C) 2015 - 2018 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');###LICENSE_LOCKED_DEFINED###

/**
 * ###View### View class
 */
class ###Component###View###View### extends JViewLegacy
{
	/**
	 * display method of View
	 * @return void
	 */
	public function display($tpl = null)
	{
		// set params
		$this->params = JComponentHelper::getParams('com_###component###');
		// Assign the variables
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
		$this->script = $this->get('Script');
		$this->state = $this->get('State');
		// get action permissions
		$this->canDo = ###Component###Helper::getActions('###view###', $this->item);
		// get input
		$jinput = JFactory::getApplication()->input;
		$this->ref = $jinput->get('ref', 0, 'word');
		$this->refid = $jinput->get('refid', 0, 'int');
		$return = $jinput->get('return', null, 'base64');
		// set the referral string
		$this->referral = '';
		if ($this->refid && $this->ref)
		{
			// return to the item that referred to this item
			$this->referral = '&ref=' . (string)$this->ref . '&refid=' . (int)$this->refid;
		}
		elseif($this->ref)
		{
			// return to the list view that referred to this item
			$this->referral = '&ref=' . (string)$this->ref;
		}
		// check return value
		if (!is_null($return))
		{
			// add the return value
			$this->referral .= '&return=' . (string)$return;
		}###LINKEDVIEWITEMS###

		// Set the toolbar
		$this->addToolBar();
		
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors), 500);
		}

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}


	/**
	 * Setting the toolbar
	 */
	protected function addToolBar()
	{
		// adding the joomla edit toolbar to the front
		JLoader::register('JToolbarHelper', JPATH_ADMINISTRATOR.'/includes/toolbar.php');
		###ADDTOOLBAR###
		// now initiate the toolbar
		$this->toolbar = JToolbar::getInstance();
	}

	/**
	 * Escapes a value for output in a view script.
	 *
	 * @param   mixed  $var  The output to escape.
	 *
	 * @return  mixed  The escaped value.
	 */
	public function escape($var)
	{
		if(strlen($var) > 30)
		{
    			// use the helper htmlEscape method instead and shorten the string
			return ###Component###Helper::htmlEscape($var, $this->_charset, true, 30);
		}
		// use the helper htmlEscape method instead.
		return ###Component###Helper::htmlEscape($var, $this->_charset);
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		if (!isset($this->document))
		{
			$this->document = JFactory::getDocument();
		}
		$this->document->setTitle(JText::_($isNew ? 'COM_###COMPONENT###_###VIEW###_NEW' : 'COM_###COMPONENT###_###VIEW###_EDIT'));
		// only add the ISIS template css & js if needed (default is 1 = true)
		// you can override this in the global component options
		// just add a (radio yes/no field) with a name called add_isis_template
		// to your components config area
		if ($this->params->get('add_isis_template', 1))
		{
			// we need this to fix the form display (TODO)
			$this->document->addStyleSheet(JURI::root() . "administrator/templates/isis/css/template.css", (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');
			$this->document->addScript(JURI::root() . "administrator/templates/isis/js/template.js", (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		}
		// the default style of this view
		$this->document->addStyleSheet(JURI::root()."components/com_###component###/assets/css/###view###.css", (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/css');###AJAXTOKE######LINKEDVIEWTABLESCRIPTS###
		// default javascript of this view
		$this->document->addScript(JURI::root(). $this->script, (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript');
		$this->document->addScript(JURI::root(). "components/com_###component###/views/###view###/submitbutton.js", (###Component###Helper::jVersion()->isCompatible('3.8.0')) ? array('version' => 'auto') : 'text/javascript'); ###DOCUMENT_CUSTOM_PHP###
		JText::script('view not acceptable. Error');
	}
}
