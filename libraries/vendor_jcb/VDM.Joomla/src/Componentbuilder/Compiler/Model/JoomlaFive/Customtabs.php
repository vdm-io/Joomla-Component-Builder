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

namespace VDM\Joomla\Componentbuilder\Compiler\Model\JoomlaFive;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomTabs as BuilderCustomTabs;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Model\CustomtabsInterface;


/**
 * Model Custom Tabs Class
 * 
 * @since 3.2.0
 */
final class Customtabs implements CustomtabsInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The CustomTabs Class.
	 *
	 * @var   BuilderCustomTabs
	 * @since 3.2.0
	 */
	protected BuilderCustomTabs $buildercustomtabs;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Customcode Class.
	 *
	 * @var   Customcode
	 * @since 3.2.0
	 */
	protected Customcode $customcode;

	/**
	 * Constructor.
	 *
	 * @param Config              $config              The Config Class.
	 * @param BuilderCustomTabs   $buildercustomtabs   The CustomTabs Class.
	 * @param Language            $language            The Language Class.
	 * @param Placeholder         $placeholder         The Placeholder Class.
	 * @param Customcode          $customcode          The Customcode Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, BuilderCustomTabs $buildercustomtabs, Language $language, Placeholder $placeholder, Customcode $customcode)
	{
		$this->config = $config;
		$this->buildercustomtabs = $buildercustomtabs;
		$this->language = $language;
		$this->placeholder = $placeholder;
		$this->customcode = $customcode;
	}

	/**
	 * Set custom tabs
	 *
	 * @param   object  $item  The view data
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function set(object &$item)
	{
		$item->customtabs = (isset($item->customtabs)
			&& JsonHelper::check($item->customtabs))
			? json_decode((string) $item->customtabs, true) : null;

		if (ArrayHelper::check($item->customtabs))
		{
			// get the name
			$name = $item->name_single_code;

			// setup custom tabs to global data sets
			$this->buildercustomtabs->set($name,
				array_map(
					function ($tab) use (&$name) {

						// set the view name
						$tab['view'] = $name;

						// load the dynamic data
						$tab['html'] = $this->placeholder->update_(
							$this->customcode->update($tab['html'])
						);

						// set the tab name
						$tab['name'] = (isset($tab['name'])
							&& StringHelper::check(
								$tab['name']
							)) ? $tab['name'] : 'Tab';

						// set lang
						$tab['lang'] = $this->config->lang_prefix . '_'
							. StringHelper::safe(
								$tab['view'], 'U'
							) . '_' . StringHelper::safe(
								$tab['name'], 'U'
							);
						$this->language->set(
							'both', $tab['lang'], $tab['name']
						);

						// set code name
						$tab['code'] = StringHelper::safe(
							$tab['name']
						);

						// check if the permissions for the tab should be added
						$_tab = '';
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$_tab = Indent::_(1);
						}

						// check if the php of the tab is set, if not load it now
						if (strpos((string) $tab['html'], 'uitab.addTab') === false
							&& strpos((string) $tab['html'], 'uitab.endTab')
							=== false)
						{
							// add the tab
							$tmp = PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo Html::_('uitab.addTab', '"
								. $tab['view'] . "Tab', '" . $tab['code']
								. "', JT" . "ext::_('" . $tab['lang']
								. "', true)); ?>";
							$tmp .= PHP_EOL . $_tab . Indent::_(2)
								. '<div class="row">';
							$tmp .= PHP_EOL . $_tab . Indent::_(3)
								. '<div class="col-md-12">';
							$tmp .= PHP_EOL . $_tab . Indent::_(4) . implode(
									PHP_EOL . $_tab . Indent::_(4),
									(array) explode(PHP_EOL, trim((string) $tab['html']))
								);
							$tmp .= PHP_EOL . $_tab . Indent::_(3) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(2) . '</div>';
							$tmp .= PHP_EOL . $_tab . Indent::_(1)
								. "<?php echo Html::_('uitab.endTab'); ?>";

							// update html
							$tab['html'] = $tmp;
						}
						else
						{
							$tab['html'] = PHP_EOL . $_tab . Indent::_(1)
								. implode(
									PHP_EOL . $_tab . Indent::_(1),
									(array) explode(PHP_EOL, trim((string) $tab['html']))
								);
						}

						// add the permissions if needed
						if (isset($tab['permission'])
							&& $tab['permission'] == 1)
						{
							$tmp = PHP_EOL . Indent::_(1)
								. "<?php if (\$this->canDo->get('"
								. $tab['view'] . "." . $tab['code']
								. ".viewtab')) : ?>";
							$tmp .= $tab['html'];
							$tmp .= PHP_EOL . Indent::_(1) . "<?php endif; ?>";
							// update html
							$tab['html'] = $tmp;
							// set lang for permissions
							$tab['lang_permission']      = $tab['lang']
								. '_TAB_PERMISSION';
							$tab['lang_permission_desc'] = $tab['lang']
								. '_TAB_PERMISSION_DESC';
							$tab['lang_permission_title']
								= $this->placeholder->get('Views') . ' View '
								. $tab['name'] . ' Tab';
							$this->language->set(
								'both', $tab['lang_permission'],
								$tab['lang_permission_title']
							);
							$this->language->set(
								'both', $tab['lang_permission_desc'],
								'Allow the users in this group to view '
								. $tab['name'] . ' Tab of '
								. $this->placeholder->get('views')
							);
							// set the sort key
							$tab['sortKey']
								= StringHelper::safe(
								$tab['lang_permission_title']
							);
						}

						// return tab
						return $tab;

					}, array_values($item->customtabs)
				)
			);
		}

		unset($item->customtabs);
	}
}

