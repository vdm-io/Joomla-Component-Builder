<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this JCB template file (EVER)
defined('_JCB_TEMPLATE') or die;
?>
###BOM###
namespace ###NAMESPACEPREFIX###\Component\###ComponentNameSpace###\Administrator\View\Import;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\View\HtmlView as BaseHtmlView;
use Joomla\CMS\Toolbar\ToolbarHelper;
use ###NAMESPACEPREFIX###\Component\###ComponentNameSpace###\Administrator\Helper\###Component###Helper;

// No direct access to this file
\defined('_JEXEC') or die;###LICENSE_LOCKED_DEFINED###

/**
 * ###Component### Import Html View
 *
 * @since  1.6
 */
class HtmlView extends BaseHtmlView
{
	protected $headerList;
	protected $hasPackage = false;
	protected $headers;
	protected $hasHeader = 0;
	protected $dataType;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		$paths = new \StdClass;
		$paths->first = '';
		$state = $this->get('state');

		$this->paths = &$paths;
		$this->state = &$state;
		// get global action permissions
		$this->canDo = ###Component###Helper::getActions('import');

		// We don't need toolbar in the modal window.
		if ($this->getLayout() !== 'modal')
		{
			$this->addToolbar();
		}

		// get the session object
		$session = Factory::getSession();
		// check if it has package
		$this->hasPackage     = $session->get('hasPackage', false);
		$this->dataType     = $session->get('dataType', false);
		if($this->hasPackage && $this->dataType)
		{
			$this->headerList     = json_decode($session->get($this->dataType.'_VDM_IMPORTHEADERS', false),true);
			$this->headers         = ###Component###Helper::getFileHeaders($this->dataType);
			// clear the data type
			$session->clear('dataType');
		}

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new \Exception(implode("\n", $errors), 500);
		}

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
		ToolbarHelper::title(Text::_('COM_###COMPONENT###_IMPORT_TITLE'), 'upload');

		if ($this->canDo->get('core.admin') || $this->canDo->get('core.options'))
		{
			ToolbarHelper::preferences('com_###component###');
		}

		// set help url for this view if found
		$this->help_url = ###Component###Helper::getHelpUrl('import');
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($this->help_url))
		{
			ToolbarHelper::help('COM_###COMPONENT###_HELP_MANAGER', false, $this->help_url);
		}
	}
}
