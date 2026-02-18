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
namespace VDM\Component\Componentbuilder\Administrator\Field;

use Joomla\CMS\Factory;
use Joomla\CMS\Form\Field\ListField;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use Joomla\Database\DatabaseInterface;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Lang Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class LangField extends ListField
{
	/**
	 * The lang field type.
	 *
	 * @var        string
	 */
	public $type = 'Lang';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array    An array of Html options.
	 * @since   1.6
	 */
	protected function getOptions()
	{
				$db = Factory::getContainer()
			->get(DatabaseInterface::class);

		$query = $db->getQuery(true);
		$query->select(
			$db->quoteName(
				['a.langtag', 'a.name'],
				['langtag', 'language_name']
			)
		);
		$query->from($db->quoteName('#__componentbuilder_language', 'a'));
		$query->where($db->quoteName('a.published') . ' >= 1');
		$query->order('a.langtag ASC');
		$db->setQuery((string) $query);

		$items = $db->loadObjectList();

		$mainLangRaw = ComponentHelper::getParams('com_componentbuilder')->get('language', 'en-GB');
		$mainLang = trim((string) $mainLangRaw);
		if ($mainLang === '')
		{
			$mainLang = 'en-GB';
		}

		$normalize = static function (string $value): string
		{
			$value = trim($value);

			// Normalize to canonical Joomla style: xx-YY
			$value = str_replace('_', '-', $value);

			$value = strtolower($value);

			if (strpos($value, '-') !== false)
			{
				[$a, $b] = explode('-', $value, 2);

				$value = strtolower($a) . '-' . strtoupper($b);
			}

			return $value;
		};

		// Normalized main language
		$mainLangNorm = $normalize($mainLang);

		$options = [];

		/**
		 * Tracks normalized language codes that were added.
		 * Prevents duplicates under all circumstances.
		 *
		 * @var array<string,bool>
		 */
		$added = [];

		// Default option
		$options[] = Html::_(
			'select.option',
			'',
			'Select an option'
		);

		if (!empty($items))
		{
			foreach ($items as $item)
			{
				$rawId = trim((string) $item->langtag);

				if ($rawId === '')
				{
					continue;
				}

				$normId = $normalize($rawId);

				// Skip if already added (absolute safety)
				if (isset($added[$normId]))
				{
					continue;
				}

				$options[] = Html::_(
					'select.option',
					$rawId,
					$item->language_name . ' (' . $rawId . ')'
				);

				$added[$normId] = true;
			}
		}

		if (!isset($added[$mainLangNorm]))
		{
			if ($mainLangNorm === 'en-GB')
			{
				$label = 'English GB (' . $mainLang . ')';
			}
			else
			{
				$label = 'Main Language (' . $mainLang . ')';
			}

			$options[] = Html::_(
				'select.option',
				$mainLang,
				$label
			);

			$added[$mainLangNorm] = true;
		}

		return $options;
	}
}
