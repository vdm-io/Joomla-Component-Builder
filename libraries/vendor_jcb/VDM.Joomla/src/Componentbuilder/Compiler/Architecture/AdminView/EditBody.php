<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView;


use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Registry;
use VDM\Joomla\Componentbuilder\Compiler\Adminview\Data as AdminviewData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\HasPermissions;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Layout;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MetaData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\MovedPublishingFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\NewPublishingFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SecondRunAdmin;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TabCounter;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Layout\View as LayoutView;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\EditBodyInterface;


/**
 * Admin Edit View Body Class.
 * 
 * Builds the edit template of an admin view: the tab set, the layouts each
 * tab renders, the side and title areas, and the trailing publishing,
 * metadata and permissions tabs.
 * 
 * The markup a Joomla target expects differs only in its grid and tab
 * vocabulary and in how the outer containers close, so those are the
 * extension points the target variants override. Everything else — which
 * fields land in which alignment, which layouts are emitted, and which
 * linked views are deferred to the second pass — is the same for every
 * target and lives here.
 * 
 * @since  6.1.7
 */
class EditBody implements EditBodyInterface
{
	/**
	 * The alignment names, keyed by their stored position.
	 *
	 * @var   array<int, string>
	 * @since 6.1.7
	 */
	protected array $alignmentOptions = [
		1 => 'left', 2 => 'right', 3 => 'fullwidth', 4 => 'above',
		5 => 'under', 6 => 'leftside', 7 => 'rightside'
	];

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Registry Class.
	 *
	 * @var   Registry
	 * @since 6.1.7
	 */
	protected Registry $registry;

	/**
	 * The Adminview Data Class.
	 *
	 * @var   AdminviewData
	 * @since 6.1.7
	 */
	protected AdminviewData $adminviewdata;

	/**
	 * The Permission Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The Layout View Class.
	 *
	 * @var   LayoutView
	 * @since 6.1.7
	 */
	protected LayoutView $layoutview;

	/**
	 * The Custom Tabs Class.
	 *
	 * @var   CustomTabs
	 * @since 6.1.7
	 */
	protected CustomTabs $customtabs;

	/**
	 * The Layout Class.
	 *
	 * @var   Layout
	 * @since 6.1.7
	 */
	protected Layout $layout;

	/**
	 * The Tab Counter Class.
	 *
	 * @var   TabCounter
	 * @since 6.1.7
	 */
	protected TabCounter $tabcounter;

	/**
	 * The Second Run Admin Class.
	 *
	 * @var   SecondRunAdmin
	 * @since 6.1.7
	 */
	protected SecondRunAdmin $secondrunadmin;

	/**
	 * The New Publishing Fields Class.
	 *
	 * @var   NewPublishingFields
	 * @since 6.1.7
	 */
	protected NewPublishingFields $newpublishingfields;

	/**
	 * The Moved Publishing Fields Class.
	 *
	 * @var   MovedPublishingFields
	 * @since 6.1.7
	 */
	protected MovedPublishingFields $movedpublishingfields;

	/**
	 * The Meta Data Class.
	 *
	 * @var   MetaData
	 * @since 6.1.7
	 */
	protected MetaData $metadata;

	/**
	 * The Access Switch Class.
	 *
	 * @var   AccessSwitch
	 * @since 6.1.7
	 */
	protected AccessSwitch $accessswitch;

	/**
	 * The Has Permissions Class.
	 *
	 * @var   HasPermissions
	 * @since 6.1.7
	 */
	protected HasPermissions $haspermissions;

	/**
	 * The Application Class.
	 *
	 * @var   CMSApplicationInterface
	 * @since 6.1.7
	 */
	protected CMSApplicationInterface $app;

	/**
	 * Constructor.
	 *
	 * @param Config                   $config                  The Config Class.
	 * @param Language                 $language                The Language Class.
	 * @param Registry                 $registry                The Registry Class.
	 * @param AdminviewData            $adminviewdata           The Adminview Data Class.
	 * @param Permission               $permission              The Permission Class.
	 * @param LayoutView               $layoutview              The Layout View Class.
	 * @param CustomTabs               $customtabs              The Custom Tabs Class.
	 * @param Layout                   $layout                  The Layout Class.
	 * @param TabCounter               $tabcounter              The Tab Counter Class.
	 * @param SecondRunAdmin           $secondrunadmin          The Second Run Admin Class.
	 * @param NewPublishingFields      $newpublishingfields     The New Publishing Fields Class.
	 * @param MovedPublishingFields    $movedpublishingfields   The Moved Publishing Fields Class.
	 * @param MetaData                 $metadata                The Meta Data Class.
	 * @param AccessSwitch             $accessswitch            The Access Switch Class.
	 * @param HasPermissions           $haspermissions          The Has Permissions Class.
	 * @param CMSApplicationInterface|null  $app                The Application Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Language $language,
		Registry $registry, AdminviewData $adminviewdata,
		Permission $permission, LayoutView $layoutview,
		CustomTabs $customtabs, Layout $layout, TabCounter $tabcounter,
		SecondRunAdmin $secondrunadmin,
		NewPublishingFields $newpublishingfields,
		MovedPublishingFields $movedpublishingfields, MetaData $metadata,
		AccessSwitch $accessswitch, HasPermissions $haspermissions,
		?CMSApplicationInterface $app = null)
	{
		$this->config = $config;
		$this->language = $language;
		$this->registry = $registry;
		$this->adminviewdata = $adminviewdata;
		$this->permission = $permission;
		$this->layoutview = $layoutview;
		$this->customtabs = $customtabs;
		$this->layout = $layout;
		$this->tabcounter = $tabcounter;
		$this->secondrunadmin = $secondrunadmin;
		$this->newpublishingfields = $newpublishingfields;
		$this->movedpublishingfields = $movedpublishingfields;
		$this->metadata = $metadata;
		$this->accessswitch = $accessswitch;
		$this->haspermissions = $haspermissions;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Get the edit view body of an admin view.
	 *
	 * @param   array  $view  The view definition with its settings object.
	 *
	 * @return  string  The generated edit body, empty when the view has no layout.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		// set view name
		$nameSingleCode = $view['settings']->name_single_code;
		// main lang prefix
		$langView = $this->config->lang_prefix . '_'
			. StringHelper::safe($nameSingleCode, 'U');
		// check if the load build is set for this view
		if (!$this->layout->exists($nameSingleCode))
		{
			return '';
		}

		// reset the linked keys
		$keys                 = [];
		$linkedViewIdentifier = [];
		// set the linked view tabs
		$linkedTab = $this->getLinkedAdminViewsTabs(
			$view, $nameSingleCode, $keys, $linkedViewIdentifier
		);
		// custom tab searching array
		$searchTabs = [];
		// reset tab values
		$leftside    = '';
		$rightside   = '';
		$footer      = '';
		$header      = '';
		$mainwidth   = 12;
		$sidewidth   = 0;
		$width_class = $this->getWidthClass();
		$row_class   = $this->getRowClass();
		$form_class  = $this->getFormClass();
		$uitab       = $this->getUiTab();
		$side_open   = $this->getSideOpen();
		$side_close  = $this->getSideClose();
		// get the tabs with positions
		$tabBucket = $this->getTabs(
			$nameSingleCode, $langView, $linkedTab, $keys,
			$linkedViewIdentifier, $searchTabs, $leftside, $rightside,
			$footer, $header, $mainwidth, $sidewidth
		);
		// tab counter
		$tabCounter = 0;
		// check if width is still 12
		$span = '';
		if ($mainwidth != 12)
		{
			$span = $width_class . $mainwidth;
		}
		// a view with side content needs an extra row on the modern targets
		$hasSides = strlen((string) $leftside) > 2
			|| strlen((string) $rightside) > 2;
		// start building body
		$body = PHP_EOL . '<div class="' . $form_class . '">';
		$body .= $this->getBodyRowOpen($hasSides);
		if (StringHelper::check($span))
		{
			$body .= PHP_EOL . Indent::_(1) . '<div class="' . $span . '">';
		}
		// now build the dynamic tabs
		foreach ($tabBucket as $tabCodeName => $positions)
		{
			// get lang string
			$tabLangName = $positions['lang'] ?? 'error_missing_lang';
			// build main center position
			$main       = '';
			$mainbottom = '';
			$this->setTabMainCenterPositionDiv(
				$main, $mainbottom, $positions
			);
			// set acctive tab (must be in side foreach loop to get active tab code name)
			if ($tabCounter == 0)
			{
				$body .= PHP_EOL . PHP_EOL . Indent::_(1)
					. "<?php echo Html::_('{$uitab}.startTabSet', '"
					. $nameSingleCode . "Tab', ['active' => '"
					. $tabCodeName . "', 'recall' => true]); ?>";
			}
			// check if custom tab must be added
			if (($_customTabHTML = $this->customtabs->get(
					$searchTabs[$tabCodeName], $nameSingleCode, 1
				)) !== false)
			{
				$body .= $_customTabHTML;
			}
			// if this is a linked view set permissions
			$closeIT = false;
			if (ArrayHelper::check($linkedViewIdentifier)
				&& in_array($tabCodeName, $linkedViewIdentifier))
			{
				// get view name
				$linkedViewGuid   = array_search(
					$tabCodeName, $linkedViewIdentifier
				);
				$linkedViewData = $this->adminviewdata->get($linkedViewGuid);
				$linkedCodeName = StringHelper::safe(
					$linkedViewData->name_single
				);
				// check if the item has permissions.
				if ($this->permission->globalExist($linkedCodeName, 'core.access'))
				{
					$body .= PHP_EOL . PHP_EOL . Indent::_(1)
						. "<?php if (\$this->canDo->get('"
						. $this->permission->getGlobal($linkedCodeName, 'core.access') . "')) : ?>";
					$closeIT = true;
				}
				else
				{
					$body .= PHP_EOL;
				}
			}
			else
			{
				$body .= PHP_EOL;
			}
			// start addtab body
			$body .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.addTab', '"
				. $nameSingleCode . "Tab', '" . $tabCodeName . "', Text:"
				. ":_('" . $tabLangName . "', true)); ?>";
			// add the main
			$body .= PHP_EOL . Indent::_(2)
				. '<div class="' . $row_class . '">';
			$body .= $main;
			$body .= PHP_EOL . Indent::_(2) . "</div>";
			// add main body bottom div if needed
			if (strlen((string) $mainbottom) > 0)
			{
				// add the main bottom
				$body .= PHP_EOL . Indent::_(2)
					. '<div class="' . $row_class . '">';
				$body .= $mainbottom;
				$body .= PHP_EOL . Indent::_(2) . "</div>";
			}
			// end addtab body
			$body .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			// if we had permissions added
			if ($closeIT)
			{
				$body .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			}
			// check if custom tab must be added
			if (($_customTabHTML = $this->customtabs->get(
					$searchTabs[$tabCodeName], $nameSingleCode, 2
				)) !== false)
			{
				$body .= $_customTabHTML;
			}
			// set counter
			$tabCounter++;
		}
		// add option to load forms loaded in via plugins (TODO) we may want to move these tab locations
		$body .= PHP_EOL . PHP_EOL . Indent::_(1)
			. "<?php \$this->ignore_fieldsets = array('details','metadata','vdmmetadata','accesscontrol'); ?>";
		$body .= PHP_EOL . Indent::_(1) . "<?php \$this->tab_name = '"
			. $nameSingleCode . "Tab'; ?>";
		$body .= PHP_EOL . Indent::_(1)
			. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('joomla.edit.params', \$this); ?>";
		// add the publish and meta data tabs
		$body .= $this->getPublishMetaTabs(
			$nameSingleCode, $langView
		);
		// end the tab set
		$body .= PHP_EOL . PHP_EOL . Indent::_(1)
			. "<?php echo Html::_('{$uitab}.endTabSet'); ?>";
		$body .= PHP_EOL . PHP_EOL . Indent::_(1) . "<div>";
		$body .= PHP_EOL . Indent::_(2)
			. '<input type="hidden" name="task" value="' . $nameSingleCode
			. '.edit" />';
		$body .= PHP_EOL . Indent::_(2)
			. "<?php echo Html::_('form.token'); ?>";
		$body .= PHP_EOL . Indent::_(1) . "</div>";
		// close divs
		if (StringHelper::check($span))
		{
			$body .= PHP_EOL . Indent::_(1) . "</div>";
		}
		// check if left has been set
		if (strlen((string) $leftside) > 2)
		{
			$left = PHP_EOL . Indent::_(1) . '<div class="' . $width_class . $sidewidth . '">' . $side_open;
			$left .= $leftside;
			$left .= PHP_EOL . Indent::_(1) . $side_close . "</div>";
		}
		else
		{
			$left = '';
		}
		// check if right has been set
		if (strlen((string) $rightside) > 2)
		{
			$right = PHP_EOL . Indent::_(1) . '<div class="' . $width_class . $sidewidth . '">' . $side_open;
			$right .= $rightside;
			$right .= PHP_EOL . Indent::_(1) . $side_close . "</div>";
		}
		else
		{
			$right = '';
		}

		$body .= $this->getBodyTail($hasSides);
		$right .= $this->getSidesTail($hasSides);

		// set active tab and return
		return $header . $left . $body . $right . $footer;
	}

	/**
	 * Get the grid width class prefix of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getWidthClass(): string
	{
		return 'col-md-';
	}

	/**
	 * Get the row class of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getRowClass(): string
	{
		return 'row';
	}

	/**
	 * Get the outer form class of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getFormClass(): string
	{
		return 'main-card';
	}

	/**
	 * Get the tab helper name of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getUiTab(): string
	{
		return 'uitab';
	}

	/**
	 * Get the markup that opens a side area of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSideOpen(): string
	{
		return '<div class="m-md-3">';
	}

	/**
	 * Get the markup that closes a side area of the target.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSideClose(): string
	{
		return '</div>';
	}

	/**
	 * Get the row the modern targets wrap the body and its sides in.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getBodyRowOpen(bool $hasSides): string
	{
		return $hasSides ? PHP_EOL . '<div class="row">' : '';
	}

	/**
	 * Get the containers the body closes for itself.
	 *
	 * With a side area the modern targets close the body and the wrapping
	 * row after the sides instead, so the body closes nothing here.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getBodyTail(bool $hasSides): string
	{
		return $hasSides ? '' : PHP_EOL . '</div>';
	}

	/**
	 * Get the containers the side areas close on the target's behalf.
	 *
	 * @param   bool  $hasSides  Whether the view renders a side area.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getSidesTail(bool $hasSides): string
	{
		return $hasSides ? PHP_EOL . '</div>' . PHP_EOL . '</div>' : '';
	}

	/**
	 * Get the access-control fieldset of the permissions tab.
	 *
	 * @param   string  $tabLangName  The language key of the tab.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getPermissionsFieldset(string $tabLangName): string
	{
		$tabs = PHP_EOL . Indent::_(4) . '<fieldset id="fieldset-rules" class="options-form">';
		$tabs .= PHP_EOL . Indent::_(5)
			. "<legend><?php echo Text:"
			. ":_('{$tabLangName}'); ?></legend>";
		$tabs .= PHP_EOL . Indent::_(5) . "<div>";
		$tabs .= PHP_EOL . Indent::_(6)
			. "<?php echo \$this->form->getInput('rules'); ?>";
		$tabs .= PHP_EOL . Indent::_(5) . "</div>";
		$tabs .= PHP_EOL . Indent::_(4) . "</fieldset>";

		return $tabs;
	}

	/**
	 * Get the tabs a view's linked admin views occupy.
	 *
	 * @param   array   $view                  The view data.
	 * @param   string  $nameSingleCode        The single view name.
	 * @param   array   $keys                  The tabs to add in layout.
	 * @param   array   $linkedViewIdentifier  The linked view identifier.
	 *
	 * @return  array  The linked admin view tabs.
	 *
	 * @since   6.1.7
	 */
	protected function getLinkedAdminViewsTabs(&$view,
		&$nameSingleCode, &$keys, &$linkedViewIdentifier
	)
	{
		// start linked tabs bucket
		$linkedTab = [];
		// check if the view has linked admin view
		if (($linkedAdminViews = $this->registry->get('builder.linked_admin_views.' . $nameSingleCode, null)) !== null
			&& ArrayHelper::check($linkedAdminViews))
		{
			foreach ($linkedAdminViews as $linkedView)
			{
				// when this happens tell me.
				if (!isset($view['settings']->tabs[(int) $linkedView['tab']]))
				{
					echo "Tab Mismatch Oops! Check your linked views in admin view ($nameSingleCode) that they line-up.";
					echo '<pre>';
					var_dump($view['settings']->tabs, $linkedView);
					exit;
				}
				// get the tab name
				$tabName = $view['settings']->tabs[(int) $linkedView['tab']];
				// update the tab counter
				$this->tabcounter->set($nameSingleCode . '.' . $linkedView['tab'], $tabName);
				// add the linked view
				$linkedTab[$linkedView['adminview']] = $linkedView['tab'];
				// set the keys if values are set
				if (StringHelper::check($linkedView['key'])
					&& StringHelper::check(
						$linkedView['parentkey']
					))
				{
					$keys[$linkedView['adminview']]
						= array('key'       => $linkedView['key'],
						'parentKey' => $linkedView['parentkey']);
				}
				else
				{
					$keys[$linkedView['adminview']] = array('key'       => null,
						'parentKey' => null);
				}
				// set the button switches
				if (isset($linkedView['addnew']))
				{
					$keys[$linkedView['adminview']]['addNewButton']
						= (int) $linkedView['addnew'];
				}
				else
				{
					$keys[$linkedView['adminview']]['addNewButton'] = 0;
				}
			}
		}

		return $linkedTab;
	}

	/**
	 * Get the tabs of a view together with the content of each position.
	 *
	 * @param   string  $nameSingleCode        The single view name.
	 * @param   string  $langView              The main lang prefix.
	 * @param   array   $linkedTab             The linked admin view tabs.
	 * @param   array   $keys                  The tabs to add in layout.
	 * @param   array   $linkedViewIdentifier  The linked view identifier.
	 * @param   array   $searchTabs            The tabs to add in layout.
	 * @param   string  $leftside              The left side html string.
	 * @param   string  $rightside             The right side html string.
	 * @param   string  $footer                The footer html string.
	 * @param   string  $header                The header html string.
	 * @param   int     $mainwidth             The main width value.
	 * @param   int     $sidewidth             The side width value.
	 *
	 * @return  array  The tabs of the view.
	 *
	 * @since   6.1.7
	 */
	protected function getTabs(&$nameSingleCode, &$langView,
		&$linkedTab, &$keys, &$linkedViewIdentifier, &$searchTabs, &$leftside,
		&$rightside, &$footer, &$header, &$mainwidth, &$sidewidth
	)
	{
		// start tabs
		$tabs = [];
		// sort the tabs based on key order
		$tab_counter = (array) $this->tabcounter->get($nameSingleCode, []);
		ksort($tab_counter);
		// start tab building loop
		foreach ($tab_counter as $tabNr => $tabName)
		{
			$tabWidth  = 12;
			$lrCounter = 0;
			// set tab lang
			$tabLangName = $langView . '_' . StringHelper::safe(
					$tabName, 'U'
				);
			// set tab code name
			$tabCodeName = StringHelper::safe($tabName);
			/// set the values to use in search latter
			$searchTabs[$tabCodeName] = $tabNr;
			// add to lang array
			$this->language->set($this->config->lang_target, $tabLangName, $tabName);
			// check if linked view belongs to this tab
			$buildLayout  = true;
			$linkedViewGuid = '';
			if (ArrayHelper::check($linkedTab))
			{
				if (($linkedViewGuid = array_search($tabNr, $linkedTab))
					!== false)
				{
					// don't build (since this is a linked view)
					$buildLayout = false;
				}
			}
			// build layout these are actual fields
			if ($buildLayout && $this->layout->exists($nameSingleCode . '.' . $tabName))
			{
				// sort to make sure it loads left first
				$alignments = $this->layout->get($nameSingleCode . '.' . $tabName);
				ksort($alignments);
				foreach ($alignments as $alignment => $names)
				{
					// set layout code name
					$layoutCodeName = $tabCodeName . '_'
						. $this->alignmentOptions[$alignment];
					// reset each time
					$items       = '';
					$itemCounter = 0;
					// sort the names based on order of keys
					$names = (array) $names;
					ksort($names);
					// build the items array for this alignment
					foreach ($names as $nr => $name)
					{
						if ($itemCounter == 0)
						{
							$items .= "'" . $name . "'";
						}
						else
						{
							$items .= "," . PHP_EOL . Indent::_(1) . "'" . $name
								. "'";
						}
						$itemCounter++;
					}
					// based on alignment build the layout
					switch ($alignment)
					{
						case 1: // left
						case 2: // right
							// count
							$lrCounter++;
							// set as items layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 3: // fullwidth
							// set as items layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutfull'
							);
							// set the lang to tab
							$tabs[$tabCodeName]['lang'] = $tabLangName;
							// load the body
							if (!isset($tabs[$tabCodeName][(int) $alignment]))
							{
								$tabs[$tabCodeName][(int) $alignment] = '';
							}
							$tabs[$tabCodeName][(int) $alignment] .= "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 4: // above
							// set as title layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layouttitle'
							);
							// load to header
							$header .= PHP_EOL
								. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 5: // under
							// set as title layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layouttitle'
							);
							// load to footer
							$footer .= PHP_EOL . PHP_EOL
								. "<div class=\"clearfix\"></div>" . PHP_EOL
								. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 6: // left side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// load the body
							$leftside .= PHP_EOL . Indent::_(2)
								. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
						case 7: // right side
							$tabWidth = $tabWidth - 2;
							// set as items layout
							$this->layoutview->set(
								$nameSingleCode, $layoutCodeName, $items,
								'layoutitems'
							);
							// load the body
							$rightside .= PHP_EOL . Indent::_(2)
								. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
								. $nameSingleCode . "." . $layoutCodeName
								. "', \$this); ?>";
							break;
					}
				}
			}
			else
			{
				// set layout code name
				$layoutCodeName = $tabCodeName . '_fullwidth';
				// set identifiers
				$linkedViewIdentifier[$linkedViewGuid] = $tabCodeName;
				//set function name
				$codeName = StringHelper::safe(
					Unique::get(3) . $tabCodeName
				);
				// set as items layout
				$this->layoutview->set(
					$nameSingleCode, $layoutCodeName, $codeName,
					'layoutlinkedview'
				);
				// set the lang to tab
				$tabs[$tabCodeName]['lang'] = $tabLangName;
				// set all the linked view stuff
				$this->secondrunadmin->add('setLinkedView', array(
					'viewGuid'         => $linkedViewGuid,
					'nameSingleCode' => $nameSingleCode,
					'codeName'       => $codeName,
					'layoutCodeName' => $layoutCodeName,
					'key'            => $keys[$linkedViewGuid]['key'],
					'parentKey'      => $keys[$linkedViewGuid]['parentKey'],
					'addNewButon'    => $keys[$linkedViewGuid]['addNewButton']), true);
				// load the body
				if (!isset($tabs[$tabCodeName][3]))
				{
					$tabs[$tabCodeName][3] = '';
				}
				$tabs[$tabCodeName][3] .= "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('"
					. $nameSingleCode . "." . $layoutCodeName
					. "', \$this); ?>";
			}
			// width calculator :)
			if ($tabWidth == 8)
			{
				$mainwidth = 8;
				$sidewidth = 2;
			}
			elseif ($tabWidth == 10 && $mainwidth != 8)
			{
				$mainwidth = 9;
				$sidewidth = 3;
			}
			$tabs[$tabCodeName]['lr'] = $lrCounter;
		}

		return $tabs;
	}

	/**
	 * Set the main and main bottom center positions of one tab.
	 *
	 * @param   string  $main        The main position of this tab.
	 * @param   string  $mainbottom  The main bottom position of this tab.
	 * @param   array   $positions   The build positions of this tab.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	protected function setTabMainCenterPositionDiv(&$main, &$mainbottom,
		&$positions
	)
	{
		$width_class = $this->getWidthClass();

		foreach ($positions as $position => $string)
		{
			if ($positions['lr'] == 2)
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . Indent::_(3) . '<div class="' . $width_class . '6">';
						$main .= PHP_EOL . Indent::_(4) . $string;
						$main .= PHP_EOL . Indent::_(3) . '</div>';
						break;
				}
			}
			else
			{
				switch ($position)
				{
					case 1: // left
					case 2: // right
						$main .= PHP_EOL . Indent::_(3)
							. '<div class="' . $width_class . '12">';
						$main .= PHP_EOL . Indent::_(4) . $string;
						$main .= PHP_EOL . Indent::_(3) . '</div>';
						break;
				}
			}
			switch ($position)
			{
				case 3: // fullwidth
					$mainbottom .= PHP_EOL . Indent::_(3)
						. '<div class="' . $width_class . '12">';
					$mainbottom .= PHP_EOL . Indent::_(4) . $string;
					$mainbottom .= PHP_EOL . Indent::_(3) . '</div>';
					break;
			}
		}
	}

	/**
	 * Get the publishing, metadata and permissions tabs of a view.
	 *
	 * @param   string  $nameSingleCode  The single view name.
	 * @param   string  $langView        The main lang prefix.
	 *
	 * @return  string  The generated trailing tabs.
	 *
	 * @since   6.1.7
	 */
	protected function getPublishMetaTabs(&$nameSingleCode, &$langView
	)
	{
		// build the two tabs
		$tabs = '';
		// set default publishing tab lang
		$tabLangName = $langView . '_PUBLISHING';
		// add to lang array
		$this->language->set($this->config->lang_target, $tabLangName, 'Publishing');
		// the default publishing items
		$items = array('left' => array(), 'right' => array());
		// Setup the default (custom) fields
		// only load (1 => 'left', 2 => 'right')
		$fieldsAddedRight = false;
		$width_class      = $this->getWidthClass();
		$row_class        = $this->getRowClass();
		$uitab            = $this->getUiTab();
		if ($this->newpublishingfields->exists($nameSingleCode))
		{
			$new_published_fields = $this->newpublishingfields->get($nameSingleCode);
			foreach ($new_published_fields as $df_alignment => $df_items)
			{
				foreach ($df_items as $df_order => $df_name)
				{
					if ($df_alignment == 2 || $df_alignment == 1)
					{
						$items[$this->alignmentOptions[$df_alignment]][$df_order]
							= $df_name;
					}
					else
					{
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_WARNINGHTHREE'), 'Warning'
						);
						$this->app->enqueueMessage(
							Text::sprintf(
								'Your <b>%s</b> field could not be added, since the <b>%s</b> alignment position is not available in the %s (publishing) tab. Please only target <b>Left or right</b> in the publishing tab.',
								$df_name,
								$this->alignmentOptions[$df_alignment],
								$nameSingleCode
							), 'Warning'
						);
					}
				}
			}
			// set switch to trigger notice if custom fields added to right
			if (ArrayHelper::check($items['right']))
			{
				$fieldsAddedRight = true;
			}
		}
		// load all defaults
		$loadDefaultFields = array(
			'left'  => array('created', 'created_by', 'modified',
				'modified_by'),
			'right' => array('published', 'ordering', 'access', 'version',
				'hits', 'id')
		);
		foreach ($loadDefaultFields as $d_alignment => $defaultFields)
		{
			foreach ($defaultFields as $defaultField)
			{
				if (!$this->movedpublishingfields->exists($nameSingleCode . '.' . $defaultField))
				{
					if ($defaultField != 'access')
					{
						$items[$d_alignment][] = $defaultField;
					}
					elseif ($defaultField === 'access'
						&& $this->accessswitch->exists($nameSingleCode))
					{
						$items[$d_alignment][] = $defaultField;
					}
				}
			}
		}
		// check if metadata is added to this view
		if ($this->metadata->exists($nameSingleCode))
		{
			// set default publishing tab code name
			$tabCodeNameLeft  = 'publishing';
			$tabCodeNameRight = 'metadata';
			// the default publishing tiems
			if (ArrayHelper::check($items['left'])
				|| ArrayHelper::check($items['right']))
			{
				$items_one = '';
				// load the items into one side
				if (ArrayHelper::check($items['left']))
				{
					$items_one .= "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['left']
						) . "'";
				}
				if (ArrayHelper::check($items['right']))
				{
					// there is already fields just add these
					if (strlen($items_one) > 3)
					{
						$items_one .= "," . PHP_EOL . Indent::_(1) . "'"
							. implode(
								"'," . PHP_EOL . Indent::_(1) . "'",
								$items['right']
							) . "'";
					}
					// no fields has been added yet
					else
					{
						$items_one .= "'" . implode(
								"'," . PHP_EOL . Indent::_(1) . "'",
								$items['right']
							) . "'";
					}
				}
				// only triger the info notice if there were custom fields targeted to the right alignment position.
				if ($fieldsAddedRight)
				{
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEFIELD_NOTICEHTHREE'), 'Notice'
					);
					$this->app->enqueueMessage(
						Text::sprintf(
							'Your field/s added to the <b>right</b> alignment position in the %s (publishing) tab was added to the <b>left</b>. Since we have metadata fields on the right. Fields can only be loaded to the right of the publishing tab if there is no metadata fields.',
							$nameSingleCode
						), 'Notice'
					);
				}
				// set the publishing layout
				$this->layoutview->set(
					$nameSingleCode, $tabCodeNameLeft, $items_one,
					'layoutpublished'
				);
				$items_one = true;
			}
			else
			{
				$items_one = false;
			}
			// set the metadata layout
			$this->layoutview->set(
				$nameSingleCode, $tabCodeNameRight, false, 'layoutmetadata'
			);
			$items_two = true;
		}
		else
		{
			// set default publishing tab code name
			$tabCodeNameLeft  = 'publishing';
			$tabCodeNameRight = 'publlshing';
			// the default publishing tiems
			if (ArrayHelper::check($items['left'])
				|| ArrayHelper::check($items['right']))
			{
				// load left items that remain
				if (ArrayHelper::check($items['left']))
				{
					// load all items
					$items_one = "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['left']
						) . "'";
					// set the publishing layout
					$this->layoutview->set(
						$nameSingleCode, $tabCodeNameLeft, $items_one,
						'layoutpublished'
					);
					$items_one = true;
				}
				// load right items that remain
				if (ArrayHelper::check($items['right']))
				{
					// load all items
					$items_two = "'" . implode(
							"'," . PHP_EOL . Indent::_(1) . "'", $items['right']
						) . "'";
					// set the publishing layout
					$this->layoutview->set(
						$nameSingleCode, $tabCodeNameRight, $items_two,
						'layoutpublished'
					);
					$items_two = true;
				}
			}
			else
			{
				$items_one = false;
				$items_two = false;
			}
		}
		if ($items_one && $items_two)
		{
			$classs = "{$width_class}6";
		}
		elseif ($items_one || $items_two)
		{
			$classs = "{$width_class}12";
		}
		// only load this if needed
		if ($items_one || $items_two)
		{
			// check if the item has permissions.
			$publishingPerOR  = [];
			$allToBeChekcedOR = array('core.edit.created_by',
				'core.edit.created',
				'core.edit.state');
			foreach ($allToBeChekcedOR as $core_permission)
			{
				// set permissions.
				$publishingPerOR[] = "\$this->canDo->get('"
					. $this->permission->getGlobal($nameSingleCode, $core_permission) . "')";
			}
			$publishingPerAND  = [];
			$allToBeChekcedAND = array('core.delete', 'core.edit.state');
			foreach ($allToBeChekcedAND as $core_permission)
			{
				// set permissions.
				$publishingPerAND[] = "\$this->canDo->get('"
					. $this->permission->getGlobal($nameSingleCode, $core_permission) . "')";
			}
			// check if custom tab must be added
			if (($_customTabHTML = $this->customtabs->get(
					15, $nameSingleCode, 1
				)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
			// add the AND values to OR
			$publishingPerOR[] = '(' . implode(' && ', $publishingPerAND) . ')';
			// now build the complete showhide behaviour for the publishing area
			$tabs .= PHP_EOL . PHP_EOL . Indent::_(1) . "<?php if (" . implode(
					' || ', $publishingPerOR
				) . ") : ?>";
			// set the default publishing tab
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.addTab', '"
				. $nameSingleCode . "Tab', '" . $tabCodeNameLeft . "', Text:"
				. ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . Indent::_(2)
				. '<div class="' . $row_class . '">';
			if ($items_one)
			{
				$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $classs
					. '">';
				$tabs .= PHP_EOL . Indent::_(4)
					. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('" . $nameSingleCode
					. "." . $tabCodeNameLeft . "', \$this); ?>";
				$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			}
			if ($items_two)
			{
				$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $classs
					. '">';
				$tabs .= PHP_EOL . Indent::_(4)
					. "<?php echo Joomla__"."_7ab82272_0b3d_4bb1_af35_e63a096cfe0b___Power::render('" . $nameSingleCode
					. "." . $tabCodeNameRight . "', \$this); ?>";
				$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			}
			$tabs .= PHP_EOL . Indent::_(2) . "</div>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			$tabs .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
			// check if custom tab must be added
			if (($_customTabHTML = $this->customtabs->get(
					15, $nameSingleCode, 2
				)) !== false)
			{
				$tabs .= $_customTabHTML;
			}
		}

		// make sure we don't load it to a view with the name component (as this will cause conflict with Joomla conventions)
		if ($nameSingleCode != 'component'
			&& $this->haspermissions->exists($nameSingleCode))
		{
			// set permissions tab lang
			$tabLangName = $langView . '_PERMISSION';
			// set permissions tab code name
			$tabCodeName = 'permissions';
			// add to lang array
			$this->language->set($this->config->lang_target, $tabLangName, 'Permissions');
			// set the permissions tab
			$tabs .= PHP_EOL . PHP_EOL . Indent::_(1)
				. "<?php if (\$this->canDo->get('core.admin')) : ?>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.addTab', '"
				. $nameSingleCode . "Tab', '" . $tabCodeName . "', Text:"
				. ":_('" . $tabLangName . "', true)); ?>";
			$tabs .= PHP_EOL . Indent::_(2)
				. '<div class="' . $row_class . '">';
			$tabs .= PHP_EOL . Indent::_(3) . '<div class="' . $width_class . '12">';
			$tabs .= $this->getPermissionsFieldset($tabLangName);
			$tabs .= PHP_EOL . Indent::_(3) . "</div>";
			$tabs .= PHP_EOL . Indent::_(2) . "</div>";
			$tabs .= PHP_EOL . Indent::_(1)
				. "<?php echo Html::_('{$uitab}.endTab'); ?>";
			$tabs .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
		}

		return $tabs;
	}
}

