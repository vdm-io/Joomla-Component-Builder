<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Language;


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Languages;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;


/**
 * Language Admin Class.
 * 
 * Registers every language string the administrator side of a component
 * needs: its own name and description, the labels of its views and their
 * permissions, and the messages the installer and the dashboard show.
 * 
 * @since  6.1.7
 */
final class Admin
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The Languages Class.
	 *
	 * @var   Languages
	 * @since 6.1.7
	 */
	protected Languages $languages;

	/**
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 6.1.7
	 */
	protected Event $event;

	/**
	 * Constructor.
	 *
	 * @param Config     $config     The Config Class.
	 * @param Component  $component  The Component Class.
	 * @param Language   $language   The Language Class.
	 * @param Languages  $languages  The Languages Class.
	 * @param Event      $event      The Event Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		Language $language,
		Languages $languages,
		Event $event)
	{
		$this->config = $config;
		$this->component = $component;
		$this->language = $language;
		$this->languages = $languages;
		$this->event = $event;
	}

	/**
	 * Register every language string the administrator side needs.
	 *
	 * @param   string  $componentName  The component name.
	 *
	 * @return  bool
	 *
	 * @since   6.1.7
	 */
	public function get(string $componentName): bool
	{
		// Trigger Event: jcb_ce_onBeforeBuildAdminLang
		$this->event->trigger(
			'jcb_ce_onBeforeBuildAdminLang'
		);

		// start loading the defaults
		$this->language->set('adminsys', $this->config->lang_prefix, $componentName);
		$this->language->set(
			'adminsys', $this->config->lang_prefix . '_CONFIGURATION',
			$componentName . ' Configuration'
		);
		$this->language->set('admin', $this->config->lang_prefix, $componentName);
		$this->language->set('admin', $this->config->lang_prefix . '_BACK', 'Back');
		$this->language->set(
			'admin', $this->config->lang_prefix . '_DASH', 'Dashboard'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_VERSION', 'Version'
		);
		$this->language->set('admin', $this->config->lang_prefix . '_DATE', 'Date');
		$this->language->set('admin', $this->config->lang_prefix . '_AUTHOR', 'Author');
		$this->language->set(
			'admin', $this->config->lang_prefix . '_WEBSITE', 'Website'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_LICENSE', 'License'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_CONTRIBUTORS', 'Contributors'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_CONTRIBUTOR', 'Contributor'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_DASHBOARD',
			$componentName . ' Dashboard'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_SAVE_SUCCESS',
			"Great! Item successfully saved."
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_SAVE_WARNING',
			"The value already existed so please select another."
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_HELP_MANAGER', "Help"
		);
		$this->language->set('admin', $this->config->lang_prefix . '_NEW', "New");
		$this->language->set(
			'admin', $this->config->lang_prefix . '_CLOSE_NEW', "Close & New"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_CREATE_NEW_S', "Create New %s"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_EDIT_S', "Edit %s"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_KEEP_ORIGINAL_STATE',
			"- Keep Original State -"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_KEEP_ORIGINAL_ACCESS',
			"- Keep Original Access -"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_KEEP_ORIGINAL_CATEGORY',
			"- Keep Original Category -"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_PUBLISHED', 'Published'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_INACTIVE', 'Inactive'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_ARCHIVED', 'Archived'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_TRASHED', 'Trashed'
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_NO_ACCESS_GRANTED',
			"No Access Granted!"
		);
		$this->language->set(
			'admin', $this->config->lang_prefix . '_NOT_FOUND_OR_ACCESS_DENIED',
			"Not found or access denied!"
		);

		if ($this->component->get('add_license')
			&& $this->component->get('license_type') == 3)
		{
			$this->language->set(
				'admin', 'NIE_REG_NIE',
				"<br /><br /><center><h1>License not set for " . $componentName
				. ".</h1><p>Notify your administrator!<br />The license can be obtained from <a href='"
				. $this->component->get('whmcs_buy_link') . "' target='_blank'>"
				. $this->component->get('companyname') . "</a>.</p></center>"
			);
		}

		// add the langug files needed to import and export data
		if ($this->config->get('add_eximport', false))
		{
			$this->language->set(
				'admin', $this->config->lang_prefix . '_EXPORT_FAILED', "Export Failed"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FAILED', "Import Failed"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_TITLE', "Data Importer"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_NO_IMPORT_TYPE_FOUND',
				"Import type not found."
			);
			$this->language->set(
				'admin',
				$this->config->lang_prefix . '_IMPORT_UNABLE_TO_FIND_IMPORT_PACKAGE',
				"Package to import not found."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_ERROR', "Import error."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_SUCCESS',
				"Great! Import successful."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_MSG_WARNIMPORTFILE',
				"Warning, import file error."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_MSG_NO_FILE_SELECTED',
				"No import file selected."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_A_FILE',
				"Please select a file to import."
			);
			$this->language->set(
				'admin',
				$this->config->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_ALL_COLUMNS',
				"Please link all columns."
			);
			$this->language->set(
				'admin',
				$this->config->lang_prefix . '_IMPORT_MSG_PLEASE_SELECT_A_DIRECTORY',
				"Please enter the file directory."
			);
			$this->language->set(
				'admin',
				$this->config->lang_prefix . '_IMPORT_MSG_WARNIMPORTUPLOADERROR',
				"Warning, import upload error."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix
				. '_IMPORT_MSG_PLEASE_ENTER_A_PACKAGE_DIRECTORY',
				"Please enter the file directory."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix
				. '_IMPORT_MSG_PATH_DOES_NOT_HAVE_A_VALID_PACKAGE',
				"Path does not have a valid file."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix
				. '_IMPORT_MSG_DOES_NOT_HAVE_A_VALID_FILE_TYPE',
				"Does not have a valid file type."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_MSG_ENTER_A_URL',
				"Please enter a url."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_MSG_INVALID_URL',
				"Invalid url."
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_CONTINUE', "Continue"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FROM_UPLOAD', "Upload"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_SELECT_FILE',
				"Select File"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_UPLOAD_BOTTON',
				"Upload File"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FROM_DIRECTORY',
				"Directory"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_SELECT_FILE_DIRECTORY',
				"Set the path to file"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_GET_BOTTON', "Get File"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FROM_URL', "URL"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_SELECT_FILE_URL',
				"Enter file URL"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_UPDATE_DATA',
				"Import Data"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FORMATS_ACCEPTED',
				"formats accepted"
			);
			$this->language->set(
				'admin',
				$this->config->lang_prefix . '_IMPORT_LINK_FILE_TO_TABLE_COLUMNS',
				"Link File to Table Columns"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_TABLE_COLUMNS',
				"Table Columns"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_FILE_COLUMNS',
				"File Columns"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_PLEASE_SELECT_COLUMN',
				"-- Please Select Column --"
			);
			$this->language->set(
				'admin', $this->config->lang_prefix . '_IMPORT_IGNORE_COLUMN',
				"-- Ignore This Column --"
			);
		}

		// check if the both array is set
		if ($this->language->exist('both'))
		{
			foreach ($this->language->getTarget('both') as $keylang => $langval)
			{
				$this->language->set('admin', $keylang, $langval);
			}
		}

		// check if the both admin array is set
		if ($this->language->exist('bothadmin'))
		{
			foreach ($this->language->getTarget('bothadmin') as $keylang => $langval)
			{
				$this->language->set('admin', $keylang, $langval);
			}
		}

		if ($this->language->exist('admin'))
		{
			// Trigger Event: jcb_ce_onAfterBuildAdminLang
			$this->event->trigger(
				'jcb_ce_onAfterBuildAdminLang'
			);
			// get language content
			$langContent = $this->language->getTarget('admin');
			// sort the strings
			ksort($langContent);
			// load to global languages
			$langTag = $this->config->get('lang_tag', 'en-GB');
			$this->languages->set(
				"components.{$langTag}.admin",
				$langContent
			);
			// remove tmp array
			$this->language->setTarget('admin', null);

			return true;
		}

		return false;
	}
}

