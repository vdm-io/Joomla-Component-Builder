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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\Dashboard;


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
	 * @param Config         $config         The Config Class.
	 * @param Component      $component      The Component Class.
	 * @param Placeholder    $placeholder    The Placeholder Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 * @param Structure      $structure      The Structure Class.
	 *
	 * @since 5.1.5
	 */
	public function __construct(Config $config, Component $component,
		Placeholder $placeholder, ContentMulti $contentmulti, Structure $structure)
	{
		$this->config = $config;
		$this->component = $component;
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->structure = $structure;
	}

	/**
	 * Build the admin dashboard display markup for Joomla 4 and above.
	 *
	 * @return  string  The compiled dashboard display markup.
	 *
	 * @since 5.1.5
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
			$this->appendStandardRowEnd($state);
		}

		$this->appendDashboardContainerEnd($state);

		return PHP_EOL . implode(PHP_EOL, $state['display']);
	}

	/**
	 * Get the initial dashboard display state.
	 *
	 * @return  array  The dashboard display state.
	 *
	 * @since 5.1.5
	 */
	protected function getDashboardDisplayState(): array
	{
		return [
			'display' => [],
			'mainAccordionName' => 'cPanel',
			'builder' => [],
			'tab' => Indent::_(3),
			'loadTabs' => false,
			'widthClass' => 'col-md-',
			'rowClass' => 'row',
			'formClass' => 'main-card',
			'uiTab' => 'uitab',
		];
	}

	/**
	 * Initialize the dashboard display structure.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function initializeDashboardDisplay(array &$state): void
	{
		if ($this->hasCustomDashboardTabs())
		{
			$this->buildCustomDashboardTabTemplates($state['builder']);
			$this->appendDashboardWithTabsStart($state);

			$state['mainAccordionName'] = 'Control Panel';
			$state['loadTabs'] = true;

			return;
		}

		$this->appendStandardDashboardStart($state);
	}

	/**
	 * Check whether custom dashboard tabs exist.
	 *
	 * @return  bool  True if custom dashboard tabs exist.
	 *
	 * @since 5.1.5
	 */
	protected function hasCustomDashboardTabs(): bool
	{
		return $this->component->isArray('dashboard_tab');
	}

	/**
	 * Build the custom dashboard tab template map.
	 *
	 * @param   array  &$builder  The custom tab builder map.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
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
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendDashboardWithTabsStart(array &$state): void
	{
		$state['display'][] = '<div id="j-main-container">';
		$state['display'][] = Indent::_(1) . '<div class="' . $state['formClass'] . '">';
		$state['display'][] = Indent::_(1)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.startTabSet', 'cpanel_tab', array('active' => 'cpanel')); ?>";
		$state['display'][] = PHP_EOL . Indent::_(2)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.addTab', 'cpanel_tab', 'cpanel', Text:" . ":_('cPanel', true)); ?>";
		$state['display'][] = Indent::_(2) . '<div class="' . $state['rowClass'] . '">';
	}

	/**
	 * Append the standard dashboard start markup.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendStandardDashboardStart(array &$state): void
	{
		$state['display'][] = '<div id="j-main-container">';
		$state['display'][] = Indent::_(1) . '<div class="' . $state['formClass'] . '" style="padding: 20px;">';
		$state['display'][] = Indent::_(2) . '<div class="' . $state['rowClass'] . '">';
	}

	/**
	 * Append the main dashboard columns.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendMainDashboardColumns(array &$state): void
	{
		$this->appendLeftDashboardColumn($state);
		$this->appendRightDashboardColumn($state);
	}

	/**
	 * Append the left dashboard column.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendLeftDashboardColumn(array &$state): void
	{
		$state['display'][] = $state['tab'] . '<div class="' . $state['widthClass'] . '9">';
		$state['display'][] = $state['tab'] . Indent::_(1)
			. "<?php echo \$this->loadTemplate('main');?>";
		$state['display'][] = $state['tab'] . '</div>';
	}

	/**
	 * Append the right dashboard column.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendRightDashboardColumn(array &$state): void
	{
		$state['display'][] = $state['tab'] . '<div class="' . $state['widthClass'] . '3">';
		$state['display'][] = $state['tab'] . Indent::_(1)
			. "<?php echo \$this->loadTemplate('vdm');?>";
		$state['display'][] = $state['tab'] . '</div>';
	}

	/**
	 * Append all custom dashboard tabs.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendCustomTabs(array &$state): void
	{
		$state['display'][] = Indent::_(2) . '</div>';
		$state['display'][] = Indent::_(2)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.endTab'); ?>";

		foreach ($state['builder'] as $tabName => $accordions)
		{
			$this->appendCustomTab($state, $tabName, $accordions);
		}
	}

	/**
	 * Append a single custom dashboard tab.
	 *
	 * @param   array   &$state       The dashboard display state.
	 * @param   string  $tabName      The tab name.
	 * @param   array   $accordions   The accordion content definitions.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendCustomTab(array &$state, string $tabName, array $accordions): void
	{
		$alias = StringHelper::safe($tabName);

		$state['display'][] = PHP_EOL . Indent::_(2)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.addTab', 'cpanel_tab', '"
			. $alias . "', Joomla__" . "_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('"
			. $tabName . "', true)); ?>";
		$state['display'][] = Indent::_(2) . '<div class="' . $state['rowClass'] . '">';
		$state['display'][] = $state['tab'] . '<div class="' . $state['widthClass'] . '12">';

		$this->appendCustomTabTemplates($state, $alias, $accordions);

		$state['display'][] = $state['tab'] . '</div>';
		$state['display'][] = Indent::_(2) . '</div>';
		$state['display'][] = Indent::_(2)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.endTab'); ?>";
	}

	/**
	 * Append all template loads for a custom dashboard tab.
	 *
	 * @param   array   &$state       The dashboard display state.
	 * @param   string  $alias        The safe tab alias.
	 * @param   array   $accordions   The accordion content definitions.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendCustomTabTemplates(array &$state, string $alias, array $accordions): void
	{
		foreach ($accordions as $accordionName => $html)
		{
			$this->appendCustomTabTemplate($state, $alias, $accordionName, $html);
		}
	}

	/**
	 * Append a single custom dashboard template load and register its content.
	 *
	 * @param   array   &$state          The dashboard display state.
	 * @param   string  $alias           The safe tab alias.
	 * @param   string  $accordionName   The accordion name.
	 * @param   string  $html            The HTML content.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendCustomTabTemplate(
		array &$state,
		string $alias,
		string $accordionName,
		string $html
	): void
	{
		$accordionAlias = StringHelper::safe($accordionName);
		$templateName = $alias . '_' . $accordionAlias;

		$state['display'][] = $state['tab'] . Indent::_(1)
			. "<?php echo \$this->loadTemplate('" . $templateName . "');?>";

		$this->buildCustomDashboardTemplate($templateName, $html);
	}

	/**
	 * Build a custom dashboard template file and register its content.
	 *
	 * @param   string  $templateName  The template name.
	 * @param   string  $html          The template body HTML.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function buildCustomDashboardTemplate(string $templateName, string $html): void
	{
		$componentCodeName = $this->config->component_code_name;
		$target = ['custom_admin' => $componentCodeName];

		$this->structure->build($target, 'template', $templateName);

		$this->contentmulti->set(
			$componentCodeName . '_' . $templateName . '|CUSTOM_ADMIN_TEMPLATE_BODY',
			PHP_EOL . $html
		);

		$this->contentmulti->set(
			$componentCodeName . '_' . $templateName . '|CUSTOM_ADMIN_TEMPLATE_CODE_BODY',
			''
		);
	}

	/**
	 * Append the end of the tab set.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendTabSetEnd(array &$state): void
	{
		$state['display'][] = PHP_EOL . Indent::_(1)
			. "<?php echo Joomla__" . "_34690c75_1090_47eb_8c06_7228dc7eedd6___Power::_('{$state['uiTab']}.endTabSet'); ?>";
	}

	/**
	 * Append the end of the standard row layout.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendStandardRowEnd(array &$state): void
	{
		$state['display'][] = Indent::_(2) . '</div>';
	}

	/**
	 * Append the closing dashboard container markup.
	 *
	 * @param   array  &$state  The dashboard display state.
	 *
	 * @return  void
	 *
	 * @since 5.1.5
	 */
	protected function appendDashboardContainerEnd(array &$state): void
	{
		$state['display'][] = Indent::_(1) . '</div>';
		$state['display'][] = '</div>';
	}
}

