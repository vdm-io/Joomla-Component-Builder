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

namespace VDM\Joomla\Componentbuilder\Compiler\Language;


use Joomla\CMS\Factory;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Multilingual;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Languages;
use VDM\Joomla\Componentbuilder\Compiler\Language\Insert;
use VDM\Joomla\Componentbuilder\Compiler\Language\Update;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\JsonHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\MathHelper;


/**
 * Compiler Set Language Strings
 * 
 * @since 5.0.2
 */
final class Set
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.0.2
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 5.0.2
	 */
	protected Language $language;

	/**
	 * The Multilingual Class.
	 *
	 * @var   Multilingual
	 * @since 5.0.2
	 */
	protected Multilingual $multilingual;

	/**
	 * The Languages Class.
	 *
	 * @var   Languages
	 * @since 5.0.2
	 */
	protected Languages $languages;

	/**
	 * The Insert Class.
	 *
	 * @var   Insert
	 * @since 5.0.2
	 */
	protected Insert $insert;

	/**
	 * The Update Class.
	 *
	 * @var   Update
	 * @since 5.0.2
	 */
	protected Update $update;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param Language       $language       The Language Class.
	 * @param Messages       $messages       The Language Messages Class.
	 * @param Multilingual   $multilingual   The Multilingual Class.
	 * @param Languages      $languages      The Languages Class.
	 * @param Insert         $insert         The Insert Class.
	 * @param Update         $update         The Update Class.
	 *
	 * @since 5.0.2
	 */
	public function __construct(Config $config, Language $language,
		Multilingual $multilingual, Languages $languages,
		Insert $insert, Update $update)
	{
		$this->config = $config;
		$this->language = $language;
		$this->multilingual = $multilingual;
		$this->languages = $languages;
		$this->insert = $insert;
		$this->update = $update;
	}

	/**
	 * Set the current language values to the database.
	 *
	 * This method inserts or updates language strings in the database based on the current state.
	 *
	 * @param array  $strings The language strings to process.
	 * @param int $target_id  The target component ID.
	 * @param string $target The target extension type (default is 'components').
	 *
	 * @return void
	 * @since 5.0.2
	 */
	public function execute(array $strings, int $target_id, string $target = 'components'): void
	{
		$counterInsert = 0;
		$counterUpdate = 0;
		$today = Factory::getDate()->toSql();
		$langTag = $this->config->get('lang_tag', 'en-GB');
		$multiLangString = $this->multilingual->get($target, []);

		foreach ($this->languages->get("{$target}.{$langTag}") as $area => $placeholders)
		{
			foreach ($placeholders as $placeholder => $string)
			{
				if (StringHelper::check($string))
				{
					$this->processString(
						$string, $strings, $area, $placeholder, $multiLangString, $target, $target_id, $today, $counterInsert, $counterUpdate
					);
				}
			}
		}

		$this->multilingual->set($target, $multiLangString);
		$this->update->execute();
		$this->insert->execute($target);
	}

	/**
	 * Process an individual language string for database update or insert.
	 *
	 * @param string $string           The language string to process.
	 * @param array  $strings          The language strings array.
	 * @param string $area             The targeted area.
	 * @param string $placeholder      The placeholder.
	 * @param array  &$multiLangString The multilingual string array.
	 * @param string $target           The target extension type.
	 * @param int    $target_id        The target component ID.
	 * @param string $today            The current date.
	 * @param int    &$counterInsert   The insert counter.
	 * @param int    &$counterUpdate   The update counter.
	 *
	 * @return void
	 * @since 5.0.2
	 */
	protected function processString(string $string, array &$strings, string $area,
		string $placeholder, array &$multiLangString, string $target,
		int $target_id, string $today, int &$counterInsert, int &$counterUpdate): void
	{
		$remove = false;

		if (isset($multiLangString[$string]))
		{
			if (isset($multiLangString[$string]['translation']) && JsonHelper::check($multiLangString[$string]['translation']))
			{
				$multiLangString[$string]['translation'] = json_decode((string) $multiLangString[$string]['translation'], true);
			}

			if (isset($multiLangString[$string]['translation']) && ArrayHelper::check($multiLangString[$string]['translation']))
			{
				foreach ($multiLangString[$string]['translation'] as $translations)
				{
					if (isset($translations['language']) && isset($translations['translation']))
					{
						$multiLangTag = $translations['language'];
						$this->languages->set("{$target}.{$multiLangTag}.{$area}.{$placeholder}", $this->language->fix($translations['translation']));
					}
				}
			}
			else
			{
				$remove = true;
			}
		}

		if (StringHelper::check($string) && ($key = array_search($string, $strings)) !== false)
		{
			$this->updateOrInsertString($string, $multiLangString, $target, $target_id, $today, $counterInsert, $counterUpdate);

			if ($remove)
			{
				unset($multiLangString[$string]);
			}

			unset($strings[$key]);
		}
	}

	/**
	 * Update or insert a language string in the database.
	 *
	 * @param string $string           The language string to update or insert.
	 * @param array  &$multiLangString The multilingual string array.
	 * @param string $target           The target extension type.
	 * @param int    $target_id        The target component ID.
	 * @param string $today            The current date.
	 * @param int    &$counterInsert   The insert counter.
	 * @param int    &$counterUpdate   The update counter.
	 *
	 * @return void
	 * @since 5.0.2
	 */
	protected function updateOrInsertString(string $string, array &$multiLangString, string $target, int $target_id, string $today, int &$counterInsert, int &$counterUpdate): void
	{
		if (isset($multiLangString[$string]))
		{
			$id = $multiLangString[$string]['id'];
			$targets = $this->getTargets($multiLangString[$string], $target, $target_id);

			$this->update->set($id, $target, $targets, 1, $today, $counterUpdate);

			$counterUpdate++;

			$this->update->execute(50);
		}
		else
		{
			$this->insert->set($target, $counterInsert, json_encode([$target_id]));
			$this->insert->set($target, $counterInsert, $string);
			$this->insert->set($target, $counterInsert, 1);
			$this->insert->set($target, $counterInsert, $today);
			$this->insert->set($target, $counterInsert, 1);
			$this->insert->set($target, $counterInsert, 1);
			$this->insert->set($target, $counterInsert, 1);

			$counterInsert++;

			$this->insert->execute($target, 100);
		}
	}

	/**
	 * Get targets for a given string.
	 *
	 * @param array  $multiLangString  The multilingual string array.
	 * @param string $target           The target extension type.
	 * @param int    $target_id        The target component ID.
	 *
	 * @return array The updated targets array.
	 * @since 5.0.2
	 */
	protected function getTargets(array $multiLangString, string $target, int $target_id): array
	{
		if (JsonHelper::check($multiLangString[$target]))
		{
			$targets = (array) json_decode((string) $multiLangString[$target], true);
			if (!in_array($target_id, $targets))
			{
				$targets[] = $target_id;
			}
		}
		else
		{
			$targets = [$target_id];
		}

		return $targets;
	}
}

