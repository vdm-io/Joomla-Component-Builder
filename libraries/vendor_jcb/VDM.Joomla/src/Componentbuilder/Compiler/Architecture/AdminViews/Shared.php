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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\DynamicButtons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\AliasTitleFix;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\GenerateNewAlias;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\GenerateNewTitle;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\UniqueFields;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Router\SiteRouter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Creator\AccessSectionsCategory;
use VDM\Joomla\Componentbuilder\Compiler\Creator\AccessSectionsJoomlaFields;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\AddToolBarInterface as AdminViewsAddToolBarInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowAddInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\AllowEditInterface as ControllerAllowEditInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Controller\CustomAdminDynamicButtonInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\AllowEditInterface as ModelAllowEditInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\BatchCopyInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\BatchMoveInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanDeleteInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\CanEditStateInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\GetFormInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Router\RouteHelperInterface;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;


/**
 * Admin Views Shared Class.
 * 
 * Builds the pieces an admin view needs whether or not it can be edited or
 * listed: what a batch may copy and move, what a controller and a model will
 * let a user do, the buttons a custom admin view adds, the routes the site
 * reaches it by, and the permissions it is asked for.
 * 
 * The order the pieces are asked for is the order the compiler has always
 * asked for them in, and the event fired at the end is the same event.
 * 
 * @since 6.1.7
 */
final class Shared
{
	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 6.1.7
	 */
	protected Event $event;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

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
	 * The Router SiteRouter Class.
	 *
	 * @var   SiteRouter
	 * @since 6.1.7
	 */
	protected SiteRouter $siterouter;

	/**
	 * The AdminViews AddToolBar Class.
	 *
	 * @var   AdminViewsAddToolBarInterface
	 * @since 6.1.7
	 */
	protected AdminViewsAddToolBarInterface $adminviewsaddtoolbar;

	/**
	 * The Controller AllowAdd Class.
	 *
	 * @var   AllowAddInterface
	 * @since 6.1.7
	 */
	protected AllowAddInterface $allowadd;

	/**
	 * The Controller AllowEdit Class.
	 *
	 * @var   ControllerAllowEditInterface
	 * @since 6.1.7
	 */
	protected ControllerAllowEditInterface $controllerallowedit;

	/**
	 * The Dynamic Buttons Class.
	 *
	 * @var   DynamicButtons
	 * @since 6.1.7
	 */
	protected DynamicButtons $dynamicbuttons;

	/**
	 * The Model AllowEdit Class.
	 *
	 * @var   ModelAllowEditInterface
	 * @since 6.1.7
	 */
	protected ModelAllowEditInterface $modelallowedit;

	/**
	 * The Model CanDelete Class.
	 *
	 * @var   CanDeleteInterface
	 * @since 6.1.7
	 */
	protected CanDeleteInterface $candelete;

	/**
	 * The Model CanEditState Class.
	 *
	 * @var   CanEditStateInterface
	 * @since 6.1.7
	 */
	protected CanEditStateInterface $caneditstate;

	/**
	 * The Access Sections Category Creator Class.
	 *
	 * @var   AccessSectionsCategory
	 * @since 6.1.7
	 */
	protected AccessSectionsCategory $accesssectionscategory;

	/**
	 * The Access Sections Joomla Fields Creator Class.
	 *
	 * @var   AccessSectionsJoomlaFields
	 * @since 6.1.7
	 */
	protected AccessSectionsJoomlaFields $accesssectionsjoomlafields;

	/**
	 * The Model AliasTitleFix Class.
	 *
	 * @var   AliasTitleFix
	 * @since 6.1.7
	 */
	protected AliasTitleFix $aliastitlefix;

	/**
	 * The Model BatchCopy Class.
	 *
	 * @var   BatchCopyInterface
	 * @since 6.1.7
	 */
	protected BatchCopyInterface $batchcopy;

	/**
	 * The Model BatchMove Class.
	 *
	 * @var   BatchMoveInterface
	 * @since 6.1.7
	 */
	protected BatchMoveInterface $batchmove;

	/**
	 * The Model GenerateNewAlias Class.
	 *
	 * @var   GenerateNewAlias
	 * @since 6.1.7
	 */
	protected GenerateNewAlias $generatenewalias;

	/**
	 * The Model GenerateNewTitle Class.
	 *
	 * @var   GenerateNewTitle
	 * @since 6.1.7
	 */
	protected GenerateNewTitle $generatenewtitle;

	/**
	 * The Model GetForm Class.
	 *
	 * @var   GetFormInterface
	 * @since 6.1.7
	 */
	protected GetFormInterface $getform;

	/**
	 * The Router RouteHelper Class.
	 *
	 * @var   RouteHelperInterface
	 * @since 6.1.7
	 */
	protected RouteHelperInterface $routehelper;

	/**
	 * The Model UniqueFields Class.
	 *
	 * @var   UniqueFields
	 * @since 6.1.7
	 */
	protected UniqueFields $uniquefields;

	/**
	 * The Controller CustomAdminDynamicButton Class.
	 *
	 * @var   CustomAdminDynamicButtonInterface
	 * @since 6.1.7
	 */
	protected CustomAdminDynamicButtonInterface $customadmindynamicbutton;

	/**
	 * Constructor.
	 *
	 * @param Event                             $event                                 The Event Class.
	 * @param Dispenser                         $dispenser                             The Customcode Dispenser Class.
	 * @param ContentOne                        $contentone                            The Content One Builder Class.
	 * @param ContentMulti                      $contentmulti                          The Content Multi Builder Class.
	 * @param SiteRouter                        $siterouter                            The Router SiteRouter Class.
	 * @param AdminViewsAddToolBarInterface     $adminviewsaddtoolbar                  The AdminViews AddToolBar Class.
	 * @param AllowAddInterface                 $allowadd                              The Controller AllowAdd Class.
	 * @param ControllerAllowEditInterface      $controllerallowedit                   The Controller AllowEdit Class.
	 * @param DynamicButtons                    $dynamicbuttons                        The Dynamic Buttons Class.
	 * @param ModelAllowEditInterface           $modelallowedit                        The Model AllowEdit Class.
	 * @param CanDeleteInterface                $candelete                             The Model CanDelete Class.
	 * @param CanEditStateInterface             $caneditstate                          The Model CanEditState Class.
	 * @param AccessSectionsCategory            $accesssectionscategory                The Access Sections Category Creator Class.
	 * @param AccessSectionsJoomlaFields        $accesssectionsjoomlafields            The Access Sections Joomla Fields Creator Class.
	 * @param AliasTitleFix                     $aliastitlefix                         The Model AliasTitleFix Class.
	 * @param BatchCopyInterface                $batchcopy                             The Model BatchCopy Class.
	 * @param BatchMoveInterface                $batchmove                             The Model BatchMove Class.
	 * @param GenerateNewAlias                  $generatenewalias                      The Model GenerateNewAlias Class.
	 * @param GenerateNewTitle                  $generatenewtitle                      The Model GenerateNewTitle Class.
	 * @param GetFormInterface                  $getform                               The Model GetForm Class.
	 * @param RouteHelperInterface              $routehelper                           The Router RouteHelper Class.
	 * @param UniqueFields                      $uniquefields                          The Model UniqueFields Class.
	 * @param CustomAdminDynamicButtonInterface $customadmindynamicbutton              The Controller CustomAdminDynamicButton Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Event $event,
		Dispenser $dispenser,
		ContentOne $contentone,
		ContentMulti $contentmulti,
		SiteRouter $siterouter,
		AdminViewsAddToolBarInterface $adminviewsaddtoolbar,
		AllowAddInterface $allowadd,
		ControllerAllowEditInterface $controllerallowedit,
		DynamicButtons $dynamicbuttons,
		ModelAllowEditInterface $modelallowedit,
		CanDeleteInterface $candelete,
		CanEditStateInterface $caneditstate,
		AccessSectionsCategory $accesssectionscategory,
		AccessSectionsJoomlaFields $accesssectionsjoomlafields,
		AliasTitleFix $aliastitlefix,
		BatchCopyInterface $batchcopy,
		BatchMoveInterface $batchmove,
		GenerateNewAlias $generatenewalias,
		GenerateNewTitle $generatenewtitle,
		GetFormInterface $getform,
		RouteHelperInterface $routehelper,
		UniqueFields $uniquefields,
		CustomAdminDynamicButtonInterface $customadmindynamicbutton)
	{
		$this->event = $event;
		$this->dispenser = $dispenser;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
		$this->siterouter = $siterouter;
		$this->adminviewsaddtoolbar = $adminviewsaddtoolbar;
		$this->allowadd = $allowadd;
		$this->controllerallowedit = $controllerallowedit;
		$this->dynamicbuttons = $dynamicbuttons;
		$this->modelallowedit = $modelallowedit;
		$this->candelete = $candelete;
		$this->caneditstate = $caneditstate;
		$this->accesssectionscategory = $accesssectionscategory;
		$this->accesssectionsjoomlafields = $accesssectionsjoomlafields;
		$this->aliastitlefix = $aliastitlefix;
		$this->batchcopy = $batchcopy;
		$this->batchmove = $batchmove;
		$this->generatenewalias = $generatenewalias;
		$this->generatenewtitle = $generatenewtitle;
		$this->getform = $getform;
		$this->routehelper = $routehelper;
		$this->uniquefields = $uniquefields;
		$this->customadmindynamicbutton = $customadmindynamicbutton;
	}

	/**
	 * Build the pieces both views of one admin view share.
	 *
	 * @param   array   $view            The view being built.
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $nameListCode    The list view name.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function build(&$view, &$nameSingleCode, &$nameListCode): void
	{
		// set u fields used in batch
		$this->contentmulti->set($nameSingleCode . '|UNIQUEFIELDS',
			$this->uniquefields->get(
				$nameSingleCode
			)
		);

		// TITLEALIASFIX <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|TITLEALIASFIX',
			$this->aliastitlefix->get(
				$nameSingleCode
			)
		);

		// GENERATENEWTITLE <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|GENERATENEWTITLE',
			$this->generatenewtitle->get(
				$nameSingleCode
			)
		);

		// GENERATENEWALIAS <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|GENERATENEWALIAS',
			$this->generatenewalias->get(
				$nameSingleCode
			)
		);

		// MODEL_BATCH_COPY <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|MODEL_BATCH_COPY',
			$this->batchcopy->get($nameSingleCode)
		);

		// MODEL_BATCH_MOVE <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|MODEL_BATCH_MOVE',
			$this->batchmove->get($nameSingleCode)
		);

		// BATCH_ONCLICK_CANCEL_SCRIPT <<<DYNAMIC>>>
		$this->contentmulti->set($nameListCode . '|BATCH_ONCLICK_CANCEL_SCRIPT', ''); // TODO <-- must still be build

		// JCONTROLLERFORM_ALLOWADD <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JCONTROLLERFORM_ALLOWADD',
			$this->allowadd->get(
				$nameSingleCode,
			)
		);

		// JCONTROLLERFORM_BEFORECANCEL <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JCONTROLLERFORM_BEFORECANCEL',
			$this->dispenser->get(
				'php_before_cancel', $nameSingleCode,
				PHP_EOL, null, false,
				''
			)
		);

		// JCONTROLLERFORM_AFTERCANCEL <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JCONTROLLERFORM_AFTERCANCEL',
			$this->dispenser->get(
				'php_after_cancel', $nameSingleCode,
				PHP_EOL, null, false,
				''
			)
		);

		// JCONTROLLERFORM_ALLOWEDIT <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JCONTROLLERFORM_ALLOWEDIT',
			$this->controllerallowedit->get(
				$nameSingleCode,
				$nameListCode
			)
		);

		// JMODELADMIN_GETFORM <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JMODELADMIN_GETFORM',
			$this->getform->get(
				$nameSingleCode,
				$nameListCode
			)
		);

		// JMODELADMIN_ALLOWEDIT <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JMODELADMIN_ALLOWEDIT',
			$this->modelallowedit->get(
				$nameSingleCode,
				$nameListCode
			)
		);

		// JMODELADMIN_CANDELETE <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JMODELADMIN_CANDELETE',
			$this->candelete->get(
				$nameSingleCode
			)
		);

		// JMODELADMIN_CANEDITSTATE <<<DYNAMIC>>>
		$this->contentmulti->set($nameSingleCode . '|JMODELADMIN_CANEDITSTATE',
			$this->caneditstate->get(
				$nameSingleCode
			)
		);

		// set custom admin view Toolbare buttons
		// CUSTOM_ADMIN_DYNAMIC_BUTTONS  <<<DYNAMIC>>>
		$this->contentmulti->set($nameListCode . '|CUSTOM_ADMIN_DYNAMIC_BUTTONS',
			$this->dynamicbuttons->get(
				$nameListCode
			)
		);
		// CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER  <<<DYNAMIC>>>
		$this->contentmulti->set($nameListCode . '|CUSTOM_ADMIN_DYNAMIC_BUTTONS_CONTROLLER',
			$this->customadmindynamicbutton->get(
				$nameListCode
			)
		);

		// ADDTOOLBAR <<<DYNAMIC>>>
		$this->contentmulti->set($nameListCode . '|ADDTOOLBAR',
			$this->adminviewsaddtoolbar->get($view)
		);

		// set helper router
		$this->contentone->add('ROUTEHELPER',
			$this->routehelper->get(
			(string) $nameSingleCode,
			(string) $nameListCode
		));

		if (isset($view['edit_create_site_view'])
			&& is_numeric(
				$view['edit_create_site_view']
			)
			&& $view['edit_create_site_view'] > 0)
		{
			// add needed router stuff for front edit views
			$this->contentone->add('ROUTER_PARSE_SWITCH',
				$this->siterouter->parseSwitch(
				$nameSingleCode, null, false
			));
			$this->contentone->add('ROUTER_BUILD_VIEWS',
				$this->siterouter->buildViews(
				(string) $nameSingleCode
			));
		}

		// ACCESS_SECTIONS
		$this->contentone->add('ACCESS_SECTIONS',
			$this->accesssectionscategory->get(
				$nameSingleCode,
				$nameListCode
			)
		);
		// set the Joomla Fields ACCESS section if needed
		if (isset($view['joomla_fields'])
			&& $view['joomla_fields'] == 1)
		{
			$this->contentone->add('ACCESS_SECTIONS',
				$this->accesssectionsjoomlafields->get()
			);
		}

		// Trigger Event: jcb_ce_onAfterBuildAdminViewContent
		$this->event->trigger(
			'jcb_ce_onAfterBuildAdminViewContent', [&$view, &$nameSingleCode, &$nameListCode]
		);
	}
}

