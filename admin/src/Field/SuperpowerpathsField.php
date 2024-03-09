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
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Form\Field\CheckboxesField;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\Component\Helper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Superpowerpaths Form Field class for the Componentbuilder component
 *
 * @since  1.6
 */
class SuperpowerpathsField extends CheckboxesField
{
	/**
	 * The superpowerpaths field type.
	 *
	 * @var        string
	 */
	public $type = 'Superpowerpaths';

	// A DynamicCheckboxes@ Field
	/**
	 * Method to get the data to be passed to the layout for rendering.
	 *
	 * @return  array
	 *
	 * @since   3.5
	 */
	protected function getLayoutData()
	{
		$data = parent::getLayoutData();

		// True if the field has 'value' set. In other words, it has been stored, don't use the default values.
		$hasValue = (isset($this->value) && !empty($this->value));

		// If a value has been stored, use it. Otherwise, use the defaults.
		$checkedOptions = $hasValue ? $this->value : $this->checkedOptions;

		// get the form options
		$options = [];

		// get the component params
		$params = Helper::getParams();
		$activate  = $params->get('super_powers_repositories', 0);

		// set the default
		$default = $params->get('super_powers_core', 'joomla/super-powers');

		// must have one / in the path
		if (strpos($default, '/') !== false)
		{
			$tmp = new \stdClass;
			$tmp->text = $tmp->value = trim($default);
			$tmp->checked = false;
			$options[$tmp->value] = $tmp;
		}

		if ($activate == 1)
		{
			$subform = $params->get($this->fieldname);

			// add the paths found in global settings
			if (is_object($subform))
			{
				foreach ($subform as $value)
				{
					if (isset($value->owner) && strlen($value->owner) > 1 &&
						isset($value->repo) && strlen($value->repo) > 1)
					{
						$tmp = new \stdClass;
						$tmp->text = $tmp->value = trim($value->owner) . '/' . trim($value->repo);
						$tmp->checked = false;

						$options[$tmp->value] = $tmp;
					}
				}
			}
		}

		$extraData = array(
			'checkedOptions' => is_array($checkedOptions) ? $checkedOptions : explode(',', (string) $checkedOptions),
			'hasValue'       => $hasValue,
			'options'        => array_values($options)
		);

		return array_merge($data, $extraData);
	}
}
