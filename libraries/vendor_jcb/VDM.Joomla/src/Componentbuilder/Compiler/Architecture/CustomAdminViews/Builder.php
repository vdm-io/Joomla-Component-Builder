<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomAdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\LicenseLock;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\Body as CustomViewBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\CodeBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\ExtraDisplayMethods;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\Layouts as CustomViewLayouts;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\SubmitButtonScript;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\TemplateBody as CustomViewTemplateBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\PrepareDocument;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\Resource as ApiResource;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\CustomGetMethods;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItem;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\GetItems;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\ListQuery as DynamicListQuery;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Methods;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomAdmin\AddToolBarInterface as CustomAdminAddToolBarInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\DisplayMethodInterface as CustomViewDisplayMethodInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\FormInterface as CustomViewFormInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Custom Admin Views Builder Class.
 * 
 * Builds every custom admin view the component was given: the body it shows,
 * the form and the toolbar above it, the data it fetches, the document it
 * prepares, and the layouts it draws with.
 * 
 * A component that was given none is left alone.
 * 
 * @since 6.1.7
 */
final class Builder
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 6.1.7
	 */
	protected Event $event;

	/**
	 * The Header Class.
	 *
	 * @var   HeaderInterface
	 * @since 6.1.7
	 */
	protected HeaderInterface $header;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Component LicenseLock Class.
	 *
	 * @var   LicenseLock
	 * @since 6.1.7
	 */
	protected LicenseLock $licenselock;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Compiler Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The CustomAdminView AddToolBar Class.
	 *
	 * @var   CustomAdminAddToolBarInterface
	 * @since 6.1.7
	 */
	protected CustomAdminAddToolBarInterface $customadminviewaddtoolbar;

	/**
	 * The CustomAdminViews AddToolBar Class.
	 *
	 * @var   CustomAdminAddToolBarInterface
	 * @since 6.1.7
	 */
	protected CustomAdminAddToolBarInterface $customadminviewsaddtoolbar;

	/**
	 * The Dynamicget CustomGetMethods Class.
	 *
	 * @var   CustomGetMethods
	 * @since 6.1.7
	 */
	protected CustomGetMethods $customgetmethods;

	/**
	 * The Dynamicget GetItem Class.
	 *
	 * @var   GetItem
	 * @since 6.1.7
	 */
	protected GetItem $getitem;

	/**
	 * The Dynamicget GetItems Class.
	 *
	 * @var   GetItems
	 * @since 6.1.7
	 */
	protected GetItems $getitems;

	/**
	 * The Dynamicget ListQuery Class.
	 *
	 * @var   DynamicListQuery
	 * @since 6.1.7
	 */
	protected DynamicListQuery $dynamiclistquery;

	/**
	 * The Dynamicget Methods Class.
	 *
	 * @var   Methods
	 * @since 6.1.7
	 */
	protected Methods $dynamicmethods;

	/**
	 * The CustomView Body Class.
	 *
	 * @var   CustomViewBody
	 * @since 6.1.7
	 */
	protected CustomViewBody $customviewbody;

	/**
	 * The CustomView DisplayMethod Class.
	 *
	 * @var   CustomViewDisplayMethodInterface
	 * @since 6.1.7
	 */
	protected CustomViewDisplayMethodInterface $customviewdisplaymethod;

	/**
	 * The CustomView Form Class.
	 *
	 * @var   CustomViewFormInterface
	 * @since 6.1.7
	 */
	protected CustomViewFormInterface $customviewform;

	/**
	 * The CustomView Layouts Class.
	 *
	 * @var   CustomViewLayouts
	 * @since 6.1.7
	 */
	protected CustomViewLayouts $customviewlayouts;

	/**
	 * The CustomView TemplateBody Class.
	 *
	 * @var   CustomViewTemplateBody
	 * @since 6.1.7
	 */
	protected CustomViewTemplateBody $customviewtemplatebody;

	/**
	 * The CustomView SubmitButtonScript Class.
	 *
	 * @var   SubmitButtonScript
	 * @since 6.1.7
	 */
	protected SubmitButtonScript $submitbuttonscript;

	/**
	 * The CustomView CodeBody Class.
	 *
	 * @var   CodeBody
	 * @since 6.1.7
	 */
	protected CodeBody $customviewcodebody;

	/**
	 * The CustomView ExtraDisplayMethods Class.
	 *
	 * @var   ExtraDisplayMethods
	 * @since 6.1.7
	 */
	protected ExtraDisplayMethods $extradisplaymethods;

	/**
	 * The View PrepareDocument Class.
	 *
	 * @var   PrepareDocument
	 * @since 6.1.7
	 */
	protected PrepareDocument $preparedocument;

	/**
	 * The Api Dynamic Resource Class.
	 *
	 * @var   ApiResource
	 * @since 6.1.7
	 */
	protected ApiResource $apiresource;

	/**
	 * Constructor.
	 *
	 * @param Config                           $config                               The Config Class.
	 * @param Event                            $event                                The Event Class.
	 * @param HeaderInterface                  $header                               The Header Class.
	 * @param Dispenser                        $dispenser                            The Customcode Dispenser Class.
	 * @param ContentMulti                     $contentmulti                         The Content Multi Builder Class.
	 * @param LicenseLock                      $licenselock                          The Component LicenseLock Class.
	 * @param Component                        $component                            The Component Class.
	 * @param Language                         $language                             The Language Class.
	 * @param Registry                         $registry                             The Compiler Registry Class.
	 * @param Placeholder                      $placeholder                          The Placeholder Class.
	 * @param CustomAdminAddToolBarInterface   $customadminviewaddtoolbar            The CustomAdminView AddToolBar Class.
	 * @param CustomAdminAddToolBarInterface   $customadminviewsaddtoolbar           The CustomAdminViews AddToolBar Class.
	 * @param CustomGetMethods                 $customgetmethods                     The Dynamicget CustomGetMethods Class.
	 * @param GetItem                          $getitem                              The Dynamicget GetItem Class.
	 * @param GetItems                         $getitems                             The Dynamicget GetItems Class.
	 * @param DynamicListQuery                 $dynamiclistquery                     The Dynamicget ListQuery Class.
	 * @param Methods                          $dynamicmethods                       The Dynamicget Methods Class.
	 * @param CustomViewBody                   $customviewbody                       The CustomView Body Class.
	 * @param CustomViewDisplayMethodInterface $customviewdisplaymethod              The CustomView DisplayMethod Class.
	 * @param CustomViewFormInterface          $customviewform                       The CustomView Form Class.
	 * @param CustomViewLayouts                $customviewlayouts                    The CustomView Layouts Class.
	 * @param CustomViewTemplateBody           $customviewtemplatebody               The CustomView TemplateBody Class.
	 * @param SubmitButtonScript               $submitbuttonscript                   The CustomView SubmitButtonScript Class.
	 * @param CodeBody                         $customviewcodebody                   The CustomView CodeBody Class.
	 * @param ExtraDisplayMethods              $extradisplaymethods                  The CustomView ExtraDisplayMethods Class.
	 * @param PrepareDocument                  $preparedocument                      The View PrepareDocument Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Event $event,
		HeaderInterface $header,
		Dispenser $dispenser,
		ContentMulti $contentmulti,
		LicenseLock $licenselock,
		Component $component,
		Language $language,
		Registry $registry,
		Placeholder $placeholder,
		CustomAdminAddToolBarInterface $customadminviewaddtoolbar,
		CustomAdminAddToolBarInterface $customadminviewsaddtoolbar,
		CustomGetMethods $customgetmethods,
		GetItem $getitem,
		GetItems $getitems,
		DynamicListQuery $dynamiclistquery,
		Methods $dynamicmethods,
		CustomViewBody $customviewbody,
		CustomViewDisplayMethodInterface $customviewdisplaymethod,
		CustomViewFormInterface $customviewform,
		CustomViewLayouts $customviewlayouts,
		CustomViewTemplateBody $customviewtemplatebody,
		SubmitButtonScript $submitbuttonscript,
		CodeBody $customviewcodebody,
		ExtraDisplayMethods $extradisplaymethods,
		PrepareDocument $preparedocument,
		ApiResource $apiresource)
	{
		$this->config = $config;
		$this->event = $event;
		$this->header = $header;
		$this->dispenser = $dispenser;
		$this->contentmulti = $contentmulti;
		$this->licenselock = $licenselock;
		$this->component = $component;
		$this->language = $language;
		$this->registry = $registry;
		$this->placeholder = $placeholder;
		$this->customadminviewaddtoolbar = $customadminviewaddtoolbar;
		$this->customadminviewsaddtoolbar = $customadminviewsaddtoolbar;
		$this->customgetmethods = $customgetmethods;
		$this->getitem = $getitem;
		$this->getitems = $getitems;
		$this->dynamiclistquery = $dynamiclistquery;
		$this->dynamicmethods = $dynamicmethods;
		$this->customviewbody = $customviewbody;
		$this->customviewdisplaymethod = $customviewdisplaymethod;
		$this->customviewform = $customviewform;
		$this->customviewlayouts = $customviewlayouts;
		$this->customviewtemplatebody = $customviewtemplatebody;
		$this->submitbuttonscript = $submitbuttonscript;
		$this->customviewcodebody = $customviewcodebody;
		$this->extradisplaymethods = $extradisplaymethods;
		$this->preparedocument = $preparedocument;
		$this->apiresource = $apiresource;
	}

	/**
	 * Build every custom admin view the component was given.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function build(): void
	{
		// setup custom_admin_views and all needed stuff for the site
		if ($this->component->isArray('custom_admin_views'))
		{
			$this->config->build_target = 'custom_admin';
			$this->config->lang_target = 'admin';
			// start dynamic build
			foreach ($this->component->get('custom_admin_views') as $view)
			{
				// for single views
				$this->contentmulti->set($view['settings']->code . '|SView', $view['settings']->Code);
				$this->contentmulti->set($view['settings']->code . '|sview', $view['settings']->code);
				$this->contentmulti->set($view['settings']->code . '|SVIEW', $view['settings']->CODE);
				// for list views
				$this->contentmulti->set($view['settings']->code . '|SViews', $view['settings']->Code);
				$this->contentmulti->set($view['settings']->code . '|sviews', $view['settings']->code);
				$this->contentmulti->set($view['settings']->code . '|SVIEWS', $view['settings']->CODE);
				// add to lang array
				$this->language->set(
					$this->config->lang_target,
					$this->config->lang_prefix . '_' . $view['settings']->CODE,
					$view['settings']->name
				);
				$this->language->set(
					$this->config->lang_target,
					$this->config->lang_prefix . '_' . $view['settings']->CODE
					. '_DESC', $view['settings']->description
				);
				// ICOMOON <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|ICOMOON', $view['icomoon']);

				// set placeholders
				$this->placeholder->set('SView', $view['settings']->Code);
				$this->placeholder->set('sview', $view['settings']->code);
				$this->placeholder->set('SVIEW', $view['settings']->CODE);

				$this->placeholder->set('SViews', $view['settings']->Code);
				$this->placeholder->set('sviews', $view['settings']->code);
				$this->placeholder->set('SVIEWS', $view['settings']->CODE);

				// Trigger Event: jcb_ce_onBeforeBuildCustomAdminViewContent
				$this->event->trigger(
					'jcb_ce_onBeforeBuildCustomAdminViewContent', [&$view, &$view['settings']->code]
				);

				// set license per view if needed
				$this->licenselock->setView(
					$view['settings']->code
				);

				// check if this custom admin view is the default view
				if ($this->registry->get('build.dashboard.type', '') === 'custom_admin_views'
					&& $this->registry->get('build.dashboard', '') === $view['settings']->code)
				{
					// HIDEMAINMENU <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|HIDEMAINMENU', '');
				}
				else
				{
					if ($this->config->get('joomla_version', 3) == 3)
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						$this->contentmulti->set($view['settings']->code . '|HIDEMAINMENU',
							PHP_EOL . Indent::_(2) . '//' . Line::_(
								__LINE__,__CLASS__
							) . " hide the main menu"
							. PHP_EOL . Indent::_(2)
							. "\$this->app->input->set('hidemainmenu', true);"
						);
					}
					else
					{
						// HIDEMAINMENU <<<DYNAMIC>>>
						$this->contentmulti->set($view['settings']->code . '|HIDEMAINMENU',
							PHP_EOL . Indent::_(2) . '//' . Line::_(
								__LINE__,__CLASS__
							) . " hide the main menu"
							. PHP_EOL . Indent::_(2)
							. "\$this->input->set('hidemainmenu', true);"
						);
					}
				}

				if ($view['settings']->main_get->gettype == 1)
				{
					// CUSTOM_ADMIN_BEFORE_GET_ITEM <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_BEFORE_GET_ITEM',
						$this->dispenser->get(
							$this->config->build_target . '_php_before_getitem',
							$view['settings']->code, '', null, true
						)
					);

					// CUSTOM_ADMIN_GET_ITEM <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_GET_ITEM',
						$this->getitem->get(
							$view['settings']->main_get,
							$view['settings']->code, Indent::_(2)
						)
					);

					// CUSTOM_ADMIN_AFTER_GET_ITEM <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_AFTER_GET_ITEM',
						$this->dispenser->get(
							$this->config->build_target . '_php_after_getitem',
							$view['settings']->code, '', null, true
						)
					);
				}
				elseif ($view['settings']->main_get->gettype == 2)
				{
					// CUSTOM_ADMIN_GET_LIST_QUERY <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_GET_LIST_QUERY',
						$this->dynamiclistquery->get(
							$view['settings']->main_get, $view['settings']->code
						)
					);

					// CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_BEFORE_LIST_QUERY',
						$this->dispenser->get(
							$this->config->build_target . '_php_getlistquery',
							$view['settings']->code, PHP_EOL, null, true
						)
					);

					// CUSTOM_ADMIN_BEFORE_GET_ITEMS <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_BEFORE_GET_ITEMS',
						$this->dispenser->get(
							$this->config->build_target . '_php_before_getitems',
								$view['settings']->code, PHP_EOL, null, true
						)
					);

					// CUSTOM_ADMIN_GET_ITEMS <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_GET_ITEMS',
						$this->getitems->get(
							$view['settings']->main_get, $view['settings']->code
						)
					);

					// CUSTOM_ADMIN_AFTER_GET_ITEMS <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_AFTER_GET_ITEMS',
						$this->dispenser->get(
							$this->config->build_target . '_php_after_getitems',
							$view['settings']->code, PHP_EOL, null, true
						)
					);
				}

				// the API resource of this view, when the component has an API
				$this->apiresource->set($view, 'custom_admin');

				// CUSTOM_ADMIN_CUSTOM_METHODS <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_METHODS',
					$this->customgetmethods->get(
						$view['settings']->main_get, $view['settings']->code
					)
				);
				$this->contentmulti->add($view['settings']->code . '|CUSTOM_ADMIN_CUSTOM_METHODS',
					$this->dynamicmethods->get(
						$view, $view['settings']->code
					). false
				);
				// CUSTOM_ADMIN_DIPLAY_METHOD <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_DIPLAY_METHOD',
					$this->customviewdisplaymethod->get($view)
				);
				// set document details
				$this->preparedocument->set($view);
				// CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_EXTRA_DIPLAY_METHODS',
					$this->extradisplaymethods->get($view)
				);
				// CUSTOM_ADMIN_CODE_BODY <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_CODE_BODY',
					$this->customviewcodebody->get($view)
				);
				// CUSTOM_ADMIN_BODY <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_BODY',
					$this->customviewbody->get($view)
				);
				// CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_SUBMITBUTTON_SCRIPT',
					$this->submitbuttonscript->get($view)
				);

				// setup the templates
				$this->customviewtemplatebody->set($view);

				// set the site form if needed
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_TOP_FORM',
					$this->customviewform->get(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 1
					)
				);
				$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_BOTTOM_FORM',
					$this->customviewform->get(
						$view['settings']->code,
						$view['settings']->main_get->gettype, 2
					)
				);

				// set headers based on the main get type
				if ($view['settings']->main_get->gettype == 1)
				{
					// CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_CONTROLLER_HEADER',
						$this->header->get(
							'custom.admin.view.controller',
							$view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_MODEL_HEADER',
						$this->header->get(
							'custom.admin.view.model', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_HTML_HEADER',
						$this->header->get(
							'custom.admin.view.html', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEW_HEADER',
						$this->header->get(
							'custom.admin.view', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_ADDTOOLBAR <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_ADDTOOLBAR',
						$this->customadminviewaddtoolbar->get($view)
					);
				}
				elseif ($view['settings']->main_get->gettype == 2)
				{
					// CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the controller
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_CONTROLLER_HEADER',
						$this->header->get(
							'custom.admin.views.controller',
							$view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_MODEL_HEADER',
						$this->header->get(
							'custom.admin.views.model', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_HTML_HEADER',
						$this->header->get(
							'custom.admin.views.html', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_VIEWS_HEADER',
						$this->header->get(
							'custom.admin.views', $view['settings']->code
						)
					);
					// CUSTOM_ADMIN_ADDTOOLBAR <<<DYNAMIC>>>
					$this->contentmulti->set($view['settings']->code . '|CUSTOM_ADMIN_ADDTOOLBAR',
						$this->customadminviewsaddtoolbar->get($view)
					);
				}

				// Trigger Event: jcb_ce_onAfterBuildCustomAdminViewContent
				$this->event->trigger(
					'jcb_ce_onAfterBuildCustomAdminViewContent', [&$view, &$view['settings']->code]
				);
			}

			// setup the layouts
			$this->customviewlayouts->set();
		}
	}
}

