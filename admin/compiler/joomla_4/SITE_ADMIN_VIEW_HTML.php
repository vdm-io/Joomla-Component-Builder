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
namespace ###NAMESPACEPREFIX###\Component\###ComponentNamespace###\Site\View\###View###;

###SITE_ADMIN_VIEW_HTML_HEADER###

// No direct access to this file
\defined('_JEXEC') or die;###LICENSE_LOCKED_DEFINED###

/**
 * ###View### Html View class
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
	 * The origin referral view item id
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
	 * ###View### view display method
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 * @since  1.6
	 */
	public function display($tpl = null)
	{
		// set params
		$this->params = Joomla___aeb8e463_291f_4445_9ac4_34b637c12dbd___Power::getParams('com_###component###');
		$this->useCoreUI = true;
		// Assign the variables
		$this->form ??= $this->get('Form');
		$this->item = $this->get('Item');
		$this->state = $this->get('State');
		$this->styles = $this->get('Styles') ?? [];
		$this->scripts = $this->get('Scripts') ?? [];
		// get action permissions
		$this->canDo = ###Component###Helper::getActions('###view###', $this->item);
		// get input
		$jinput = Joomla___39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication()->input;
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
		}###LINKEDVIEWITEMS###

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
		###ADDTOOLBAR###

		// add the toolbar if it's not already loaded
		$this->toolbar ??= Joomla___39403062_84fb_46e0_bac4_0023f766e827___Power::getContainer()->get(Joomla___5d2ae99b_1ea1_44f0_9b59_f1aa7eab9e2e___Power::class)->createToolbar('toolbar');
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

		return Super___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::html($var, $this->_charset ?? 'UTF-8', $shorten, $length);
	}

	/**
	 * Prepare some document related stuff.
	 *
	 * @return  void
	 * @since   1.6
	 */
	protected function _prepareDocument(): void
	{###JQUERY###
		$isNew = ($this->item->id < 1);
		$this->getDocument()->setTitle(Joomla___ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_($isNew ? 'COM_###COMPONENT###_###VIEW###_NEW' : 'COM_###COMPONENT###_###VIEW###_EDIT'));
		// add styles
		foreach ($this->styles as $style)
		{
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('stylesheet', $style, ['version' => 'auto']);
		}###AJAXTOKE######LINKEDVIEWTABLESCRIPTS###
		// add scripts
		foreach ($this->scripts as $script)
		{
			Joomla___34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('script', $script, ['version' => 'auto']);
		}###DOCUMENT_CUSTOM_PHP###
	}
}
