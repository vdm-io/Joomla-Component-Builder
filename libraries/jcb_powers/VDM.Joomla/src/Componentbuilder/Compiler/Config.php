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

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\Registry\Registry as JoomlaRegistry;
use Joomla\CMS\Factory as JoomlaFactory;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Abstraction\BaseConfig;


/**
 * Compiler Configurations
 * 
 * 	All these functions are accessed via the direct name without the get:
 * 	example: $this->component_code_name calls: $this->getComponentcodename()
 * 
 * 	All values once called are cached, yet can be updated directly:
 * 	example: $this->component_code_name = 'new_code_name'; // be warned!
 * 
 * @since 3.2.0
 */
class Config extends BaseConfig
{
	/**
	 * The Global Joomla Configuration
	 *
	 * @var     JoomlaRegistry
	 * @since 3.2.0
	 */
	protected JoomlaRegistry $config;

	/**
	 * Constructor
	 *
	 * @param Input|null        $input      Input
	 * @param Registry|null     $params     The component parameters
	 * @param Registry|null     $config     The Joomla configuration
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Input $input = null, ?JoomlaRegistry $params = null, ?JoomlaRegistry $config = null)
	{
		parent::__construct($input, $params);

		$this->config = $config ?: JoomlaFactory::getConfig();
	}

	/**
	 * get add contributors switch
	 *
	 * @return  bool  Add contributors switch
	 * @since 3.2.0
	 */
	protected function getAddcontributors(): bool
	{
		return false; // default is false
	}

	/**
	 * get Add Ajax Switch
	 *
	 * @return  bool  Add Ajax Switch
	 * @since 3.2.0
	 */
	protected function getAddajax(): bool
	{
		return false; // default is false
	}

	/**
	 * get Add Site Ajax Switch
	 *
	 * @return  bool  Add Site Ajax Switch
	 * @since 3.2.0
	 */
	protected function getAddsiteajax(): bool
	{
		return false; // default is false
	}

	/**
	 * get add eximport
	 *
	 * @return  bool  add eximport switch
	 * @since 3.2.0
	 */
	protected function getAddeximport(): bool
	{
		return false; // default is false
	}

	/**
	 * get posted component id
	 *
	 * @return  int  Component id
	 * @since 3.2.0
	 */
	protected function getComponentid(): int
	{
		return $this->input->post->get('component_id', 0, 'INT');
	}

	/**
	 * get component version
	 *
	 * @return  string  Component version
	 * @since 3.2.0
	 */
	protected function getComponentversion(): string
	{
		return '1.0.0';
	}

	/**
	 * get components code name
	 *
	 * @return  string  The components code name
	 * @since 3.2.0
	 */
	protected function getComponentcodename(): string
	{
		// get components code name
		return StringHelper::safe(GetHelper::var(
			'joomla_component', $this->component_id, 'id', 'name_code'
		));
	}

	/**
	 * get component context
	 *
	 * @return  string  The component context
	 * @since 3.2.0
	 */
	protected function getComponentcontext(): string
	{
		// get component context
		return $this->component_code_name . '.' . $this->component_id;
	}

	/**
	 * get component code name length
	 *
	 * @return  int  The component code name length
	 * @since 3.2.0
	 */
	protected function getComponentcodenamelength(): int
	{
		// get component name length
		return strlen((string) $this->component_code_name);
	}

	/**
	 * get posted Joomla version
	 *
	 * @return  int  Joomla version code
	 * @since 3.2.0
	 */
	protected function getJoomlaversion(): int
	{
		return $this->input->post->get('joomla_version', 3, 'INT');
	}

	/**
	 * get Joomla versions
	 *
	 * @return  array  Joomla versions
	 * @since 3.2.0
	 */
	protected function getJoomlaversions(): array
	{
		return [
			3    => ['folder_key' => 3, 'xml_version' => 3.9], // only joomla 3
			3.10 => ['folder_key' => 3, 'xml_version' => 4.0] // legacy joomla 4
		];
	}

	/**
	 * get posted Joomla version name
	 *
	 * @return  string  Joomla version code name
	 * @since 3.2.0
	 */
	protected function getJoomlaversionname(): string
	{
		return StringHelper::safe($this->joomla_version);
	}

	/**
	 * set joomla fields
	 *
	 * @return  bool  set joomla fields
	 * @since 3.2.0
	 */
	protected function getSetjoomlafields(): bool
	{
		return false;
	}

	/**
	 * get indentation value
	 *
	 * @return  string  Indentation value
	 * @since 3.2.0
	 */
	protected function getIndentationvalue(): string
	{
		return "\t"; // TODO add to GUI as an Global Option?
	}

	/**
	 * get posted backup switch
	 *
	 * @return  int  Backup switch number
	 * @since 3.2.0
	 */
	protected function getBackup(): int
	{
		return $this->input->post->get('backup', 0, 'INT');
	}

	/**
	 * get posted repository switch
	 *
	 * @return  int  Repository switch number
	 * @since 3.2.0
	 */
	protected function getRepository(): int
	{
		return $this->input->post->get('repository', 0, 'INT');
	}

	/**
	 * get posted debuglinenr switch
	 *
	 * @return  int  Debuglinenr switch number
	 * @since 3.2.0
	 */
	protected function getDebuglinenr(): int
	{
		// get posted value
		$value = $this->input->post->get('debug_line_nr', 2, 'INT');
		// get global value
		if ($value > 1)
		{
			return (int) GetHelper::var('joomla_component', $this->component_id, 'id', 'debug_linenr');
		}
		return $value;
	}

	/**
	 * get posted minify switch
	 *
	 * @return  int  Minify switch number
	 * @since 3.2.0
	 */
	protected function getMinify(): int
	{
		// get posted value
		$minify = $this->input->post->get('minify', 2, 'INT');

		// if value is 2 use global value
		return ($minify != 2) ? $minify : $this->params->get('minify', 0);
	}

	/**
	 * get posted remove line breaks switch
	 *
	 * @return  bool  Remove line breaks switch number
	 * @since 3.2.0
	 */
	protected function getRemovelinebreaks(): bool
	{
		// get posted value
		$value = $this->input->post->get('remove_line_breaks', 2, 'INT');
		// get global
		if ($value > 1)
		{
			return (bool) GetHelper::var('joomla_component', $this->component_id, 'id', 'remove_line_breaks');
		}
		return (bool) $value;
	}

	/**
	 * get system tidy state
	 *
	 * @return  bool  Tidy is active
	 * @since 3.2.0
	 */
	protected function getTidy(): bool
	{
		// check if we have Tidy enabled
		return \extension_loaded('Tidy');
	}

	/**
	 * add tidy warning
	 *
	 * @return  bool  Set tidy warning
	 * @since 3.2.0
	 */
	protected function getSettidywarning(): bool
	{
		// add warning once
		return true;
	}

	/**
	 * get history tag switch
	 *
	 * @return  bool  get history tag switch
	 * @since 3.2.0
	 */
	protected function getSettaghistory(): bool
	{
		// add warning once
		return true;
	}

	/**
	 * get language tag
	 *
	 * @return  string  The active language tag
	 * @since 3.2.0
	 */
	protected function getLangtag(): string
	{
		// get the global language
		return $this->params->get('language', 'en-GB');
	}

	/**
	 * get language prefix
	 *
	 * @return  string  The language prefix
	 * @since 3.2.0
	 */
	protected function getLangprefix(): string
	{
		// get components code name
		return 'COM_' . StringHelper::safe(GetHelper::var(
			'joomla_component', $this->component_id, 'id', 'name_code'
		), 'U');
	}

	/**
	 * get language target
	 *
	 * @return  string  The language active target
	 * @since 3.2.0
	 */
	protected function getLangtarget(): string
	{
		// we start with admin
		// but this is a switch value and is changed many times
		return 'admin';
	}

	/**
	 * get language string targets
	 *
	 * @return  array  The language prefix
	 * @since 3.2.0
	 */
	protected function getLangstringtargets(): array
	{
		// these strings are used to search for language strings in all content
		return array_values($this->lang_string_key_targets);
	}

	/**
	 * get language string targets (by key name)
	 *
	 * @return  array  The language prefix
	 * @since 3.2.0
	 */
	protected function getLangstringkeytargets(): array
	{
		// these strings are used to search for language strings in all content
		return [
			'jjt' => 'Joomla' . '.JText._(',
			'js' => 'JText:' . ':script(',
			't' => 'Text:' . ':_(',        // namespace and J version will be found
			'ts' => 'Text:' . ':sprintf(',  // namespace and J version will be found
			'jt' => 'JustTEXT:' . ':_('
		];
	}

	/**
	 * get field builder type
	 *
	 * @return  int  The field builder type
	 * @since 3.2.0
	 */
	protected function getFieldbuildertype(): int
	{
		// get the field type builder
		return $this->params->get(
			'compiler_field_builder_type', 2
		);
	}

	/**
	 * get default fields
	 *
	 * @return  array  The default fields
	 * @since 3.2.0
	 */
	protected function getDefaultfields(): array
	{
		// get the field type builder
		return ['created', 'created_by', 'modified', 'modified_by', 'published',
			'ordering', 'access', 'version', 'hits', 'id'];
	}

	/**
	 * get temporary path
	 *
	 * @return  string  The temporary path
	 * @since 3.2.0
	 */
	protected function getTmppath(): string
	{
		// get the temporary path
		return $this->config->get('tmp_path');
	}

	/**
	 * get compiler path
	 *
	 * @return  string  The compiler path
	 * @since 3.2.0
	 */
	protected function getCompilerpath(): string
	{
		// get the compiler path
		return $this->params->get(
			'compiler_folder_path',
			JPATH_COMPONENT_ADMINISTRATOR . '/compiler'
		);
	}

	/**
	 * get jcb powers path
	 *
	 * @return  string  The jcb powers path
	 * @since 3.2.0
	 */
	protected function getJcbpowerspath(): string
	{
		// get jcb powers path
		return $this->params->get('jcb_powers_path', 'libraries/jcb_powers');
	}

	/**
	 * get bom path
	 *
	 * @return  string  The bom path
	 * @since 3.2.0
	 */
	protected function getBompath(): string
	{
		// get default bom path
		return $this->compiler_path . '/default.txt';
	}

	/**
	 * get switch to add assets table fix
	 *
	 * @return  int  Switch number to add assets table fix
	 * @since 3.2.0
	 */
	protected function getAddassetstablefix(): int
	{
		// get global add assets table fix
		$global = $this->params->get(
			'assets_table_fix', 1
		);

		// get component value
		return (($add_assets_table_fix = (int) GetHelper::var(
				'joomla_component', $this->component_id, 'id',
				'assets_table_fix'
			)) == 3) ? $global : $add_assets_table_fix;
	}

	/**
	 * get switch to add assets table name fix
	 *
	 * @return  bool  Switch number to add assets table name fix
	 * @since 3.2.0
	 */
	protected function getAddassetstablenamefix(): bool
	{
		// get global is false
		return false;
	}

	/**
	 * get access worse case size
	 *
	 * @return  int  access worse case size
	 * @since 3.2.0
	 */
	protected function getAccessworsecase(): int
	{
		// we start at zero
		return 0;
	}

	/**
	 * get mysql table keys
	 *
	 * @return  array
	 * @since 3.2.0
	 */
	protected function getMysqltablekeys(): array
	{
		return [
			'engine'     => ['default' => 'MyISAM'],
			'charset'    => ['default' => 'utf8'],
			'collate'    => ['default' => 'utf8_general_ci'],
			'row_format' => ['default' => '']
		];
	}

	/**
	 * get switch add placeholders
	 *
	 * @return  bool  Switch to add placeholders
	 * @since 3.2.0
	 */
	protected function getAddplaceholders(): bool
	{
		// get posted value
		$value = $this->input->post->get('add_placeholders', 2, 'INT');
		// get global value
		if ($value > 1)
		{
			return (bool) GetHelper::var('joomla_component', $this->component_id, 'id', 'add_placeholders');
		}
		return (bool) $value;
	}

	/**
	 * get switch add power
	 *
	 * @return  bool  Switch to add power
	 * @since 3.2.0
	 */
	protected function getAddpower(): bool
	{
		// get posted value
		$value = $this->input->post->get('powers', 2, 'INT');
		// get global value
		if ($value > 1)
		{
			return (bool) GetHelper::var('joomla_component', $this->component_id, 'id', 'add_powers');
		}
		return (bool) $value;
	}

	/**
	 * get switch build target switch
	 *
	 * @return  string  Switch to control the build flow
	 * @since 3.2.0
	 */
	protected function getBuildtarget(): string
	{
		// we start with admin
		// but this is a switch value and is changed many times
		return 'admin';
	}

	/**
	 * get encryption types
	 *
	 * @return  array  encryption types
	 * @since 3.2.0
	 */
	protected function getCryptiontypes(): array
	{
		return ['basic', 'medium', 'whmcs', 'expert'];
	}

	/**
	 * get basic encryption switch
	 *
	 * @return  bool  Switch to control the encryption
	 * @since 3.2.0
	 */
	protected function getBasicencryption(): bool
	{
		return false;
	}

	/**
	 * get medium encryption switch
	 *
	 * @return  bool  Switch to control the encryption
	 * @since 3.2.0
	 */
	protected function getMediumencryption(): bool
	{
		return false;
	}

	/**
	 * get whmcs encryption switch
	 *
	 * @return  bool  Switch to control the encryption
	 * @since 3.2.0
	 */
	protected function getWhmcsencryption(): bool
	{
		return false;
	}

	/**
	 * Should we remove the site folder
	 *
	 * @return  bool  Switch to control the removal
	 * @since 3.2.0
	 */
	protected function getRemovesitefolder(): bool
	{
		return false;
	}

	/**
	 * Should we remove the site edit folder
	 *
	 * @return  bool  Switch to control the removal
	 * @since 3.2.0
	 */
	protected function getRemovesiteeditfolder(): bool
	{
		return true;
	}

	/**
	 * The Uikit switch
	 *
	 * @return  int  Switch to control the adding uikit
	 * @since 3.2.0
	 */
	protected function getUikit(): int
	{
		return 0; // default its not added
	}

	/**
	 * The google chart switch
	 *
	 * @return  bool  Switch to control the adding googlechart
	 * @since 3.2.0
	 */
	protected function getGooglechart(): bool
	{
		return false; // default its not added
	}

	/**
	 * The footable switch
	 *
	 * @return  bool  Switch to control the adding footable
	 * @since 3.2.0
	 */
	protected function getFootable(): bool
	{
		return false; // default its not added
	}

	/**
	 * The footable version
	 *
	 * @return  int  Switch to control the adding footable
	 * @since 3.2.0
	 */
	protected function getFootableversion(): int
	{
		return 2; // default is version 2
	}

}

