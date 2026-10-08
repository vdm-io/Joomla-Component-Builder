<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    19th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Language;


use Joomla\Filesystem\File as JoomlaFile;
use Joomla\Filesystem\Folder;
use Joomla\Filter\OutputFilter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Languages;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Multilingual as MultilingualRegistry;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Language\Multilingual;
use VDM\Joomla\Componentbuilder\Compiler\Language\Purge;
use VDM\Joomla\Componentbuilder\Compiler\Language\Set;
use VDM\Joomla\Componentbuilder\Compiler\Language\Translation;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\File;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\FileHelper;


/**
 * Language Files Class.
 * 
 * Collects every language string the four areas of a component were given,
 * keeps the component's own record of them in step, and writes each area's
 * strings into the ini file the built component ships them in.
 * 
 * A language the component has too little of is left out, which is what the
 * translation service decides, and the manifest only lists the files that
 * were written.
 * 
 * @since 6.1.7
 */
final class Files
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
	 * The Event Class.
	 *
	 * @var   Event
	 * @since 6.1.7
	 */
	protected Event $event;

	/**
	 * The Languages Builder Class.
	 *
	 * @var   Languages
	 * @since 6.1.7
	 */
	protected Languages $languages;

	/**
	 * The Multilingual Builder Class.
	 *
	 * @var   MultilingualRegistry
	 * @since 6.1.7
	 */
	protected MultilingualRegistry $multilingualregistry;

	/**
	 * The Language Multilingual Class.
	 *
	 * @var   Multilingual
	 * @since 6.1.7
	 */
	protected Multilingual $multilingual;

	/**
	 * The Language Set Class.
	 *
	 * @var   Set
	 * @since 6.1.7
	 */
	protected Set $set;

	/**
	 * The Language Purge Class.
	 *
	 * @var   Purge
	 * @since 6.1.7
	 */
	protected Purge $purge;

	/**
	 * The Language Translation Class.
	 *
	 * @var   Translation
	 * @since 6.1.7
	 */
	protected Translation $translation;

	/**
	 * The Admin Language Class.
	 *
	 * @var   Admin
	 * @since 6.1.7
	 */
	protected Admin $admin;

	/**
	 * The Admin System Language Class.
	 *
	 * @var   AdminSys
	 * @since 6.1.7
	 */
	protected AdminSys $adminsys;

	/**
	 * The Site Language Class.
	 *
	 * @var   Site
	 * @since 6.1.7
	 */
	protected Site $site;

	/**
	 * The Site System Language Class.
	 *
	 * @var   SiteSys
	 * @since 6.1.7
	 */
	protected SiteSys $sitesys;

	/**
	 * The Paths Class.
	 *
	 * @var   Paths
	 * @since 6.1.7
	 */
	protected Paths $paths;

	/**
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 6.1.7
	 */
	protected Counter $counter;

	/**
	 * The File Class.
	 *
	 * @var   File
	 * @since 6.1.7
	 */
	protected File $file;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param Config               $config               The Config Class.
	 * @param Component            $component            The Component Class.
	 * @param Event                $event                The Event Class.
	 * @param Languages            $languages            The Languages Builder Class.
	 * @param MultilingualRegistry $multilingualregistry The Multilingual Builder Class.
	 * @param Multilingual         $multilingual         The Language Multilingual Class.
	 * @param Set                  $set                  The Language Set Class.
	 * @param Purge                $purge                The Language Purge Class.
	 * @param Translation          $translation          The Language Translation Class.
	 * @param Admin                $admin                The Admin Language Class.
	 * @param AdminSys             $adminsys             The Admin System Language Class.
	 * @param Site                 $site                 The Site Language Class.
	 * @param SiteSys              $sitesys              The Site System Language Class.
	 * @param Paths                $paths                The Paths Class.
	 * @param Counter              $counter              The Counter Class.
	 * @param File                 $file                 The File Class.
	 * @param Placeholder          $placeholder          The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		Event $event,
		Languages $languages,
		MultilingualRegistry $multilingualregistry,
		Multilingual $multilingual,
		Set $set,
		Purge $purge,
		Translation $translation,
		Admin $admin,
		AdminSys $adminsys,
		Site $site,
		SiteSys $sitesys,
		Paths $paths,
		Counter $counter,
		File $file,
		Placeholder $placeholder)
	{
		$this->config = $config;
		$this->component = $component;
		$this->event = $event;
		$this->languages = $languages;
		$this->multilingualregistry = $multilingualregistry;
		$this->multilingual = $multilingual;
		$this->set = $set;
		$this->purge = $purge;
		$this->translation = $translation;
		$this->admin = $admin;
		$this->adminsys = $adminsys;
		$this->site = $site;
		$this->sitesys = $sitesys;
		$this->paths = $paths;
		$this->counter = $counter;
		$this->file = $file;
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the language values and insert into file
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function build(): void
	{
		// add final list of needed lang strings
		$componentName = $this->component->get('name');
		$componentName = OutputFilter::cleanText($componentName);
		$langTag = $this->config->get('lang_tag', 'en-GB');

		// Trigger Event: jcb_ce_onBeforeLoadingAllLangStrings
		$this->event->trigger(
			'jcb_ce_onBeforeLoadingAllLangStrings', [&$componentName]
		);

		// reset values
		$values         = [];
		$mainLangLoader = [];
		// check the admin lang is set
		if ($this->admin->get($componentName))
		{
			$values[]                = array_values(
				$this->languages->get("components.{$langTag}.admin")
			);
			$mainLangLoader['admin'] = count(
				$this->languages->get("components.{$langTag}.admin")
			);
		}
		// check the admin system lang is set
		if ($this->adminsys->get())
		{
			$values[]                   = array_values(
				$this->languages->get("components.{$langTag}.adminsys")
			);
			$mainLangLoader['adminsys'] = count(
				$this->languages->get("components.{$langTag}.adminsys")
			);
		}
		// check the site lang is set
		if ((!$this->config->remove_site_folder || !$this->config->remove_site_edit_folder)
			&& $this->site->get($componentName))
		{
			$values[]               = array_values(
				$this->languages->get("components.{$langTag}.site")
			);
			$mainLangLoader['site'] = count(
				$this->languages->get("components.{$langTag}.site")
			);
		}
		// check the site system lang is set
		if ((!$this->config->remove_site_folder || !$this->config->remove_site_edit_folder)
			&& $this->sitesys->get($componentName))
		{
			$values[]                  = array_values(
				$this->languages->get("components.{$langTag}.sitesys")
			);
			$mainLangLoader['sitesys'] = count(
				$this->languages->get("components.{$langTag}.sitesys")
			);
		}
		$values = array_unique(ArrayHelper::merge($values));
		// get the other lang strings if there is any
		$this->multilingualregistry->set('components',
			$this->multilingual->get($values)
		);
		// update insert the current lang in to DB
		$this->set->execute($values, $this->config->component_guid);
		// remove old unused language strings
		$this->purge->execute($values, $this->config->component_guid);
		// path to INI file
		$getPAth = $this->paths->template_path . '/en-GB.com_admin.ini';

		// Trigger Event: jcb_ce_onBeforeBuildAllLangFiles
		$this->event->trigger(
			'jcb_ce_onBeforeBuildAllLangFiles', ['components']
		);

		// now we insert the values into the files
		if ($this->languages->IsArray("components"))
		{
			// rest xml array
			$langXML = [];
			foreach ($this->languages->get("components") as $tag => $areas)
			{
				// trim the tag
				$tag = trim((string) $tag);
				foreach ($areas as $area => $languageStrings)
				{
					// set naming convention
					$p = 'admin';
					$t = '';
					if (strpos((string) $area, 'site') !== false)
					{
						if ($this->config->remove_site_folder
							&& $this->config->remove_site_edit_folder)
						{
							continue;
						}
						$p = 'site';
					}
					if (strpos((string) $area, 'sys') !== false)
					{
						$t = '.sys';
					}
					// build the file name
					$file_name = $tag . '.com_' . $this->config->component_code_name . $t
						. '.ini';
					// check if language should be added
					if ($this->translation->check(
						$tag, $languageStrings, $mainLangLoader[$area],
						$file_name
					))
					{
						// build the path to place the lang file
						$path = $this->paths->component_path . '/' . $p . '/language/'
							. $tag . '/';
						if (!is_dir($path))
						{
							Folder::create($path);
							// count the folder created
							$this->counter->folder++;
						}
						// move the file to its place
						JoomlaFile::copy($getPAth, $path . $file_name);
						// count the file created
						$this->counter->file++;
						// add content to it
						$lang = array_map(
							fn($langstring, $placeholder) => $placeholder . '="' . $langstring . '"',
							array_values($languageStrings),
							array_keys($languageStrings)
						);
						// add to language file
						$this->file->write(
							$path . $file_name, implode(PHP_EOL, $lang)
						);
						// set the line counter
						$this->counter->line += count(
								(array) $lang
							);
						unset($lang);
						// build xml strings
						if (!isset($langXML[$p]))
						{
							$langXML[$p] = [];
						}
						$langXML[$p][] = '<language tag="' . $tag
							. '">language/'
							. $tag . '/' . $file_name . '</language>';
					}
				}
			}
			// load the lang xml
			if (ArrayHelper::check($langXML))
			{
				$replace = [];
				if (isset($langXML['admin'])
					&& ArrayHelper::check($langXML['admin']))
				{
					$replace[Placefix::_h('ADMIN_LANGUAGES')]
						= implode(PHP_EOL . Indent::_(3), $langXML['admin']);
				}
				if ((!$this->config->remove_site_folder || !$this->config->remove_site_edit_folder)
					&& isset($langXML['site'])
					&& ArrayHelper::check($langXML['site']))
				{
					$replace[Placefix::_h('SITE_LANGUAGES')]
						= implode(PHP_EOL . Indent::_(2), $langXML['site']);
				}
				// build xml path
				$xmlPath = $this->paths->component_path . '/' . $this->config->component_code_name
					. '.xml';
				// get the content in xml
				$componentXML = FileHelper::getContent(
					$xmlPath
				);
				// update the xml content
				$componentXML = $this->placeholder->update($componentXML, $replace);
				// store the values back to xml
				$this->file->write($xmlPath, $componentXML);
			}
		}
	}
}

