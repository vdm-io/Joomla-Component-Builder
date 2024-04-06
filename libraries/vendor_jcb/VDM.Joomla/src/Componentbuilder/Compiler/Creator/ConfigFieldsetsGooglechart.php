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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsets;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ConfigFieldsetsCustomfield as Customfield;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ExtensionsParams;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Config Fieldsets Googlechart Creator Class
 * 
 * @since 3.2.0
 */
final class ConfigFieldsetsGooglechart
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The ConfigFieldsets Class.
	 *
	 * @var   ConfigFieldsets
	 * @since 3.2.0
	 */
	protected ConfigFieldsets $configfieldsets;

	/**
	 * The ConfigFieldsetsCustomfield Class.
	 *
	 * @var   Customfield
	 * @since 3.2.0
	 */
	protected Customfield $customfield;

	/**
	 * The ExtensionsParams Class.
	 *
	 * @var   ExtensionsParams
	 * @since 3.2.0
	 */
	protected ExtensionsParams $extensionsparams;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Language           $language           The Language Class.
	 * @param ConfigFieldsets    $configfieldsets    The ConfigFieldsets Class.
	 * @param Customfield        $customfield        The ConfigFieldsetsCustomfield Class.
	 * @param ExtensionsParams   $extensionsparams   The ExtensionsParams Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Language $language,
		ConfigFieldsets $configfieldsets,
		Customfield $customfield,
		ExtensionsParams $extensionsparams)
	{
		$this->config = $config;
		$this->language = $language;
		$this->configfieldsets = $configfieldsets;
		$this->customfield = $customfield;
		$this->extensionsparams = $extensionsparams;
	}

	/**
	 * Set Email Helper Config Fieldsets
	 *
	 * @param string $lang
	 *
	 * @since 3.2.0
	 */
	public function set(string $lang): void
	{
		if ($this->config->get('google_chart', false))
		{
			$this->configfieldsets->add('component', PHP_EOL . Indent::_(1) . "<fieldset");
			$this->configfieldsets->add('component', Indent::_(2)
				. "name=\"googlechart_config\"");
			$this->configfieldsets->add('component', Indent::_(2) . "label=\"" . $lang
				. "_CHART_SETTINGS_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(2) . "description=\"" . $lang
				. "_CHART_SETTINGS_DESC\">");
			$this->configfieldsets->add('component', Indent::_(2));
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"note\" name=\"chart_admin_naote\" class=\"alert alert-info\" label=\""
				. $lang . "_ADMIN_CHART_NOTE_LABEL\" description=\"" . $lang
				. "_ADMIN_CHART_NOTE_DESC\"  />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_chartbackground Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_chartbackground\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#F7F7FA\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTBACKGROUND_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTBACKGROUND_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_mainwidth Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_mainwidth\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_MAINWIDTH_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_MAINWIDTH_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add area width here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_MAINWIDTH_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(__LINE__,__CLASS__)
				. " Spacer_chartadmin_hr_a Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartadmin_hr_a\" hr=\"true\" class=\"spacer_chartadmin_hr_a\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(__LINE__,__CLASS__)
					. " Admin_chartareatop Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_chartareatop\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREATOP_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREATOP_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add top spacing here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREATOP_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_chartarealeft Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_chartarealeft\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREALEFT_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREALEFT_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add left spacing here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREALEFT_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_chartareawidth Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_chartareawidth\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREAWIDTH_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREAWIDTH_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add chart width here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREAWIDTH_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartadmin_hr_b Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartadmin_hr_b\" hr=\"true\" class=\"spacer_chartadmin_hr_b\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_legendtextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_legendtextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_legendtextstylefontsize Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_legendtextstylefontsize\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add size of the legend here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartadmin_hr_c Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartadmin_hr_c\" hr=\"true\" class=\"spacer_chartadmin_hr_c\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_vaxistextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_vaxistextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_VAXISTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_VAXISTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartadmin_hr_d Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartadmin_hr_d\" hr=\"true\" class=\"spacer_chartadmin_hr_d\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Admin_haxistextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_haxistextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_HAXISTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_HAXISTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Admin_haxistitletextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"admin_haxistitletextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2));
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"note\" name=\"chart_site_note\" class=\"alert alert-info\" label=\""
				. $lang . "_SITE_CHART_NOTE_LABEL\" description=\"" . $lang
				. "_SITE_CHART_NOTE_DESC\"  />");
			$this->configfieldsets->add('component', Indent::_(2));
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_chartbackground Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_chartbackground\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#F7F7FA\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTBACKGROUND_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTBACKGROUND_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_mainwidth Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3) . "name=\"site_mainwidth\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_MAINWIDTH_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_MAINWIDTH_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add area width here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_MAINWIDTH_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartsite_hr_a Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartsite_hr_a\" hr=\"true\" class=\"spacer_chartsite_hr_a\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_chartareatop Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_chartareatop\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREATOP_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREATOP_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add top spacing here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREATOP_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_chartarealeft Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_chartarealeft\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREALEFT_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREALEFT_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add left spacing here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREALEFT_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_chartareawidth Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_chartareawidth\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_CHARTAREAWIDTH_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_CHARTAREAWIDTH_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add chart width here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_CHARTAREAWIDTH_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartsite_hr_b Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartsite_hr_b\" hr=\"true\" class=\"spacer_chartsite_hr_b\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_legendtextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_legendtextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_legendtextstylefontsize Field. Type: Text. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"text\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_legendtextstylefontsize\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "size=\"20\"");
			$this->configfieldsets->add('component', Indent::_(3) . "maxlength=\"50\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_DESC\"");
			$this->configfieldsets->add('component', Indent::_(3) . "class=\"text_area\"");
			$this->configfieldsets->add('component', Indent::_(3) . "filter=\"INT\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "message=\"Error! Please add size of the legend here.\"");
			$this->configfieldsets->add('component', Indent::_(3) . "hint=\"" . $lang
				. "_LEGENDTEXTSTYLEFONTSIZE_HINT\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartsite_hr_c Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartsite_hr_c\" hr=\"true\" class=\"spacer_chartsite_hr_c\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_vaxistextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_vaxistextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_VAXISTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_VAXISTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Spacer_chartsite_hr_d Field. Type: Spacer. A None Database Field. -->");
			$this->configfieldsets->add('component', Indent::_(2)
				. "<field type=\"spacer\" name=\"spacer_chartsite_hr_d\" hr=\"true\" class=\"spacer_chartsite_hr_d\" />");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				) . " Site_haxistextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_haxistextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_HAXISTEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_HAXISTEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");
			$this->configfieldsets->add('component', Indent::_(2) . "<!--" . Line::_(
					__LINE__,__CLASS__
				)
				. " Site_haxistitletextstylefontcolor Field. Type: Color. -->");
			$this->configfieldsets->add('component', Indent::_(2) . "<field");
			$this->configfieldsets->add('component', Indent::_(3) . "type=\"color\"");
			$this->configfieldsets->add('component', Indent::_(3)
				. "name=\"site_haxistitletextstylefontcolor\"");
			$this->configfieldsets->add('component', Indent::_(3) . "default=\"#63B1F2\"");
			$this->configfieldsets->add('component', Indent::_(3) . "label=\"" . $lang
				. "_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL\"");
			$this->configfieldsets->add('component', Indent::_(3) . "description=\"" . $lang
				. "_HAXISTITLETEXTSTYLEFONTCOLOR_DESC\"");
			$this->configfieldsets->add('component', Indent::_(2) . "/>");

			// add custom Encryption Settings fields
			if ($this->customfield->isArray('Chart Settings'))
			{
				$this->configfieldsets->add('component', implode(
					"", $this->customfield->get('Chart Settings')
				));
				$this->customfield->remove('Chart Settings');
			}

			$this->configfieldsets->add('component', Indent::_(1) . "</fieldset>");

			// set params defaults
			$this->extensionsparams->add('component',
				'"admin_chartbackground":"#F7F7FA","admin_mainwidth":"1000","admin_chartareatop":"20","admin_chartarealeft":"20","admin_chartareawidth":"170","admin_legendtextstylefontcolor":"10","admin_legendtextstylefontsize":"20","admin_vaxistextstylefontcolor":"#63B1F2","admin_haxistextstylefontcolor":"#63B1F2","admin_haxistitletextstylefontcolor":"#63B1F2","site_chartbackground":"#F7F7FA","site_mainwidth":"1000","site_chartareatop":"20","site_chartarealeft":"20","site_chartareawidth":"170","site_legendtextstylefontcolor":"10","site_legendtextstylefontsize":"20","site_vaxistextstylefontcolor":"#63B1F2","site_haxistextstylefontcolor":"#63B1F2","site_haxistitletextstylefontcolor":"#63B1F2"'
			);

			// set field lang
			$this->language->set(
				$this->config->lang_target, $lang . '_CHART_SETTINGS_LABEL', "Chart Settings"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHART_SETTINGS_DESC',
				"The Google Chart Display Settings Are Made Here."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_ADMIN_CHART_NOTE_LABEL', "Admin Settings"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_ADMIN_CHART_NOTE_DESC',
				"The following settings are used on the back-end of the site called (admin)."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_SITE_CHART_NOTE_LABEL', "Site Settings"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_SITE_CHART_NOTE_DESC',
				"The following settings are used on the front-end of the site called (site)."
			);

			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREALEFT_DESC',
				"Set in pixels the spacing from the left of the chart area to the beginning of the chart it self. Please don't add the px sign"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREALEFT_HINT', "170"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREALEFT_LABEL', "Left Spacing"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREATOP_DESC',
				"Set in pixels the spacing from the top of the chart area to the beginning of the chart it self. Please don't add the px sign"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREATOP_HINT', "20"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREATOP_LABEL', "Top Spacing"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREAWIDTH_DESC',
				"Set in % the width of the chart it self inside the chart area. Please don't add the % sign"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREAWIDTH_HINT', "60"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTAREAWIDTH_LABEL', "Chart Width"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTBACKGROUND_DESC',
				"Select the chart background color here."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_CHARTBACKGROUND_LABEL',
				"Chart Background"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_HAXISTEXTSTYLEFONTCOLOR_DESC',
				"Select the horizontal axis font color."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_HAXISTEXTSTYLEFONTCOLOR_LABEL',
				"hAxis Font Color"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_HAXISTITLETEXTSTYLEFONTCOLOR_DESC',
				"Select the horizontal axis title's font color."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_HAXISTITLETEXTSTYLEFONTCOLOR_LABEL',
				"hAxis Title Font Color"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_LEGENDTEXTSTYLEFONTCOLOR_DESC',
				"Select the legend font color."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_LEGENDTEXTSTYLEFONTCOLOR_LABEL',
				"Legend Font Color"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_LEGENDTEXTSTYLEFONTSIZE_DESC',
				"Set in pixels the font size of the legend"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_LEGENDTEXTSTYLEFONTSIZE_HINT', "10"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_LEGENDTEXTSTYLEFONTSIZE_LABEL',
				"Legend Font Size"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_MAINWIDTH_DESC',
				"Set the width of the entire chart area"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_MAINWIDTH_HINT', "1000"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_MAINWIDTH_LABEL', "Chart Area Width"
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_VAXISTEXTSTYLEFONTCOLOR_DESC',
				"Select the vertical axis font color."
			);
			$this->language->set(
				$this->config->lang_target, $lang . '_VAXISTEXTSTYLEFONTCOLOR_LABEL',
				"vAxis Font Color"
			);
		}
	}
}

