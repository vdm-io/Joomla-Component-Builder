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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Component;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\AssetsTableInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Component\UninstallScript as ExtendingUninstallScript;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component\UninstallScriptInterface;


/**
 * Component Uninstall Script Class for Joomla 3.
 * 
 * The Joomla 3 target registers content types, fields and history for
 * its views, so its generated uninstall removes them table by table
 * before the shared assets table reversal and custom uninstall script.
 * 
 * @since  6.1.7
 */
final class UninstallScript extends ExtendingUninstallScript implements UninstallScriptInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * Constructor.
	 *
	 * @param Config                $config        The Config Class.
	 * @param Dispenser             $dispenser     The Dispenser Class.
	 * @param AssetsTableInterface  $assetstable   The AssetsTable Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Dispenser $dispenser, AssetsTableInterface $assetstable)
	{
		parent::__construct($dispenser, $assetstable);

		$this->config = $config;
	}

	/**
	 * Get the generated uninstall method body of the script.php.
	 *
	 * @param   array  $uninstallScriptBuilder  The views to remove, keyed by view code name.
	 * @param   array  $uninstallScriptFields   The views that have field relations.
	 *
	 * @return  string  The generated uninstall script.
	 *
	 * @since   6.1.7
	 */
	public function get(array $uninstallScriptBuilder = [], array $uninstallScriptFields = []): string
	{
		$this->uninstallScriptBuilder = $uninstallScriptBuilder;
		$this->uninstallScriptFields = $uninstallScriptFields;

		// reset script
		$script = '';
		if (isset($this->uninstallScriptBuilder)
			&& ArrayHelper::check(
				$this->uninstallScriptBuilder
			))
		{
			$component = $this->config->component_code_name;
			// start loading the data to delete
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Get Application object";
			$script .= PHP_EOL . Indent::_(2)
				. "\$app = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(2) . "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";

			foreach (
				$this->uninstallScriptBuilder as $viewsCodeName => $typeAlias
			)
			{
				// set a var value
				$view = StringHelper::safe($viewsCodeName);

				// check if it has field relations
				if (isset($this->uninstallScriptFields)
					&& isset($this->uninstallScriptFields[$viewsCodeName]))
				{
					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Select ids from fields";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->from(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Where " . $viewsCodeName . " context is found";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(2)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute query to see if context is found";
					$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $view
						. "_found = \$db->getNumRows();";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if there were any rows";
					$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
						. "_found)";
					$script .= PHP_EOL . Indent::_(2) . "{";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Since there are load the needed  " . $view
						. " field ids";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_field_ids = \$db->loadColumn();";

					// Now remove the actual type entry
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Remove " . $viewsCodeName
						. " from the field table";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " items";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The fields with type (" . $typeAlias
						. ") context was removed from the <b>#__fields</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Also Remove " . $viewsCodeName . " field values";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('field_id') . ' IN ('. implode(',', \$"
						. $view . "_field_ids) .')');";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields_values'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " field values";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The fields values for " . $viewsCodeName
						. " was removed from the <b>#__fields_values</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(2) . "}";

					// First check if data is till in table
					$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
						. Line::_(__Line__, __Class__)
						. " Create a new query object.";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Select ids from field groups";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->select(\$db->quoteName('id'));";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->from(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Where " . $viewsCodeName . " context is found";
					$script .= PHP_EOL . Indent::_(2)
						. "\$query->where( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(2)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute query to see if context is found";
					$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
					$script .= PHP_EOL . Indent::_(2) . "\$" . $view
						. "_found = \$db->getNumRows();";
					$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Now check if there were any rows";
					$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
						. "_found)";
					$script .= PHP_EOL . Indent::_(2) . "{";

					// Now remove the actual type entry
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Remove " . $viewsCodeName
						. " from the field groups table";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_condition = array( \$db->quoteName('context') . ' = '. \$db->quote('"
						. $typeAlias . "') );";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Create a new query object.";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query = \$db->getQuery(true);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$query->delete(\$db->quoteName('#__fields_groups'));";
					$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$"
						. $view . "_condition);";
					$script .= PHP_EOL . Indent::_(3)
						. "\$db->setQuery(\$query);";
					$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " Execute the query to remove " . $viewsCodeName
						. " items";
					$script .= PHP_EOL . Indent::_(3) . "\$" . $view
						. "_done = \$db->execute();";
					$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view
						. "_done)";
					$script .= PHP_EOL . Indent::_(3) . "{";
					$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
							__LINE__,__CLASS__
						) . " If successfully remove " . $viewsCodeName
						. " add queued success message.";
					// TODO lang is not translated
					$script .= PHP_EOL . Indent::_(4)
						. "\$app->enqueueMessage(Text:"
						. ":_('The field groups with type (" . $typeAlias
						. ") context was removed from the <b>#__fields_groups</b> table'));";
					$script .= PHP_EOL . Indent::_(3) . "}";
					$script .= PHP_EOL . Indent::_(2) . "}";
				}
				// First check if data is till in table
				$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Select id from content type table";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->select(\$db->quoteName('type_id'));";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->from(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Where " . $viewsCodeName . " alias is found";
				$script .= PHP_EOL . Indent::_(2)
					. "\$query->where( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute query to see if alias is found";
				$script .= PHP_EOL . Indent::_(2) . "\$db->execute();";
				$script .= PHP_EOL . Indent::_(2) . "\$" . $view
					. "_found = \$db->getNumRows();";
				$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Now check if there were any rows";
				$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view
					. "_found)";
				$script .= PHP_EOL . Indent::_(2) . "{";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Since there are load the needed  " . $view
					. " type ids";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_ids = \$db->loadColumn();";

				// Now remove the actual type entry
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Remove " . $viewsCodeName
					. " from the content type table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__content_types'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully remove " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__content_type</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// Now remove the related items from contentitem tag map table
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the contentitem tag map table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('type_alias') . ' = '. \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__contentitem_tag_map'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully remove " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__contentitem_tag_map</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// Now remove the related items from ucm content table
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the ucm content table";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_condition = array( \$db->quoteName('core_type_alias') . ' = ' . \$db->quote('"
					. $typeAlias . "') );";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(3)
					. "\$query->delete(\$db->quoteName('#__ucm_content'));";
				$script .= PHP_EOL . Indent::_(3) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(3) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(3) . "\$" . $view
					. "_done = \$db->execute();";
				$script .= PHP_EOL . Indent::_(3) . "if (\$" . $view . "_done)";
				$script .= PHP_EOL . Indent::_(3) . "{";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " If successfully removed " . $viewsCodeName
					. " add queued success message.";
				// TODO lang is not translated
				$script .= PHP_EOL . Indent::_(4)
					. "\$app->enqueueMessage(Joomla__"."_ba6326ef_cb79_4348_80f4_ab086082e3c5___Power::_('The (" . $typeAlias
					. ") type alias was removed from the <b>#__ucm_content</b> table'));";
				$script .= PHP_EOL . Indent::_(3) . "}";

				// setup the foreach loop of ids
				$script .= PHP_EOL . PHP_EOL . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__) . " Make sure that all the "
					. $viewsCodeName . " items are cleared from DB";
				$script .= PHP_EOL . Indent::_(3) . "foreach (\$" . $view
					. "_ids as \$" . $view . "_id)";
				$script .= PHP_EOL . Indent::_(3) . "{";

				// Now remove the related items from ucm base table
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Remove " . $viewsCodeName
					. " items from the ucm base table";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $view
					. "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$"
					. $view . "_id);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query->delete(\$db->quoteName('#__ucm_base'));";
				$script .= PHP_EOL . Indent::_(4) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(4) . "\$db->execute();";

				// Now remove the related items from ucm history table
				$script .= PHP_EOL . PHP_EOL . Indent::_(4) . "//"
					. Line::_(__Line__, __Class__) . " Remove " . $viewsCodeName
					. " items from the ucm history table";
				$script .= PHP_EOL . Indent::_(4) . "\$" . $view
					. "_condition = array( \$db->quoteName('ucm_type_id') . ' = ' . \$"
					. $view . "_id);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Create a new query object.";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query = \$db->getQuery(true);";
				$script .= PHP_EOL . Indent::_(4)
					. "\$query->delete(\$db->quoteName('#__ucm_history'));";
				$script .= PHP_EOL . Indent::_(4) . "\$query->where(\$" . $view
					. "_condition);";
				$script .= PHP_EOL . Indent::_(4) . "\$db->setQuery(\$query);";
				$script .= PHP_EOL . Indent::_(4) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Execute the query to remove " . $viewsCodeName
					. " items";
				$script .= PHP_EOL . Indent::_(4) . "\$db->execute();";

				$script .= PHP_EOL . Indent::_(3) . "}";

				$script .= PHP_EOL . Indent::_(2) . "}";
			}

			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " If All related items was removed queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . Indent::_(2) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__ucm_base</b> table'));";
			$script .= PHP_EOL . Indent::_(2) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__ucm_history</b> table'));";
			// finaly remove the assets from the assets table
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Remove " . $component . " assets from the assets table";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $component
				. "_condition = array( \$db->quoteName('name') . ' LIKE ' . \$db->quote('com_"
				. $component . "%') );";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Create a new query object.";
			$script .= PHP_EOL . Indent::_(2)
				. "\$query = \$db->getQuery(true);";
			$script .= PHP_EOL . Indent::_(2)
				. "\$query->delete(\$db->quoteName('#__assets'));";
			$script .= PHP_EOL . Indent::_(2) . "\$query->where(\$" . $component
				. "_condition);";
			$script .= PHP_EOL . Indent::_(2) . "\$db->setQuery(\$query);";
			$script .= PHP_EOL . Indent::_(2) . "\$" . $view
				. "_done = \$db->execute();";
			$script .= PHP_EOL . Indent::_(2) . "if (\$" . $view . "_done)";
			$script .= PHP_EOL . Indent::_(2) . "{";
			$script .= PHP_EOL . Indent::_(3) . "//" . Line::_(__Line__, __Class__)
				. " If successfully removed " . $component
				. " add queued success message.";
			// TODO lang is not translated
			$script .= PHP_EOL . Indent::_(3) . "\$app->enqueueMessage(Text:"
				. ":_('All related items was removed from the <b>#__assets</b> table'));";
			$script .= PHP_EOL . Indent::_(2) . "}";
			// done
			$script .= PHP_EOL;
		}
		elseif ($this->config->add_assets_table_fix == 2)
		{
			// start loading the data to delete (WE NEED THIS)
			$script .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Get Application object";
			$script .= PHP_EOL . Indent::_(2)
				. "\$app = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();";
			$script .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get The Database object";
			$script .= PHP_EOL . Indent::_(2) . "\$db = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getDbo();";
		}
		// add the Intelligent Reversal script if needed
		$script .= $this->assetstable->uninstall();
		// add the custom uninstall script
		$script .= $this->dispenser->get(
			'php_method', 'uninstall', "", null, true, null, PHP_EOL
		);

		return $script;
	}
}

