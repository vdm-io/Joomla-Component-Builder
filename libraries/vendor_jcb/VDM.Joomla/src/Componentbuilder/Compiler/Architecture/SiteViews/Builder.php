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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\SiteViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\LicenseLock;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\Body as CustomViewBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\CodeBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\ExtraDisplayMethods;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\TemplateBody as CustomViewTemplateBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Router\SiteRouter;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\SiteViews\Headers;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\SiteViews\ModelData;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic\Resource as ApiResource;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\View\PrepareDocument;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\CustomGetMethods;
use VDM\Joomla\Componentbuilder\Compiler\Dynamicget\Methods;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\DisplayMethodInterface as CustomViewDisplayMethodInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomView\FormInterface as CustomViewFormInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu\CustomViewInterface as MenuCustomViewInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Router\RouteHelperInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\SiteView\AddToolBarInterface as SiteViewAddToolBarInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Everything one site view of the component adds to the compiler.
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
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

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
	 * The Router SiteRouter Class.
	 *
	 * @var   SiteRouter
	 * @since 6.1.7
	 */
	protected SiteRouter $siterouter;

	/**
	 * The Router RouteHelper Class.
	 *
	 * @var   RouteHelperInterface
	 * @since 6.1.7
	 */
	protected RouteHelperInterface $routehelper;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Dynamicget CustomGetMethods Class.
	 *
	 * @var   CustomGetMethods
	 * @since 6.1.7
	 */
	protected CustomGetMethods $customgetmethods;

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
	 * The CustomView TemplateBody Class.
	 *
	 * @var   CustomViewTemplateBody
	 * @since 6.1.7
	 */
	protected CustomViewTemplateBody $customviewtemplatebody;

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
	 * The Menu CustomView Class.
	 *
	 * @var   MenuCustomViewInterface
	 * @since 6.1.7
	 */
	protected MenuCustomViewInterface $menucustomview;

	/**
	 * The SiteView AddToolBar Class.
	 *
	 * @var   SiteViewAddToolBarInterface
	 * @since 6.1.7
	 */
	protected SiteViewAddToolBarInterface $siteviewaddtoolbar;

	/**
	 * The SiteViews ModelData Class.
	 *
	 * @var   ModelData
	 * @since 6.1.7
	 */
	protected ModelData $modeldata;

	/**
	 * The SiteViews Headers Class.
	 *
	 * @var   Headers
	 * @since 6.1.7
	 */
	protected Headers $headers;

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
	 * @param ContentOne                       $contentone                           The Content One Builder Class.
	 * @param ContentMulti                     $contentmulti                         The Content Multi Builder Class.
	 * @param LicenseLock                      $licenselock                          The Component LicenseLock Class.
	 * @param SiteRouter                       $siterouter                           The Router SiteRouter Class.
	 * @param RouteHelperInterface             $routehelper                          The Router RouteHelper Class.
	 * @param Language                         $language                             The Language Class.
	 * @param Placeholder                      $placeholder                          The Placeholder Class.
	 * @param CustomGetMethods                 $customgetmethods                     The Dynamicget CustomGetMethods Class.
	 * @param Methods                          $dynamicmethods                       The Dynamicget Methods Class.
	 * @param CustomViewBody                   $customviewbody                       The CustomView Body Class.
	 * @param CustomViewDisplayMethodInterface $customviewdisplaymethod              The CustomView DisplayMethod Class.
	 * @param CustomViewFormInterface          $customviewform                       The CustomView Form Class.
	 * @param CustomViewTemplateBody           $customviewtemplatebody               The CustomView TemplateBody Class.
	 * @param CodeBody                         $customviewcodebody                   The CustomView CodeBody Class.
	 * @param ExtraDisplayMethods              $extradisplaymethods                  The CustomView ExtraDisplayMethods Class.
	 * @param PrepareDocument                  $preparedocument                      The View PrepareDocument Class.
	 * @param MenuCustomViewInterface          $menucustomview                       The Menu CustomView Class.
	 * @param SiteViewAddToolBarInterface      $siteviewaddtoolbar                   The SiteView AddToolBar Class.
	 * @param ModelData                        $modeldata                            The SiteViews ModelData Class.
	 * @param Headers                          $headers                              The SiteViews Headers Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Event $event,
		ContentOne $contentone,
		ContentMulti $contentmulti,
		LicenseLock $licenselock,
		SiteRouter $siterouter,
		RouteHelperInterface $routehelper,
		Language $language,
		Placeholder $placeholder,
		CustomGetMethods $customgetmethods,
		Methods $dynamicmethods,
		CustomViewBody $customviewbody,
		CustomViewDisplayMethodInterface $customviewdisplaymethod,
		CustomViewFormInterface $customviewform,
		CustomViewTemplateBody $customviewtemplatebody,
		CodeBody $customviewcodebody,
		ExtraDisplayMethods $extradisplaymethods,
		PrepareDocument $preparedocument,
		MenuCustomViewInterface $menucustomview,
		SiteViewAddToolBarInterface $siteviewaddtoolbar,
		ModelData $modeldata,
		Headers $headers,
		ApiResource $apiresource)
	{
		$this->config = $config;
		$this->event = $event;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
		$this->licenselock = $licenselock;
		$this->siterouter = $siterouter;
		$this->routehelper = $routehelper;
		$this->language = $language;
		$this->placeholder = $placeholder;
		$this->customgetmethods = $customgetmethods;
		$this->dynamicmethods = $dynamicmethods;
		$this->customviewbody = $customviewbody;
		$this->customviewdisplaymethod = $customviewdisplaymethod;
		$this->customviewform = $customviewform;
		$this->customviewtemplatebody = $customviewtemplatebody;
		$this->customviewcodebody = $customviewcodebody;
		$this->extradisplaymethods = $extradisplaymethods;
		$this->preparedocument = $preparedocument;
		$this->menucustomview = $menucustomview;
		$this->siteviewaddtoolbar = $siteviewaddtoolbar;
		$this->modeldata = $modeldata;
		$this->headers = $headers;
		$this->apiresource = $apiresource;
	}

	/**
	 * Build everything one site view adds to the compiler.
	 *
	 * @param   array  $view  The site view the component was given.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function build(array $view): void
	{
		// for list views
		$this->contentmulti->set($view['settings']->code . '|SViews',
			$view['settings']->Code
		);
		$this->contentmulti->set($view['settings']->code . '|sviews',
			$view['settings']->code
		);
		// for single views
		$this->contentmulti->set($view['settings']->code . '|SView',
			$view['settings']->Code
		);
		$this->contentmulti->set($view['settings']->code . '|sview',
			$view['settings']->code
		);

		// set placeholders
		$this->placeholder->set('SView', $view['settings']->Code);
		$this->placeholder->set('sview', $view['settings']->code);
		$this->placeholder->set('SVIEW', $view['settings']->CODE);

		$this->placeholder->set('SViews', $view['settings']->Code);
		$this->placeholder->set('sviews', $view['settings']->code);
		$this->placeholder->set('SVIEWS', $view['settings']->CODE);

		// Trigger Event: jcb_ce_onBeforeBuildSiteViewContent
		$this->event->trigger(
			'jcb_ce_onBeforeBuildSiteViewContent', [&$view, &$view['settings']->code]
		);

		// set license per view if needed
		$this->licenselock->setView($view['settings']->code);

		// set the site default view
		if (isset($view['default_view'])
			&& $view['default_view'] == 1)
		{
			$this->contentone->set('SITE_DEFAULT_VIEW',
				$view['settings']->code
			);
		}
		// add site menu
		if (isset($view['menu']) && $view['menu'] == 1)
		{
			// SITE_MENU_XML <<<DYNAMIC>>>
			$this->contentmulti->set($view['settings']->code . '|SITE_MENU_XML',
				$this->menucustomview->get($view)
			);
		}

		// insure the needed route helper is loaded
		$this->contentone->add('ROUTEHELPER',
			$this->routehelper->get(
			$view['settings']->code, $view['settings']->code, true
		));
		// build route details
		$this->contentone->add('ROUTER_PARSE_SWITCH',
			$this->siterouter->parseSwitch(
			$view['settings']->code, $view
		));
		$this->contentone->add('ROUTER_BUILD_VIEWS',
			$this->siterouter->buildViews($view['settings']->code)
		);

		// the model data this view's main get type asks for
		$this->modeldata->set($view);

		// the API resource of this view, when the component has an API
		$this->apiresource->set($view, 'site');
		// add to lang array
		$this->language->set(
			'site',
			$this->config->lang_prefix . '_' . $view['settings']->CODE,
			$view['settings']->name
		);
		$this->language->set(
			'site',
			$this->config->lang_prefix . '_' . $view['settings']->CODE
			. '_DESC', $view['settings']->description
		);
		// SITE_CUSTOM_METHODS <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_CUSTOM_METHODS',
			$this->customgetmethods->get(
				$view['settings']->main_get, $view['settings']->code
			)
		);
		$this->contentmulti->add($view['settings']->code . '|SITE_CUSTOM_METHODS',
			$this->dynamicmethods->get(
				$view, $view['settings']->code
			), false
		);
		// SITE_DIPLAY_METHOD <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_DIPLAY_METHOD',
			$this->customviewdisplaymethod->get($view)
		);
		// set document details
		$this->preparedocument->set($view);
		// SITE_EXTRA_DIPLAY_METHODS <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_EXTRA_DIPLAY_METHODS',
			$this->extradisplaymethods->get($view)
		);
		// SITE_CODE_BODY <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_CODE_BODY',
			$this->customviewcodebody->get($view)
		);
		// SITE_BODY <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_BODY',
			$this->customviewbody->get($view)
		);
		// SITE_ADDTOOLBAR <<<DYNAMIC>>>
		$this->contentmulti->set($view['settings']->code . '|SITE_ADDTOOLBAR',
			$this->siteviewaddtoolbar->get($view)
		);

		// setup the templates
		$this->customviewtemplatebody->set($view);

		// set the site form if needed
		$this->contentmulti->set($view['settings']->code . '|SITE_TOP_FORM',
			$this->customviewform->get(
				$view['settings']->code,
				$view['settings']->main_get->gettype, 1
			)
		);
		$this->contentmulti->set($view['settings']->code . '|SITE_BOTTOM_FORM',
			$this->customviewform->get(
				$view['settings']->code,
				$view['settings']->main_get->gettype, 2
			)
		);

		// the file headers this view's main get type asks for
		$this->headers->set($view);

		// Trigger Event: jcb_ce_onAfterBuildSiteViewContent
		$this->event->trigger(
			'jcb_ce_onAfterBuildSiteViewContent', [&$view, &$view['settings']->code]
		);
	}
}

