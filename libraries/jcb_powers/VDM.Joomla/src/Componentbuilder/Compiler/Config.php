<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler;


use Joomla\Registry\Registry;
use VDM\Joomla\Utilities\Component\Helper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Compiler Configurations Registry
 * 
 * @since   3.1.6
 */
class Config extends Registry implements \JsonSerializable, \ArrayAccess, \IteratorAggregate, \Countable
{
	/**
	 * The Params
	 *
	 * @var     Registry
	 * @since   3.1.6
	 */
	protected Registry $params;

	/**
	 * Constructor
	 *
	 * @param array $config The data to bind to the new Config object.
	 * @param Registry $params The component parameters
	 *
	 * @since   3.1.6
	 */
	public function __construct(array $config, ?Registry $params = null)
	{
		// Set the params
		$this->params = $params ?: Helper::getParams('com_componentbuilder');

		// Instantiate the internal data object.
		$this->data = new \stdClass;

		// Load the config to the data object
		$this->bindData($this->data, $this->modelConfig($config));
	}

	/**
	 * model the configuration data array
	 *
	 * @param array $config The data to bind to the new Config object.
	 *
	 * @return  array
	 * @since   3.1.6
	 */
	protected function modelConfig(array $config): array
	{
		// we do not yet have this set as an option
		$config['remove_line_breaks']
			= 2; // 2 is global (use the components value)

		// set the minfy switch of the JavaScript
		$config['minify'] = (isset($config['minify']) && $config['minify'] != 2)
			? $config['minify'] : $this->params->get('minify', 0);

		// set the global language
		$config['lang_tag'] = $this->params->get('language', 'en-GB');

		// check if we have Tidy enabled
		$config['tidy'] = extension_loaded('Tidy');

		// set the field type builder
		$config['field_builder_type'] = $this->params->get(
			'compiler_field_builder_type', 2
		);

		// load the compiler path
		$config['compiler_path'] = $this->params->get(
			'compiler_folder_path',
			JPATH_COMPONENT_ADMINISTRATOR . '/compiler'
		);

		// load the jcb powers path
		$config['jcb_powers_path'] = $this->params->get(
			'jcb_powers_path',
			'libraries/jcb_powers');

		// set the component ID
		$config['component_id'] = (int)$config['component'];
		// TODO set up stream correctly
		unset($config['component']);

		// set this components code name
		if ($name_code = GetHelper::var(
			'joomla_component', $config['component_id'], 'id', 'name_code'
		)) {
			// set lang prefix
			$config['lang_prefix'] = 'COM_' . StringHelper::safe(
					$name_code, 'U'
				);

			// set component code name
			$config['component_code_name'] = StringHelper::safe(
				$name_code
			);

			// set component context
			$config['component_context'] = $config['component_code_name'] . '.'
				. $config['component_id'];

			// set the component name length
			$config['component_code_name_length'] = strlen(
				$config['component_code_name']
			);

			// add assets table fix
			$global = (int)$this->params->get(
				'assets_table_fix', 1
			);
			$config['add_assets_table_fix'] = (($add_assets_table_fix
					= (int)GetHelper::var(
					'joomla_component', $config['component_id'], 'id',
					'assets_table_fix'
				)) == 3) ? $global : $add_assets_table_fix;

			// set if language strings line breaks should be removed
			$global = ((int)GetHelper::var(
					'joomla_component', $config['component_id'], 'id',
					'remove_line_breaks'
				) == 1) ? true : false;
			$config['remove_line_breaks'] = ((int)$config['remove_line_breaks']
				== 0)
				? false
				: (((int)$config['remove_line_breaks'] == 1) ? true
					: $global);

			// set if placeholders should be added to customcode
			$global = ((int)GetHelper::var(
					'joomla_component', $config['component_id'], 'id',
					'add_placeholders'
				) == 1) ? true : false;
			$config['add_placeholders'] = ((int)$config['placeholders'] == 0)
				? false
				: (((int)$config['placeholders'] == 1) ? true : $global);
			// TODO set up stream correctly
			unset($config['placeholders']);

			// set if line numbers should be added to comments
			$global = ((int)GetHelper::var(
					'joomla_component', $config['component_id'], 'id',
					'debug_linenr'
				) == 1) ? true : false;
			$config['debug_line_nr'] = ((int)$config['debuglinenr'] == 0) ? false
				: (((int)$config['debuglinenr'] == 1) ? true : $global);

			// set if powers should be added to component (default is true)
			$global = ((int)GetHelper::var(
					'joomla_component', $config['component_id'], 'id',
					'add_powers'
				) == 1) ? true : false;
			$config['add_power'] = (isset($config['powers']) && (int)$config['powers'] == 0)
				? false : ((isset($config['powers']) && (int)$config['powers'] == 1) ? true : $global);
			// TODO set up stream correctly
			unset($config['powers']);
		}

		return $config;
	}
}

