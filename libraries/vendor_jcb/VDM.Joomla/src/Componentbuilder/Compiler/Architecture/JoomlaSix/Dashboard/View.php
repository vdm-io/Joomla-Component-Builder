<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\Dashboard;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Dashboard\ViewInterface;


/**
 * Dashboard View Class
 * 
 * @since 5.1.5
 */
final class View implements ViewInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.5
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 5.1.5
	 */
	protected Component $component;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.5
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.5
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 5.1.5
	 */
	protected Structure $structure;

	/**
	 * Constructor.
	 *
	 * @param  Config         $config         The Config Class.
	 * @param  Component      $component      The Component Class.
	 * @param  Placeholder    $placeholder    The Placeholder Class.
	 * @param  ContentMulti   $contentmulti   The ContentMulti Class.
	 * @param  Structure      $structure      The Structure Class.
	 *
	 * @since  5.1.5
	 */
	public function __construct(
		Config $config,
		Component $component,
		Placeholder $placeholder,
		ContentMulti $contentmulti,
		Structure $structure
	) {
		$this->config = $config;
		$this->component = $component;
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->structure = $structure;
	}

	/**
	 * Build the admin dashboard display markup for Joomla 6 style layouts.
	 *
	 * @return string  The compiled dashboard display markup.
	 * @since  5.1.5
	 */
	public function get(): string
	{
		$state = $this->getDashboardDisplayState();

		$this->initializeDashboardDisplay($state);
		$this->appendMainDashboardColumns($state);

		if ($state['loadTabs'])
		{
			$this->appendCustomTabs($state);
			$this->appendTabSetEnd($state);
		}
		else
		{
			$this->appendMainRowEnd($state);
		}

		$this->appendDashboardContainerEnd($state);

		return PHP_EOL . implode(PHP_EOL, $state['display']);
	}

	/**
	 * Get the initial dashboard display state.
	 *
	 * @return array  The dashboard display state.
	 * @since  5.1.5
	 */
	protected function getDashboardDisplayState(): array
	{
		return [
			'display' => [],
			'builder' => [],
			'tab' => Indent::_(3),
			'loadTabs' => false,
			'containerId' => 'j-main-container',
			'containerClass' => 'container-fluid',
			'wrapperTabsClass' => 'main-card jcb-dashboard',
			'wrapperClass' => 'main-card jcb-dashboard p-3 p-lg-4',
			'contentClass' => 'jcb-dashboard__content',
			'rowClass' => 'row g-4 align-items-start',
			'mainColumnClass' => 'col-12 col-xxl-9',
			'sideColumnClass' => 'col-12 col-xxl-3',
			'fullColumnClass' => 'col-12',
			'mainInnerClass' => 'jcb-dashboard__main d-flex flex-column gap-4',
			'sideInnerClass' => 'jcb-dashboard__sidebar d-flex flex-column gap-4',
			'fullInnerClass' => 'jcb-dashboard__tab d-flex flex-column gap-4',
			'uiTab' => 'uitab',
			'tabSet' => 'cpanel_tab',
			'mainTabAlias' => 'cpanel',
		];
	}

	/**
	 * Initialize the dashboard display structure.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function initializeDashboardDisplay(array &$state): void
	{
		if ($this->hasCustomDashboardTabs())
		{
			$this->buildCustomDashboardTabTemplates($state['builder']);
			$this->appendDashboardWithTabsStart($state);
			$state['loadTabs'] = true;

			return;
		}

		$this->appendStandardDashboardStart($state);
	}

	/**
	 * Check whether custom dashboard tabs exist.
	 *
	 * @return bool  True if custom dashboard tabs exist.
	 * @since  5.1.5
	 */
	protected function hasCustomDashboardTabs(): bool
	{
		return $this->component->isArray('dashboard_tab');
	}

	/**
	 * Build the custom dashboard tab template map.
	 *
	 * @param  array  &$builder  The custom tab builder map.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function buildCustomDashboardTabTemplates(array &$builder): void
	{
		foreach ($this->component->get('dashboard_tab') as $data)
		{
			$builder[$data['name']][$data['header']]
				= $this->placeholder->update_($data['html']);
		}
	}

	/**
	 * Append the dashboard start markup when custom tabs are enabled.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendDashboardWithTabsStart(array &$state): void
	{
		$state['display'][] = $this->getOpenContainer(
			$state['containerId'],
			$state['containerClass']
		);
		$state['display'][] = Indent::_(1) . $this->getOpenDiv($state['wrapperTabsClass']);
		$state['display'][] = Indent::_(2) . $this->getOpenDiv($state['contentClass']);
		$state['display'][] = Indent::_(2)
			. $this->getUiTabStartSetCode($state['tabSet'], $state['mainTabAlias']);
		$state['display'][] = PHP_EOL . Indent::_(3)
			. $this->getUiTabAddTabCode(
				$state['tabSet'],
				$state['mainTabAlias'],
				"Text:" . ":_('cPanel', true)"
			);
		$state['display'][] = Indent::_(3) . $this->getOpenDiv($state['rowClass']);
	}

	/**
	 * Append the standard dashboard start markup.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendStandardDashboardStart(array &$state): void
	{
		$state['display'][] = $this->getOpenContainer(
			$state['containerId'],
			$state['containerClass']
		);
		$state['display'][] = Indent::_(1) . $this->getOpenDiv($state['wrapperClass']);
		$state['display'][] = Indent::_(2) . $this->getOpenDiv($state['contentClass']);
		$state['display'][] = Indent::_(3) . $this->getOpenDiv($state['rowClass']);
	}

	/**
	 * Append the main dashboard columns.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendMainDashboardColumns(array &$state): void
	{
		$this->appendLeftDashboardColumn($state);
		$this->appendRightDashboardColumn($state);
	}

	/**
	 * Append the left dashboard column.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendLeftDashboardColumn(array &$state): void
	{
		$state['display'][] = $state['tab']
			. $this->getOpenDiv($state['mainColumnClass']);
		$state['display'][] = $state['tab'] . Indent::_(1)
			. $this->getOpenDiv($state['mainInnerClass']);
		$state['display'][] = $state['tab'] . Indent::_(2)
			. $this->getLoadTemplateCode('main');
		$state['display'][] = $state['tab'] . Indent::_(1) . '</div>';
		$state['display'][] = $state['tab'] . '</div>';
	}

	/**
	 * Append the right dashboard column.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendRightDashboardColumn(array &$state): void
	{
		$state['display'][] = $state['tab']
			. $this->getOpenDiv($state['sideColumnClass']);
		$state['display'][] = $state['tab'] . Indent::_(1)
			. $this->getOpenDiv($state['sideInnerClass']);
		$state['display'][] = $state['tab'] . Indent::_(2)
			. $this->getLoadTemplateCode('vdm');
		$state['display'][] = $state['tab'] . Indent::_(1) . '</div>';
		$state['display'][] = $state['tab'] . '</div>';
	}

	/**
	 * Append all custom dashboard tabs.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendCustomTabs(array &$state): void
	{
		$state['display'][] = Indent::_(3) . '</div>';
		$state['display'][] = Indent::_(3) . $this->getUiTabEndTabCode();

		foreach ($state['builder'] as $tabName => $templates)
		{
			$this->appendCustomTab($state, $tabName, $templates);
		}
	}

	/**
	 * Append a single custom dashboard tab.
	 *
	 * @param  array   &$state      The dashboard display state.
	 * @param  string  $tabName     The tab name.
	 * @param  array   $templates   The template content definitions.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendCustomTab(array &$state, string $tabName, array $templates): void
	{
		$alias = StringHelper::safe($tabName);

		$state['display'][] = PHP_EOL . Indent::_(3)
			. $this->getUiTabAddTabCode(
				$state['tabSet'],
				$alias,
				"Joomla__" . "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
				. $tabName . "', true)"
			);
		$state['display'][] = Indent::_(3) . $this->getOpenDiv($state['rowClass']);
		$state['display'][] = $state['tab'] . $this->getOpenDiv($state['fullColumnClass']);
		$state['display'][] = $state['tab'] . Indent::_(1)
			. $this->getOpenDiv($state['fullInnerClass']);

		$this->appendCustomTabTemplates($state, $alias, $templates);

		$state['display'][] = $state['tab'] . Indent::_(1) . '</div>';
		$state['display'][] = $state['tab'] . '</div>';
		$state['display'][] = Indent::_(3) . '</div>';
		$state['display'][] = Indent::_(3) . $this->getUiTabEndTabCode();
	}

	/**
	 * Append all template loads for a custom dashboard tab.
	 *
	 * @param  array   &$state      The dashboard display state.
	 * @param  string  $alias       The safe tab alias.
	 * @param  array   $templates   The template content definitions.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendCustomTabTemplates(array &$state, string $alias, array $templates): void
	{
		foreach ($templates as $templateName => $html)
		{
			$this->appendCustomTabTemplate($state, $alias, $templateName, $html);
		}
	}

	/**
	 * Append a single custom dashboard template load and register its content.
	 *
	 * @param  array   &$state         The dashboard display state.
	 * @param  string  $alias          The safe tab alias.
	 * @param  string  $templateName   The template name.
	 * @param  string  $html           The HTML content.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendCustomTabTemplate(
		array &$state,
		string $alias,
		string $templateName,
		string $html
	): void
	{
		$safeTemplateName = $alias . '_' . StringHelper::safe($templateName);

		$state['display'][] = $state['tab'] . Indent::_(2)
			. $this->getLoadTemplateCode($safeTemplateName);

		$this->buildCustomDashboardTemplate($safeTemplateName, $html);
	}

	/**
	 * Build a custom dashboard template file and register its content.
	 *
	 * @param  string  $templateName  The template name.
	 * @param  string  $html          The template body HTML.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function buildCustomDashboardTemplate(string $templateName, string $html): void
	{
		$this->buildCustomDashboardTemplateStructure($templateName);
		$this->storeCustomDashboardTemplateBody($templateName, $html);
		$this->storeCustomDashboardTemplateCodeBody($templateName);
	}

	/**
	 * Build the custom dashboard template structure.
	 *
	 * @param  string  $templateName  The template name.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function buildCustomDashboardTemplateStructure(string $templateName): void
	{
		$this->structure->build(
			['custom_admin' => $this->config->component_code_name],
			'template',
			$templateName
		);
	}

	/**
	 * Store the custom dashboard template body.
	 *
	 * @param  string  $templateName  The template name.
	 * @param  string  $html          The template body HTML.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function storeCustomDashboardTemplateBody(string $templateName, string $html): void
	{
		$this->contentmulti->set(
			$this->getCustomDashboardTemplateKey(
				$templateName,
				'CUSTOM_ADMIN_TEMPLATE_BODY'
			),
			PHP_EOL . $html
		);
	}

	/**
	 * Store the custom dashboard template code body.
	 *
	 * @param  string  $templateName  The template name.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function storeCustomDashboardTemplateCodeBody(string $templateName): void
	{
		$this->contentmulti->set(
			$this->getCustomDashboardTemplateKey(
				$templateName,
				'CUSTOM_ADMIN_TEMPLATE_CODE_BODY'
			),
			''
		);
	}

	/**
	 * Get the custom dashboard template storage key.
	 *
	 * @param  string  $templateName  The template name.
	 * @param  string  $suffix        The key suffix.
	 *
	 * @return string  The storage key.
	 * @since  5.1.5
	 */
	protected function getCustomDashboardTemplateKey(
		string $templateName,
		string $suffix
	): string
	{
		return $this->config->component_code_name . '_'
			. $templateName . '|' . $suffix;
	}

	/**
	 * Append the end of the tab set.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendTabSetEnd(array &$state): void
	{
		$state['display'][] = PHP_EOL . Indent::_(2)
			. $this->getUiTabEndTabSetCode();
	}

	/**
	 * Append the end of the main row layout.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendMainRowEnd(array &$state): void
	{
		$state['display'][] = Indent::_(3) . '</div>';
	}

	/**
	 * Append the closing dashboard container markup.
	 *
	 * @param  array  &$state  The dashboard display state.
	 *
	 * @return void
	 * @since  5.1.5
	 */
	protected function appendDashboardContainerEnd(array &$state): void
	{
		$state['display'][] = Indent::_(2) . '</div>';
		$state['display'][] = Indent::_(1) . '</div>';
		$state['display'][] = '</div>';
	}

	/**
	 * Get the PHP code for starting a UI tab set.
	 *
	 * @param  string  $tabSet     The tab set name.
	 * @param  string  $activeTab  The active tab alias.
	 *
	 * @return string  The generated PHP code.
	 * @since  5.1.5
	 */
	protected function getUiTabStartSetCode(
		string $tabSet,
		string $activeTab
	): string
	{
		return "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('"
			. $this->getUiTabHelperName('startTabSet') . "', '" . $tabSet
			. "', array('active' => '" . $activeTab . "')); ?>";
	}

	/**
	 * Get the PHP code for adding a UI tab.
	 *
	 * @param  string  $tabSet  The tab set name.
	 * @param  string  $alias   The tab alias.
	 * @param  string  $title   The tab title PHP expression.
	 *
	 * @return string  The generated PHP code.
	 * @since  5.1.5
	 */
	protected function getUiTabAddTabCode(
		string $tabSet,
		string $alias,
		string $title
	): string
	{
		return "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('"
			. $this->getUiTabHelperName('addTab') . "', '" . $tabSet
			. "', '" . $alias . "', " . $title . "); ?>";
	}

	/**
	 * Get the PHP code for ending a UI tab.
	 *
	 * @return string  The generated PHP code.
	 * @since  5.1.5
	 */
	protected function getUiTabEndTabCode(): string
	{
		return "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('"
			. $this->getUiTabHelperName('endTab') . "'); ?>";
	}

	/**
	 * Get the PHP code for ending a UI tab set.
	 *
	 * @return string  The generated PHP code.
	 * @since  5.1.5
	 */
	protected function getUiTabEndTabSetCode(): string
	{
		return "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('"
			. $this->getUiTabHelperName('endTabSet') . "'); ?>";
	}

	/**
	 * Get the UI tab helper name.
	 *
	 * @param  string  $method  The helper method name.
	 *
	 * @return string  The full helper name.
	 * @since  5.1.5
	 */
	protected function getUiTabHelperName(string $method): string
	{
		return 'uitab.' . $method;
	}

	/**
	 * Get the PHP code for loading a layout template.
	 *
	 * @param  string  $templateName  The template name.
	 *
	 * @return string  The generated PHP code.
	 * @since  5.1.5
	 */
	protected function getLoadTemplateCode(string $templateName): string
	{
		return "<?php echo \$this->loadTemplate('" . $templateName . "');?>";
	}

	/**
	 * Get the opening container markup.
	 *
	 * @param  string       $id     The container ID.
	 * @param  string|null  $class  The container class.
	 *
	 * @return string  The container opening markup.
	 * @since  5.1.5
	 */
	protected function getOpenContainer(string $id, ?string $class = null): string
	{
		if ($class !== null && $class !== '')
		{
			return '<div id="' . $id . '" class="' . $class . '">';
		}

		return '<div id="' . $id . '">';
	}

	/**
	 * Get the opening div markup.
	 *
	 * @param  string  $class  The div class.
	 *
	 * @return string  The div opening markup.
	 * @since  5.1.5
	 */
	protected function getOpenDiv(string $class): string
	{
		return '<div class="' . $class . '">';
	}
}

