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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Component;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\ContentTypes as SharedContentTypes;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Joomla 3 Component Content Types Class.
 * 
 * Joomla 3 has no script.php helper to hand a content type to, so the
 * generated code assembles each row itself and inserts it, updating the row it
 * finds when the component is updating rather than installing.
 * 
 * What a row carries differs too: the table it names is the Joomla 3 JTable
 * pair, the route is the component's own helper method, and the history
 * options read a form out of the models folder and hide the version column.
 * 
 * @since  6.1.7
 */
final class ContentTypes extends SharedContentTypes
{
	/**
	 * Build the generated code that declares the collected content types.
	 *
	 * @param   string  $action   Whether the component is installing or updating.
	 * @param   array   $dbStuff  The declarations, keyed by what they declare.
	 *
	 * @return  string  The generated code, or nothing when nothing was collected.
	 *
	 * @since   6.1.7
	 */
	protected function script(string $action, array $dbStuff): string
	{
		// build the db insert query
		if (ArrayHelper::check($dbStuff))
		{
			$script = '';
			$taabb = '';
			if ($action === 'update')
			{
				$taabb = Indent::_(1);
			}
			$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(3)
				. "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";
			foreach ($dbStuff as $name => $tables)
			{
				if (ArrayHelper::check($tables))
				{
					$code   = StringHelper::safe($name);
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " Create the " . $name
						. " content type object.";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $code
						. " = new \stdClass();";
					foreach ($tables as $table => $data)
					{
						$script .= PHP_EOL . Indent::_(3) . "\$" . $code
							. "->" . $table . " = '" . $data . "';";
					}
					if ($action === 'update')
					{
						// we first load script to check if data exist
						$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
							. Line::_(__Line__, __Class__) . " Check if "
							. $name
							. " type is already in content_type DB.";
						$script .= PHP_EOL . Indent::_(3) . "\$" . $code
							. "_id = null;";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query = \$db->getQuery(true);";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->select(\$db->quoteName(array('type_id')));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->from(\$db->quoteName('#__content_types'));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$query->where(\$db->quoteName('type_alias') . ' LIKE '. \$db->quote($"
							. $code . "->type_alias));";
						$script .= PHP_EOL . Indent::_(3)
							. "\$db->setQuery(\$query);";
						$script .= PHP_EOL . Indent::_(3)
							. "\$db->execute();";
					}
					$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__)
						. " Set the object into the content types table.";
					if ($action === 'update')
					{
						$script .= PHP_EOL . Indent::_(3)
							. "if (\$db->getNumRows())";
						$script .= PHP_EOL . Indent::_(3) . "{";
						$script .= PHP_EOL . Indent::_(4) . "\$" . $code
							. "->type_id = \$db->loadResult();";
						$script .= PHP_EOL . Indent::_(4) . "\$" . $code
							. "_Updated = \$db->updateObject('#__content_types', \$"
							. $code . ", 'type_id');";
						$script .= PHP_EOL . Indent::_(3) . "}";
						$script .= PHP_EOL . Indent::_(3) . "else";
						$script .= PHP_EOL . Indent::_(3) . "{";
					}
					$script .= PHP_EOL . Indent::_(3) . $taabb . "\$"
						. $code
						. "_Inserted = \$db->insertObject('#__content_types', \$"
						. $code . ");";
					if ($action === 'update')
					{
						$script .= PHP_EOL . Indent::_(3) . "}";
					}
				}
			}

			$script .= PHP_EOL . PHP_EOL;
			return $script;
		}

		return '';
	}

	/**
	 * Add the table declaration, and whatever a target says beside it.
	 *
	 * @param   array   $array      The declaration being built.
	 * @param   string  $component  The component code name.
	 * @param   string  $view       The single view code name.
	 * @param   string  $View       The single view code name, capitalised.
	 *
	 * @return  array  The declaration, with the table added in its own place.
	 *
	 * @since   6.1.7
	 */
	protected function tableColumns(array $array, string $component, string $view,
		string $View): array
	{
		// set the table
		$array['table'] = '{"special": {"dbtable": "#__' . $component . '_'
			. $view . '","key": "id","type": "' . $View . '","prefix": "'
			. $component
			. 'Table","config": "array()"},"common": {"dbtable": "#__ucm_content","key": "ucm_id","type": "Corecontent","prefix": "JTable","config": "array()"}}';

		return $array;
	}

	/**
	 * Build the route this content type is reached by.
	 *
	 * @param   string  $Component  The component code name, capitalised.
	 * @param   string  $View       The single view code name, capitalised.
	 *
	 * @return  string  The component helper route method of this view.
	 *
	 * @since   6.1.7
	 */
	protected function router(string $Component, string $View): string
	{
		return $Component . 'HelperRoute::get' . $View . 'Route';
	}

	/**
	 * Build the head of the content history options, up to the hidden fields.
	 *
	 * @param   string  $component  The component code name.
	 * @param   string  $view       The single view code name.
	 *
	 * @return  string  The form file this view's history reads, and the fields it always hides.
	 *
	 * @since   6.1.7
	 */
	protected function historyHead(string $component, string $view): string
	{
		return '{"formFile": "administrator/components/com_' . $component
			. '/models/forms/' . $view
			. '.xml","hideFields": ["asset_id","checked_out","checked_out_time","version"';
	}

	/**
	 * Add whatever a target says beside the category table declaration.
	 *
	 * @param   array  $array  The declaration being built.
	 *
	 * @return  array  The declaration, which Joomla 3 leaves as it found it.
	 *
	 * @since   6.1.7
	 */
	protected function categoryTableColumns(array $array): array
	{
		return $array;
	}

	/**
	 * Build the route a category content type is reached by.
	 *
	 * @param   string  $Component  The component code name, capitalised.
	 *
	 * @return  string  The component helper category route method.
	 *
	 * @since   6.1.7
	 */
	protected function categoryRouter(string $Component): string
	{
		return $Component . 'HelperRoute::getCategoryRoute';
	}

	/**
	 * Build the content history options of a category content type.
	 *
	 * @return  string  The options, which name the core category form.
	 *
	 * @since   6.1.7
	 */
	protected function categoryHistory(): string
	{
		return '{"formFile":"administrator\/components\/com_categories\/models\/forms\/category.xml", "hideFields":["asset_id","checked_out","checked_out_time","version","lft","rgt","level","path","extension"], "ignoreChanges":["modified_user_id", "modified_time", "checked_out", "checked_out_time", "version", "hits", "path"],"convertToInt":["publish_up", "publish_down"], "displayLookup":[{"sourceColumn":"created_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"access","targetTable":"#__viewlevels","targetColumn":"id","displayColumn":"title"},{"sourceColumn":"modified_user_id","targetTable":"#__users","targetColumn":"id","displayColumn":"name"},{"sourceColumn":"parent_id","targetTable":"#__categories","targetColumn":"id","displayColumn":"title"}]}';
	}
}

