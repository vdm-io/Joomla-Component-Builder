<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplicationInterface as CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Admin View Site Menu Class.
 * 
 * Builds the site `edit.xml` menu metadata for an admin view whose items
 * can be edited from the site area, registering the menu language keys
 * and the metadata file in the build structure.
 * 
 * @since  6.1.7
 */
final class AdminView
{
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
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The CMS Application.
	 *
	 * @var   CMSApplication
	 * @since 6.1.7
	 */
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Config                $config      The Config Class.
	 * @param Language              $language    The Language Class.
	 * @param Structure             $structure   The Structure Class.
	 * @param CMSApplication|null   $app         The CMS Application object.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Language $language,
		Structure $structure, ?CMSApplication $app = null)
	{
		$this->config = $config;
		$this->language = $language;
		$this->structure = $structure;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Get the admin view site menu metadata XML.
	 *
	 * When the menu file cannot be added to the build structure a warning
	 * is enqueued and an empty string is returned.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   array   $view            The view definition with its settings object.
	 *
	 * @return  string  The menu metadata XML, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(string $nameSingleCode, array $view): string
	{
		$xml = '';
		// build the file target values
		$target = array('site' => $nameSingleCode);
		// build the edit.xml file
		if ($this->structure->build($target, 'admin_menu'))
		{
			// set the lang
			$lang = StringHelper::safe(
				'com_' . $this->config->component_code_name . '_menu_'
				. $nameSingleCode,
				'U'
			);
			$this->language->set(
				'adminsys', $lang . '_TITLE',
				'Create ' . $view['settings']->name_single
			);
			$this->language->set(
				'adminsys', $lang . '_OPTION',
				'Create ' . $view['settings']->name_single
			);
			$this->language->set(
				'adminsys', $lang . '_DESC',
				$view['settings']->short_description
			);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . Indent::_(1) . '<layout title="' . $lang
				. '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . Indent::_(2) . '<message>';
			$xml .= PHP_EOL . Indent::_(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . Indent::_(2) . '</message>';
			$xml .= PHP_EOL . Indent::_(1) . '</layout>';
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(
				Text::sprintf(
					'<hr /><p>Site menu for <b>%s</b> was not build.</p>',
					$nameSingleCode
				), 'Warning'
			);
		}

		return $xml;
	}
}

