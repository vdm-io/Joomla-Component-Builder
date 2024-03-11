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
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Site\Controller;

use Joomla\CMS\Factory;
use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\CMS\Router\Route;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Language\Text;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * ###Component### master site display controller.
 *
 * @since   4.0
 */
class DisplayController extends BaseController
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached.
	 * @param   boolean  $urlparams  An array of safe URL parameters and their variable types, for valid values see {@link InputFilter::clean()}.
	 *
	 * @return  DisplayController  This object to support chaining.
     * @since   1.5
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view          = $this->input->getCmd('view', '###SITE_DEFAULT_VIEW###');
		$this->input->set('view', $view);
		$isEdit        = $this->checkEditView($view);
		$layout        = $this->input->get('layout', null, 'WORD');
		$id            = $this->input->getInt('id');
		$cachable      = true;

		// ensure that the view is not cashable if edit view or if user is logged in
		$user = $this->app->getIdentity();
		if ($user->get('id') || $this->input->getMethod() === 'POST' || $isEdit)
		{
			$cachable = false;
		}

		// Check for edit form.
		if ($isEdit && !$this->checkEditId('com_###component###.edit.'.$view, $id))
		{
			// check if item was opened from other than its own list view
			$ref    = $this->input->getCmd('ref', 0);
			$refid  = $this->input->getInt('refid', 0);

			// set redirect
			if ($refid > 0 && Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($ref))
			{
				// redirect to item of ref
				$this->setRedirect(Route::_('index.php?option=com_###component###&view='.(string)$ref.'&layout=edit&id='.(int)$refid, false));
			}
			elseif (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($ref))
			{
				// redirect to ref
				 $this->setRedirect(Route::_('index.php?option=com_###component###&view='.(string)$ref, false));
			}
			else
			{
				// normal redirect back to the list default site view
				$this->setRedirect(Route::_('index.php?option=com_###component###&view=###SITE_DEFAULT_VIEW###', false));
			}

			// Somehow the person just went to the form - we don't allow that.
        	throw new \Exception(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id), 403);
		}

		// we may need to make this more dynamic in the future. (TODO)
		$safeurlparams = array(
			'catid' => 'INT',
			'id' => 'INT',
			'cid' => 'ARRAY',
			'year' => 'INT',
			'month' => 'INT',
			'limit' => 'UINT',
			'limitstart' => 'UINT',
			'showall' => 'INT',
			'return' => 'BASE64',
			'filter' => 'STRING',
			'filter_order' => 'CMD',
			'filter_order_Dir' => 'CMD',
			'filter-search' => 'STRING',
			'print' => 'BOOLEAN',
			'lang' => 'CMD',
			'Itemid' => 'INT');

		// should these not merge?
		if (Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($urlparams))
		{
			$safeurlparams = Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::merge(array($urlparams, $safeurlparams));
		}

		parent::display($cachable, $safeurlparams);

		return $this;
	}

	protected function checkEditView($view)
	{
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($view))
		{
			$views = [###SITE_EDIT_VIEW_ARRAY###
				];
			// check if this is a edit view
			if (in_array($view,$views))
			{
				return true;
			}
		}
		return false;
	}
}
