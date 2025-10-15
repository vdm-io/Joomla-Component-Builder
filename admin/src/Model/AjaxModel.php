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
namespace VDM\Component\Componentbuilder\Administrator\Model;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Application\CMSApplicationInterface;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\MVC\Model\ListModel;
use Joomla\CMS\MVC\Factory\MVCFactoryInterface;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\User\User;
use Joomla\Utilities\ArrayHelper;
use Joomla\Input\Input;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;
use Joomla\Registry\Registry;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Gitea\Factory as GiteaFactory;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Search\Factory as SearchFactory;
use VDM\Joomla\Utilities\GuidHelper;
use VDM\Joomla\Componentbuilder\Remote\Version;
use VDM\Joomla\Github\Factory as GithubFactory;
use VDM\Joomla\Utilities\ArrayHelper as UtilitiesArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\SessionHelper;
use VDM\Joomla\Utilities\Base64Helper;
use VDM\Joomla\Componentbuilder\Table\Search;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\FieldHelper;
use VDM\Joomla\Utilities\FormHelper;
use VDM\Joomla\Componentbuilder\Utilities\FilterHelper;
use VDM\Joomla\Data\Factory as DataFactory;
use VDM\Joomla\Componentbuilder\Package\Factory as PackageFactory;
use VDM\Joomla\Componentbuilder\Fieldtype\Factory as FieldtypeFactory;
use VDM\Joomla\Componentbuilder\JoomlaPower\Factory as JoomlaPowerFactory;
use VDM\Joomla\Componentbuilder\Power\Factory as PowerFactory;
use VDM\Joomla\Componentbuilder\Snippet\Factory as SnippetFactory;
use VDM\Joomla\Componentbuilder\Repository\Factory as RepositoryFactory;
use Joomla\CMS\Form\FormHelper as FormFormHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Componentbuilder Ajax List Model
 *
 * @since  1.6
 */
class AjaxModel extends ListModel
{
	/**
	 * The component params.
	 *
	 * @var   Registry
	 * @since 3.2.0
	 */
	protected Registry $app_params;

	/**
	 * The application object.
	 *
	 * @var   CMSApplicationInterface  The application instance.
	 * @since 3.2.0
	 */
	protected CMSApplicationInterface $app;

	/**
	 * Constructor
	 *
	 * @param   array                 $config   An array of configuration options (name, state, dbo, table_path, ignore_request).
	 * @param   ?MVCFactoryInterface  $factory  The factory.
	 *
	 * @since   1.6
	 * @throws  \Exception
	 */
	public function __construct($config = [], MVCFactoryInterface $factory = null)
	{
		parent::__construct($config, $factory);

		$this->app_params = ComponentHelper::getParams('com_componentbuilder');
		$this->app ??= Factory::getApplication();
	}

	// Used in joomla_component
	/**
	 * Retrieves the component details as an HTML display and metadata.
	 *
	 * This function fetches the details of a Joomla component from the database based on the provided target identifier.
	 * The target can be a GUID or an ID. If the target is valid, the function constructs a query to retrieve component
	 * information from the `#__componentbuilder_joomla_component` table, formats the result into an HTML representation, 
	 * and includes the preferred Joomla version metadata.
	 *
	 * @param string|int $target The identifier of the component. This can either be:
	 *                           - A GUID (globally unique identifier) as a string, or
	 *                           - A numeric ID (integer).
	 *
	 * @return array|null Returns an associative array with the following keys on success:
	 *                    - `html` (string): An HTML representation of the component details.
	 *                    - `preferred_joomla_version` (mixed): The preferred Joomla version, or 0 if not available.
	 *                    Returns `null` if the target is invalid or no matching component is found in the database.
	 * @since  3.0.0
	 */
	public function getComponentDetails($target): ?array
	{
		if (GuidHelper::valid($target))
		{
			$key = 'guid';
		}
		elseif (is_numeric($target))
		{
			$key = 'id';
		}
		else
		{
			return null;
		}

		try {
			// Need to find the asset id by the name of the component.
			$db = Factory::getDbo();
			$query = $db->getQuery(true)
				->select($db->quoteName([
					'id','companyname','component_version','copyright','debug_linenr',
					'description','email','image','license','name','preferred_joomla_version',
					'short_description','website','author','add_placeholders',
					'system_name','mvc_versiondate']))
				->from($db->quoteName('#__componentbuilder_joomla_component'))
				->where($db->quoteName($key) . ' = ' . $db->quote($target));
			$db->setQuery($query);
			$db->execute();
			if ($db->loadRowList())
			{
				$object = $db->loadObject();
				return [
					'html' => $this->componentDetailsDisplay($object),
					'preferred_joomla_version' => $object->preferred_joomla_version ?? 0
				];
			}
		} catch (\Exception $e) {
			return [
				'error' => $e->getMessage()
			];
		}

		return null;
	}

	/**
	 * Generates a detailed HTML representation of the component information.
	 *
	 * This method constructs a visually appealing HTML display for a Joomla component using the provided object
	 * containing component details. It includes information such as the component name, version, description, image,
	 * author details, license, copyright, and other settings.
	 *
	 * @param object $object An object containing the component details. Expected properties include:
	 *                       - `id` (int): The component ID.
	 *                       - `name` (string): The component name.
	 *                       - `component_version` (string): The version of the component.
	 *                       - `image` (string|null): The relative path to the component's image.
	 *                       - `description` (string|null): The detailed description of the component.
	 *                       - `short_description` (string|null): A short description (used if `description` is missing).
	 *                       - `add_placeholders` (bool): Whether to add custom code placeholders.
	 *                       - `debug_linenr` (bool): Whether debug line numbers are enabled.
	 *                       - `companyname` (string|null): The company name.
	 *                       - `author` (string|null): The author's name.
	 *                       - `email` (string|null): The author's email address.
	 *                       - `website` (string|null): The company's or author's website URL.
	 *                       - `license` (string|null): The component's license information.
	 *                       - `copyright` (string|null): The copyright details.
	 *                       - `system_name` (string): The system name of the component.
	 *
	 * @return string The HTML string representing the component details.
	 *
	 * @throws \InvalidArgumentException If a required property in the `$object` is missing or invalid.
	 * @since  3.0.0
	 */
	protected function componentDetailsDisplay($object): string
	{
		// Validate required properties
		if (empty($object->name) || empty($object->component_version) || empty($object->id))
		{
			throw new \InvalidArgumentException(Text::_('COM_COMPONENTBUILDER_INVALID_COMPONENT_OBJECT_MISSING_REQUIRED_PROPERTIES'));
		}

		// Prepare image HTML if provided
		$imageSrc = !empty($object->image) ? htmlspecialchars($object->image, ENT_QUOTES) : null;
		$imageHtml = $imageSrc
			? '<img alt="' . Text::_('COM_COMPONENTBUILDER_JOOMLA_COMPONENT_IMAGE') . '" src="' . Uri::root() . $imageSrc . '" class="img-fluid" style="max-width: 250px;">'
			: '';

		// Prepare description
		$description = htmlspecialchars($object->description ?? $object->short_description ?? '', ENT_QUOTES);

		// Prepare badges
		$placeholderStatus = $object->add_placeholders
			? '<span class="badge bg-success">' . Text::_('COM_COMPONENTBUILDER_YES') . '</span>'
			: '<span class="badge bg-danger">' . Text::_('COM_COMPONENTBUILDER_NO') . '</span>';
		$debugStatus = $object->debug_linenr
			? '<span class="badge bg-success">' . Text::_('COM_COMPONENTBUILDER_YES') . '</span>'
			: '<span class="badge bg-danger">' . Text::_('COM_COMPONENTBUILDER_NO') . '</span>';

		// Prepare company and author details
		$companyDetails = '<ul class="list-unstyled">';
		$companyDetails .= '<li><strong>' . Text::_('COM_COMPONENTBUILDER_COMPANY') . ':</strong> ' . htmlspecialchars($object->companyname ?? 'Vast Development Method', ENT_QUOTES) . '</li>';
		$companyDetails .= '<li><strong>' . Text::_('COM_COMPONENTBUILDER_AUTHOR') . ':</strong> ' . htmlspecialchars($object->author ?? 'Llewellyn van der Merwe', ENT_QUOTES) . '</li>';
		$companyDetails .= '<li><strong>' . Text::_('COM_COMPONENTBUILDER_EMAIL') . ':</strong> <a href="mailto:' . htmlspecialchars($object->email ?? 'joomla@vdm.io', ENT_QUOTES) . '">' . htmlspecialchars($object->email ?? 'joomla@vdm.io', ENT_QUOTES) . '</a></li>';
		$companyDetails .= '<li><strong>' . Text::_('COM_COMPONENTBUILDER_WEBSITE') . ':</strong> <a href="' . htmlspecialchars($object->website ?? 'https://dev.vdm.io', ENT_QUOTES) . '" target="_blank" rel="noopener">' . htmlspecialchars($object->website ?? 'https://dev.vdm.io', ENT_QUOTES) . '</a></li>';
		$companyDetails .= '</ul>';

		// Build HTML output
		$html = [];

		// Card container
		$html[] = '<div class="card mb-4">';
		$html[] = '<div class="card-body">';

		// Header with component name and version
		$html[] = '<h2 class="card-title">' . htmlspecialchars($object->name, ENT_QUOTES) . ' (v' . htmlspecialchars($object->component_version, ENT_QUOTES) . ')</h2>';

		// Row with image and text
		if (!empty($imageHtml))
		{
			$html[] = '<div class="row align-items-center">';
			$html[] = '<div class="col-md-7">';
			if (!empty($description))
			{
				$html[] = '<p>' . $description . '</p>';
			}
			$html[] = $companyDetails;
			$html[] = '</div>';
			$html[] = '<div class="col-md-5">' . $imageHtml . '</div>';
			$html[] = '</div>'; // End row
		}
		else
		{
			$html[] = '<div class="row align-items-center">';
			if (!empty($description))
			{
				$html[] = '<p>' . $description . '</p>';
			}
			$html[] = $companyDetails;
			$html[] = '</div>';
		}

		// Component settings
		$html[] = '<h3 class="mt-4">' . Text::_('COM_COMPONENTBUILDER_COMPONENT_SETTINGS') . '</h3>';
		$html[] = '<p>';
		$html[] = Text::_('COM_COMPONENTBUILDER_ADD_CUSTOM_CODE_PLACEHOLDERS') . ': ' . $placeholderStatus . '<br>';
		$html[] = Text::_('COM_COMPONENTBUILDER_DEBUG_LINE_NUMBERS') . ': ' . $debugStatus;
		$html[] = '</p>';

		// License details
		$html[] = '<h3 class="mt-4">' . Text::_('COM_COMPONENTBUILDER_LICENSE') . '</h3>';
		$html[] = '<p>' . nl2br(htmlspecialchars($object->license ?? Text::_('COM_COMPONENTBUILDER_NONE_SET'), ENT_QUOTES)) . '</p>';

		// Copyright
		$html[] = '<h3 class="mt-4">' . Text::_('COM_COMPONENTBUILDER_COPYRIGHT') . '</h3>';
		$html[] = '<p>' . nl2br(htmlspecialchars($object->copyright ?? Text::_('COM_COMPONENTBUILDER_NONE_SET'), ENT_QUOTES)) . '</p>';

		// Edit button
		$html[] = '<a href="index.php?option=com_componentbuilder&ref=compiler&view=joomla_components&task=joomla_component.edit&id=' . (int) $object->id . '" class="btn btn-outline-action btn-lg mt-3" style="width: 100%;">';
		$html[] = '<span class="icon-edit"></span> ' . Text::_('COM_COMPONENTBUILDER_EDIT') . ' ' . htmlspecialchars($object->system_name, ENT_QUOTES);
		$html[] = '</a>';

		$html[] = '</div>'; // End card body
		$html[] = '</div>'; // End card

		return implode("\n", $html);
	}

	/**
	 * Get the current version notice.
	 *
	 * Compares the installed version of the component with the latest available
	 * version from the repository tags and returns an appropriate message.
	 *
	 * @param   string|null  $version  Optional version to compare if manifest version not found.
	 *
	 * @return  array  The array with 'notice' or 'error' and optional 'github-error' / 'gitea-error'.
	 * @since   2.3.0
	 * @since   5.1.1 Improved with support for pre-releases and intelligent tag grouping.
	 */
	public function getVersion(?string $version = null): array
	{
		return (new Version(
			'joomengine', 'pkg-component-builder',
			'joomla', 'pkg-component-builder'
		))->get($version);
	}

	/**
	 * Get the content of a GitHub wiki page.
	 *
	 * @param   string  $name  The name of the wiki page (default: 'Home').
	 *
	 * @return  array  Associative array with 'page' or 'error' key.
	 * @since   2.3.0
	 */
	public function getWiki(string $name = 'Home'): array
	{
		try {
			$wiki = GithubFactory::_('Github.Repository.Wiki')
				->get('joomengine', 'Joomla-Component-Builder', $name);

			if (!empty($wiki->content)) {
				return ['page' => base64_decode($wiki->content)];
			}
		} catch (\Throwable $e) {
			return ['error' => $e->getMessage()];
		}

		return ['error' => Text::_('COM_COMPONENTBUILDER_THE_WIKI_CAN_ONLY_BE_LOADED_WHEN_YOUR_JCB_SYSTEM_HAS_INTERNET_CONNECTION')];
	}

	// Used in joomla_module
	/**
	 * Generates and returns the module code based on the provided data.
	 *
	 * This method processes the input data to generate module-specific code snippets 
	 * for class inclusion, data handling, libraries, CSS, and template loading. 
	 * It merges these code blocks into an array and specifies their placement within the final module output.
	 *
	 * @param string $data JSON-encoded string containing the module's class, get, lib, and other properties.
	 *
	 * @return array An associative array containing the generated code snippets for the module, 
	 *               including class, get, libraries, CSS, and template code, each with merge settings.
	 * @since  3.0.9
	 */
	public function getModuleCode($data)
	{
		// reset the return array
		$code = [];
		if (JsonHelper::check($data))
		{
			// convert the data to object
			$data = json_decode($data);
			// set class
			if (isset($data->class) && is_numeric($data->class) && ((int) $data->class == 2 || (int) $data->class == 1))
			{
				$code['class'] = [];
				// add the code
				$code['class']['code'] = '// Include the helper functions only once';
				$code['class']['code'] .= PHP_EOL . "JLoader::register('Mod[[[Module]]]Helper', __DIR__ . '/helper.php');";
				// set placement
				$code['class']['merge'] = 1;
				$code['class']['merge_target'] = 'prepend';
			}
			// get data
			if (isset($data->get) && UtilitiesArrayHelper::check($data->get))
			{
				$code['get'] = [];
				// add the code
				$code['get']['code'] = '// Include the data functions only once';
				$code['get']['code'] .= PHP_EOL . "JLoader::register('Mod[[[Module]]]Data', __DIR__ . '/data.php');";
				// set placement
				$code['get']['merge'] = 1;
				$code['get']['merge_target'] = 'prepend';
			}
			// get libraries
			if (isset($data->lib) && UtilitiesArrayHelper::check($data->lib))
			{
				$code['lib'] = [];
				// add the code
				$code['lib']['code'] = '[[[MOD_LIBRARIES]]]';
				// set placement
				$code['lib']['merge'] = 1;
				$code['lib']['merge_target'] = '// get the module class sfx (local)';
			}
		}
		// set the defaults
		$code['css'] = [];
		$code['tmpl'] = [];
		// add the code
		$code['css']['code'] = '// get the module class sfx (local)';
		$code['css']['code'] .= PHP_EOL . "\$moduleclass_sfx = htmlspecialchars(\$params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');";
		$code['tmpl']['code'] = '// load the default Tmpl';
		$code['tmpl']['code'] .= PHP_EOL . "require Joomla__"."_f15d556d_33dd_4ee3_a0f7_0653e4a7a1e4___Power::getLayoutPath('mod_[[[module]]]', \$params->get('layout', 'default'));";
		// set placement
		$code['css']['merge'] = 1;
		$code['css']['merge_target'] = '// load the default Tmpl';
		$code['tmpl']['merge'] = 1;
		$code['tmpl']['merge_target'] = 'append';

		return $code;
	}

	// Used in joomla_plugin
	/**
	 * Retrieves the class code based on the provided ID and type.
	 *
	 * @param int|string $id   The ID|GUID of the class.
	 * @param string     $type The type of the class (e.g., 'property', 'method').
	 *
	 * @return mixed The class code, or false on failure.
	 * @since  3.0.9
	 */
	public function getClassCode($id, $type)
	{
		return ComponentbuilderHelper::getClassCode($id, $type);
	}

	/**
	 * Retrieves class code IDs based on the provided ID, type, and key.
	 *
	 * @param int|string $target   The ID|GUID of the class.
	 * @param string     $type The type of the class (e.g., 'property', 'method', 'joomla_plugin_group').
	 * @param int        $key  The key that determines which data to return (e.g., 1 for 'joomla_plugin_group', 2 for 'extension_type').
	 *
	 * @return mixed The corresponding class code IDs or false if no valid data is found.
	 * @since  3.0.9
	 */
	public function getClassCodeIds($target, $type, $key)
	{
		if ('property' === $type || 'method' === $type)
		{
			// we get the plugin group, or the powers
			if ($key == 1)
			{
				return GetHelper::vars('class_' . $type, $target, 'joomla_plugin_group', 'id');
			}
			elseif ($key == 2)
			{
				return GetHelper::vars('class_' . $type, 'powers', 'extension_type', 'id');
			}
		}
		elseif ('joomla_plugin_group' === $type)
		{
			return GetHelper::vars($type, $target, 'class_extends', 'id');
		}
		return false;
	}

	/**
	 * Retrieves the header code of the class based on the provided ID and type.
	 *
	 * @param int|string $target   The ID/GUID of the class.
	 * @param string     $type The type of the header (e.g., 'extends').
	 *
	 * @return string|false The decoded header code, or false if no valid data is found.
	 * @since  3.0.9
	 */
	public function getClassHeaderCode($target, $type)
	{
		if (GuidHelper::valid($target))
		{
			$key = 'guid';
		}
		elseif (is_numeric($target))
		{
			$key = 'id';
		}
		else
		{
			return null;
		}

		if ('extends' === $type &&
			($head = GetHelper::var('class_' . $type, $target, $key, 'head')) !== false &&
				StringHelper::check($head))
		{
			return base64_decode($head);
		}

		return null;
	}

	// Used in admin_view
	/**
	 * Defines the maximum number of rows allowed for specific item types.
	 *
	 * This array maps item types to their respective maximum row limits:
	 * - 'admin_fields_conditions': Maximum 80 rows.
	 * - 'admin_fields': Maximum 50 rows.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $rowNumbers = [
		'admin_fields_conditions' => 80,
		'admin_fields' => 50,
	];

	/**
	 * Stores tab names for dynamic configuration.
	 *
	 * This array is reserved for storing dynamically assigned tab names.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $tabNames = [];

	/**
	 * Maps button configurations to their corresponding backend keys.
	 *
	 * This array defines associations between button keys and their backend representations.
	 * Some keys are boolean values (e.g., 'language' => true) for conditional handling.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $buttonArray = [
		'library_config' => 'libraries_config',
		'library_files_folders_urls' => 'libraries_files_folders_urls',
		'admin_fields' => 'admins_fields',
		'admin_fields_conditions' => 'admins_fields_conditions',
		'admin_fields_relations' => 'admins_fields_relations',
		'admin_custom_tabs' => 'admins_custom_tabs',
		'validation_rule' => 'validation_rules',
		'field' => 'fields',
		'component_admin_views' => 'components_admin_views',
		'component_site_views' => 'components_site_views',
		'component_custom_admin_views' => 'components_custom_views',
		'component_updates' => 'components_updates',
		'component_mysql_tweaks' => 'components_mysql_tweaks',
		'component_custom_admin_menus' => 'components_custom_admin_menus',
		'component_config' => 'components_config',
		'component_dashboard' => 'components_dashboard',
		'component_files_folders' => 'components_files_folders',
		'custom_code' => 'custom_codes',
		'language' => true,
	];

	/**
	 * Maps function names to their respective handlers.
	 *
	 * This array defines the function-to-handler mappings for different operations
	 * in libraries, admin views, and Joomla components.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $functionArray = [
		// Library
		'rename' => 'setYesNo',
		'update' => 'setYesNo',
		'type' => 'setURLType',
		// Admin View
		'field' => 'setItemNames',
		'listfield' => 'setItemNames',
		'joinfields' => 'setItemNames',
		'area' => 'setAreaName',
		'set' => 'setCode',
		'join_type' => 'setJoinType',
		'list' => 'setAdminBehaviour',
		'title' => 'setYesNo',
		'alias' => 'setYesNo',
		'sort' => 'setYesNo',
		'search' => 'setYesNo',
		'filter' => 'setYesNo',
		'link' => 'setYesNo',
		'permission' => 'setPermissions',
		'tab' => 'setTabName',
		'alignment' => 'setAlignmentName',
		'target_field' => 'setItemNames',
		'target_behavior' => 'setTargetBehavior',
		'target_relation' => 'setTargetRelation',
		'match_field' => 'setItemNames',
		'match_behavior' => 'setMatchBehavior',
		'match_options' => 'setMatchOptions',
		// Joomla Component
		'menu' => 'setYesNo',
		'metadata' => 'setYesNo',
		'default_view' => 'setYesNo',
		'access' => 'setYesNo',
		'public_access' => 'setYesNo',
		'mainmenu' => 'setYesNo',
		'dashboard_list' => 'setYesNo',
		'submenu' => 'setYesNo',
		'dashboard_add' => 'setYesNo',
		'checkin' => 'setYesNo',
		'history' => 'setYesNo',
		'joomla_fields' => 'setYesNo',
		'port' => 'setYesNo',
		'edit_create_site_view' => 'setYesNo',
		'icomoon' => 'setIcoMoon',
		'customadminview' => 'setItemNames',
		'adminviews' => 'setItemNames',
		'adminview' => 'setItemNames',
		'siteview' => 'setItemNames',
		'before' => 'setItemNames',
	];

	/**
	 * Reference variable for internal operations.
	 *
	 * This string is used as a reference in various methods and mappings.
	 *
	 * @var    string
	 * @since  3.0.0
	 */
	protected string $ref = '';

	/**
	 * Maps specific field types to their respective field handlers.
	 *
	 * This array defines the mapping between field types and their corresponding
	 * handler methods or sub-arrays for processing.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $fieldsArray = [
		'library_config' => 'addconfig',
		'library_files_folders_urls' => [
			'addurls',
			'addfiles',
			'addfolders',
			'addfoldersfullpath',
			'addfilesfullpath',
		],
		'admin_fields' => 'addfields',
		'admin_fields_conditions' => 'addconditions',
		'admin_fields_relations' => 'addrelations',
		'component_admin_views' => 'addadmin_views',
		'component_site_views' => 'addsite_views',
		'component_custom_admin_views' => 'addcustom_admin_views',
	];

	/**
	 * Defines the allowed views for operations.
	 *
	 * This array lists the allowed view names for specific actions in the application.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $allowedViewsArray = [
		'admin_view',
		'joomla_component',
		'library',
	];

	/**
	 * Maps conversion checks to their associated types.
	 *
	 * This array defines the mapping between conversion check keys and their associated field types.
	 *
	 * @var    array
	 * @since  3.0.0
	 */
	protected array $conversionCheck = [
		'addfields' => 'field',
		'addconditions' => 'target_field',
		'addadmin_views' => 'adminview',
		'addconfig' => 'field',
		'addcustom_admin_views' => 'customadminview',
		'addcustommenus' => 'name',
		'addsite_views' => 'siteview',
		'sql_tweak' => 'adminview',
		'version_update' => 'version',
	];

	/**
	 * Stores item names grouped by their type.
	 *
	 * This array is used to cache item names for various field types. The structure includes:
	 * - 'field': For fields.
	 * - 'admin_view': For admin views.
	 * - 'site_view': For site views.
	 * - 'custom_admin_view': For custom admin views.
	 *
	 * @var array
	 * @since  3.0.9
	 */
	protected array $itemNames = [
		'field' => [],
		'admin_view' => [],
		'site_view' => [],
		'custom_admin_view' => []
	];

	/**
	 * Defines the configuration for item keys.
	 *
	 * This array maps various keys (e.g., 'field', 'adminview') to their corresponding database table,
	 * ID column, name column, and additional metadata. The structure includes:
	 * - 'table': The table name in the database.
	 * - 'tables': The plural form of the table name.
	 * - 'id': The column name for the unique identifier.
	 * - 'name': The column name for the item's name.
	 * - 'text': The human-readable label for the item type.
	 * - 'get': The name of a helper method to retrieve additional information.
	 *
	 * @var array
	 * @since  3.0.9
	 */
	protected array $itemKeys = [
		// Admin view keys
		'field' => [
			'table' => 'field',
			'tables' => 'fields',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Field',
			'get' => 'getFieldNameAndType'
		],
		'target_field' => [
			'table' => 'field',
			'tables' => 'fields',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Field',
			'get' => 'getFieldNameAndType'
		],
		'match_field' => [
			'table' => 'field',
			'tables' => 'fields',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Field',
			'get' => 'getFieldNameAndType'
		],
		'listfield' => [
			'table' => 'field',
			'tables' => 'fields',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Field',
			'get' => 'getFieldNameAndType'
		],
		'joinfields' => [
			'table' => 'field',
			'tables' => 'fields',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Field',
			'get' => 'getFieldNameAndType'
		],

		// Joomla component view keys
		'siteview' => [
			'table' => 'site_view',
			'tables' => 'site_views',
			'key' => 'guid',
			'name' => 'name',
			'text' => 'Site View'
		],
		'customadminview' => [
			'table' => 'custom_admin_view',
			'tables' => 'custom_admin_views',
			'key' => 'guid',
			'name' => 'system_name',
			'text' => 'Custom Admin View'
		],
		'adminviews' => [
			'table' => 'admin_view',
			'tables' => 'admin_views',
			'key' => 'guid',
			'name' => 'system_name',
			'text' => 'Admin View'
		],
		'adminview' => [
			'table' => 'admin_view',
			'tables' => 'admin_views',
			'key' => 'guid',
			'name' => 'system_name',
			'text' => 'Admin View'
		],
		'before' => [
			'table' => 'admin_view',
			'tables' => 'admin_views',
			'key' => 'guid',
			'name' => 'system_name',
			'text' => 'Admin View'
		]
	];

	/**
	 * An associative array mapping field types to configurations
	 * used for linking different database tables and their relationships
	 * within the component. This property defines the structure
	 * and metadata for various linked tables, including their fields,
	 * relationships, and additional metadata required for component functionality.
	 *
	 * Structure:
	 * - Key: Represents the context or type (e.g., 'field', 'admin_view', 'library', etc.).
	 * - Value: An array of configurations where each configuration contains:
	 *   - 'table': The database table name (singular form).
	 *   - 'tables': The database table name (plural form).
	 *   - 'fields': An associative array of field mappings (e.g., component-specific fields to database columns).
	 *   - 'linked': A string identifying the linked component or relationship.
	 *   - Optional:
	 *     - 'linked_name': A specific key to identify the linked name.
	 *     - 'type_name': An optional identifier for specific field types.
	 *
	 * Example Usage:
	 * - 'field': Links fields to specific configurations for components, libraries, etc.
	 * - 'library': Links libraries to templates, layouts, or other component parts.
	 * - 'power': Links metadata about system power usage or relationships for fields.
	 *
	 * @var array<string, array<array{
	 *     table: string,
	 *     tables: string,
	 *     fields: array<string, string>,
	 *     linked: string,
	 *     linked_name?: string,
	 *     type_name?: string
	 * }>> A multi-dimensional associative array defining table relationships.
	 * @since  3.0.0
	 */
	protected array $linkedKeys = [
		'field' => [
			[
				'table' => 'component_config',
				'tables' => 'components_config',
				'fields' => [
					'addconfig' => 'field',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			],
			[
				'table' => 'library_config',
				'tables' => 'libraries_config',
				'fields' => [
					'addconfig' => 'field',
					'library' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_LIBRARY',
				'linked_name' => 'name'
			],
			[
				'table' => 'admin_fields',
				'tables' => 'admins_fields',
				'fields' => [
					'addfields' => 'field',
					'admin_view' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_ADMIN_VIEW',
				'linked_name' => 'system_name'
			],
			[
				'table' => 'field',
				'tables' => 'fields',
				'fields' => [
					'xml' => 'fields',
					'name' => 'NAME',
					'fieldtype' => 'TYPE'
				],
				'linked' => 'COM_COMPONENTBUILDER_FIELD',
				'type_name' => 'name'
			],
			[
				'table' => 'joomla_module',
				'tables' => 'joomla_modules',
				'fields' => [
					'fields' => 'fields.fields.field',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_MODULE'
			],
			[
				'table' => 'joomla_plugin',
				'tables' => 'joomla_plugins',
				'fields' => [
					'fields' => 'fields.fields.field',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_PLUGIN'
			]
		],
		'admin_view' => [
			[
				'table' => 'component_admin_views',
				'tables' => 'components_admin_views',
				'fields' => [
					'addadmin_views' => 'adminview',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			]
		],
		'custom_admin_view' => [
			[
				'table' => 'component_custom_admin_views',
				'tables' => 'components_custom_admin_views',
				'fields' => [
					'addcustom_admin_views' => 'customadminview',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			]
		],
		'site_view' => [
			[
				'table' => 'component_site_views',
				'tables' => 'components_site_views',
				'fields' => [
					'addsite_views' => 'siteview',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			]
		],
		'library' => [
			[
				'table' => 'template',
				'tables' => 'templates',
				'fields' => [
					'libraries' => 'ARRAY',
					'name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_TEMPLATE'
			],
			[
				'table' => 'layout',
				'tables' => 'layouts',
				'fields' => [
					'libraries' => 'ARRAY',
					'name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_LAYOUT'
			],
			[
				'table' => 'site_view',
				'tables' => 'site_views',
				'fields' => [
					'libraries' => 'ARRAY',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_SITE_VIEW'
			],
			[
				'table' => 'custom_admin_view',
				'tables' => 'custom_admin_views',
				'fields' => [
					'libraries' => 'ARRAY',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW'
			]
		],
		'dynamic_get' => [
			[
				'table' => 'site_view',
				'tables' => 'site_views',
				'fields' => [
					'custom_get' => 'ARRAY',
					'main_get' => 'GUID',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_SITE_VIEW'
			],
			[
				'table' => 'custom_admin_view',
				'tables' => 'custom_admin_views',
				'fields' => [
					'custom_get' => 'ARRAY',
					'main_get' => 'GUID',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW'
			]
		],
		'joomla_module' => [
			[
				'table' => 'component_modules',
				'tables' => 'components_modules',
				'fields' => [
					'addjoomla_modules' => 'module',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			]
		],
		'joomla_plugin' => [
			[
				'table' => 'component_plugins',
				'tables' => 'components_plugins',
				'fields' => [
					'addjoomla_plugins' => 'plugin',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT',
				'linked_name' => 'system_name'
			]
		],
		'power' => [
			[
				'table' => 'admin_view',
				'tables' => 'admin_views',
				'fields' => [
					'params' => 'admin_view_headers:power_:power',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_ADMIN_VIEW'
			],
			[
				'table' => 'site_view',
				'tables' => 'site_views',
				'fields' => [
					'params' => 'site_view_headers:power_:power',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_SITE_VIEW'
			],
			[
				'table' => 'custom_admin_view',
				'tables' => 'custom_admin_views',
				'fields' => [
					'params' => 'custom_admin_view_headers:power_:power',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_CUSTOM_ADMIN_VIEW'
			],
			[
				'table' => 'joomla_component',
				'tables' => 'joomla_components',
				'fields' => [
					'params' => 'joomla_component_headers:power_:power',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_JOOMLA_COMPONENT'
			],
			[
				'table' => 'component_dashboard',
				'tables' => 'components_dashboard',
				'fields' => [
					'params' => 'component_dashboard_headers:power_:power',
					'joomla_component' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_COMPONENT_DASHBOARD',
				'linked_name' => 'system_name'
			],
			[
				'table' => 'power',
				'tables' => 'powers',
				'fields' => [
					'extends' => 'GUID',
					'extendsinterfaces' => 'ARRAY',
					'implements' => 'ARRAY',
					'use_selection' => 'use',
					'load_selection' => 'load',
					'system_name' => 'NAME'
				],
				'linked' => 'COM_COMPONENTBUILDER_POWER'
			]
		]
	];

	/**
	 * Retrieves the translated language string for a given key.
	 *
	 * This function fetches the appropriate language string from a predefined array based on the provided key.
	 * It supports both unique keys and shared keys using the `|=VDM=|` delimiter for shared language values.
	 * If the key is not found, it falls back to a safe default value.
	 *
	 * @param string $key The key to look up in the language array. It can be:
	 *                    - A unique key (e.g., 'rename', 'field').
	 *                    - A shared key in the format 'prefix|=VDM=|key' (e.g., 'custom|=VDM=|field').
	 *
	 * @return string The translated language string associated with the key. If the key is not found,
	 *                a safe fallback value is returned.
	 * @since  3.0.0
	 *
	 * Example usage:
	 * ```php
	 * $languageString = $this->getLanguage('rename');
	 * echo $languageString; // Outputs: 'Rename'
	 *
	 * $sharedString = $this->getLanguage('custom|=VDM=|field');
	 * echo $sharedString; // Outputs: 'Field'
	 * ```
	 *
	 * Behavior:
	 * - If the `$key` exists in the `$language` array, the corresponding value is returned.
	 * - If the `$key` is in shared format (`|=VDM=|`), it attempts to resolve the shared key.
	 * - If the key is not found, it falls back to `StringHelper::safe`
	 */
	protected function getLanguage($key)
	{
		$language = [
			// Library (folder file url)
			'rename' => Text::_('COM_COMPONENTBUILDER_RENAME'),
			'path' => Text::_('COM_COMPONENTBUILDER_TARGET_PATH'),
			'update' => Text::_('COM_COMPONENTBUILDER_UPDATE'),
			// Admin View (fields)
			'field' => Text::_('COM_COMPONENTBUILDER_FIELD'),
			'listfield' =>  Text::_('COM_COMPONENTBUILDER_LIST_FIELD'),
			'joinfields' =>  Text::_('COM_COMPONENTBUILDER_JOIN_FIELDS'),
			'set' =>  Text::_('COM_COMPONENTBUILDER_GLUECODE'),
			'join_type' =>  Text::_('COM_COMPONENTBUILDER_JOIN_TYPE'),
			'list' => Text::_('COM_COMPONENTBUILDER_ADMIN_BEHAVIOUR'),
			'order_list' => Text::_('COM_COMPONENTBUILDER_ORDER_IN_LIST_VIEWS'),
			'title' => Text::_('COM_COMPONENTBUILDER_TITLE'),
			'alias' => Text::_('COM_COMPONENTBUILDER_ALIAS'),
			'sort' => Text::_('COM_COMPONENTBUILDER_SORTABLE'),
			'search' => Text::_('COM_COMPONENTBUILDER_SEARCHABLE'),
			'filter' => Text::_('COM_COMPONENTBUILDER_FILTER'),
			'link' => Text::_('COM_COMPONENTBUILDER_LINK'),
			'permission' => Text::_('COM_COMPONENTBUILDER_PERMISSIONS'),
			'tab' => Text::_('COM_COMPONENTBUILDER_TAB'),
			'alignment' => Text::_('COM_COMPONENTBUILDER_ALIGNMENT'),
			'order_edit' => Text::_('COM_COMPONENTBUILDER_ORDER_IN_EDIT'),
			// Admin View (conditions)
			'target_field' => Text::_('COM_COMPONENTBUILDER_TARGET_FIELDS'),
			'target_behavior' => Text::_('COM_COMPONENTBUILDER_TARGET_BEHAVIOUR'),
			'target_relation' => Text::_('COM_COMPONENTBUILDER_TARGET_RELATION'),
			'match_field' => Text::_('COM_COMPONENTBUILDER_MATCH_FIELD'),
			'match_behavior' => Text::_('COM_COMPONENTBUILDER_MATCH_BEHAVIOUR'),
			'match_options' => Text::_('COM_COMPONENTBUILDER_MATCH_OPTIONS'),
			// Joomla Component
			'menu' => Text::_('COM_COMPONENTBUILDER_ADD_MENU'),
			'metadata' => Text::_('COM_COMPONENTBUILDER_HAS_METADATA'),
			'default_view' => Text::_('COM_COMPONENTBUILDER_DEFAULT_VIEW'),
			'access' => Text::_('COM_COMPONENTBUILDER_ADD_ACCESS'),
			'public_access' => Text::_('COM_COMPONENTBUILDER_PUBLIC_ACCESS'),
			'mainmenu' => Text::_('COM_COMPONENTBUILDER_MAIN_MENU'),
			'dashboard_list' => Text::_('COM_COMPONENTBUILDER_DASHBOARD_LIST_OF_RECORDS'),
			'dashboard_add' => Text::_('COM_COMPONENTBUILDER_DASHBOARD_ADD_RECORD'),
			'submenu' => Text::_('COM_COMPONENTBUILDER_SUBMENU'),
			'checkin' => Text::_('COM_COMPONENTBUILDER_AUTO_CHECKIN'),
			'history' => Text::_('COM_COMPONENTBUILDER_KEEP_HISTORY'),
			'joomla_fields' => Text::_('COM_COMPONENTBUILDER_JOOMLA_FIELDS'),
			'port' => Text::_('COM_COMPONENTBUILDER_EXPORTIMPORT_DATA'),
			'edit_create_site_view' => Text::_('COM_COMPONENTBUILDER_EDITCREATE_SITE_VIEW'),
			'icomoon' => Text::_('COM_COMPONENTBUILDER_ICON'),
			'customadminview' => Text::_('COM_COMPONENTBUILDER_VIEW'),
			'adminviews' => Text::_('COM_COMPONENTBUILDER_VIEWS'),
			'adminview' => Text::_('COM_COMPONENTBUILDER_VIEW'),
			'siteview' => Text::_('COM_COMPONENTBUILDER_VIEW'),
			'before' => Text::_('COM_COMPONENTBUILDER_ORDER_BEFORE')
		];

		// check if a unique value is available
		if (isset($language[$key]))
		{
			return $language[$key];
		}

		// check a shared value is available
		if (strpos($key, '|=VDM=|') !== false)
		{
			$keys = explode('|=VDM=|', $key);
			if (isset($language[$keys[1]]))
			{
				return $language[$keys[1]];
			}
		}

		return StringHelper::safe($keys[1], 'Ww');
	}

	/**
	 * Checks if the current view has an alias field.
	 *
	 * This method retrieves the view ID and checks if the associated fields include
	 * an alias field (a field marked with an `alias` value of 1). It ensures the view
	 * is valid and part of the allowed views before performing the check.
	 *
	 * @param mixed $type  The type of the view to check (not directly used in this function but passed for consistency).
	 *
	 * @return bool Returns `true` if an alias field exists in the view, `false` otherwise.
	 * @since  3.0.0
	 */
	public function checkAliasField($type): bool
	{
		// get the view name & id
		$values = $this->getViewID();
		if (GuidHelper::valid($values['a_guid'] ?? '') && strlen($values['a_view']) && in_array($values['a_view'], $this->allowedViewsArray))
		{
			// get the fields
			if ($fields = GetHelper::var('admin_fields', $values['a_guid'], 'admin_view', 'addfields'))
			{
				// open the fields
				if (JsonHelper::check($fields))
				{
					$fields = json_decode($fields, true);
					if (UtilitiesArrayHelper::check($fields))
					{
						foreach($fields as $field)
						{
							if (isset($field['alias']) && $field['alias'] == 1)
							{
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	/**
	 * Checks if the current view has a category field.
	 *
	 * This method retrieves the view ID and checks if the associated fields include
	 * a category field (a field with a type of `category`). It ensures the view is
	 * valid and part of the allowed views before performing the check.
	 *
	 * @param mixed $type   The type of the view to check (not directly used in this function but passed for consistency).
	 *
	 * @return bool Returns `true` if a category field exists in the view, `false` otherwise.
	 * @since  3.0.0
	 */
	public function checkCategoryField($type): bool
	{
		// get the view name & id
		$values = $this->getViewID();
		if (GuidHelper::valid($values['a_guid'] ?? '') && strlen($values['a_view']) && in_array($values['a_view'], $this->allowedViewsArray))
		{
			// get the fields
			if ($fields = GetHelper::var('admin_fields', $values['a_guid'], 'admin_view', 'addfields'))
			{
				// open the fields
				if (JsonHelper::check($fields))
				{
					$fields = json_decode($fields, true);
					if (UtilitiesArrayHelper::check($fields))
					{
						foreach($fields as $field)
						{
							if (isset($field['field']) &&
								($field_values = ComponentbuilderHelper::getFieldNameAndType($field['field'])) !== null && 
								$field_values['type'] === 'category' )
							{
								return true;
							}
						}
					}
				}
			}
		}
		return false;
	}

	/**
	 * Retrieves dynamic scripts for the given type.
	 *
	 * This method acts as a wrapper to retrieve dynamic scripts for a specific type
	 * by delegating the call to a global helper method.
	 *
	 * @param string $type   The target type of string
	 *
	 * @return string|array The dynamic scripts associated with the specified type. The return
	 *                        value depends on the implementation of the helper method.
	 * @since  3.0.0
	 */
	public function getDynamicScripts($type)
	{
		// get from global helper
		return ComponentbuilderHelper::getDynamicScripts($type);
	}

	/**
	 * Retrieves the name and type of a field.
	 *
	 * This function fetches the name and type of a field using the component helper and formats them into a string.
	 *
	 * @param mixed $value The value used to identify the field (e.g., field ID or GUID).
	 *
	 * @return string A formatted string containing the field name and type in the format `[name - type]`.
	 *                Returns an empty string if the field cannot be resolved.
	 * @since  3.0.9
	 */
	protected function getFieldNameAndType($value): string
	{
		// check if we can get the field name and type
		if (($array = ComponentbuilderHelper::getFieldNameAndType($value, true)) !== false)
		{
			return ' [' . $array['name'] . ' - ' . $array['type'] . ']';
		}
		return '';
	}

	/**
	 * Converts permission values into human-readable strings.
	 *
	 * This function translates permission values into their respective labels (e.g., "Editing", "Access").
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $values A single value or an array of values representing permissions.
	 *
	 * @return string A comma-separated string of permission labels. Returns "None" if no valid permissions are found.
	 * @since  3.0.9
	 */
	protected function setPermissions(string $header, $values): string
	{
		// check if value is array
		if (!UtilitiesArrayHelper::check($values))
		{
			$values = [$values];
		}

		// check if value is array
		if (UtilitiesArrayHelper::check($values))
		{
			// Editing, Access, View
			$bucket = [];
			foreach ($values as $value)
			{
				switch ($value)
				{
					case 1:
						$bucket[] = Text::_('COM_COMPONENTBUILDER_EDITING');
					break;
					case 2:
						$bucket[] = Text::_('COM_COMPONENTBUILDER_ACCESS');
					break;
					case 3:
						$bucket[] = Text::_('COM_COMPONENTBUILDER_VIEW');
					break;
				}
			}

			// check if value is array
			if (UtilitiesArrayHelper::check($bucket))
			{
				return implode(', ', $bucket);
			}
		}

		return Text::_('COM_COMPONENTBUILDER_NONE');
	}

	/**
	 * Converts join type values into human-readable strings.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the join type.
	 *
	 * @return string The human-readable label for the join type. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setJoinType(string $header, $value): string
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_CONCATENATE');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_CUSTOM_CODE');
			break;
		}
		return Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Converts URL type values into human-readable strings.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the URL type.
	 *
	 * @return string The human-readable label for the URL type. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setURLType(string $header, $value): string
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_DEFAULT_LINK');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_LOCAL_GET');
			break;
			case 3:
				return Text::_('COM_COMPONENTBUILDER_LINK_LOCAL_DYNAMIC');
			break;
		}
		return Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Converts IcoMoon values into an HTML span element.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The IcoMoon icon name.
	 *
	 * @return string An HTML span element with the IcoMoon icon class. Returns "-" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setIcoMoon(string $header, $value): string
	{
		if (StringHelper::check($value))
		{
			return '<span class="icon-' . $value . '"></span>';
		}
		return '-';
	}

	/**
	 * Converts alignment values into human-readable strings.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the alignment.
	 *
	 * @return string The human-readable label for the alignment. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setAlignmentName(string $header, $value): string
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_LEFT_IN_TAB');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_RIGHT_IN_TAB');
			break;
			case 3:
				return Text::_('COM_COMPONENTBUILDER_FULL_WIDTH_IN_TAB');
			break;
			case 4:
				return Text::_('COM_COMPONENTBUILDER_ABOVE_TABS');
			break;
			case 5:
				return Text::_('COM_COMPONENTBUILDER_UNDERNEATH_TABS');
			break;
			case 6:
				return Text::_('COM_COMPONENTBUILDER_LEFT_OF_TABS');
			break;
			case 7:
				return Text::_('COM_COMPONENTBUILDER_RIGHT_OF_TABS');
			break;
		}
		return Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Converts admin behavior values into human-readable strings.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the admin behavior.
	 *
	 * @return string The human-readable label for the admin behavior. Returns "Default" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setAdminBehaviour(string $header, $value): string
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_SHOW_IN_ALL_LIST_VIEWS');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_NONE_DB');
			break;
			case 3:
				return Text::_('COM_COMPONENTBUILDER_ONLY_IN_ADMIN_LIST_VIEW');
			break;
			case 4:
				return Text::_('COM_COMPONENTBUILDER_ONLY_IN_LINKED_LIST_VIEWS');
			break;
			default:
				return Text::_('COM_COMPONENTBUILDER_DEFAULT');
			break;
		}
	}

	/**
	 * Resolves a tab name based on the provided value.
	 *
	 * This function retrieves a tab name from a predefined list or dynamically fetches it if not already set.
	 * If the value is 15, it defaults to "Publishing".
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the tab.
	 *
	 * @return string The resolved tab name. Returns "Details" if no matching tab is found.
	 * @since  3.0.9
	 */
	protected function setTabName(string $header, $value): string
	{
		// return published if set to 15 (since this is the default number for it)
		if (15 == $value)
		{
			return Text::_('COM_COMPONENTBUILDER_PUBLISHING');
		}

		if (!UtilitiesArrayHelper::check($this->tabNames))
		{
			// get the view name & id
			$values = $this->getViewID();
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && $values['a_view'] === 'admin_view')
			{
				if ($tabs = GetHelper::var('admin_view', $values['a_id'], 'id', 'addtabs'))
				{
					$tabs = json_decode($tabs, true);
					if (UtilitiesArrayHelper::check($tabs))
					{
						$nr = 1;
						foreach ($tabs as $tab)
						{
							if (UtilitiesArrayHelper::check($tab) && isset($tab['name']))
							{
								$this->tabNames[$nr] = $tab['name'];
								$nr++;
							}
						}
					}
				}
			}
		}

		// has it been set
		if (UtilitiesArrayHelper::check($this->tabNames) && isset($this->tabNames[$value]))
		{
			return $this->tabNames[$value];
		}

		return Text::_('COM_COMPONENTBUILDER_DETAILS');
	}

	/**
	 * Converts area values into human-readable strings.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value representing the area.
	 *
	 * @return string The human-readable label for the area. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setAreaName(string $header, $value): string
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_MODEL_BEFORE_MODELLING');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_VIEW');
			break;
			case 3:
				return Text::_('COM_COMPONENTBUILDER_MODEL_AFTER_MODELLING');
			break;
		}
		return  Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Formats code values for display.
	 *
	 * This function converts the given value into a safe, HTML-escaped, and line-breaked format.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The code value to format.
	 *
	 * @return string The formatted code string.
	 * @since  3.0.9
	 */
	protected function setCode(string $header, $value): string
	{
		return nl2br(htmlspecialchars($value));
	}

	/**
	 * Converts binary values (1/0) into Yes/No HTML icons.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The binary value to convert.
	 *
	 * @return string An HTML string with a green checkmark for "Yes" or a gray delete icon for "No".
	 * @since  3.0.9
	 */
	protected function setYesNo(string $header, $value): string
	{
		if (1 == $value)
		{
			return '<span style="color: #46A546;" class="icon-ok"></span>';
		}
		return '<span style="color: #e6e6e6;" class="icon-delete"></span>';
	}

	/**
	 * Converts target behavior values into human-readable strings.
	 *
	 * This function translates a numeric value into its corresponding behavior for
	 * displaying, hiding, or toggling a field's visibility.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The numeric value representing the target behavior.
	 *
	 * @return string The human-readable label for the target behavior.
	 * @since  3.0.9
	 */
	protected function setTargetBehavior(string $header, $value): string
	{
		if (1 == $value)
		{
			return Text::_('COM_COMPONENTBUILDER_SHOW_TOGGLE');
		}
		elseif (3 == $value)
		{
			return Text::_('COM_COMPONENTBUILDER_SHOW_ONLY');
		}
		elseif (4 == $value)
		{
			return Text::_('COM_COMPONENTBUILDER_HIDE_ONLY');
		}
		return Text::_('COM_COMPONENTBUILDER_HIDE_TOGGLE');
	}

	/**
	 * Converts target relation values into human-readable strings.
	 *
	 * This function translates a numeric value into its corresponding relation type
	 * for handling field dependencies.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The numeric value representing the target relation.
	 *
	 * @return string The human-readable label for the target relation. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setTargetRelation(string $header, $value): string
	{
		switch ($value)
		{
			case 0:
				return Text::_('COM_COMPONENTBUILDER_ISOLATE');
			break;
			case 1:
				return Text::_('COM_COMPONENTBUILDER_CHAIN');
			break;
		}
		return  Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Converts match behavior values into human-readable strings.
	 *
	 * This function translates numeric values into behavior types for matching fields, such as
	 * keywords, length constraints, or selection criteria.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The numeric value representing the match behavior.
	 *
	 * @return string The human-readable label for the match behavior. Returns "not set" if the value is invalid.
	 * @since  3.0.9
	 */
	protected function setMatchBehavior($header, $value)
	{
		switch ($value)
		{
			case 1:
				return Text::_('COM_COMPONENTBUILDER_IS_ONLY_FOUR_LISTRADIOCHECKBOXES');
			break;
			case 2:
				return Text::_('COM_COMPONENTBUILDER_IS_NOT_ONLY_FOUR_LISTRADIOCHECKBOXES');
			break;
			case 3:
				return Text::_('COM_COMPONENTBUILDER_ANY_SELECTION_ONLY_FOUR_LISTRADIOCHECKBOXESDYNAMIC_LIST');
			break;
			case 4:
				return Text::_('COM_COMPONENTBUILDER_ACTIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 5:
				return Text::_('COM_COMPONENTBUILDER_UNACTIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 6:
				return Text::_('COM_COMPONENTBUILDER_KEY_WORD_ALL_CASESENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 7:
				return Text::_('COM_COMPONENTBUILDER_KEY_WORD_ANY_CASESENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 8:
				return Text::_('COM_COMPONENTBUILDER_KEY_WORD_ALL_CASEINSENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 9:
				return Text::_('COM_COMPONENTBUILDER_KEY_WORD_ANY_CASEINSENSITIVE_ONLY_FOUR_TEXT_FIELD');
			break;
			case 10:
				return Text::_('COM_COMPONENTBUILDER_MIN_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
			case 11:
				return Text::_('COM_COMPONENTBUILDER_MAX_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
			case 12:
				return Text::_('COM_COMPONENTBUILDER_EXACT_LENGTH_ONLY_FOUR_TEXT_FIELD');
			break;
		}
		return  Text::_('COM_COMPONENTBUILDER_NOT_SET');
	}

	/**
	 * Converts match options into a formatted string.
	 *
	 * This function replaces newlines in the input value with `<br />` tags for proper HTML formatting.
	 *
	 * @param string $header The header name (not used in this function but kept for consistency).
	 * @param mixed  $value  The value containing match options (e.g., a string with newline-separated options).
	 *
	 * @return string The formatted string with `<br />` tags for each option.
	 * @since  3.0.9
	 */
	protected function setMatchOptions(string $header, $value): string
	{
		return str_replace("\n", "<br />", $value);
	}

	/**
	 * Retrieves the select options for a given field.
	 *
	 * This function fetches field options from the database based on the field's ID and type.
	 * Depending on the field type, it processes the options differently (e.g., list, text, dynamic).
	 *
	 * @param mixed $target The ID|GUID of the field.
	 *
	 * @return string|null Returns a string of options if successful, or `null` if no options are found.
	 * @since  3.0.9
	 */
	public function getFieldSelectOptions($target): ?string
	{
		if (GuidHelper::valid($target))
		{
			$key = 'guid';
		}
		elseif (is_numeric($target))
		{
			$key = 'id';
		}
		else
		{
			return null;
		}

		// Create a new query object.
		$query = $this->_db->getQuery(true);
		$query->select($this->_db->quoteName(['a.xml', 'b.name']));
		$query->from($this->_db->quoteName('#__componentbuilder_field', 'a'));
		$query->join('LEFT', $this->_db->quoteName('#__componentbuilder_fieldtype', 'b') . ' ON (' . $this->_db->quoteName('a.fieldtype') . ' = ' . $this->_db->quoteName('b.id') . ')');
		$query->where($this->_db->quoteName('a.published') . ' = 1');
		$query->where($this->_db->quoteName('a.' . $key) . ' = ' . $this->_db->quote($target));

		// Reset the query using our newly populated query object.
		$this->_db->setQuery($query);
		$this->_db->execute();
		if ($this->_db->getNumRows())
		{
			$result = $this->_db->loadObject();
			$result->name = strtolower($result->name);
			if (ComponentbuilderHelper::fieldCheck($result->name,'list'))
			{
				// load the values form params
				$xml = json_decode($result->xml);

				$xmlOptions = GetHelper::between($xml,'option="','"');

				$optionSet = '';
				if (strpos($xmlOptions,',') !== false)
				{
					// mulitpal options
					$options = explode(',',$xmlOptions);
					foreach ($options as $option)
					{
						// return both value and text
						if (StringHelper::check($optionSet))
						{
							// no add to option set
							$optionSet .= "\n".$option;
						}
						else 
						{
							// no add to option set
							$optionSet .= $option;
						}
					}
				}
				else
				{
					// return both value and text
					if (StringHelper::check($optionSet))
					{
						// no add to option set
						$optionSet .= "\n".$xmlOptions;
					}
					else 
					{
						// no add to option set
						$optionSet .= $xmlOptions;
					}
				}				
				// return found field options
				return $optionSet;
			}
			elseif (ComponentbuilderHelper::fieldCheck($result->name,'text'))
			{
				return "keywords=\"\"\nlength=\"\"";
			}
			elseif (ComponentbuilderHelper::fieldCheck($result->name,'dynamic'))
			{
				return 'dynamic_list';
			}
			elseif (ComponentbuilderHelper::fieldCheck($result->name))
			{
				return 'match field type not supported. Select another!';
			}
			else
			{
				return 'dynamic_list';
			}
		}
		return null;
	}

	/**
	 * Retrieves the columns of a database table.
	 *
	 * This function fetches the column names and formats them into a string for easy display.
	 *
	 * @param string $tableName The name of the database table (without the prefix).
	 *
	 * @return string|null Returns a newline-separated string of column names if successful,
	 *                        or `null` if the table has no columns or an error occurs.
	 * @since  3.0.9
	 */
	public function getTableColumns(string $tableName): ?string
	{
        	// get the columns
		$columns = $this->_db->getTableColumns("#__".$tableName);
		if (UtilitiesArrayHelper::check($columns))
		{
        	   	// build the return string
			$tableColumns = array();
			foreach ($columns as $column => $type)
			{
				$tableColumns[] = $column . ' => ' . $column;
			}
			return implode("\n",$tableColumns);
		}
		return null;
	}

	/**
	 * Get Linked
	 * 
	 * @param   int   $type   The display return type
	 *
	 * @return  string  The display return type on success
	 * @since   3.0.0
	 */
	public function getLinked($type): string
	{
		// get the view name & id
		$values = $this->getViewID();

		// check if item is set
		if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
		{
			// check if we have any linked to config
			if (isset($this->linkedKeys[$values['a_view']]))
			{
				// set a return value
				$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
				if (isset($values['a_return']))
				{
					$return_url .= '&return=' . (string) $values['a_return'];
				}

				// make sure the ref is set
				$this->ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'] . '&return=' . urlencode(base64_encode($return_url));

				// specail treatment of powers
				$guid = $values['a_guid'] ?? null;

				// get the linked to
				if ($linked = $this->getLinkedTo($values['a_view'], $values['a_id'], $guid))
				{
					// just return it for now a table
					$table =  '<div class="control-group"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
					$table .=  '<caption>'.Text::sprintf('COM_COMPONENTBUILDER_PLACES_ACROSS_JCB_WHERE_THIS_S_IS_LINKED', StringHelper::safe($values['a_view'], 'w')).'</caption>';
					$table .=  '<thead><tr><th>'.Text::_('COM_COMPONENTBUILDER_TYPE_NAME').'</th></tr></thead>';
					$table .=  '<tbody><tr><td>' .implode('</td></tr><tr><td>', $linked) . '</td></tr></tbody></table></div>';
					return $table;
				}
			}
		}

		// if not found but has session view name
		if (strlen($values['a_view']))
		{
			return '<div class="control-group"><div class="alert alert-info"><h4>' .
				Text::sprintf('COM_COMPONENTBUILDER_S_NOT_LINKED', StringHelper::safe($values['a_view'], 'Ww')) .
				'</h4><p>' . Text::sprintf('COM_COMPONENTBUILDER_THIS_BSB_IS_NOT_LINKED_TO_ANY_OTHER_AREAS_OF_JCB_AT_THIS_TIME', $values['a_view']) .
				'</p></div></div>';
		}

		// no view or id found in session, or view not allowed to access area
		return '<div class="control-group"><div class="alert alert-error"><h4>' . Text::_('COM_COMPONENTBUILDER_ERROR') . '</h4><p>' .
			Text::_('COM_COMPONENTBUILDER_THERE_WAS_A_PROBLEM_BNO_VIEW_OR_ID_FOUND_IN_SESSION_OR_VIEW_NOT_ALLOWED_TO_ACCESS_AREAB_WE_COULD_NOT_LOAD_ANY_LINKED_TO_VALUES_PLEASE_INFORM_YOUR_SYSTEM_ADMINISTRATOR') .
			'</p></div></div>';
	}

	/**
	 * Get Linked to Items
	 * 
	 * @param   string         $view    View that is being searched for
	 * @param   int            $id      ID
	 * @param   string|null    $guid    GUID
	 *
	 * @return  array|null   Found items
	 * @since   3.0.0
	 */
	protected function getLinkedTo(string $view, int $id, ?string $guid): ?array
	{
		// reset bucket
		$linked = [];

		// start search
		foreach ($this->linkedKeys[$view] as $search)
		{
			// Create a new query object.
			$query = $this->_db->getQuery(true);

			// get all history values
			$selection = array_keys($search['fields']);
			$selection[] = 'id';
			$query->select($selection);
			$query->from('#__componentbuilder_' . $search['table']);
			$this->_db->setQuery($query);
			$this->_db->execute();
			if ($this->_db->getNumRows())
			{
				// load all items
				$items = $this->_db->loadObjectList();

				// search the items
				foreach ($items as $item)
				{
					$found = false;
					$type_name = null;
					foreach ($search['fields'] as $key => $target)
					{
						if ('NAME' === $target)
						{
							$linked_name = $item->{$key};
							$linked_nameTable = $key;
							continue;
						}
						elseif ('TYPE' === $target)
						{
							$type_name = $item->{$key};
							$type_nameTable = $key;
							continue;
						}
						elseif (!$found)
						{
							if ('INT' === $target)
							{
								// check if ID match
								if ($item->{$key} == $id)
								{
									$found = true;
								}
							}
							elseif ('GUID' === $target)
							{
								// check if GUID match
								if ($this->linkedGuid($guid, $item->{$key}))
								{
									$found = true;
								}
							}
							else
							{
								// check if we have a json
								if (JsonHelper::check($item->{$key}))
								{
									$item->{$key} = json_decode($item->{$key}, true);
								}
								// if array
								if (UtilitiesArrayHelper::check($item->{$key}))
								{
									if ('ARRAY' === $target)
									{
										// check if ID match
										foreach ($item->{$key} as $_id)
										{
											if ($_id == $id || $this->linkedGuid($guid, $_id))
											{
												$found = true;
											}
										}
									}
									else
									{
										// check if this is a sub sub form target
										if (strpos($target, '.') !== false)
										{
											$_target = (array) explode('.', $target);
											// check that we have an array and get the size
											if (($_size = UtilitiesArrayHelper::check($_target)) !== false)
											{
												foreach ($item->{$key} as $row)
												{
													if ($_size == 2)
													{
														if (isset($row[$_target[0]]) && isset($row[$_target[0]][$_target[1]]) && ($row[$_target[0]][$_target[1]] == $id || $this->linkedGuid($guid, $row[$_target[0]][$_target[1]])))
														{
															$found = true;
														}
													}
													elseif ($_size == 3 && isset($row[$_target[0]]) && UtilitiesArrayHelper::check($row[$_target[0]]))
													{
														foreach ($row[$_target[0]] as $_row)
														{
															if (!$found && isset($_row[$_target[2]]) && ($_row[$_target[2]] == $id || $this->linkedGuid($guid, $_row[$_target[2]]))) 
															{
																$found = true;
															}
														}
													}
												}
											}
										}
										elseif (strpos($target, ':') !== false)
										{
											$_target = (array) explode(':', $target);
											// check that we have an array and get the size
											if (($_size = UtilitiesArrayHelper::check($_target)) == 2)
											{
												foreach ($item->{$key} as $field_name => $row)
												{
													if (!$found && $field_name === $_target[0])
													{
														foreach ($row as $_key => $_ids)
														{
															if (!$found && strpos($_key, $_target[1]) !== false && (in_array($id, $_ids) || $this->linkedGuid($guid, $_ids)))
															{
																$found = true;
															}
														}
													}
												}
											}
											// check that we have an array and get the size
											if (($_size = UtilitiesArrayHelper::check($_target)) == 3)
											{
												foreach ($item->{$key} as $field_name => $row)
												{
													if (!$found && $field_name === $_target[0])
													{
														foreach ($row as $_key => $_items)
														{
															if (!$found && strpos($_key, $_target[1]) !== false && is_array($_items) && count($_items) > 0)
															{
																foreach ($_items as $_item)
																{
																	if (!$found && isset($_item[$_target[2]]) && ($id == $_item[$_target[2]] || $this->linkedGuid($guid, $_item[$_target[2]])))
																	{
																		$found = true;
																	}
																}
															}
														}
													}
												}
											}
										}
										else
										{
											foreach ($item->{$key} as $row)
											{
												if (!$found && isset($row[$target]) && ($row[$target] == $id || $this->linkedGuid($guid, $row[$target])))
												{
													$found = true;
												}
											}
										}
									}
								}
								// if string (fields)
								if (!$found &&  'xml' === $key && StringHelper::check($item->{$key})
									&& strpos($item->{$key}, $target.'="') !== false)
								{
									// now get the fields between
									$_fields = GetHelper::between($item->{$key},  $target.'="', '"');
									// check the result
									if (StringHelper::check($_fields))
									{
										// get the ids of all the fields linked here
										$_fields = array_map('trim', (array) explode(',', $_fields));
										// check the result
										if (UtilitiesArrayHelper::check($_fields))
										{
											foreach ($_fields as $_field)
											{
												if ($_field == $id || $this->linkedGuid($guid, $_field))
												{
													$found = true;
												}
											}
										}
									}
								}
							}
						}
					}
					// check if found
					if ($found)
					{
						// build the name
						$edit = true;
						if ((is_numeric($linked_name) || GuidHelper::valid($linked_name)) && isset($search['linked_name']))
						{
							$key_field = GuidHelper::valid($linked_name) ? 'guid':'id';
							if (!$linked_name =  GetHelper::var($linked_nameTable, $linked_name, $key_field, $search['linked_name']))
							{
								$linked_name = Text::_('COM_COMPONENTBUILDER_NO_FOUND');
								$edit = false;
							}
						}

						// build the local type
						if ((is_numeric($type_name) || GuidHelper::valid($type_name)) && isset($search['type_name']))
						{
							$key_field = GuidHelper::valid($type_name) ? 'guid':'id';
							if (!$type_name =  GetHelper::var($type_nameTable, $type_name, $key_field, $search['type_name']))
							{
								$type_name = '';
							}
							else
							{
								$type_name = ' (' . $type_name . ') ';
							}
						}
						elseif (StringHelper::check($type_name) || is_numeric($type_name))
						{
							$type_name = ' (' . $type_name . ') ';
						}

						// set edit link
						$link = ($edit) ? ComponentbuilderHelper::getEditButton($item->id, $search['table'], $search['tables'], $this->ref) : '';
						// build the linked
						$linked[] = Text::_($search['linked']) . $type_name . ' - ' . $linked_name . ' ' . $link;
					}
				}
			}
		}
		// check if we found any
		if (UtilitiesArrayHelper::check($linked))
		{
			return $linked;
		}
		return null;
	}

	/**
	 * Check if we have a GUID match
	 * 
	 * @param   string|null      $guid       The active power guid
	 * @param   string|array     $setGuid    The linked power guid
	 *
	 * @return  bool true if match is found
	 * @since  3.0.0
	 */
	protected function linkedGuid(?string $guid, $setGuid): bool
	{
		// check if GUID is valid
		if ($guid !== null && GuidHelper::valid($guid))
		{
			if (is_string($setGuid) && GuidHelper::valid($setGuid) && $guid === $setGuid)
			{
				return true;
			}
			elseif (is_array($setGuid) && in_array($guid, $setGuid))
			{
				return true;
			}
		}
		return false;
	}

	/**
	 * The view persistence details
	 *
	 * @var	array
	 * @since 3.0.13
	 */
	protected array $viewid = [];

	/**
	 * Get the view details via the session
	 *
	 * @input	string  $call    The persistence key
	 *
	 * @return array
	 * @since 3.0.13
	 */
	protected function getViewID(string $call = 'table'): array
	{
		if (!isset($this->viewid[$call]))
		{
			// get the vdm key
			$input = Factory::getApplication()->getInput();
			$vdm = $input->get('vdm', null, 'WORD');
			if ($vdm)
			{
				// set view and id
				if (($view = SessionHelper::get($vdm)) !== null)
				{
					$current = (array) explode('__', $view);
					if (StringHelper::check($current[0]) && isset($current[1]) && is_numeric($current[1]))
					{
						// get the view name & id
						$this->viewid[$call] = array(
							'a_id' => (int) $current[1],
							'a_view' => $current[0]
						);
					}
				}

				// set GUID if found
				if (($guid = SessionHelper::get($vdm . '__guid')) !== null)
				{
					if (GuidHelper::valid($guid))
					{
						$this->viewid[$call]['a_guid'] = $guid;
					}
				}

				// set return if found
				if (($return = SessionHelper::get($vdm . '__return')) !== null)
				{
					if (StringHelper::check($return))
					{
						$this->viewid[$call]['a_return'] = $return;
					}
				}
			}
		}

		if (isset($this->viewid[$call]))
		{
			return $this->viewid[$call];
		}

		return [];
	}


	public function getButton($type, $size)
	{
		if (isset($this->buttonArray[$type]))
		{
			$user = Factory::getUser();
			// only add if user allowed to create
			if ($user->authorise($type.'.create', 'com_componentbuilder'))
			{
				// get the view name & id
				$values = $this->getViewID();
				// check if new item
				$ref = '';
				if (!empty($values['a_id']) && !empty($values['a_view']))
				{
					// check if we have a return value
					$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
					if (isset($values['a_return']))
					{
						$return_url .= '&return=' . (string) $values['a_return'];
					}

					// load the return url
					$ref = '&amp;return=' . urlencode(base64_encode($return_url));

					// check if we have a GUID
					if (isset($values['a_guid']))
					{
						$ref .= '&amp;init_defaults=' . urlencode(json_encode([$values['a_view'] => $values['a_guid']]));
					}
				}
				// build url (A tag)
				$startAtag = 'onclick="UIkit2.modal.confirm(\''.Text::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \'index.php?option=com_componentbuilder&amp;view=' . $type . '&amp;layout=edit' . $ref . '\' })" href="javascript:void(0)"  title="'.Text::sprintf('COM_COMPONENTBUILDER_CREATE_NEW_S', StringHelper::safe($type, 'W')).'">';
				// build the smallest button
				if (3 == $size)
				{
					$button = '<a class="btn btn-small btn-success" style="margin: 0 0 5px 0;" ' . $startAtag.'<span class="icon-new icon-white"></span></a>';
				}
				// build the smaller button
				elseif (2 == $size)
				{
					$button = '<a class="btn btn-success vdm-button-new" ' . $startAtag . '<span class="icon-new icon-white"></span> ' . Text::_('COM_COMPONENTBUILDER_CREATE') . '</a>';
				}
				else
				// build the big button
				{
					$button = '<div class="control-group">
								<div class="control-label">
									<label>' . ucwords($type) . '</label>
								</div>
								<div class="controls"><a class="btn btn-success vdm-button-new" ' . $startAtag . '
									<span class="icon-new icon-white"></span> 
										' . Text::_('COM_COMPONENTBUILDER_NEW') . '
									</a>
								</div>
							</div>';
				}
				// return the button attached to input field
				return $button;
			}
			return '';
		}
		return false;
	}

	public function getButtonID($type, $size)
	{
		if (isset($this->buttonArray[$type]))
		{
			$user = Factory::getUser();
			// only add if user allowed to create
			if ($user->authorise($type.'.create', 'com_componentbuilder'))
			{
				// get the view name & id
				$values = $this->getViewID();
				// set the button ID
				$css_class = 'control-group-'.StringHelper::safe($type. '-' . $size, 'L', '-');
				// check if new item
				$ref = '';
				if (!empty($values['a_id']) && !empty($values['a_view']))
				{
					// set the return value
					$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
					if (isset($values['a_return']))
					{
						$return_url .= '&return=' . (string) $values['a_return'];
					}
					// only load referral if not new item.
					$ref = '&amp;return=' . urlencode(base64_encode($return_url));

					// set the key get value
					$key_get_value = $values['a_id'];

					// check if we have a GUID
					if (isset($values['a_guid']))
					{
						$ref .= '&amp;init_defaults=' . urlencode(json_encode([$values['a_view'] => $values['a_guid']]));
						$key_get_value = $values['a_guid'];
					}

					// get item id
					if (($id = GetHelper::var($type, $key_get_value, $values['a_view'], 'id')) !== false && $id > 0)
					{
						$buttonText = Text::sprintf('COM_COMPONENTBUILDER_EDIT_S_FOR_THIS_S', StringHelper::safe($type, 'w'), StringHelper::safe($values['a_view'], 'w'));
						$buttonTextSmall = Text::_('COM_COMPONENTBUILDER_EDIT');
						$editThis = 'index.php?option=com_componentbuilder&amp;view='.$this->buttonArray[$type].'&amp;task='.$type.'.edit&amp;id='.$id;
						$icon = 'icon-apply';
					}
					else
					{
						$buttonText = Text::sprintf('COM_COMPONENTBUILDER_CREATE_S_FOR_THIS_S', StringHelper::safe($type, 'w'), StringHelper::safe($values['a_view'], 'w'));
						$buttonTextSmall = Text::_('COM_COMPONENTBUILDER_CREATE');
						$editThis = 'index.php?option=com_componentbuilder&amp;view='.$type.'&amp;layout=edit';
						$icon = 'icon-new';
					}
					// build the button
					$button = [];
					if (1 == $size)
					{
						$button[] = '<div class="control-group '.$css_class.'">';
						$button[] = '<div class="control-label">';
						$button[] = '<label>' . StringHelper::safe($type, 'Ww') . '</label>';
						$button[] = '</div>';
						$button[] = '<div class="controls">';
					}
					$button[] = '<a class="btn btn-success vdm-button-new" onclick="UIkit2.modal.confirm(\''.Text::_('COM_COMPONENTBUILDER_ALL_UNSAVED_WORK_ON_THIS_PAGE_WILL_BE_LOST_ARE_YOU_SURE_YOU_WANT_TO_CONTINUE').'\', function(){ window.location.href = \''.$editThis.$ref.'\' })" href="javascript:void(0)" title="'.$buttonText.'">';
					if (1 == $size)
					{
						$button[] = '<span class="'.$icon.' icon-white"></span>';
						$button[] = $buttonText;
						$button[] = '</a>';
						$button[] = '</div>';
						$button[] = '</div>';
					}
					elseif (2 == $size)
					{
						$button[] = '<span class="'.$icon.' icon-white"></span>';
						$button[] = $buttonTextSmall;
						$button[] = '</a>';
					}
					// return the button attached to input field
					return implode("\n", $button);
				}

				// only return notice if big button
				if (1 == $size)
				{
					return '<div class="control-group '.$css_class.'"><div class="alert alert-info">' . Text::sprintf('COM_COMPONENTBUILDER_BUTTON_TO_CREATE_S_WILL_SHOW_ONCE_S_IS_SAVED_FOR_THE_FIRST_TIME', StringHelper::safe($type, 'w'), StringHelper::safe($values['a_view'], 'w')) . '</div></div>';
				}
			}
		}
		return '';
	}

	protected function getSubformTable($idName, $data)
	{
		// make sure we convert the json to array
		if (JsonHelper::check($data))
		{
			$data = json_decode($data, true);
		}
		// make sure we have an array
		if (UtilitiesArrayHelper::check($data) && StringHelper::check($idName))
		{ 
			// Build heading
			$head = array();
			foreach ($data as $headers)
			{
				foreach ($headers as $header => $value)
				{
					if (!isset($head[$header]))
					{
						$head[$header] = $this->getLanguage($idName . '|=VDM=|' . $header);
					}
				}
			}
			// build the rows
			$rows = array();
			if (UtilitiesArrayHelper::check($data) && UtilitiesArrayHelper::check($head))
			{
				foreach ($data as $nr => $values)
				{
					foreach ($head as $key => $_header)
					{
						// set the value for the row
						if (isset($values[$key]))
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, $values[$key]), $rows, $_header);
						}
						else
						{
							$this->setSubformRows($nr, $this->setSubformValue($key, ''), $rows, $_header);
						}
					}
				}
			}
			// build table
			if (UtilitiesArrayHelper::check($rows) && UtilitiesArrayHelper::check($head))
			{
				// set the number of rows
				$this->rowNumber = count($rows);
				// return the table
				return ComponentbuilderHelper::setSubformTable($head, $rows, $idName);
			}
		}
		return false;
	}

	protected function setSubformValue($header, $value)
	{
		if (array_key_exists($header, $this->functionArray) && method_exists($this, $this->functionArray[$header]))
		{
			$value = $this->{$this->functionArray[$header]}($header, $value);
		}
		// if no value are set
		if (!StringHelper::check($value))
		{
			$value = '-';
		}
		return $value;
	}

	protected function setSubformRows($nr, $value, &$rows, $_header)
	{
		// build rows
		if (!isset($rows[$nr]))
		{
			$rows[$nr] = '<td data-column=" '.$_header.' ">'.$value.'</td>';
		}
		else
		{
			$rows[$nr] .= '<td data-column=" '.$_header.' ">'.$value.'</td>';
		}
	}

	/**
	 * Generates the HTML display for fields linked to a specific view via an AJAX request.
	 *
	 * This method dynamically retrieves and constructs the HTML display for fields linked to a view
	 * based on the provided type. It validates the view, builds return URLs, fetches field tables,
	 * and generates a structured HTML output. If no fields are linked, or an error occurs, an appropriate
	 * alert is displayed.
	 *
	 * @param string  $type  The type of fields to retrieve and display.
	 *
	 * @return string The generated HTML output. This can include:
	 *                - A list of fields rendered as HTML.
	 *                - An informational message if no fields are linked.
	 *                - An error message in case of a type-related issue.
	 * @since  3.0.0
	 */
	public function getAjaxDisplay(string $type): string
	{
		if (isset($this->fieldsArray[$type]))
		{
			// set type name
			$typeName = StringHelper::safe($type, 'w');
			// get the view name & id
			$values = $this->getViewID();
			// check if we are in the correct view.
			if (GuidHelper::valid($values['a_guid'] ?? '') &&
				!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']) && in_array($values['a_view'], $this->allowedViewsArray))
			{
				// set a return value
				$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
				// set a global return value
				if (isset($values['a_return']))
				{
					$return_url .= '&return=' . (string) $values['a_return'];
				}
				// set the ref
				$this->ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'] . '&return=' . urlencode(base64_encode($return_url));
				// set the key get value
				$target = $values['a_guid'] ?? null;
				// load the results
				$result = [];
				// return field table
				if (UtilitiesArrayHelper::check($this->fieldsArray[$type]))
				{
					foreach ($this->fieldsArray[$type] as $fieldName)
					{
						if ($table = $this->getFieldTable($type, $target, $values['a_view'], $fieldName, $typeName))
						{
							$result[] = $table;
						}
					}
				}
				elseif (StringHelper::check($this->fieldsArray[$type]))
				{
					if ($table = $this->getFieldTable($type, $target, $values['a_view'], $this->fieldsArray[$type], $typeName))
					{
						$result[] = $table;
					}
				}

				// check if we have results
				if (UtilitiesArrayHelper::check($result) && count($result) == 1)
				{
					// return the display
					return implode('', $result);
				}
				elseif (UtilitiesArrayHelper::check($result))
				{
					// return the display
					return '<div>' . implode('</div><div>', $result) . '</div>';
				}
			}
			return '<div class="control-group"><div class="alert alert-info">' . Text::sprintf('COM_COMPONENTBUILDER_NO_S_HAVE_BEEN_LINKED_TO_THIS_VIEW_SOON_AS_THIS_IS_DONE_IT_WILL_BE_DISPLAYED_HERE', $typeName) . '</div></div>';
		}
		return '<div class="control-group"><div class="alert alert-error"><h4>' . Text::_('COM_COMPONENTBUILDER_TYPE_ERROR') . '</h4><p>' . Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_IF_THIS_CONTINUES_PLEASE_INFORM_YOUR_SYSTEM_ADMINISTRATOR_OF_A_TYPE_ERROR_IN_THE_FIELDS_DISPLAY_REQUEST') . '</p></div></div>';
	}

	/**
	 * Sets and retrieves item names with optional edit links.
	 *
	 * This method processes a list of items or a single item based on the provided header and value.
	 * It fetches the item names from a predefined table, appends additional information if required, 
	 * and generates edit links if supported. If no items are found, an appropriate message is returned.
	 *
	 * @param string $header The key used to access the item configuration (`itemKeys` and `itemNames`).
	 * @param mixed  $value  The value(s) to process. Can be a single numeric or GUID value, or an array of such values.
	 *
	 * @return string A string containing the processed item names and optional edit links, separated by `<br />`.
	 *
	 * @throws \RuntimeException If a required dependency or method is missing.
	 * @since  3.0.9
	 */
	protected function setItemNames(string $header, $value)
	{
		// Check if the header exists in itemKeys and if the corresponding table is defined
		if (!isset($this->itemKeys[$header]) || !isset($this->itemKeys[$header]['table']) || !isset($this->itemNames[$this->itemKeys[$header]['table']]))
		{
			return Text::_('COM_COMPONENTBUILDER_NO_ITEM_FOUND');
		}

		// Check for helper methods
		$guidEdit = method_exists(ComponentbuilderHelper::class, 'getEditButtonGUID');
		$getEdit = method_exists(ComponentbuilderHelper::class, 'getEditButton');

		// Initialize bucket to hold processed items
		$bucket = [];

		// Process an array of values
		if (is_array($value) && UtilitiesArrayHelper::check($value))
		{
			foreach ($value as $item)
			{
				$bucket[] = $this->processItemName($header, $item, $guidEdit, $getEdit);
			}
		} 
		// Process a single value
		elseif (is_numeric($value) || GuidHelper::valid($value))
		{
			$bucket[] = $this->processItemName($header, $value, $guidEdit, $getEdit);
		}

		// Return processed items or a "No items found" message
		if (!empty($bucket))
		{
			return implode('<br />', $bucket);
		}

		return Text::sprintf('COM_COMPONENTBUILDER_NO_S_FOUND', $this->itemKeys[$header]['text'] ?? 'Item');
	}

	/**
	 * Processes a single item and retrieves its name with an optional edit link.
	 *
	 * @param string  $header    The key used to access the item configuration.
	 * @param mixed   $item      The item value (ID or GUID) to process.
	 * @param bool    $guidEdit  Whether GUID edit links are supported.
	 * @param bool    $getEdit   Whether standard edit links are supported.
	 *
	 * @return string The processed item name with an optional edit link.
	 * @since  3.0.9
	 */
	private function processItemName(string $header, $item, bool $guidEdit, bool $getEdit): string
	{
		$edit = true;

		// Fetch the item name if not already cached
		if (!isset($this->itemNames[$this->itemKeys[$header]['table']][$item]))
		{
			$this->itemNames[$this->itemKeys[$header]['table']][$item] = GetHelper::var(
				$this->itemKeys[$header]['table'],
				$item,
				$this->itemKeys[$header]['key'],
				$this->itemKeys[$header]['name']
			);

			// Handle the case where the item was not found
			if (empty($this->itemNames[$this->itemKeys[$header]['table']][$item]))
			{
				$this->itemNames[$this->itemKeys[$header]['table']][$item] = Text::sprintf('COM_COMPONENTBUILDER_NO_S_FOUND', $this->itemKeys[$header]['text']);
				$edit = false;
			}

			// Append additional information if configured
			if (
				$edit &&
				isset($this->itemKeys[$header]['get']) &&
				StringHelper::check($this->itemKeys[$header]['get']) &&
				method_exists(__CLASS__, $this->itemKeys[$header]['get'])
			) {
				$this->itemNames[$this->itemKeys[$header]['table']][$item] .= $this->{$this->itemKeys[$header]['get']}($item);
			}
		}

		// Generate the edit link based on the type of item (GUID or ID)
		if (GuidHelper::valid($item))
		{
			$link = ($edit && $guidEdit)
				? ComponentbuilderHelper::getEditButtonGUID($item, $this->itemKeys[$header]['key'], $this->itemKeys[$header]['table'], $this->itemKeys[$header]['tables'], $this->ref)
				: '';
		}
		else
		{
			$link = ($edit && $getEdit)
				? ComponentbuilderHelper::getEditButton($item, $this->itemKeys[$header]['table'], $this->itemKeys[$header]['tables'], $this->ref)
				: '';
		}

		// Return the item name with the edit link
		return $this->itemNames[$this->itemKeys[$header]['table']][$item] . $link;
	}

	/**
	 * Retrieves the HTML table for a specific field type.
	 *
	 * This method fetches field data and generates an HTML table for the given field type. It also checks for
	 * repeatable conversion if applicable, validates the number of rows, and returns appropriate notices 
	 * about best practices if limits are exceeded.
	 *
	 * @param string $type        The type of the field (e.g., 'subform', 'repeatable').
	 * @param mixed  $target      The ID|GUID of the parent entity.
	 * @param string $targetKey   The name of the ID column in the database.
	 * @param string $fieldName   The name of the field being processed.
	 * @param string $typeName    The display name of the field type (used in notices).
	 *
	 * @return string|null  Returns the generated HTML table with optional notices on success, or `false` if no data is found.
	 *
	 * @throws \RuntimeException If a required dependency or method is missing.
	 * @since  3.0.0
	 */
	protected function getFieldTable($type, $target, $targetKey, $fieldName, $typeName): ?string
	{
		// Fetch field data
		$fieldsData = GetHelper::var($type, $target, $targetKey, $fieldName);

		if ($fieldsData === false)
		{
			// Return false if no field data is found
			return null;
		}

		// Generate the subform table
		$table = $this->getSubformTable($type, $fieldsData);

		// Determine the maximum allowed number of rows
		$maxRows = $this->rowNumbers[$type] ?? false;

		// Generate a notice about best practices if the number of rows exceeds the limit
		$notice = '';
		if (isset($this->rowNumber) && $maxRows)
		{
			if ($this->rowNumber > $maxRows)
			{
				$notice = '<div class="alert alert-warning">' . Text::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THAN_S_S_IS_CONSIDERED_BAD_PRACTICE_YOUR_S_PAGE_LOAD_IN_JCB_WILL_SLOW_DOWN_YOU_SHOULD_CONSIDER_DECOUPLING_SOME_OF_THESE_S',
					$this->rowNumber,
					$typeName,
					$maxRows,
					$typeName,
					$typeName,
					$typeName
				) . '</div>';
			}
			else
			{
				$notice = '<div class="alert alert-info">' . Text::sprintf('COM_COMPONENTBUILDER_YOU_HAVE_S_S_ADDING_MORE_THAN_S_S_IS_CONSIDERED_BAD_PRACTICE',
					$this->rowNumber,
					$typeName,
					$maxRows,
					$typeName
				) . '</div>';
			}
		}

		// Return the notice (if any) concatenated with the table HTML
		return $notice . $table;
	}

	// Used in template
	public function getTemplateDetails($id)
	{
		// set table
		$table = false;
		// Get a db connection.
		$db = Factory::getDbo();	
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id', 'a.alias', 'a.template', 'b.name', 'a.dynamic_get')));
		$query->from($db->quoteName('#__componentbuilder_template', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_dynamic_get', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.dynamic_get') . ')');
		$query->where($db->quoteName('a.id') . ' != '. (int) $id);
		$query->where($db->quoteName('a.published') . ' = 1');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{ 
			$results = $db->loadObjectList();
			$templateString = array();
			// get the view name & id
			$values = $this->getViewID();
			// set a return value
			$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
			if (isset($values['a_return']))
			{
				$return_url .= '&return=' . (string) $values['a_return'];
			}
			// start the ref builder
			$ref = '';
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
			{
				// set the return ref
				$ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'] . '&return=' . urlencode(base64_encode($return_url));
			}
			// load the template data
			foreach ($results as $result)
			{
				$edit = (($button = ComponentbuilderHelper::getEditButton($result->id, 'template', 'templates', $ref)) !== false) ? $button : '';
				$editget = (isset($result->dynamic_get) && $result->dynamic_get > 0 && ($button = ComponentbuilderHelper::getEditButton($result->dynamic_get, 'dynamic_get', 'dynamic_gets', $ref)) !== false) ? $button : '';
				$result->name = (StringHelper::check($result->name)) ? $result->name : Text::_('COM_COMPONENTBUILDER_NONE_SELECTED');
				$templateString[] = "<td><b>".$result->name."</b> ".$editget."</td><td><code>&lt;?php echo \$this->loadTemplate('".StringHelper::safe($result->alias)."'); ?&gt;</code> ".$edit."</td>";
			}
			// build the table
			$table = '<h2>' . Text::_('COM_COMPONENTBUILDER_TEMPLATE_CODE_SNIPPETS') . '</h2><div class="uk-scrollable-box"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .= '<caption>' . Text::_('COM_COMPONENTBUILDER_TO_ADD_SIMPLY_COPY_AND_PAST_THE_SNIPPET_INTO_YOUR_CODE') . '</caption>';
			$table .= '<thead><tr><th>' . Text::_('COM_COMPONENTBUILDER_NAME_OF_DYNAMICGET') . '</th><th>' . Text::_('COM_COMPONENTBUILDER_SNIPPET') . '</th></thead>';
			$table .= '<tbody><tr>' . implode("</tr><tr>", $templateString) . "</tr></tbody></table></div>";
		}
		return $table;
	}

	// Used in layout
	public function getLayoutDetails($id)
	{
		// set table
		$table = false;
		// Get a db connection.
		$db = Factory::getDbo();	
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.id','a.alias','a.layout','b.getcustom','b.gettype','b.name','a.dynamic_get')));
		$query->from($db->quoteName('#__componentbuilder_layout', 'a'));
		$query->join('LEFT', $db->quoteName('#__componentbuilder_dynamic_get', 'b') . ' ON (' . $db->quoteName('b.id') . ' = ' . $db->quoteName('a.dynamic_get') . ')');
		$query->where($db->quoteName('a.id') . ' != '.(int) $id);
		$query->where($db->quoteName('a.published') . ' = 1');
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{ 
			$results = $db->loadObjectList();
			$layoutString = array();
			// get the view name & id
			$values = $this->getViewID();
			// set a return value
			$return_url = 'index.php?option=com_componentbuilder&view=' . (string) $values['a_view'] .  '&layout=edit&id=' . (int) $values['a_id'];
			if (isset($values['a_return']))
			{
				$return_url .= '&return=' . (string) $values['a_return'];
			}
			// start the ref builder
			$ref = '';
			if (!is_null($values['a_id']) && $values['a_id'] > 0 && strlen($values['a_view']))
			{
				// set the return ref
				$ref = '&ref=' . $values['a_view'] . '&refid=' . $values['a_id'] . '&return=' . urlencode(base64_encode($return_url));
			}
			foreach ($results as $result)
			{
				$edit = (($button = ComponentbuilderHelper::getEditButton($result->id, 'layout', 'layouts', $ref)) !== false) ? $button : '';
				$editget = (isset($result->dynamic_get) && $result->dynamic_get > 0 && ($button = ComponentbuilderHelper::getEditButton($result->dynamic_get, 'dynamic_get', 'dynamic_gets', $ref)) !== false) ? $button : '';
				$result->name = (StringHelper::check($result->name)) ? $result->name : Text::_('COM_COMPONENTBUILDER_NONE_SELECTED');

				switch ($result->gettype)
				{
					case 1:
						// single
						$layoutString[] = "<td><b>" . $result->name . "</b> " . $editget . "</td><td><code>&lt;?php echo LayoutHelper::render('" . StringHelper::safe($result->alias) . "', \$this->item); ?&gt;</code> " . $edit . "</td>";
					break;
					case 2:
						// list
						$layoutString[] = "<td><b>" . $result->name . "</b> " . $editget . "</td><td><code>&lt;?php echo LayoutHelper::render('" . StringHelper::safe($result->alias) . "', \$this->items); ?&gt;</code> " . $edit . "</td>";
					break;
					case 3:
					case 4:
						// custom
						$result->getcustom = StringHelper::safe($result->getcustom);
						if (substr($result->getcustom, 0, strlen('get')) == 'get')
						{
							$varName = substr($result->getcustom, strlen('get'));
						}
						else
						{
							$varName = $result->getcustom;
						}
						$layoutString[] = "<td><b>" . $result->name . "</b> " . $editget . "</td><td><code>&lt;?php echo LayoutHelper::render('" . StringHelper::safe($result->alias) . "', \$this->" . $varName . "); ?&gt;</code> " . $edit . "</td>";
					break;
					default:
						// no get
						$layoutString[] = "<td>" . Text::_('COM_COMPONENTBUILDER_NONE_SELECTED') . "</td><td><code>&lt;?php echo LayoutHelper::render('" . StringHelper::safe($result->alias) . "', [?]); ?&gt;</code> " . $edit . "</td>";
					break;
				}
			}
			// build the table
			$table = '<h2>' . Text::_('COM_COMPONENTBUILDER_LAYOUT_CODE_SNIPPETS') . '</h2><div class="uk-scrollable-box"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .= '<caption>' . Text::_('COM_COMPONENTBUILDER_TO_ADD_SIMPLY_COPY_AND_PAST_THE_SNIPPET_INTO_YOUR_CODE') . '</caption>';
			$table .= '<thead><tr><th>' . Text::_('COM_COMPONENTBUILDER_NAME_OF_DYNAMICGET') . '</th><th>' . Text::_('COM_COMPONENTBUILDER_SNIPPET') . '</th></thead>';
			$table .= '<tbody><tr>' . implode("</tr><tr>",$layoutString) . "</tr></tbody></table></div>";
		}
		return $table;
	}

	// Used in dynamic_get
	/**
	 * Retrieve view table columns.
	 *
	 * @param string   $adminView  The admin view identifier.
	 * @param string   $as         The alias to use.
	 * @param int      $type       The type indicator.
	 *
	 * @return mixed The view table columns.
	 * @since  3.0.0
	 */
	public function getViewTableColumns($adminView, $as, $type)
	{
		return ComponentbuilderHelper::getViewTableColumns($adminView, $as, $type);
	}

	/**
	 * Retrieve database table columns.
	 *
	 * @param string  $tableName The name of the database table.
	 * @param string  $as        The alias to use.
	 * @param int     $type      The type indicator.
	 *
	 * @return mixed The database table columns.
	 * @since  3.0.0
	 */
	public function getDbTableColumns($tableName, $as, $type)
	{
		return ComponentbuilderHelper::getDbTableColumns($tableName, $as, $type);
	}

	/**
	 * Retrieve dynamic values based on a key and view.
	 *
	 * The method builds a database query to retrieve dynamic settings, processes main and joined
	 * selections, and returns an HTML code snippet that shows PHP code for outputting these fields.
	 *
	 * @param mixed  $key  The key used to fetch dynamic values (can be a guid or numeric id).
	 * @param string $view The view context (e.g., 'template', 'site_view', 'custom_admin_view', 'layout').
	 *
	 * @return string|null HTML code snippet with dynamic value output or false if key is invalid or no rows found.
	 * @since  3.0.0
	 */
	public function getDynamicValues($key, $view)
	{
		// Determine the target field based on the key.
		if (GuidHelper::valid($key))
		{
			$target = 'guid';
		}
		elseif (is_numeric($key))
		{
			$target = 'id';
		}
		else
		{
			return null;
		}

		// Get a database connection.
		$db = Factory::getDbo();

		// Build the query.
		$query = $db->getQuery(true);
		$fields = [
			'getcustom', 'gettype', 'select_all', 'db_table_main',
			'view_table_main', 'main_source', 'view_selection',
			'db_selection', 'join_view_table', 'join_db_table',
			'addcalculation', 'php_calculation'
		];

		$query->select($db->quoteName($fields))
			  ->from($db->quoteName('#__componentbuilder_dynamic_get'))
			  ->where($db->quoteName('published') . ' = 1')
			  ->where($db->quoteName($target) . ' = ' . $db->quote($key));
		$db->setQuery($query);
		$db->execute();

		if (!$db->getNumRows())
		{
			return null;
		}

		$result = $db->loadObject();

		// Initialize selection arrays.
		$selections = [];
		$selectionsList = [];

		// Process main source selections.
		if ($result->main_source == 1)
		{
			if ($result->select_all == 1)
			{
				$result->view_selection = ComponentbuilderHelper::getViewTableColumns($result->view_table_main, 'a', $result->gettype);
			}
			$selections[] = explode("\n", $result->view_selection);
		}
		elseif ($result->main_source == 2)
		{
			if ($result->select_all == 1)
			{
				$result->db_selection = ComponentbuilderHelper::getDbTableColumns($result->db_table_main, 'a', $result->gettype);
			}
			$selections[] = explode("\n", $result->db_selection);
		}
		elseif ($result->main_source == 3)
		{
			return '<br /><br /><h2>Custom get source! You will need to transpose the variables manually.</h2>';
		}

		// Process joined view table selections.
		$joinViewTable = json_decode($result->join_view_table, true);
		if (UtilitiesArrayHelper::check($joinViewTable))
		{
			list($joinSelections, $joinSelectionsList) = $this->processJoinTables($joinViewTable, true);
			$selections = array_merge($selections, $joinSelections);
			$selectionsList = array_merge($selectionsList, $joinSelectionsList);
		}

		// Process joined database table selections.
		$joinDbTable = json_decode($result->join_db_table, true);
		if (UtilitiesArrayHelper::check($joinDbTable))
		{
			list($joinSelections, $joinSelectionsList) = $this->processJoinTables($joinDbTable, false);
			$selections = array_merge($selections, $joinSelections);
			$selectionsList = array_merge($selectionsList, $joinSelectionsList);
		}

		// Process calculation selections.
		if ($result->addcalculation == 1)
		{
			$phpCalculation = base64_decode($result->php_calculation);
			$phpSelections  = GetHelper::allBetween($phpCalculation, 'cal__', ' ');
			$selections[]   = array_unique($phpSelections);
			unset($phpCalculation, $phpSelections, $result->php_calculation);
		}

		// Determine the bucket variable name based on view and get type.
		$buketName = $this->determineBucketName($result, $view);
		if (empty($buketName))
		{
			return null;
		}

		// Build and return the final HTML code snippet.
		return $this->buildCodeOutput($result->gettype, $buketName, $selections, $selectionsList);
	}

	/**
	 * Process join tables for dynamic selections.
	 *
	 * This method iterates over an array of join table configurations, replacing '*' selections
	 * with full column lists and sorting the results into main selections and selection lists.
	 *
	 * @param array $joinTables An array of join table configurations.
	 * @param bool  $isView True if processing view tables; false if processing DB tables.
	 *
	 * @return array Returns an array with two elements: [selections, selectionsList].
	 * @since  5.0.4
	 */
	protected function processJoinTables(array $joinTables, bool $isView): array
	{
		$selections = [];
		$selectionsList = [];

		foreach ($joinTables as $join)
		{
			// Replace '*' with full selection if applicable.
			if (strpos($join['selection'], '*') !== false)
			{
				$join['selection'] = ComponentbuilderHelper::getViewTableColumns($join['view_table'], $join['as'], $join['row_type']);
			}

			// Process based on the row type.
			if ($join['row_type'] == '1')
			{
				$selections[] = explode("\n", $join['selection']);
			}
			elseif ($join['row_type'] == '2')
			{
				$names = $this->setListMethodName(
					[$join['on_field'], $join['join_field']],
					$isView ? $join['view_table'] : $join['db_table'],
					$join['as'],
					$isView ? 1 : 2
				);
				$selectionsList[implode('', $names)] = explode("\n", $join['selection']);
			}
		}

		return [$selections, $selectionsList];
	}

	/**
	 * Determine the bucket variable name based on the result type and view.
	 *
	 * This method selects the proper variable (e.g. "$this->item" or "$this->items")
	 * or a custom bucket name based on the provided result and view context.
	 *
	 * @param object $result The result object from the database query.
	 * @param string $view   The view context.
	 *
	 * @return string|null The bucket variable name (or an empty string if none can be determined).
	 * @since  5.0.4
	 */
	protected function determineBucketName($result, string $view): ?string
	{
		if (in_array($view, ['template', 'site_view', 'custom_admin_view'], true))
		{
			switch ($result->gettype) {
				case 1:
					return 'this->item';
				case 2:
					return 'this->items';
				case 3:
				case 4:
					$custom  = StringHelper::safe($result->getcustom);
					$varName = (strpos($custom, 'get') === 0) ? substr($custom, 3) : $custom;
					return 'this->' . $varName;
				default:
					return null;
			}
		}
		elseif ($view === 'layout')
		{
			return 'displayData';
		}

		return null;
	}

	/**
	 * Build the HTML code output for dynamic selections.
	 *
	 * This method generates HTML code snippets (using <code> blocks) that output the
	 * dynamic selection values based on the get type. For list types, it wraps the output
	 * in a foreach loop.
	 *
	 * @param int $getType The type of get operation.
	 * @param string $buketName The bucket variable name.
	 * @param array  $selections An array of selections.
	 * @param array  $selectionsList An array of selection lists.
	 *
	 * @return string The HTML code snippet.
	 * @since  5.0.4
	 */
	protected function buildCodeOutput(int $getType, string $buketName, array $selections, array $selectionsList): string
	{
		$outputLines = [];

		// Set the starting code based on the get type.
		switch ($getType)
		{
			case 1:
			case 3:
				$prefix = '&lt;?php echo $' . $buketName;
				$suffix = '; ?&gt;';
				break;
			case 2:
			case 4:
				$prefix = '&lt;?php echo $item';
				$suffix = '; ?&gt;';
				$outputLines[] = '<code>&lt;?php foreach ($' . $buketName . ' as $item): ?&gt;</code><br />';
				break;
			default:
				$prefix = '';
				$suffix = '';
		}

		// Build code lines for the main selections.
		foreach ($selections as $selection)
		{
			if (UtilitiesArrayHelper::check($selection))
			{
				foreach ($selection as $value)
				{
					$value = trim($value);
					if (strpos($value, 'AS') !== false)
					{
						list(, $key) = explode('AS', $value);
						$outputLines[] = '<code>' . $prefix . '->' . trim($key) . $suffix . '</code>';
					}
					else
					{
						$outputLines[] = '<code>' . $prefix . '->' . $value . $suffix . '</code>';
					}
				}
			}
		}

		// Build code lines for selection lists.
		if (UtilitiesArrayHelper::check($selectionsList))
		{
			$outputLines[] = '<hr />';
			foreach ($selectionsList as $name => $selectionList)
			{
				if (UtilitiesArrayHelper::check($selectionList))
				{
					$listPrefix = '&lt;?php echo $' . $name;
					$listSuffix = '; ?&gt;';
					$outputLines[] = '<code>&lt;?php foreach ($item->' . $name . ' as $' . $name . '): ?&gt;</code><br />';
					foreach ($selectionList as $value)
					{
						$value = trim($value);
						if (strpos($value, 'AS') !== false)
						{
							list(, $key) = explode('AS', $value);
							$outputLines[] = '<code>' . $listPrefix . '->' . trim($key) . $listSuffix . '</code>';
						}
						else
						{
							$outputLines[] = '<code>' . $listPrefix . '->' . $value . $listSuffix . '</code>';
						}
					}
					$outputLines[] = '<br /><code>&lt;?php endforeach; ?&gt;</code><hr />';
				}
			}
		}

		// For list types, add the closing foreach.
		if (in_array($getType, [2, 4], true))
		{
			$outputLines[] = '<br /><code>&lt;?php endforeach; ?&gt;</code>';
		}

		return implode('&nbsp;', $outputLines);
	}

	/**
	 * Generate a list method name based on provided names and table.
	 *
	 * This method creates an array of sanitized method/variable names based on input field names,
	 * the table name, and an alias.
	 *
	 * @param array  $names An array of field names.
	 * @param string $table The table name.
	 * @param string $as The alias.
	 * @param int $type  The type flag (1 for view, 2 for database).
	 *
	 * @return array An array of method names.
	 * @since  3.0.0
	 */
	protected function setListMethodName($names, $table, $as, $type)
	{
		$methodNames = [];
		if (UtilitiesArrayHelper::check($names))
		{
			foreach ($names as $nr => $name)
			{
				if (StringHelper::check($name))
				{
					if (strpos($name, '.') !== false)
					{
						list(, $var) = explode('.', $name);
					}
					else
					{
						$var = $name;
					}

					if ($nr > 0)
					{
						$methodNames[] = StringHelper::safe($var, 'F');
					}
					else
					{
						$methodNames[] = StringHelper::safe($var);
					}
				}
			}
		}

		switch ($type)
		{
			// For view tables.
			case 1:
				$methodNames[] = StringHelper::safe($this->getViewName($table), 'F');
				break;
			// For database tables.
			case 2:
				$methodNames[] = StringHelper::safe($table, 'F');
				break;
		}

		$methodNames[] = StringHelper::safe($as, 'U');
		return $methodNames;
	}

	/**
	 * Retrieve the view name based on a key.
	 *
	 * @param mixed $key The key used to determine the view name.
	 *
	 * @return string The view name or an empty string if not found.
	 * @since  3.0.0
	 */
	protected function getViewName($key): string
	{
		if (GuidHelper::valid($key))
		{
			$target = 'guid';
		}
		elseif (is_numeric($key))
		{
			$target = 'id';
		}
		else
		{
			return '';
		}

		// Retrieve the view name.
		if ($name = GetHelper::var('admin_view', $key, $target, 'name_single'))
		{
			return $name;
		}

		return '';
	}

	// Used in custom_code
	/**
	 * Retrieves edit custom code buttons.
	 *
	 * This method orchestrates the process of validating the view,
	 * building a return URL, fetching custom code data from the database,
	 * and processing that data to generate a set of edit buttons.
	 *
	 * @param int $id The identifier for the custom code.
	 *
	 * @return  array|false Returns an array of buttons if successful, or false otherwise.
	 * @since   5.1.0
	 */
	public function getEditCustomCodeButtons(int $id)
	{
		// Validate that the current view request is legitimate.
		$validationResult = $this->validateViewRequest($id);
		if ($validationResult === null)
		{
			return false;
		}
		list($view, $target) = $validationResult;

		// Build the return URL parameter.
		$returnUrl = $this->buildReturnUrl($view, $id);

		// Fetch custom code data from the database.
		$data = $this->fetchCustomCodeData($id, $target);
		if (empty($data))
		{
			return false;
		}

		// Process the data to generate buttons.
		$buttons = $this->processCustomCodeData($data, $target, $returnUrl);

		// Return the buttons if any valid ones are found.
		if (UtilitiesArrayHelper::check($buttons))
		{
			return $buttons;
		}

		return false;
	}

	/**
	 * Checks the validity of a function name.
	 *
	 * This function splits the provided function name at uppercase letters,
	 * sanitizes it, and then verifies if the name is already in use. If the name
	 * exists and belongs to a different record (ID), it returns an error message.
	 * Otherwise, it returns a success message along with the sanitized name.
	 *
	 * @param string $name The function name to validate.
	 * @param int $id   The identifier associated with the function.
	 *
	 * @return array An associative array containing:
	 *               - 'name': The sanitized function name (only on success).
	 *               - 'message': A message indicating success or error.
	 *               - 'status': A status indicator ('success' or 'danger').
	 * @since   5.1.0
	 */
	public function checkFunctionName(string $name, int $id): array
	{
		// Split the name into parts at each uppercase letter.
		$nameArray = $this->splitAtUpperCase($name);
		
		// Reassemble the name with spaces and sanitize it.
		$sanitizedName = StringHelper::safe(implode(' ', $nameArray), 'cA');

		// Check if the function name is already used in the custom code context.
		$found = GetHelper::var('custom_code', $sanitizedName, 'function_name', 'id');
		if ($found && ((int)$id !== (int)$found))
		{
			return [
				'message' => Text::_('COM_COMPONENTBUILDER_SORRY_THIS_FUNCTION_NAME_IS_ALREADY_IN_USE'),
				'status'  => 'danger'
			];
		}

		return [
			'name' => $sanitizedName,
			'message' => Text::_('COM_COMPONENTBUILDER_GREAT_THIS_FUNCTION_NAME_WILL_WORK'),
			'status' => 'success'
		];
	}

	/**
	 * Validates the view request.
	 *
	 * This method checks that the current view has a valid ID and that the code
	 * search keys are available.
	 *
	 * @param int $id The identifier to validate.
	 *
	 * @return  array|null Returns an array with view and target data if valid, or null otherwise.
	 * @since   5.1.0
	 */
	protected function validateViewRequest(int $id): ?array
	{
		$view = $this->getViewID();
		if (isset($view['a_id'], $view['a_view']) && (int)$view['a_id'] === $id)
		{
			$target = $this->getCodeSearchKeys($view['a_view'], 'customcode', 'query_');
			if ($target !== null)
			{
				return [$view, $target];
			}
		}
		return null;
	}

	/**
	 * Builds the return URL parameter.
	 *
	 * This method reads the input for a "return_here" parameter and constructs a URL
	 * fragment accordingly. If no valid return value is found, it builds a reference URL.
	 *
	 * @param array $view The view array.
	 * @param int   $id   The identifier.
	 *
	 * @return string The constructed return URL parameter.
	 * @since  5.1.0
	 */
	protected function buildReturnUrl(array $view, int $id): string
	{
		$jinput = Factory::getApplication()->getInput();
		$returnHere = $jinput->get('return_here', null, 'base64');
		if (StringHelper::check($returnHere))
		{
			return '&return=' . $returnHere;
		}
		return '&ref=' . $view['a_view'] . '&refid=' . $id;
	}

	/**
	 * Fetches custom code data from the database.
	 *
	 * This method constructs and executes a database query based on the target
	 * configuration and retrieves the associated data.
	 *
	 * @param int   $id The identifier for the data.
	 * @param array $target The target configuration array.
	 *
	 * @return array|null Returns the fetched data as an associative array, or null if not found.
	 * @since  5.1.0
	 */
	protected function fetchCustomCodeData(int $id, array $target): ?array
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName($target['select']))
			->from($db->quoteName('#__componentbuilder_' . $target['table'], 'a'))
			->where('a.id = ' . $id);
		$db->setQuery($query);
		$db->execute();

		if ($db->loadRowList())
		{
			return $db->loadAssoc();
		}
		return null;
	}

	/**
	 * Processes the custom code data to generate buttons.
	 *
	 * This method decodes values if needed, searches for custom code placeholders,
	 * and builds both creation and edit buttons based on the data.
	 *
	 * @param array  $data The associative array of custom code data.
	 * @param array  $target The target configuration array.
	 * @param string $returnUrl The return URL parameter.
	 *
	 * @return array Returns an array of buttons.
	 * @since  5.1.0
	 */
	protected function processCustomCodeData(array $data, array $target, string $returnUrl): array
	{
		$buttons = [];
		$bucket  = [];
		$helper  = ['xml' => 'note_filter_information'];

		foreach ($data as $key => $value)
		{
			// Skip the 'id' and primary target name fields and empty field values.
			if ($key === 'id' || $key === $target['name'] || empty($value))
			{
				continue;
			}

			// Decode the value if a decoder is specified.
			$decoder = $target['decode'][$key] ?? null;
			if (!empty($decoder))
			{
				if ($decoder === 'base64')
				{
					$value = Base64Helper::open($value, null);
				}
				elseif ($decoder === 'json')
				{
					$value = json_decode($value);
				}
			}

			// Special processing for XML fields.
			if ($target['table'] === 'field' && $key === 'xml')
			{
				$this->searchFieldBase64($value);
			}

			// skip empty fields values
			if (empty($value))
			{
				continue;
			}

			// Check for custom code placeholders.
			if (strpos($value, '[CUSTOMC' . 'ODE=') !== false)
			{
				$bucket[$key] = GetHelper::allBetween($value, '[CUSTOMC' . 'ODE=', ']');
			}

			// Build a "create" button if the field contains valid content.
			if (StringHelper::check($value))
			{
				$fieldKey = $helper[$key] ?? $key;
				$buttons[$fieldKey] = [];
				$button = $this->getButton('custom_code', 3);
				if ($button && StringHelper::check($button))
				{
					$buttons[$fieldKey]['_create'] = $button;
				}
			}
		}

		// Process the bucket to add "edit" buttons.
		if (UtilitiesArrayHelper::check($bucket))
		{
			foreach ($bucket as $field => $customCodes)
			{
				$fieldKey = $helper[$field] ?? $field;
				$editIcon = '<span class="icon-edit" aria-hidden="true"></span> ';
				foreach ($customCodes as $customCode)
				{
					$parts = explode('+', $customCode);
					$functionName = $parts[0];
					if (!isset($buttons[$fieldKey][$functionName]))
					{
						$_id = GetHelper::var('custom_code', $functionName, 'function_name');
						if ($_id !== false)
						{
							$button = ComponentbuilderHelper::getEditTextButton(
								$editIcon . $functionName,
								$_id,
								'custom_code',
								'custom_codes',
								$returnUrl,
								'com_componentbuilder',
								false,
								'btn btn-small button-edit" style="margin: 0 0 5px 0;'
							);

							if ($button && StringHelper::check($button))
							{
								$buttons[$fieldKey][$functionName] = $button;
							}
						}
					}
				}
			}
		}

		return $buttons;
	}

	/**
	 * Splits a string at each uppercase letter.
	 *
	 * This function uses a regular expression to split the input string at every
	 * occurrence of an uppercase letter. The resulting array contains the parts
	 * of the original string.
	 *
	 * @param string $string The string to be split.
	 *
	 * @return array An array of substrings resulting from the split.
	 * @since  5.1.0
	 */
	protected function splitAtUpperCase(string $string): array
	{
		return preg_split('/(?=[A-Z])/', $string, -1, PREG_SPLIT_NO_EMPTY);
	}

	/**
	 * Processes custom code placeholders and returns corresponding edit buttons.
	 *
	 * This method builds a database query based on the target configuration,
	 * retrieves the dataset, and then examines each field for custom code
	 * placeholders. Depending on the search mode, it builds a bucket of matches
	 * and finally returns an HTML list of edit buttons.
	 *
	 * @param string  $customcode The search value.
	 * @param int     $id The record ID.
	 * @param string|int  $targeting The targeting parameter for code search keys.
	 *
	 * @return array|null Returns an array with keys 'in' (HTML) and 'id' if buttons are found; false otherwise.
	 * @since  5.1.0
	 */
	public function usedin(string $customcode, int $id, string|int $targeting): ?array
	{
		// Get the target configuration using the provided targeting value.
		$target = $this->getCodeSearchKeys($targeting, 'customcode', 'query');
		if (!$target)
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_INVALID_TABLE_TARGET')];
		}

		// Build the database query based on the target configuration.
		$query = $this->buildQueryForTarget($target);
		if ($query === null)
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NAME_FIELD_MISSING_LINK_VALUES')];
		}

		$db = Factory::getDbo();
		$db->setQuery($query);
		$db->execute();

		// If no records were found, return null.
		if (!$db->loadRowList())
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NO_ROWS_FOUND_FOR_THIS_TARGET_AREA')];
		}

		$dataSet = $db->loadAssocList();

		// Process the dataset to extract a bucket of records with placeholders.
		$bucket = $this->extractPlaceholders($dataSet, $target, $customcode, $id, 'customcode');
		if (!UtilitiesArrayHelper::check($bucket))
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NO_SEARCH_VALUES_FOUND_IN_ROWS_FOR_THIS_TARGET_AREA')];
		}

		// Build the return URL for later use.
		$returnUrl = $this->buildReturnUrlForcustom_code($id);

		// Create edit buttons from the bucket.
		$buttons = $this->buildButtonsFromBucket($bucket, $target, $returnUrl);
		if (empty($buttons))
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_WE_FAILED_TO_BUILD_THE_DETAILS_OF_THE_SEARCH_RESULTS')];
		}

		// Wrap the buttons in an HTML unordered list.
		$html = '<ul><li>' . implode('</li><li>', $buttons) . '</li></ul>';
		$view_name = $target['area_name'] ?? 'Empty';

		return ['in' => $html, 'id' => $targeting, 'area_name' => Text::_($view_name)];
	}

	/**
	 * Builds the return URL parameter for custom_code.
	 *
	 * Retrieves a base64-encoded return parameter from the input; if not found,
	 * uses a default reference URL.
	 *
	 * @param int $id The record ID.
	 *
	 * @return string Returns the constructed return URL.
	 * @since  5.1.0
	 */
	protected function buildReturnUrlForcustom_code(int $id): string
	{
		$input = Factory::getApplication()->getInput();
		$returnHere = $input->get('return_here', null, 'base64');
		if (StringHelper::check($returnHere))
		{
			return '&return=' . $returnHere;
		}
		return '&ref=custom_code&refid=' . $id;
	}

	/**
	 * Search for base64 strings and decode them
	 *
	 * @param   string  $value The string to search
	 *
	 * @return  void
	 * @since   5.1.0
	 */
	protected function searchFieldBase64(string &$value): void
	{
		// first get the start property (if dynamic)
		$starts =  [];
		// get all values
		$allBetween = GetHelper::allBetween($value, 'type_php', '="');
		// just again make sure we found some
		if (UtilitiesArrayHelper::check($allBetween))
		{
			if (count((array) $allBetween) > 1)
			{
				// search for many
				foreach ($allBetween as $between)
				{
					// load the starting property
					$start = 'type_php';
					$start .= $between;
					$start .= '="';

					$starts[] = $start;
				}
			}
			else
			{
				// load the starting property
				$start = 'type_php';
				$start .= array_values($allBetween)[0];
				$start .= '="';

				$starts[] = $start;
			}
		}
		// has any been found
		if (UtilitiesArrayHelper::check($starts))
		{
			foreach ($starts as $_start)
			{
				// get the base64 string
				$base64 = GetHelper::between($value, $_start, '"');
				// now open the base64 text
				$tmp = Base64Helper::open($base64);
				// insert it back into the value (so we still search the whole string)
				$value = str_replace($base64, $tmp, $value);
			}
		}
	}

	/**
	 * The code search keys/targets
	 *
	 * @var      array
	 * @since  3.0.9
	 */
	protected array $codeSearchKeys = ['customcode' => [], 'placeholders' => [], 'powers' => []];

	/**
	 * Get the keys of the values to search custom code in.
	 *
	 * This method supports an optional type parameter. When the type is 'query',
	 * the method assumes that the $target parameter is a single letter corresponding
	 * to the position of the table in the internal list, and it maps that letter to
	 * the actual table name. For types 'query' or 'query_', the configuration is
	 * adjusted for query usage by prefixing the search keys with "a.", adding a 'table'
	 * entry, and removing the original 'search' key.
	 *
	 * @param string|int     $target  The table targeted. When type is 'query', this can be an int.
	 * @param string          $area    The area we are searching
	 * @param string|null  $type    The type of get ('query', 'query_' or null).
	 * 
	 * @return array|null The configuration for the targeted table or null if not found.
	 * @since  3.0.9
	 */
	protected function getCodeSearchKeys(string|int $target, string $area = 'customcode', ?string $type = null): ?array
	{
		// Lazy-load the code search keys if they haven't been loaded yet.
		if (empty($this->codeSearchKeys[$area]))
		{
			$this->codeSearchKeys[$area] = (new Search())->getTextSearchSet($area);
		}

		// Return null if the configuration is still empty.
		if (empty($this->codeSearchKeys[$area]))
		{
			return null;
		}

		// If type is 'query', assume $target is a letter that maps to a table name.
		if (is_numeric($target))
		{
			$tableKeys = array_keys($this->codeSearchKeys[$area]);
			if (isset($tableKeys[$target]))
			{
				$target = $tableKeys[$target];
			}
		}

		// If the target does not exist in the configuration, return null immediately.
		if (!isset($this->codeSearchKeys[$area][$target]))
		{
			return null;
		}

		// Retrieve the configuration for the target.
		$config = $this->codeSearchKeys[$area][$target];

		// If type is 'query' or 'query_', adjust the configuration for query usage.
		if (in_array($type, ['query', 'query_'], true))
		{
			// Prefix each search key with 'a.' for the select clause.
			$config['select'] = array_map(fn(string $select): string => 'a.' . $select, $config['search']);
			$config['table'] = $target;
			unset($config['search']);
		}

		return $config;
	}

	/**
	 * Builds the database query for the given target configuration.
	 *
	 * If the target configuration defines a join (via "name_link"), it adds the
	 * necessary SELECT and JOIN clauses.
	 *
	 * @param array $target The target configuration array.
	 *
	 * @return object|null Returns the constructed database query object or false on error.
	 * @since  5.1.0
	 */
	protected function buildQueryForTarget(array &$target): ?object
	{
		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName($target['select']))
			->from($db->quoteName('#__componentbuilder_' . $target['table'], 'a'));

		if (!empty($target['name_link']))
		{
			$targetJoin  = $target['name_link']['table'] ?? null;
			$targetValue = $target['name_link']['value'] ?? null;
			$targetKey   = $target['name_link']['key'] ?? null;
			$parentKey   = $target['name'] ?? null;

			// Validate required join parameters.
			if (empty($targetJoin) || empty($targetValue) || empty($targetKey) || empty($parentKey))
			{
				return null;
			}

			// Select the proper name from the joined table.
			$query->select($db->quoteName(['c.' . $targetValue], [$targetValue]));
			// Add the LEFT JOIN clause.
			$query->join('LEFT', $db->quoteName('#__componentbuilder_' . $targetJoin, 'c') 
				. ' ON (' . $db->quoteName('a.' . $parentKey) . ' = ' . $db->quoteName('c.' . $targetKey) . ')');

			// Update the target "name" field.
			$target['name'] = $targetValue;
		}

		return $query;
	}

	/**
	 * Decodes a field value based on the target configuration.
	 *
	 * Supports 'base64' and 'json' decoders. Also processes XML fields if the table is 'field'.
	 *
	 * @param mixed  $value  The original field value.
	 * @param string $field  The field key.
	 * @param array  $target The target configuration array.
	 *
	 * @return mixed Returns the decoded field value.
	 * @since  5.1.0
	 */
	protected function decodeFieldValue($value, string $field, array $target)
	{
		$decoder = $target['decode'][$field] ?? null;
		if (!empty($decoder))
		{
			if ($decoder === 'base64')
			{
				$value = Base64Helper::open($value, null);
			}
			elseif ($decoder === 'json')
			{
				$value = json_decode($value);
			}
		}

		// Special handling for XML fields in the 'field' table.
		if ($target['table'] === 'field' && $field === 'xml')
		{
			$this->searchFieldBase64($value);
		}

		return $value;
	}

	/**
	 * Extracts a bucket of records that contain the desired custom code placeholders.
	 *
	 * For each record in the dataset, each field (except 'id' and the main name)
	 * is examined after decoding. Depending on the search mode, the method checks
	 * for the presence of a placeholder. When found, the field is added to a bucket.
	 *
	 * @param array  $dataSet       The dataset retrieved from the database.
	 * @param array  $target        The target configuration array.
	 * @param mixed  $searchValue   The search value to use when looking for placeholders.
	 * @param int    $id            The record ID.
	 * @param string $area          The search area ('customcode' or 'placeholders' or 'powers').
	 *
	 * @return array Returns a bucket array keyed by record ID with 'name' and 'fields' keys.
	 * @since  5.1.0
	 */
	protected function extractPlaceholders(array $dataSet, array $target, $searchValue, int $id, string $area): array
	{
		$bucket = [];

		foreach ($dataSet as $data)
		{
			foreach ($data as $field => $fieldValue)
			{
				// Skip the 'id' and primary name field and empty field values
				if ($field === 'id' || $field === $target['name'] || empty($fieldValue))
				{
					continue;
				}

				// Decode the field value if needed.
				$decodedValue = $this->decodeFieldValue($fieldValue, $field, $target);
				// Skip the empty decoded field values
				if (empty($decodedValue))
				{
					continue;
				}

				// Determine if the placeholder is present.
				if ($area === 'customcode')
				{
					if (
						strpos($decodedValue, '[CUSTOMCODE=' . (string) $searchValue . ']') !== false ||
						strpos($decodedValue, '[CUSTOMCODE=' . (int) $id . ']') !== false ||
						strpos($decodedValue, '[CUSTOMCODE=' . (string) $searchValue . '+') !== false ||
						strpos($decodedValue, '[CUSTOMCODE=' . (int) $id . '+') !== false
					) {
						$bucket = $this->addFieldToBucket($bucket, $data, $target, $field);
					}
				}
				elseif ($area === 'placeholders')
				{
					// Clean and wrap the search value.
					$cleanValue   = preg_replace("/[^A-Za-z0-9_]/", '', $searchValue);
					$wrappedValue = '[[[' . trim($cleanValue) . ']]]';
					if (strpos($decodedValue, (string)$wrappedValue) !== false)
					{
						$bucket = $this->addFieldToBucket($bucket, $data, $target, $field);
					}
				}
				elseif ($area === 'powers')
				{
					// soon we will add these :)
				}
			}
		}

		return $bucket;
	}

	/**
	 * Adds a field to the bucket for a given record.
	 *
	 * Initializes the bucket entry for the record if not already set, then appends the field.
	 *
	 * @param array  $bucket The current bucket array.
	 * @param array  $data   The record data.
	 * @param array  $target The target configuration array.
	 * @param string $field  The field key that contains the placeholder.
	 *
	 * @return array Returns the updated bucket array.
	 * @since  5.1.0
	 */
	protected function addFieldToBucket(array $bucket, array $data, array $target, string $field): array
	{
		$recordId = $data['id'];
		if (!isset($bucket[$recordId]))
		{
			$bucket[$recordId] = [
				'name'   => $data[$target['name']],
				'fields' => []
			];
		}
		$bucket[$recordId]['fields'][] = $field;
		return $bucket;
	}

	/**
	 * Builds edit buttons from the bucket of matched records.
	 *
	 * For each record in the bucket, an edit button is generated using an external helper.
	 * The button is appended with a list of field names where the placeholder was found.
	 *
	 * @param array  $bucket     The bucket array containing matched records.
	 * @param array  $target     The target configuration array.
	 * @param string $returnUrl  The return URL parameter.
	 *
	 * @return array Returns an array of HTML strings representing the edit buttons.
	 * @since  5.1.0
	 */
	protected function buildButtonsFromBucket(array $bucket, array $target, string $returnUrl): array
	{
		$buttons = [];
		foreach ($bucket as $editId => $values)
		{
			$button = ComponentbuilderHelper::getEditTextButton(
				$values['name'],
				$editId,
				$target['table'],
				$target['views'],
				$returnUrl,
				'com_componentbuilder',
				false,
				''
			);

			if ($button && StringHelper::check($button))
			{
				$buttons[] = $button . ' (' . implode(', ', $values['fields']) . ')';
			}
		}
		return $buttons;
	}

	// Used in placeholder
	public function checkPlaceholderName($id, $name)
	{
		return ComponentbuilderHelper::validateUniquePlaceholder($id, $name);
	}

	/**
	 * Processes custom code placeholders and returns corresponding edit buttons.
	 *
	 * This method builds a database query based on the target configuration,
	 * retrieves the dataset, and then examines each field for custom code
	 * placeholders. Depending on the search mode, it builds a bucket of matches
	 * and finally returns an HTML list of edit buttons.
	 *
	 * @param string  $placeholders The search value.
	 * @param int     $id The record ID.
	 * @param string|int  $targeting The targeting parameter for code search keys.
	 *
	 * @return array|null Returns an array with keys 'in' (HTML) and 'id' if buttons are found; false otherwise.
	 * @since  5.1.0
	 */
	public function placedin(string $placeholders, int $id, string|int $targeting): ?array
	{
		// Get the target configuration using the provided targeting value.
		$target = $this->getCodeSearchKeys($targeting, 'placeholders', 'query');
		if (!$target)
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_INVALID_TABLE_TARGET')];
		}

		// Build the database query based on the target configuration.
		$query = $this->buildQueryForTarget($target);
		if ($query === null)
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NAME_FIELD_MISSING_LINK_VALUES')];
		}

		$db = Factory::getDbo();
		$db->setQuery($query);
		$db->execute();

		// If no records were found, return null.
		if (!$db->loadRowList())
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NO_ROWS_FOUND_FOR_THIS_TARGET_AREA')];
		}

		$dataSet = $db->loadAssocList();

		// Process the dataset to extract a bucket of records with placeholders.
		$bucket = $this->extractPlaceholders($dataSet, $target, $placeholders, $id, 'placeholders');
		if (!UtilitiesArrayHelper::check($bucket))
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_NO_SEARCH_VALUES_FOUND_IN_ROWS_FOR_THIS_TARGET_AREA')];
		}

		// Build the return URL for later use.
		$returnUrl = $this->buildReturnUrlForplaceholder($id);

		// Create edit buttons from the bucket.
		$buttons = $this->buildButtonsFromBucket($bucket, $target, $returnUrl);
		if (empty($buttons))
		{
			return ['error' => Text::_('COM_COMPONENTBUILDER_WE_FAILED_TO_BUILD_THE_DETAILS_OF_THE_SEARCH_RESULTS')];
		}

		// Wrap the buttons in an HTML unordered list.
		$html = '<ul><li>' . implode('</li><li>', $buttons) . '</li></ul>';
		$view_name = $target['area_name'] ?? 'Empty';

		return ['in' => $html, 'id' => $targeting, 'area_name' => Text::_($view_name)];
	}

	/**
	 * Builds the return URL parameter for placeholder.
	 *
	 * Retrieves a base64-encoded return parameter from the input; if not found,
	 * uses a default reference URL.
	 *
	 * @param int $id The record ID.
	 *
	 * @return string Returns the constructed return URL.
	 * @since  5.1.0
	 */
	protected function buildReturnUrlForplaceholder(int $id): string
	{
		$input = Factory::getApplication()->getInput();
		$returnHere = $input->get('return_here', null, 'base64');
		if (StringHelper::check($returnHere))
		{
			return '&return=' . $returnHere;
		}
		return '&ref=placeholder&refid=' . $id;
	}

	// Used in snippet

	/**
	 * Retrieves published snippet GUIDs for valid libraries.
	 *
	 * @param   mixed  $libraries  JSON string or array of library GUIDs.
	 *
	 * @return  array|false  List of snippet IDs or false on failure.
	 * @since   5.1.1
	 */
	public function getSnippets($libraries)
	{
		// Decode JSON if required
		if (JsonHelper::check($libraries))
		{
			$libraries = json_decode($libraries, true);
		}

		// Ensure we have a valid array of libraries
		if (!UtilitiesArrayHelper::check($libraries))
		{
			return false;
		}

		// Validate and expand libraries
		$validatedLibraries = $this->expandAndValidateLibraries($libraries);

		if (!$validatedLibraries)
		{
			return false;
		}

		$db = Factory::getDbo();
		$query = $db->getQuery(true)
			->select($db->quoteName('a.id'))
			->from($db->quoteName('#__componentbuilder_snippet', 'a'))
			->where($db->quoteName('a.published') . ' = 1')
			->where($db->quoteName('a.library') . ' IN ("' . implode('","', $validatedLibraries) . '")');

		$db->setQuery($query);
		$db->execute();

		return $db->getNumRows() ? $db->loadColumn() : false;
	}

	/**
	 * Validates and expands library GUIDs to ensure only integers and valid references remain.
	 *
	 * @param   array  $libraries  The original list of library GUIDs.
	 *
	 * @return  array|false  Sanitized and validated list of libraries, or false.
	 * @since   5.1.1
	 */
	protected function expandAndValidateLibraries(array $libraries)
	{
		$expanded = [];

		foreach ($libraries as $guid)
		{
			$guid = (string) $guid;
			$type = GetHelper::var('library', $guid, 'guid', 'type');

			if ((int) $type === 2)
			{
				$bundled = GetHelper::var('library', $guid, 'guid', 'libraries');

				if (JsonHelper::check($bundled))
				{
					$bundled = json_decode($bundled, true);
				}

				if (UtilitiesArrayHelper::check($bundled))
				{
					foreach ($bundled as $lib)
					{
						$expanded[$lib] = $lib;
					}
				}
				elseif (is_numeric($bundled))
				{
					$expanded[$bundled] = $bundled;
				}
			}
			else
			{
				$expanded[$guid] = $guid;
			}
		}

		// Remove invalid entries and duplicates
		$valid = array_filter(array_unique($expanded), function ($guid) {
			return GuidHelper::valid($guid);
		});

		return UtilitiesArrayHelper::check($valid) ? array_values($valid) : false;
	}

	/**
	 * Retrieves snippet details by GUID or ID.
	 *
	 * @param   string|int  $key  The snippet GUID (string) or ID (int).
	 *
	 * @return  object|false  The snippet data object or false on failure.
	 * @since   5.1.1
	 */
	public function getSnippetDetails($key)
	{
		$target = $this->resolveSnippetKeyField($key);

		if ($target === false)
		{
			return false;
		}

		$db = Factory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($db->quoteName(
				[
					'a.name',
					'a.heading',
					'a.usage',
					'a.description',
					'b.name',
					'a.snippet',
					'a.url',
					'c.name'
				],
				[
					'name',
					'heading',
					'usage',
					'description',
					'type',
					'snippet',
					'url',
					'library'
				]
			))
			->from($db->quoteName('#__componentbuilder_snippet', 'a'))
			->join('LEFT', $db->quoteName('#__componentbuilder_snippet_type', 'b') . ' ON ' . $db->quoteName('a.type') . ' = ' . $db->quoteName('b.guid'))
			->join('LEFT', $db->quoteName('#__componentbuilder_library', 'c') . ' ON ' . $db->quoteName('a.library') . ' = ' . $db->quoteName('c.guid'))
			->where($db->quoteName('a.published') . ' >= 1')
			->where($db->quoteName("a.$target") . ' = ' . $db->quote($key));

		$db->setQuery($query);
		$db->execute();

		if ($db->getNumRows() > 0)
		{
			$snippet = $db->loadObject();

			if (isset($snippet->snippet))
			{
				$snippet->snippet = base64_decode($snippet->snippet);
			}

			return $snippet;
		}

		return false;
	}

	/**
	 * Resolves whether the given key is a GUID or numeric ID and returns the appropriate field.
	 *
	 * @param   mixed  $key  The value used to identify the snippet.
	 *
	 * @return  string|false  'guid', 'id', or false if invalid.
	 * @since   5.1.1
	 */
	protected function resolveSnippetKeyField($key)
	{
		if (GuidHelper::valid($key))
		{
			return 'guid';
		}

		if (is_numeric($key))
		{
			return 'id';
		}

		return false;
	}

	// Used in validation_rule
	public function getExistingValidationRuleCode($name)
	{
		// make sure we have all the exiting rule names
		if ($names = ComponentbuilderHelper::getExistingValidationRuleNames())
		{
			// check that this is a valid rule file
			if (UtilitiesArrayHelper::check($names) && in_array($name, $names))
			{
				// get the full path to rule file
				$path = JPATH_LIBRARIES . '/src/Form/Rule/'.$name.'Rule.php';
				// get all the code
				if ($code = FileHelper::getContent($path))
				{
					// remove the class details and the ending }
					$codeArray = (array) explode("FormRule\n{\n", $code);
					if (isset($codeArray[1]))
					{
						return array('values' => rtrim(rtrim(rtrim($codeArray[1]),'}')));
					}
				}
			}
		}
		return false;
	}

	public function checkRuleName($name, $id)
	{
		$name = StringHelper::safe($name);
		if ($found = GetHelper::var('validation_rule', $name, 'name', 'id'))
		{
			if ((int) $id !== (int) $found)
			{
				return array (
					'message' => Text::sprintf('COM_COMPONENTBUILDER_SORRY_THIS_VALIDATION_RULE_NAME_S_ALREADY_EXIST_IN_YOUR_SYSTEM', $name),
					'status' => 'danger',
					'timeout' => 6000);
			}
		}
		// now check the existing once
		if ($names = ComponentbuilderHelper::getExistingValidationRuleNames(true))
		{
			if (in_array($name, $names))
			{
				return array (
					'message' => Text::sprintf('COM_COMPONENTBUILDER_SORRY_THIS_VALIDATION_RULE_NAME_S_ALREADY_EXIST_AS_PART_OF_THE_JOOMLA_CORE_NO_NEED_TO_CREATE_IT_IF_YOU_ARE_ADAPTING_IT_GIVE_IT_YOUR_OWN_UNIQUE_NAME', $name),
					'status' => 'danger',
					'timeout' => 10000);
			}
		}
		return array (
			'name' => $name,
			'message' => Text::sprintf('COM_COMPONENTBUILDER_GREAT_THIS_VALIDATION_RULE_NAME_S_WILL_WORK', $name),
			'status' => 'success',
			'timeout' => 5000);
	}

	public function getValidationRulesTable($id)
	{
		// get all the validation rules
		if ($rules = $this->getValidationRules())
		{
			// build table
			$table =  '<div class="control-group"><table class="uk-table uk-table-hover uk-table-striped uk-table-condensed">';
			$table .=  '<caption>'.Text::sprintf('COM_COMPONENTBUILDER_THE_AVAILABLE_VALIDATION_RULES_FOR_THE_VALIDATE_ATTRIBUTE_ARE').'</caption>';
			$table .=  '<thead><tr><th class="uk-text-right">'.Text::_('COM_COMPONENTBUILDER_VALIDATE').'</th><th>'.Text::_('COM_COMPONENTBUILDER_DESCRIPTION').'</th></tr></thead>';
			$table .=  '<tbody>';
			foreach ($rules as $name => $decs)
			{
				// just load the values
				$decs = (StringHelper::check($decs) && !is_numeric($decs)) ? $decs : '';
				$table .=  '<tr><td class="uk-text-right"><code>'.$name.'</code></td><td>'. $decs. '</td></tr>';
			}
			return $table.'</tbody></table></div>';
		}
		return false;
	}

	public function getValidationRules()
	{
		// custom rule names
		$names = array();
		// make sure we have all the exiting rule names
		if (!$exitingNames = ComponentbuilderHelper::getExistingValidationRuleNames(true))
		{
			// stop (something is wrong)
			return false;
		}
		// convert names to keys
		$exitingNames = array_flip($exitingNames);
		// load the descriptions (taken from https://docs.joomla.org/Server-side_form_validation)
		$exitingNames["boolean"] = Text::_("COM_COMPONENTBUILDER_ACCEPTS_ONLY_THE_VALUES_ZERO_ONE_TRUE_OR_FALSE_CASEINSENSITIVE");
		$exitingNames["color"] = Text::_("COM_COMPONENTBUILDER_ACCEPTS_ONLY_EMPTY_VALUES_CONVERTED_TO_ZERO_AND_STRINGS_IN_THE_FORM_RGB_OR_RRGGBB_WHERE_R_G_AND_B_ARE_HEX_VALUES");
		$exitingNames["email"] =  Text::_("COM_COMPONENTBUILDER_ACCEPTS_AN_EMAIL_ADDRESS_SATISFIES_A_BASIC_SYNTAX_CHECK_IN_THE_PATTERN_OF_QUOTXYZZQUOT_WITH_NO_INVALID_CHARACTERS");
		$exitingNames["equals"] = Text::sprintf("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_TO_BE_THE_SAME_AS_THAT_HELD_IN_THE_FIELD_NAMED_QUOTFIELDQUOT_EGS", '<br /><code>&lt;input<br />&nbsp;&nbsp;type="text"<br />&nbsp;&nbsp;name="email_check"<br />&nbsp;&nbsp;validate="equals"<br />&nbsp;&nbsp;field="email"<br />/&gt;</code>');
		$exitingNames["options"] = Text::_("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_ENTERED_BE_ONE_OF_THE_OPTIONS_IN_AN_ELEMENT_OF_TYPEQUOTLISTQUOT_THAT_IS_THAT_THE_ELEMENT_IS_A_SELECT_LIST");
		$exitingNames["tel"] = Text::_("COM_COMPONENTBUILDER_REQUIRES_THE_VALUE_TO_BE_A_TELEPHONE_NUMBER_COMPLYING_WITH_THE_STANDARDS_OF_NANPA_ITUT_TRECEONE_HUNDRED_AND_SIXTY_FOUR_OR_IETF_RFCFOUR_THOUSAND_NINE_HUNDRED_AND_THIRTY_THREE");
		$exitingNames["url"] = Text::sprintf("COM_COMPONENTBUILDER_VALIDATES_THAT_THE_VALUE_IS_A_URL_WITH_A_VALID_SCHEME_WHICH_CAN_BE_RESTRICTED_BY_THE_OPTIONAL_COMMASEPARATED_FIELD_SCHEME_AND_PASSES_A_BASIC_SYNTAX_CHECK_EGS", '<br /><code>&lt;input<br />&nbsp;&nbsp;type="text"<br />&nbsp;&nbsp;name="link"<br />&nbsp;&nbsp;validate="url"<br />&nbsp;&nbsp;scheme="http,https,mailto"<br />/&gt;</code>');
		$exitingNames["username"] = Text::_("COM_COMPONENTBUILDER_VALIDATES_THAT_THE_VALUE_DOES_NOT_APPEAR_AS_A_USERNAME_ON_THE_SYSTEM_THAT_IS_THAT_IT_IS_A_VALID_NEW_USERNAME_DOES_NOT_SYNTAX_CHECK_IT_AS_A_VALID_NAME");
		// now get the custom created rules
		$db = Factory::getDbo();
		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('a.name','a.short_description')));
		$query->from($db->quoteName('#__componentbuilder_validation_rule','a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			$names = $db->loadAssocList('name', 'short_description');
		}
		// merge the arrays
		$rules = UtilitiesArrayHelper::merge(array($exitingNames, $names));
		// sort the array
		 ksort($rules);
		// return the validation rules
		return $rules;
	}

	// Used in field
	/**
	 * The current extras available
	 *
	 * @var   array
	 * @since 3.0.0
	 */
	protected array $extraFieldProperties = [
			'listclass' => 'COM_COMPONENTBUILDER_SET_A_CLASS_VALUE_FOR_THE_LIST_VIEW_OF_THIS_FIELD',
			'escape' => 'COM_COMPONENTBUILDER_SHOULD_THIS_FIELD_BE_ESCAPED_IN_THE_LIST_VIEW',
			'display' => 'COM_COMPONENTBUILDER_DISPLAY_SWITCH_FOR_DYNAMIC_PLACEMENT_IN_RELATION_TO_THE_USE_OF_THE_FIELD_IN_MENU_AND_GLOBAL_CONFIGURATION_OPTIONS_SO_THE_CONFIG_OPTION_WILL_ONLY_ADD_THE_FIELD_TO_THE_GLOBAL_CONFIGURATION_AREA_MENU_WILL_ADD_THE_FIELD_ONLY_TO_THE_MENU_AREA',
			'validate' => 'COM_COMPONENTBUILDER_TO_ADD_VALIDATION_TO_A_FIELD_IF_VALIDATION_IS_NOT_PART_OF_FIELD_TYPE_PROPERTIES_LOADED_ABOVE_SO_IF_YOU_HAVE_VALIDATION_SET_AS_A_FIELD_PROPERTY_THIS_EXTRA_PROPERTY_WILL_NOT_BE_NEEDED'
	];

	/**
	 * Retrieves and constructs the properties for a given field type.
	 *
	 * This method generates a set of field properties, including subforms and extra properties,
	 * based on the specified field type. It also handles additional PHP-based properties by
	 * constructing textarea fields for multi-line input. The resulting field configuration is 
	 * returned as an associative array, which includes HTML-rendered fields for integration into 
	 * the Joomla form interface.
	 *
	 * @param mixed $fieldtype The type of the field to retrieve properties for. This can be an 
	 *                         identifier such as a GUID, numeric ID, or a string.
	 *
	 * @return array|null An associative array containing the following keys if successful:
	 *                     - `subform`: HTML-rendered subform for field properties.
	 *                     - `extra`: HTML-rendered subform for extra field properties.
	 *                     - `textarea`: An array of HTML-rendered textarea fields for PHP-based properties (if any).
	 *                     Returns `false` if the field type is invalid or no properties are found.
	 * @since 3.0.0
	 */
	public function getFieldTypeProperties($fieldtype): ?array
	{
		// get the fieldtype key
		if (GuidHelper::valid($fieldtype))
		{
			$key = 'guid';
		}
		elseif (is_numeric($fieldtype))
		{
			$key = 'id';
		}
		else
		{
			return null;
		}

		// get the xml
		$xml = $this->getFieldXML($fieldtype);

		// now get the field options
		if ($field = ComponentbuilderHelper::getFieldTypeProperties($fieldtype, $key, null, $xml, true))
		{
			// get subform field properties object
			$properties = $this->buildFieldOptionsSubform($field['subform'], $field['nameListOptions']);

			// load the extra options
			$extraValues = $this->getFieldExtraValues($xml, $field['nameListOptions']);

			// set the nameListOption
			$extraNameListOption = $this->extraFieldProperties;
			array_walk($extraNameListOption, function (&$value, $key) {
				$value = $key;
			});

			// get subform field object
			$extras = $this->buildFieldOptionsSubform($extraValues, $extraNameListOption, 'extraproperties',  'COM_COMPONENTBUILDER_EXTRA_PROPERTIES_LIKE_LISTCLASS_ESCAPE_DISPLAY_VALIDATEBR_SMALLHERE_YOU_CAN_SET_THE_EXTRA_PROPERTIES_FOR_THIS_FIELDSMALL');

			// load the html 
			$field['subform'] = '<div class="control-label prop_removal">'. $properties->label . '</div><div class="controls prop_removal">' . $properties->input . '</div>';
			$field['extra'] = '<div class="control-label prop_removal">'. $extras->label . '</div><div class="controls prop_removal">' . $extras->input . '</div>';

			// check if we have PHP values
			if (UtilitiesArrayHelper::check($field['php']))
			{
				$field['textarea'] = array();
				foreach($field['php'] as $name => $values)
				{
					$value = implode(PHP_EOL, $values['value']);
					$textarea = $this->buildFieldTextarea($name, $values['desc'], $value, substr_count( $value, PHP_EOL ));
					// load the html 
					$field['textarea'][] = '<div class="control-label prop_removal">'. $textarea->label . '</div><div class="controls prop_removal">' . $textarea->input . '</div><br />';
				}
			}

			// remove some unneeded values
			unset($field['values']);

			// return found field options
			return $field;
		}

		return null;
	}

	/**
	 * Retrieves extra field properties and their values.
	 *
	 * This method identifies and extracts additional properties from a field's XML definition
	 * that are not included in the provided options array. It verifies the validity of each
	 * property's value and returns an associative array of extra properties with their names, 
	 * values, and descriptions.
	 *
	 * @param \SimpleXMLElement $xml The XML definition of the field, used to extract property values.
	 * @param array $options An array of property names to exclude from the extraction process.
	 *
	 * @return array|null An associative array of extra properties, each containing:
	 *                    - `name`: The name of the property.
	 *                    - `value`: The value of the property if it is valid.
	 *                    - `desc`: The translated description of the property.
	 *                    Returns `null` if no extra properties are found.
	 * @since 3.0.0
	 */
	protected function getFieldExtraValues($xml, $options): ?array
	{
		if (empty($this->extraFieldProperties))
		{
			return null;
		}

		// get the value
		$values = [];

		// value to check since there are false and null values even 0 in the values returned
		$confirmation = '8qvZHoyuFYQqpj0YQbc6F3o5DhBlmS-_-a8pmCZfOVSfANjkmV5LG8pCdAY2JNYu6cB';
		$nr = 0;
		foreach ($this->extraFieldProperties as $extra => $desc)
		{
			if (!in_array($extra, $options))
			{
				$value =  FieldHelper::getValue($xml, $extra, $confirmation);
				if ($confirmation !== $value)
				{
					$values['extraproperties' . $nr] = ['name' => $extra, 'value' => $value, 'desc' => Text::_($desc)];
					$nr++;
				}
			}
		}

		// return only if extras founb
		if (UtilitiesArrayHelper::check($values))
		{
			return $values;
		}

		return null;
	}

	/**
	 * Builds a textarea field for a Joomla form.
	 *
	 * This method dynamically generates a textarea field with configurable attributes 
	 * such as name, description, default value, and number of rows. The textarea is 
	 * used to capture multi-line input, such as scripts or extended text values.
	 *
	 * @param string $name The name identifier for the textarea field, appended to the 
	 *                     'property_' prefix to create a unique field name.
	 * @param string $desc The label or description for the textarea field, displayed 
	 *                     in the form UI.
	 * @param mixed $default The default value to populate the textarea field.
	 * @param int $rows The number of rows for the textarea. If the provided value is 
	 *                  less than 3, 2 additional rows are added to ensure readability.
	 *
	 * @return object A Joomla textarea field object configured with the specified attributes and default value.
	 *
	 * @throws \Exception If any errors occur while generating the field XML or setting up the field.
	 * @since 3.0.0
	 */
	protected function buildFieldTextarea($name, $desc, $default, $rows): object
	{
		// get the textarea
		$textarea = FormFormHelper::loadFieldType('textarea', true);
		// start building the name field XML
		$textareaXML = new \SimpleXMLElement('<field/>');
		// textarea attributes
		$textareaAttribute = array(
			'type' => 'textarea',
			'name' => 'property_'.$name,
			'label' => $desc,
			'rows' => (int) ($rows >= 3) ? $rows : $rows + 2,
			'cols' => '15',
			'class' => 'text_area  span12',
			'filter' => 'RAW',
			'hint' => 'COM_COMPONENTBUILDER__ADD_YOUR_PHP_SCRIPT_HERE');
		// load the textarea attributes
		FormHelper::attributes($textareaXML, $textareaAttribute);

		// setup subform with values
		$textarea->setup($textareaXML, $default);

		// return textarea object
		return $textarea;
	}

	/**
	 * Builds a subform field for configuring field options.
	 *
	 * This method dynamically generates a Joomla subform field with multiple attributes,
	 * child fields, and configurations. The generated subform field includes properties for 
	 * name, value, and description, and supports dynamic field attributes and options based 
	 * on the provided input values and configurations.
	 *
	 * @param array $values An array of initial values to populate the subform fields.
	 *                      Each value corresponds to a row in the subform.
	 * @param array|null $nameListOptions An optional associative array of options for the 
	 *                                    "name" field. If provided, the field will render 
	 *                                    as a dropdown list with these options. If `null`, 
	 *                                    the field will render as a text input.
	 * @param string $name The name attribute for the subform field. Default is 'properties'.
	 * @param string $label The label for the subform field. By default, it includes a 
	 *                      description of the subform purpose.
	 *
	 * @return object A Joomla subform field object configured with the specified 
	 *                attributes, child fields, and values.
	 * @since 3.0.0
	 */
	protected function buildFieldOptionsSubform($values, $nameListOptions = null, $name = 'properties',
		$label = 'COM_COMPONENTBUILDER_PROPERTIESBR_SMALLHERE_YOU_CAN_SET_THE_PROPERTIES_FOR_THIS_FIELDSMALL'): object
	{
		// get the subform
		$subform = FormFormHelper::loadFieldType('subform', true);
		// start building the subform field XML
		$subformXML = new \SimpleXMLElement('<field/>');
		// subform attributes
		$subformAttribute = array(
			'type' => 'subform',
			'name' => $name,
			'label' => $label,
			'layout' => 'joomla.form.field.subform.repeatable-table',
			'multiple' => 'true',
			'icon' => 'list',
			'max' =>  (UtilitiesArrayHelper::check($nameListOptions)) ? (int) count($nameListOptions) : 4);
		// load the subform attributes
		FormHelper::attributes($subformXML, $subformAttribute);
		// now add the subform child form
		$childForm = $subformXML->addChild('form');
		// child form attributes
		$childFormAttribute = array(
			'hidden' => 'true',
			'name' => 'list_properties',
			'repeat' => 'true');
		// load the child form attributes
		FormHelper::attributes($childForm, $childFormAttribute);

		// start building the name field XML
		$nameXML = new \SimpleXMLElement('<field/>');
		// subform attributes
		$nameAttribute = array(
			'type' => (UtilitiesArrayHelper::check($nameListOptions)) ? 'list' : 'text',
			'name' => 'name',
			'label' => 'COM_COMPONENTBUILDER_PROPERTY',
			'size' => '40',
			'maxlength' => '150',
			'class' => (UtilitiesArrayHelper::check($nameListOptions)) ? 'list_class field_list_name_options' : 'text_area',
			'filter' => 'STRING');
		// add the hint only if not name list and description if name list is an array
		if (UtilitiesArrayHelper::check($nameListOptions))
		{
			$nameAttribute['description'] = 'COM_COMPONENTBUILDER_SELECTION';
			$nameAttribute['multiple'] = 'false';
			$nameAttribute['onchange'] = "getFieldPropertyDesc(this, '".$name."')";
			$nameAttribute['layout'] = 'joomla.form.field.list-fancy-select';
		}
		else
		{
			$nameAttribute['hint'] = 'COM_COMPONENTBUILDER_PROPERTY_NAME';
		}
		// load the subform attributes
		FormHelper::attributes($nameXML, $nameAttribute);
		// add name list if found
		if (UtilitiesArrayHelper::check($nameListOptions))
		{
			FormHelper::options($nameXML, $nameListOptions);
		}
		// now add the fields to the child form
		FormHelper::append($childForm, $nameXML);

		// start building the name field XML
		$valueXML = new \SimpleXMLElement('<field/>');
		// subform attributes
		$valueAttribute = array(
			'type' => 'textarea',
			'name' => 'value',
			'label' => 'COM_COMPONENTBUILDER_VALUE',
			'rows' => '1',
			'cols' => '15',
			'class' => 'text_area  span12',
			'filter' => 'STRING',
			'hint' => 'COM_COMPONENTBUILDER_PROPERTY_VALUE');
		// load the subform attributes
		FormHelper::attributes($valueXML, $valueAttribute);
		// now add the fields to the child form
		FormHelper::append($childForm, $valueXML);

		// start building the desc field XML
		$descXML = new \SimpleXMLElement('<field/>');
		// subform attributes
		$descAttribute = array(
			'type' => 'textarea',
			'name' => 'desc',
			'label' => 'COM_COMPONENTBUILDER_DESCRIPTION',
			'rows' => '3',
			'cols' => '25',
			'readonly' => 'true',
			'class' => 'text_area span12',
			'filter' => 'WORD',
			'hint' => 'COM_COMPONENTBUILDER_SELECT_A_PROPERTY');
		// load the desc attributes
		FormHelper::attributes($descXML, $descAttribute);
		// now add the fields to the child form
		FormHelper::append($childForm, $descXML);

		// setup subform with values
		$subform->setup($subformXML, $values);

		// return subfrom object
		return $subform;
	}

	/**
	 * Retrieves the field property description based on the given property name and field type.
	 *
	 * This function performs a series of validations and database lookups to fetch
	 * the description and associated value of a specified field property. If the
	 * property is not found or valid, it returns `false`.
	 *
	 * @param string $_property The name of the field property to retrieve.
	 * @param mixed $fieldtype The type of the field, which can be a GUID, numeric ID, or other identifier.
	 *
	 * @return array|false Returns an associative array with keys `value` and `desc` if the property is found, 
	 *                     or `false` if no matching property is found.
	 * @since 3.0.0
	 */
	public function getFieldPropertyDesc(string $_property, $fieldtype)
	{
		if (GuidHelper::valid($fieldtype))
		{
			$key = 'guid';
		}
		elseif (is_numeric($fieldtype))
		{
			$key = 'id';
		}
		elseif (isset($this->extraFieldProperties[$_property]))
		{
			return ['value' => '', 'desc' => Text::_($this->extraFieldProperties[$_property])];
		}
		else
		{
			return false;
		}

		// Get a db connection.
		$db = Factory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);
		$query->select($db->quoteName(array('properties', 'short_description', 'description')));
		$query->from($db->quoteName('#__componentbuilder_fieldtype'));
		$query->where($db->quoteName($key) . ' = '. $db->quote($fieldtype));

		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		$db->execute();
		if ($db->getNumRows())
		{
			// get the result
			$result = $db->loadObject();
			// get the xml
			$xml = $this->getFieldXML($fieldtype);
			// open the properties
			$properties = json_decode($result->properties,true);
			// value to check since there are false and null values even 0 in the values returned
			$confirmation = '8qvZHoyuFYQqpj0YQbc6F3o5DhBlmS-_-a8pmCZfOVSfANjkmV5LG8pCdAY2JNYu6cB';

			// make sure we have an array
			if (!UtilitiesArrayHelper::check($properties))
			{
				return false;
			}

			foreach ($properties as $property)
			{
				if(isset($property['name']) && $_property === $property['name'])
				{
					// check if we should load the value
					$value = FieldHelper::getValue($xml, $property['name'], $confirmation);
					if ($confirmation === $value)
					{
						$value = (isset($property['example']) && StringHelper::check($property['example'])) ? $property['example'] : '';
					}
					// return the found values
					return ['value' => $value, 'desc' => $property['description']];
				}
			}
		}
		return false;
	}

	/**
	 * Retrieves the XML configuration for a given field type.
	 *
	 * This method fetches the XML configuration associated with a specific field type.
	 * If the current view is a "field" view and the view ID is valid, it attempts to 
	 * retrieve the XML configuration from the database. It also ensures that the XML 
	 * configuration matches the specified field type, applying transformations if 
	 * necessary to adapt the XML to the new field type.
	 *
	 * @param mixed $fieldtype The type of the field for which XML configuration is requested.
	 *                         This can be a numeric ID, GUID, or other identifier.
	 *
	 * @return string|null The XML configuration as a string if found and processed, 
	 *                     or `null` if no valid XML configuration is available.
	 * @since 3.0.0
	 */
	protected function getFieldXML($fieldtype): ?string
	{
		// reset xml to null
		$xml = null;

		// get the view name & id
		$global = $this->getViewID();

		// get the xml if this view already has it set
		if (!is_null($global['a_id']) && $global['a_id'] > 0 && isset($global['a_view']) && 'field' === $global['a_view'])
		{
			// first check field type
			$_fieldType = GetHelper::var('field', $global['a_id'], 'id', 'fieldtype');
			$xmlDB = GetHelper::var('field', $global['a_id'], 'id', 'xml');

			// check if it is a string
			if (StringHelper::check($xmlDB))
			{
				$xml = json_decode($xmlDB);
			}

			// remove the field type if not the same
			if ($xml && $fieldtype != $_fieldType)
			{
				// unset some stuff
				$pattern = [];
				$pattern[] = '/type=".+?"/i'; // to force the new type to be set
				$pattern[] = '/class=".+?"/i'; // to remove all classes
				$pattern[] = '/type_php.+?".+?"/i'; // to remove any PHP code stuff

				// also add a special switch to force adding all properties of the new type
				$xml = preg_replace($pattern, '..__FORCE_LOAD_ALL_PROPERTIES__..', $xml);
			}
		}
		return $xml;
	}

	// Used in language_translation
	/**
	 * Export language translation data by filtering records based on extension, translated, and untranslated tags.
	 *
	 * This method loads translation records from the database and structures them into an array
	 * with language-tagged headers (e.g., `en-GB`, `de-DE`). It supports filtering for a specific
	 * extension, already translated languages, and missing translations. All matching records are
	 * padded with empty values for missing languages, and returned with a size count or errors.
	 *
	 * @param   string  $extension      The extension identifier in format "type__name" (e.g., "com_example__field").
	 * @param   string  $translated     Comma-separated list of language tags that must have translations.
	 * @param   string  $notTranslated  Comma-separated list of language tags that must not yet have translations.
	 *
	 * @return  array<string, mixed>  Returns an array with:
	 *                                - 'data' (array<int, array<string, string>>): The exportable translation rows.
	 *                                - 'size' (int): Number of rows (if successful).
	 *                                - 'errors' (string): Error message (if an error occurred).
	 *
	 * @throws  \Throwable  If any unexpected exception occurs during data fetching or parsing.
	 * @since   5.1.1
	 */
	public function exportLanguageTranslations(string $extension, string $translated, string $notTranslated): array
	{
		try {
			$ids = $this->resolveLanguageTranslationFilterIds($extension, $translated, $notTranslated);
			$where = $this->buildLanguageTranslationWhereClause($ids);
			$records = $this->loadLanguageTranslationRows($where);
			$headers = $this->getLanguageTranslationHeaders();

			if (empty($records))
			{
				return $this->errorLanguageTranslationResponse(Text::_('COM_COMPONENTBUILDER_NO_LANGUAGE_STRINGS_FOUND'));
			}

			$data = $this->normalizeLanguageTranslationData($records, $headers);

			return [
				'data' => $data,
				'size' => count($data),
			];
		} catch (\Throwable $e) {
			return $this->errorLanguageTranslationResponse($e->getMessage());
		}
	}

	/**
	 * Resolve all relevant record IDs from the given filters.
	 *
	 * @param   string  $extension      Extension string in format "type__name".
	 * @param   string  $translated     Comma-separated list of translated language tags.
	 * @param   string  $notTranslated  Comma-separated list of untranslated language tags.
	 *
	 * @return  array<int>|null  Array of record IDs, or empty array to load all or null to force a skip all.
	 * @since   5.1.1
	 */
	protected function resolveLanguageTranslationFilterIds(string $extension, string $translated, string $notTranslated): ?array
	{
		$ids = [];
		$forceEmpty = false;

		// Extension IDs
		if (!empty($extension) && strpos($extension, '__') !== false)
		{
			[$type, $name] = explode('__', $extension, 2);
			$extIds = FilterHelper::translation($name, $type);
			if (!empty($extIds))
			{
				$ids = array_merge($ids, $extIds);
			}
			else
			{
				$forceEmpty = true;
			}
		}

		// Translated IDs
		if (!empty($translated))
		{
			$trIds = FilterHelper::translations($translated);
			if (!empty($trIds))
			{
				$ids = array_merge($ids, $trIds);
			}
			else
			{
				$forceEmpty = true;
			}
		}

		// Not translated IDs
		if (!empty($notTranslated))
		{
			$untrIds = FilterHelper::translations($notTranslated, false);
			if (!empty($untrIds))
			{
				$ids = array_merge($ids, $untrIds);
			}
			else
			{
				$forceEmpty = true;
			}
		}

		if ($ids === [] && !$forceEmpty)
		{
			return [];
		}

		return $forceEmpty ? null : array_unique($ids);
	}

	/**
	 * Build a SQL WHERE clause using resolved IDs.
	 *
	 * @param   array<int>|null  $ids  The record IDs to include in the query.
	 *
	 * @return  array<string, array<string, mixed>>  A structured WHERE clause.
	 * @since   5.1.1
	 */
	protected function buildLanguageTranslationWhereClause(?array $ids): array
	{
		if ($ids === [])
		{
			// return all published
			return ['published' => ['value' => 1, 'operator' => '=', 'quote' => false]];
		}
		elseif ($ids === null)
		{
			// return none
			return ['id' => ['value' => 0, 'operator' => '=', 'quote' => false]];
		}

		// return selected and published
		return [
			'id' => ['value' => $ids, 'operator' => 'IN', 'quote' => false],
			'published' => ['value' => 1, 'operator' => '=', 'quote' => false]
		];
	}

	/**
	 * Load translation rows from the database based on the given WHERE clause.
	 *
	 * @param   array<string, array<string, mixed>>|null  $where  Optional WHERE clause.
	 *
	 * @return  array<int, array<string, mixed>>  Loaded records with 'source' and 'translation' keys.
	 * @since   5.1.1
	 */
	protected function loadLanguageTranslationRows(?array $where): array
	{
		return DataFactory::_('Load')->rows(
			['source', 'translation'],
			['language_translation'],
			$where,
			['source' => 'ASC']
		);
	}

	/**
	 * Get the list of available language headers (e.g., ['en-GB' => 'en-GB']).
	 *
	 * This includes a default 'source' => 'source' entry.
	 *
	 * @return  array<string, string>  Associative list of language tags.
	 * @since   5.1.1
	 */
	protected function getLanguageTranslationHeaders(): array
	{
		return ComponentbuilderHelper::getLanguageTranslationsHeaders() ?? ['source' => 'source'];
	}

	/**
	 * Normalize translation records by mapping language keys and padding missing headers.
	 *
	 * @param   array<int, array<string, mixed>>  $rows     Raw translation rows from the database.
	 * @param   array<string, string>             $headers  Valid language header list.
	 *
	 * @return  array<int, array<string, string>>  Structured translation data ready for export.
	 * @since   5.1.1
	 */
	protected function normalizeLanguageTranslationData(array $rows, array $headers): array
	{
		$normalized = [];

		foreach ($rows as $row)
		{
			$translations = json_decode($row['translation'] ?? '[]', true) ?: [];
			unset($row['translation']);

			// Pad all expected language headers
			foreach ($headers as $lang => $_)
			{
				if ($lang === 'source')
				{
					continue;
				}
				$row[$lang] = '';
			}

			foreach ($translations as $entry)
			{
				$lang = $entry['language'] ?? '';
				$text = trim(($entry['translation'] ?? ''));

				if (isset($headers[$lang]) && trim($text) !== '')
				{
					$row[$lang] = $text;
				}
			}

			$normalized[] = $row;
		}

		return $normalized;
	}

	/**
	 * Build a standardized error response with message.
	 *
	 * @param   string  $message  Error message to return.
	 *
	 * @return  array<string, mixed>  Error response with 'data' as empty array and 'errors' as message.
	 * @since   5.1.1
	 */
	protected function errorLanguageTranslationResponse(string $message): array
	{
		return [
			'data' => [],
			'errors' => $message,
		];
	}

	// Used in admin_fields_relations
	public function getCodeGlueOptions($listfield, $joinfields, $type, $area)
	{
		// CONCATENATE GLUE
		if ($type == 1)
		{
			// MODEL
			if ($area == 1 || $area == 3)
			{
				return ', ';
			}
			// VIEW
			elseif ($area == 2)
			{
				return '<br />';
			}
		}
		// CUSTOM CODE
		elseif ($type == 2)
		{
			// build fields array
			if ('none' !== $joinfields)
			{
				$fields = array_map( function ($guid) {
					return (string) $guid;
				}, (array) explode(',', $joinfields));
				// add the list field to array
				array_unshift($fields, (string) $listfield);
			}
			else
			{
				$fields = array((string) $listfield);
			}
			// get field names
			$names = array_map( function ($guid) {
				return '[' . $guid . ']=> ' . GetHelper::var('field', $guid, 'guid', 'name');
			}, $fields);
			// MODEL
			if ($area == 1 || $area == 3)
			{
				// create note
				$note = "// ". implode('; ', $names);
				return $note . PHP_EOL . '$item->{'.(string)$listfield.'} = $item->{' . implode("} . ', ' . \$item->{", $fields) . '};';
			}
			// VIEW
			elseif ($area == 2)
			{
				// create note
				$note = "<!--  " . implode('; ', $names) . " -->";
				return '[field=' . implode("]<br />[field=", $fields). ']' . PHP_EOL . PHP_EOL . $note;
			}
		}
		return false;
	}

	// Used in search
	/**
	 * Search for value in a table
	 *
	 * @param   string           $tableName    The main table to search
	 * @param   int              $typeSearch  The type of search being done
	 * @param   string           $searchValue  The value to search for
	 * @param   int               $matchCase  The switch to control match case
	 * @param   int               $wholeWord  The switch to control whole word
	 * @param   int               $regexSearch  The switch to control regex search
	 * @param   int               $componentId  The option to filter by component
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function doSearch(string $tableName, int $typeSearch, string $searchValue,
		int $matchCase, int $wholeWord, int $regexSearch, int $componentId): ?array
	{
		// check if this is a valid table
		if (SearchFactory::_('Table')->exist($tableName))
		{
			try
			{
				// load the configurations
				SearchFactory::_('Config')->table_name = $tableName;
				SearchFactory::_('Config')->type_search = $typeSearch;
				SearchFactory::_('Config')->search_value = $searchValue;
				SearchFactory::_('Config')->match_case = $matchCase;
				SearchFactory::_('Config')->whole_word = $wholeWord;
				SearchFactory::_('Config')->regex_search = $regexSearch;
				SearchFactory::_('Config')->component_id = $componentId;

				if (($items = SearchFactory::_('Agent')->table($tableName)) !== null)
				{
					return [
						'success' => Text::sprintf('COM_COMPONENTBUILDER_WE_FOUND_SOME_INSTANCES_IN_S', $tableName),
						'items' => $items,
						'fields_count' => SearchFactory::_('Config')->field_counter,
						'line_count' => SearchFactory::_('Config')->line_counter
					];
				}

				return [
					'not_found' => Text::sprintf('COM_COMPONENTBUILDER_NO_INSTANCES_WHERE_FOUND_IN_S', $tableName),
					'fields_count' => SearchFactory::_('Config')->field_counter,
					'line_count' => SearchFactory::_('Config')->line_counter
				];
			}
			catch(Exception $error)
			{
				return ['error' => $error->getMessage()];
			}
		}

		return ['error' => Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Search and replace value in a table
	 *
	 * @param   string           $tableName    The main table to search
	 * @param   string           $searchValue  The value to search for
	 * @param   string|null      $replaceValue  The value to replace search value
	 * @param   int              $matchCase  The switch to control match case
	 * @param   int              $wholeWord  The switch to control whole word
	 * @param   int              $regexSearch  The switch to control regex search
	 * @param   int              $componentId  The option to filter by component
	 *
	 * @return  array|null
	 * @since   3.2.0
	 **/
	public function replaceAll(string $tableName, string $searchValue, ?string $replaceValue,
		int $matchCase, int $wholeWord, int $regexSearch, int $componentId): ?array
	{
		// check if this is a valid table
		if (SearchFactory::_('Table')->exist($tableName))
		{
			try
			{
				// load the configurations
				SearchFactory::_('Config')->table_name = $tableName;
				SearchFactory::_('Config')->search_value = $searchValue;
				SearchFactory::_('Config')->replace_value = $replaceValue;
				SearchFactory::_('Config')->match_case = $matchCase;
				SearchFactory::_('Config')->whole_word = $wholeWord;
				SearchFactory::_('Config')->regex_search = $regexSearch;
				SearchFactory::_('Config')->component_id = $componentId;

				if (($number = SearchFactory::_('Agent')->replace()) !== 0)
				{
					return ['success' => Text::sprintf('COM_COMPONENTBUILDER_ALL_FOUND_INSTANCES_IN_S_WHERE_REPLACED', $tableName)];
				}
				return ['not_found' => Text::sprintf('COM_COMPONENTBUILDER_NO_INSTANCES_WHERE_FOUND_IN_S', $tableName)];
			}
			catch(Exception $error)
			{
				return ['error' => $error->getMessage()];
			}
		}
		return ['error' => Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Get a selected search value from a given table and row
	 *
	 * @param   string         $fieldName    The field key
	 * @param   int            $rowId        The item ID
	 * @param   string         $tableName    The table
	 * @param   string         $searchValue  The value to search for
	 * @param   string|null    $replaceValue The value to replace search value
	 * @param   int            $matchCase    The switch to control match case
	 * @param   int            $wholeWord    The switch to control whole word
	 * @param   int            $regexSearch  The switch to control regex search
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	public function getSearchValue(string $fieldName, int $rowId, string $tableName,
		string $searchValue, ?string $replaceValue, int $matchCase, int $wholeWord, int $regexSearch): array
	{
		// check if this is a valid table and field
		if ($rowId > 0 && SearchFactory::_('Table')->exist($tableName, $fieldName))
		{
			try
			{
				// load the configurations
				SearchFactory::_('Config')->table_name = $tableName;
				SearchFactory::_('Config')->type_search = 1;
				SearchFactory::_('Config')->search_value = $searchValue;
				SearchFactory::_('Config')->replace_value = $replaceValue;
				SearchFactory::_('Config')->match_case = $matchCase;
				SearchFactory::_('Config')->whole_word = $wholeWord;
				SearchFactory::_('Config')->regex_search = $regexSearch;

				if (($value = SearchFactory::_('Agent')->getValue($rowId, $fieldName, 0, $tableName)) !== null)
				{
					// load the value
					return ['value' => $value];
				}
			}
			catch(Exception $error)
			{
				return ['error' => $error->getMessage()];
			}
		}
		return ['error' => Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Get a replaced search value from a given table and row
	 *
	 * @param   string         $fieldName    The field key
	 * @param   int            $rowId        The item ID
	 * @param   mixed          $line         The line line
	 * @param   string         $tableName    The table
	 * @param   string         $searchValue  The value to search for
	 * @param   string|null    $replaceValue The value to replace search value
	 * @param   int            $matchCase    The switch to control match case
	 * @param   int            $wholeWord    The switch to control whole word
	 * @param   int            $regexSearch  The switch to control regex search
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	public function getReplaceValue(string $fieldName, int $rowId, $line, string $tableName,
		string $searchValue, ?string $replaceValue, int $matchCase, int $wholeWord, int $regexSearch): array
	{
		// check if this is a valid table and field
		if ($rowId > 0 && SearchFactory::_('Table')->exist($tableName, $fieldName))
		{
			try
			{
				// load the configurations
				SearchFactory::_('Config')->table_name = $tableName;
				SearchFactory::_('Config')->type_search = 2;
				SearchFactory::_('Config')->search_value = $searchValue;
				SearchFactory::_('Config')->replace_value = $replaceValue;
				SearchFactory::_('Config')->match_case = $matchCase;
				SearchFactory::_('Config')->whole_word = $wholeWord;
				SearchFactory::_('Config')->regex_search = $regexSearch;

				// load the value
				if (($value = SearchFactory::_('Agent')->getValue($rowId, $fieldName, $line, $tableName, true)) !== null)
				{
					return ['value' => $value];
				}
			}
			catch(Exception $error)
			{
				return ['error' => $error->getMessage()];
			}
		}
		return ['error' => Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Set selected search value in a given table and row
	 *
	 * @param   mixed        $value        The field value
	 * @param   int          $rowId        The item ID
	 * @param   string       $fieldName    The field key
	 * @param   string       $tableName    The table
	 *
	 * @return  array
	 * @since   3.2.0
	 **/
	public function setValue($value, int $rowId, string $fieldName, string $tableName): array
	{
		// check if this is a valid table and field
		if ($rowId > 0 && SearchFactory::_('Table')->exist($tableName, $fieldName) &&
			SearchFactory::_('Agent')->setValue($value, $rowId, $fieldName, $tableName))
		{
			return ['success' => Text::sprintf(
					'<b>%s</b> (%s:%s) was successfully updated!',
					$tableName, $rowId, $fieldName)];
		}
		return ['error' => Text::_('COM_COMPONENTBUILDER_THERE_HAS_BEEN_AN_ERROR_PLEASE_TRY_AGAIN')];
	}


	// Used in initialization_selection
	/**
	 * Method to get the target power
	 *
	 * @return  string|null
	 *
	 * @since   5.1.1
	 */
	protected function getTargetAreaPower($power): ?string
	{
		return $this->powers[$power] ?? null;
	}

	/**
	 * Method to get the power get class
	 *
	 * @param   string  $repo  The repo to list index
	 * @param   string  $area  The target area
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function getRepoIndex(string $repo, string $area): array
	{
		if (!GuidHelper::valid($repo))
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_REPO_SELECTED')];
		}

		if (($Power = $this->getTargetAreaPower($area)) === null)
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_AREA_SELECTED')];
		}

		try
		{
			$class = $this->getPowerClass($Power, "{$area}.Remote.Get");
			if ($class !== null)
			{
				$result = $class->list($repo);
			}
		}
		catch (\Exception $e)
		{
			return ['success' => false, 'message' => $e->getMessage()];
		}

		if (!empty($result))
		{
			foreach($result as &$values)
			{
				// ensure we don't leak the repo token
				if (isset($values->token))
				{
					$values->token = '***redacted***';
				}
			}

			return ['success' => true, 'index' => $result];
		}

		return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_THE_REPO_INDEX_FAILED_TO_LOAD_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Method to initialize the selected powers
	 *
	 * @param   string  $repo      The repo to list index
	 * @param   string  $area      The target area
	 * @param   array   $selected  The selected powers
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function initSelectedPowers(string $repo, string $area, array $selected): array
	{
		if (!GuidHelper::valid($repo))
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_REPO_SELECTED')];
		}

		if (($Power = $this->getTargetAreaPower($area)) === null)
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_AREA_SELECTED')];
		}

		$result = [];
		try
		{
			$class = $this->getPowerClass($Power, "{$area}.Remote.Get");
			if ($class !== null)
			{
				$repo_path = $class->path($repo);
				$result = $class->init($selected, $repo_path);
			}
		}
		catch (\Exception $e)
		{
			return ['success' => false, 'message' => $e->getMessage()];
		}

		if ($result !== [])
		{
			return ['success' => true, 'result_log' => $result];
		}

		return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_THE_REPO_INDEX_FAILED_TO_LOAD_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Method to initialize the selected packages
	 *
	 * @param   string  $repo      The repo to list index
	 * @param   string  $area      The target area
	 * @param   array   $selected  The selected powers
	 *
	 * @return  array
	 * @since   5.1.1
	 */
	public function initSelectedPackages(string $repo, string $area, array $selected): array
	{
		if (!GuidHelper::valid($repo))
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_REPO_SELECTED')];
		}

		if (($Power = $this->getTargetAreaPower($area)) === null)
		{
			return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_INVALID_AREA_SELECTED')];
		}

		$result = [];
		try
		{
			$class = $this->getPowerClass($Power, "Package.Builder.Get");
			$entity = $this->getPowerClass($Power, "{$area}.Remote.Get");
			if (!empty($selected) && $class !== null && $entity !== null)
			{
				$table = $entity->getTable();
				$repo_path = $entity->path($repo);
				$result = $class->init($table, $selected, $repo_path);
			}
		}
		catch (\Exception $e)
		{
			return ['success' => false, 'message' => $e->getMessage()];
		}

		if ($this->hasIntResults($result))
		{
			return ['success' => true, 'result_log' => $result];
		}

		return ['success' => false, 'message' => Text::_('COM_COMPONENTBUILDER_THE_INITIALIZATION_FAILED_PLEASE_TRY_AGAIN')];
	}

	/**
	 * Check if at least one key in the array has a non-empty value.
	 *
	 * @param array $data The result array (with 'local', 'not_found', 'added' keys)
	 *
	 * @return bool True if some values are non-empty; false if all are empty.
	 * @since  5.1.1
	 */
	protected static function hasIntResults(array $data): bool
	{
		return (bool) array_filter($data);
	}

	/**
	 * The powers that we can initialize
	 *
	 * @var    array
	 * @since  5.1.1
	 */
	protected array $powers = [
		'AdminView' => 'PackageFactory',
		'Component' => 'PackageFactory',
		'CustomAdminView' => 'PackageFactory',
		'CustomCode' => 'PackageFactory',
		'DynamicGet' => 'PackageFactory',
		'Field' => 'PackageFactory',
		'Joomla.Fieldtype' => 'FieldtypeFactory',
		'Joomla.Power' => 'JoomlaPowerFactory',
		'Layout' => 'PackageFactory',
		'Library' => 'PackageFactory',
		'JoomlaModule' => 'PackageFactory',
		'JoomlaPlugin' => 'PackageFactory',
		'Power' => 'PowerFactory',
		'SiteView' => 'PackageFactory',
		'Snippet' => 'SnippetFactory',
		'Template' => 'PackageFactory',
		'ClassExtends' => 'PackageFactory',
		'ClassProperty' => 'PackageFactory',
		'ClassMethod' => 'PackageFactory',
		'Placeholder' => 'PackageFactory',
		'Repository' => 'RepositoryFactory'
	];

	/**
	 * Method to get the power get class
	 *
	 * @param   string  $factoryName  The factory name
	 * @param   string  $getClass          The remote power class name
	 *
	 * @return  mixed
	 * @since   5.1.1
	 */
	protected function getPowerClass(string $factoryName, string $getClass)
	{
		return match ($factoryName) {
			'PowerFactory' => PowerFactory::_($getClass),
			'JoomlaPowerFactory' => JoomlaPowerFactory::_($getClass),
			'FieldtypeFactory' => FieldtypeFactory::_($getClass),
			'SnippetFactory' => SnippetFactory::_($getClass),
			'PackageFactory' => PackageFactory::_($getClass),
			'RepositoryFactory' => RepositoryFactory::_($getClass),
			default => null,
		};
	}
}
