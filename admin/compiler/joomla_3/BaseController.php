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

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
###BOM###

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\MVC\Controller\BaseController;
use Joomla\Utilities\ArrayHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

/**
 * General Controller of ###Component### component
 */
class ###Component###Controller extends BaseController
{
	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'default_task', 'model_path', and
	 * 'view_path' (this list is not meant to be comprehensive).
	 *
	 * @since   3.0
	 */
	public function __construct($config = [])
	{
		// set the default view
		$config['default_view'] = '###DASHBOARDVIEW###';

		parent::__construct($config);
	}

	/**
	 * display task
	 *
	 * @return void
	 */
	function display($cachable = false, $urlparams = false)
	{
		// set default view if not set
		$view      = $this->input->getCmd('view', '###DASHBOARDVIEW###');
		$data      = $this->getViewRelation($view);
		$layout    = $this->input->get('layout', null, 'WORD');
		$id        = $this->input->getInt('id');

		// Check for edit form.
		if(Super___0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check($data))
		{
			if ($data['edit'] && $layout == 'edit' && !$this->checkEditId('com_###component###.edit.'.$data['view'], $id))
			{
				// Somehow the person just went to the form - we don't allow that.
				$this->setError(Text::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
				$this->setMessage($this->getError(), 'error');
				// check if item was opend from other then its own list view
				$ref     = $this->input->getCmd('ref', 0);
				$refid   = $this->input->getInt('refid', 0);
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
					// normal redirect back to the list view
					$this->setRedirect(Route::_('index.php?option=com_###component###&view='.$data['views'], false));
				}

				return false;
			}
		}

		return parent::display($cachable, $urlparams);
	}

	protected function getViewRelation($view)
	{
		// check the we have a value
		if (Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($view))
		{
			// the view relationships
			$views = array(###VIEWARRAY###
					);
			// check if this is a list view
			if (in_array($view, $views))
			{
				// this is a list view
				return array('edit' => false, 'view' => array_search($view,$views), 'views' => $view);
			}
			// check if it is an edit view
			elseif (array_key_exists($view, $views))
			{
				// this is a edit view
				return array('edit' => true, 'view' => $view, 'views' => $views[$view]);
			}
		}
		return false;
	}
}
