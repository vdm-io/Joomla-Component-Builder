<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Model;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Creator\Permission;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Model\FieldRelation;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodEximportString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ItemsMethodListString;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertFieldInitiator;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FieldRelations;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\PermissionFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SelectionTranslation;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Model\ItemsStringFixInterface;


/**
 * Model Items String Fix Class.
 * 
 * Generates everything a list model does to its items after loading them:
 * decodes and escapes stored values, resolves related and expert fields,
 * applies access checks to permission-guarded fields, and attaches tags.
 * 
 * Only how the current user is obtained differs between Joomla targets, so
 * that is the extension point the target variants override.
 * 
 * @since  6.1.7
 */
class ItemsStringFix implements ItemsStringFixInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * The Customcode Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 6.1.7
	 */
	protected Dispenser $dispenser;

	/**
	 * The Permission Creator Class.
	 *
	 * @var   Permission
	 * @since 6.1.7
	 */
	protected Permission $permission;

	/**
	 * The Field Relation Class.
	 *
	 * @var   FieldRelation
	 * @since 6.1.7
	 */
	protected FieldRelation $fieldrelation;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Field Relations Class.
	 *
	 * @var   FieldRelations
	 * @since 6.1.7
	 */
	protected FieldRelations $fieldrelations;

	/**
	 * The Model Expert Field Class.
	 *
	 * @var   ModelExpertField
	 * @since 6.1.7
	 */
	protected ModelExpertField $modelexpertfield;

	/**
	 * The Permission Fields Class.
	 *
	 * @var   PermissionFields
	 * @since 6.1.7
	 */
	protected PermissionFields $permissionfields;

	/**
	 * The Selection Translation Class.
	 *
	 * @var   SelectionTranslation
	 * @since 6.1.7
	 */
	protected SelectionTranslation $selectiontranslation;

	/**
	 * The Tags Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The Items Method Eximport String Class.
	 *
	 * @var   ItemsMethodEximportString
	 * @since 6.1.7
	 */
	protected ItemsMethodEximportString $itemsmethodeximportstring;

	/**
	 * The Items Method List String Class.
	 *
	 * @var   ItemsMethodListString
	 * @since 6.1.7
	 */
	protected ItemsMethodListString $itemsmethodliststring;

	/**
	 * The Model Expert Field Initiator Class.
	 *
	 * @var   ModelExpertFieldInitiator
	 * @since 6.1.7
	 */
	protected ModelExpertFieldInitiator $modelexpertfieldinitiator;

	/**
	 * Constructor.
	 *
	 * @param Config                   $config                 The Config Class.
	 * @param Placeholder              $placeholder            The Placeholder Class.
	 * @param Dispenser                $dispenser              The Customcode Dispenser Class.
	 * @param Permission               $permission             The Permission Creator Class.
	 * @param FieldRelation            $fieldrelation          The Field Relation Class.
	 * @param ContentOne               $contentone             The ContentOne Class.
	 * @param FieldRelations           $fieldrelations         The Field Relations Class.
	 * @param ModelExpertField         $modelexpertfield       The Model Expert Field Class.
	 * @param PermissionFields         $permissionfields       The Permission Fields Class.
	 * @param SelectionTranslation     $selectiontranslation   The Selection Translation Class.
	 * @param Tags                     $tags                   The Tags Class.
	 * @param ItemsMethodEximportString  $itemsmethodeximportstring  The Items Method Eximport String Class.
	 * @param ItemsMethodListString      $itemsmethodliststring      The Items Method List String Class.
	 * @param ModelExpertFieldInitiator  $modelexpertfieldinitiator  The Model Expert Field Initiator Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Placeholder $placeholder,
		Dispenser $dispenser,
		Permission $permission,
		FieldRelation $fieldrelation,
		ContentOne $contentone,
		FieldRelations $fieldrelations,
		ModelExpertField $modelexpertfield,
		PermissionFields $permissionfields,
		SelectionTranslation $selectiontranslation,
		Tags $tags,
		ItemsMethodEximportString $itemsmethodeximportstring,
		ItemsMethodListString $itemsmethodliststring,
		ModelExpertFieldInitiator $modelexpertfieldinitiator)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->dispenser = $dispenser;
		$this->permission = $permission;
		$this->fieldrelation = $fieldrelation;
		$this->contentone = $contentone;
		$this->fieldrelations = $fieldrelations;
		$this->modelexpertfield = $modelexpertfield;
		$this->permissionfields = $permissionfields;
		$this->selectiontranslation = $selectiontranslation;
		$this->tags = $tags;
		$this->itemsmethodeximportstring = $itemsmethodeximportstring;
		$this->itemsmethodliststring = $itemsmethodliststring;
		$this->modelexpertfieldinitiator = $modelexpertfieldinitiator;
	}

	/**
	 * Get the item fixes of a list model.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 * @param   string  $nameListCode    The list view code name.
	 * @param   string  $Component       The component code name.
	 * @param   string  $tab             Extra indentation of the generated lines.
	 * @param   bool    $export          Build for an export rather than a list.
	 * @param   bool    $all             Include every field, not only listed ones.
	 *
	 * @return  string  The generated fixes.
	 *
	 * @since   6.1.7
	 */
	public function get($nameSingleCode, $nameListCode,
		$Component, $tab = '', $export = false, $all = false)
	{
		// add the fix if this view has the need for it
		$fix          = '';
		$forEachStart = '';
		$fix_access   = '';
		// encryption switches
		foreach ($this->config->cryption_types as $cryptionType)
		{
			${$cryptionType . 'Crypt'} = false;
		}
		$component = StringHelper::safe($Component);
		// check if the item has permissions.
		if ($this->permission->actionExist($nameSingleCode, 'core.access'))
		{
			$fix_access = PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(__Line__, __Class__)
				. " Remove items the user can't access.";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$access = (\$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.access')
				. "', 'com_" . $component . "." . $nameSingleCode
				. ".' . (int) \$item->id) && \$user->authorise('"
				. $this->permission->getAction($nameSingleCode, 'core.access')
				. "', 'com_" . $component . "'));";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "if (!\$access)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "unset(\$items[\$nr]);";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "continue;";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}"
				. PHP_EOL;
		}
		// add the tags if needed
		if ($this->tags->exists($nameSingleCode))
		{
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
				. Line::_(
					__LINE__,__CLASS__
				) . " Add the tags";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$item->tags = new TagsHelper;";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "\$item->tags->getTagIds(";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->id, 'com_"
				. $this->contentone->get('component') . ".$nameSingleCode'";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . ");";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "if (\$item->tags->tags)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->tags = implode(', ',";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
				. "\$item->tags->getTagNames(";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(6)
				. "explode(',', \$item->tags->tags)";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . ")";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . ");";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
				. "else";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
				. "\$item->tags = '';";
			$fix_access .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
		}
		// get the correct array
		if ($export || $all)
		{
			$action_ = 'Eximport';
		}
		else
		{
			$action_ = 'List';
		}
		// load the relations before modeling
		if (($field_relations =
			$this->fieldrelations->get($nameListCode)) !== null)
		{
			foreach ($field_relations as $field_guid => $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ((int) $area === 1 && !empty($field['code']))
					{
						$fix .= $this->fieldrelation->get(
							$field, $nameListCode, $tab
						);
					}
				}
			}
		}
		// open the values
		if ($this->itemsMethodString($action_)->exists($nameSingleCode))
		{
			foreach ($this->itemsMethodString($action_)->
				get($nameSingleCode) as $item)
			{
				switch ($item['method'])
				{
					case 1:
						// JSON_STRING_ENCODE
						$decode        = 'json_decode';
						$suffix_decode = ', true';
						break;
					case 2:
						// BASE_SIXTY_FOUR
						$decode        = 'base64_decode';
						$suffix_decode = '';
						break;
					case 3:
						// BASIC_ENCRYPTION_LOCALKEY
						$decode        = '$basic->decryptString';
						$basicCrypt    = true;
						$suffix_decode = '';
						break;
					case 4:
						// WHMCS_ENCRYPTION_WHMCS
						$decode        = '$whmcs->decryptString';
						$whmcsCrypt    = true;
						$suffix_decode = '';
						break;
					case 5:
						// MEDIUM_ENCRYPTION_LOCALFILE
						$decode        = '$medium->decryptString';
						$mediumCrypt   = true;
						$suffix_decode = '';
						break;
					case 6:
						// EXPERT_ENCRYPTION
						$expertCrypt = true;
						break;
					default:
						// JSON_ARRAY_ENCODE
						$decode        = 'json_decode';
						$suffix_decode = ', true';
						// fallback on json
						$item['method'] = 1;
						break;
				}

				if (($item['type'] === 'usergroup' || $item['type'] === 'usergrouplist') && !$export
					&& $item['method'] != 6)
				{
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " decode " . $item['name'];
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$"
						. $item['name'] . "Array = " . $decode . "(\$item->"
						. $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
						. $item['name'] . "Array))";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "\$"
						. $item['name'] . "Names = [];";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "foreach (\$" . $item['name'] . "Array as \$"
						. $item['name'] . ")";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . "\$"
						. $item['name'] . "Names[] = " . $Component
						. "Helper::getGroupName(\$" . $item['name'] . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "}";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "\$item->" . $item['name'] . " =  implode(', ', \$"
						. $item['name'] . "Names);";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
				}
				/* elseif (($item['type'] === 'usergroup' || $item['type'] === 'usergrouplist') && $export)
				{
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "//".Line::_(__Line__, __Class__)." decode ".$item['name'];
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "\$".$item['name']."Array = ".$decode."(\$item->".$item['name'].$suffix_decode.");";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$".$item['name']."Array))";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "{";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(4) . "\$item->".$item['name']." = implode('|',\$".$item['name']."Array);";
					$fix .= PHP_EOL.Indent::_(1).$tab.Indent::_(3) . "}";
				} */
				elseif ($item['translation'] && !$export
					&& $item['method'] != 6)
				{
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
						. Line::_(__Line__, __Class__) . " decode " . $item['name'];
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$"
						. $item['name'] . "Array = " . $decode . "(\$item->"
						. $item['name'] . $suffix_decode . ");";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
						. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
						. $item['name'] . "Array))";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "\$"
						. $item['name'] . "Names = [];";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "foreach (\$" . $item['name'] . "Array as \$"
						. $item['name'] . ")";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "{";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5) . "\$"
						. $item['name'] . "Names[] = Text:"
						. ":_(\$this->selectionTranslation(\$" . $item['name']
						. ", '" . $item['name'] . "'));";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "}";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
						. "\$item->" . $item['name'] . " = implode(', ', \$"
						. $item['name'] . "Names);";
					$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "}";
				}
				else
				{
					if ($item['method'] == 2 || $item['method'] == 3 || $item['method'] == 4
						|| $item['method'] == 5 || $item['method'] == 6)
					{
						// expert mode (dev must do it all)
						if ($item['method'] == 6)
						{
							$_placeholder_for_field
								= array('[[[field]]]' => "\$item->" . $item['name']);
							$fix .= $this->placeholder->update(
								PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. implode(PHP_EOL . Indent::_(1) . $tab . Indent::_(3),
									$this->modelexpertfield->get(
										$nameSingleCode . '.' . $item['name'] . '.get', []
									)
								), $_placeholder_for_field
							);
						}
						else
						{
							$taber = '';
							if ($item['method'] == 3)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$basickey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							elseif ($item['method'] == 5)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$mediumkey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							elseif ($item['method'] == 4)
							{
								$taber = Indent::_(1);
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3)
									. "if (\$whmcskey && !is_numeric(\$item->"
									. $item['name'] . ") && \$item->"
									. $item['name']
									. " === base64_encode(base64_decode(\$item->"
									. $item['name'] . ", true)))";
								$fix   .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "{";
							}
							if ($item['method'] == 3 || $item['method'] == 4
								|| $item['method'] == 5)
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " decrypt " . $item['name'];
							}
							else
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab . $taber
									. Indent::_(3) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " decode " . $item['name'];
							}
							$fix .= PHP_EOL . Indent::_(1) . $tab . $taber
								. Indent::_(3) . "\$item->" . $item['name']
								. " = " . $decode . "(\$item->" . $item['name']
								. ");";

							if ($item['method'] == 3 || $item['method'] == 4
								|| $item['method'] == 5)
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "}";
							}
						}
					}
					else
					{
						if ($export && $item['type'] === 'repeatable')
						{
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "//" . Line::_(__Line__, __Class__)
								. " decode repeatable " . $item['name'];
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "\$" . $item['name'] . "Array = " . $decode
								. "(\$item->" . $item['name'] . $suffix_decode
								. ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
								. $item['name'] . "Array))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "\$bucket" . $item['name'] . " = [];";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "foreach (\$" . $item['name'] . "Array as \$"
								. $item['name'] . "FieldName => \$"
								. $item['name'] . ")";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$"
								. $item['name'] . "))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(6)
								. "\$bucket" . $item['name'] . "[] = \$"
								. $item['name']
								. "FieldName . '<||VDM||>' . implode('<|VDM|>',\$"
								. $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "//" . Line::_(__Line__, __Class__)
								. " make sure the bucket has values.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$bucket"
								. $item['name'] . "))";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "{";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " clear the repeatable field.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "unset(\$item->" . $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " set repeatable field for export.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "\$item->" . $item['name']
								. " = implode('<|||VDM|||>',\$bucket"
								. $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "//" . Line::_(__Line__, __Class__)
								. " unset the bucket.";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(5)
								. "unset(\$bucket" . $item['name'] . ");";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4)
								. "}";
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "}";
						}
						elseif ($item['method'] == 1 && !$export)
						{
							// TODO we check if this works well.
							$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
								. "//" . Line::_(__Line__, __Class__) . " convert "
								. $item['name'];
							if (isset($item['custom']['table']))
							{
								// check if this is a local table
								if (strpos(
										(string) $item['custom']['table'],
										'#__' . $this->config->component_code_name . '_'
									) !== false)
								{
									$keyTableNAme = str_replace(
										'#__' . $this->config->component_code_name . '_',
										'', (string) $item['custom']['table']
									);
								}
								else
								{
									$keyTableNAme = $item['custom']['table'];
								}
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ", ', ', '"
									. $keyTableNAme . "', '"
									. $item['custom']['id'] . "', '"
									. $item['custom']['text'] . "');";
							}
							else
							{
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ", ', ', '"
									. $item['name'] . "');";
							}
						}
						else
						{
							if (!$export)
							{
								// For those we have not cached yet.
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " convert " . $item['name'];
								$fix .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(3) . "\$item->" . $item['name']
									. " = Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::string(\$item->"
									. $item['name'] . ");";
							}
						}
					}
				}
			}
		}
		/* // set translation (TODO) would be nice to cut down on double loops..
		if (!$export && $this->selectiontranslation->exists($nameListCode))
		{
			foreach ($this->selectiontranslation->get($nameListCode) as $name => $values)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//" . Line::_(__Line__, __Class__) . " convert " . $name;
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "\$item->" . $name . " = \$this->selectionTranslation(\$item->" . $name . ", '" . $name . "');";
			}
		} */
		// load the relations after modeling
		if (($field_relations =
			$this->fieldrelations->get($nameListCode)) !== null)
		{
			foreach ($field_relations as $fields)
			{
				foreach ($fields as $area => $field)
				{
					if ((int) $area === 3 && !empty($field['code']))
					{
						$fix .= $this->fieldrelation->get(
							$field, $nameListCode, $tab
						);
					}
				}
			}
		}
		// close the foreach if needed
		if (StringHelper::check($fix) || StringHelper::check($fix_access) || $export || $all)
		{
			// start the loop
			$forEachStart = PHP_EOL . PHP_EOL . Indent::_(1) . $tab . Indent::_(
					1
				) . "//" . Line::_(__Line__, __Class__)
				. " Set values to display correctly.";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
				. "if (Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$items))";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
			// do not add to export since it is already done
			if (!$export)
			{
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "//" . Line::_(__Line__, __Class__)
					. " Get the user object if not set.";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "if (!isset(\$user) || !"
					. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$user))";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "{";
				$forEachStart .= $this->getCurrentUser($tab);
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "}";
			}
			// the permissional acttion switch
			$hasPermissional = false;
			// add the permissional removal of values the user has not right to view or access
			if ($this->config->get('permission_strict_per_field', false)
				&& $this->permissionfields->isArray($nameSingleCode))
			{
				foreach ($this->permissionfields->get($nameSingleCode)
					as $fieldName => $permission_options)
				{
					if (!$hasPermissional)
					{
						foreach ($permission_options as $permission_option => $fieldType)
						{
							if (!$hasPermissional)
							{
								switch ($permission_option)
								{
									case 'access':
									case 'view':
										$hasPermissional = true;
										break;
								}
							}
						}
					}
				}
				// add the notes and get the global switch
				if ($hasPermissional)
				{
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							2
						) . "//" . Line::_(__Line__, __Class__)
						. " Get global permissional control activation. (default is inactive)";
					$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							2
						)
						. "\$strict_permission_per_field = ComponentHelper::getParams('com_"
						. $component
						. "')->get('strict_permission_per_field', 0);"
						. PHP_EOL;
				}
			}
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
				. "foreach (\$items as \$nr => &\$item)";
			$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "{";
			// add the access options
			$forEachStart .= $fix_access;
			// add the permissional removal of values the user has not right to view or access
			if ($hasPermissional)
			{
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "//" . Line::_(__Line__, __Class__)
					. " use permissional control if globally set.";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "if (\$strict_permission_per_field)";
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "{";
				foreach ($this->permissionfields->get($nameSingleCode)
					as $fieldName => $permission_options)
				{
					foreach ($permission_options as $permission_option => $fieldType)
					{
						switch ($permission_option)
						{
							case 'access':
							case 'view':
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "//" . Line::_(
										__LINE__,__CLASS__
									) . " set " . $permission_option
									. " permissional control for " . $fieldName
									. " value.";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "if (isset(\$item->"
									. $fieldName . ") && (!\$user->authorise('"
									. $nameSingleCode . "."
									. $permission_option . "." . $fieldName
									. "', 'com_" . $component . "."
									. $nameSingleCode
									. ".' . (int) \$item->id)";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "|| !\$user->authorise('"
									. $nameSingleCode . "."
									. $permission_option . "." . $fieldName
									. "', 'com_" . $component . "')))";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "{";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "//" . Line::_(
										__LINE__,__CLASS__
									)
									. " We JUST empty the value (do you have a better idea)";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(5) . "\$item->" . $fieldName
									. " = '';";
								$forEachStart .= PHP_EOL . Indent::_(1) . $tab
									. Indent::_(4) . "}";
								break;
						}
					}
				}
				$forEachStart .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "}";
			}
			// remove these values if export
			if ($export)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " unset the values we don't want exported.";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->asset_id);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->checked_out);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
					. "unset(\$item->checked_out_time);";
			}

			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "}";
			$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
			if ($export)
			{
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//"
					. Line::_(__Line__, __Class__) . " Add headers to items array.";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$headers = \$this->getExImPortHeaders();";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "if ("
					. "Super_" . "__91004529_94a9_4590_b842_e7c6b624ecf5___Power::check(\$headers))";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "{";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
					. "array_unshift(\$items,\$headers);";
				$fix .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
			}
		}

		// add custom php to getitems method
		$fix .= $this->dispenser->get(
			'php_getitems', $nameSingleCode, PHP_EOL . PHP_EOL . $tab
		);

		// load the encryption object if needed
		$script = '';
		foreach ($this->config->cryption_types as $cryptionType)
		{
			if (${$cryptionType . 'Crypt'})
			{
				if ('expert' !== $cryptionType)
				{
					$script .= PHP_EOL . PHP_EOL . Indent::_(1) . $tab
						. Indent::_(1) . "//" . Line::_(__Line__, __Class__)
						. " Get the " . $cryptionType . " encryption key.";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$" . $cryptionType . "key = " . $Component
						. "Helper::getCryptKey('" . $cryptionType . "');";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "//" . Line::_(__Line__, __Class__)
						. " Get the encryption object.";
					$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. "\$" . $cryptionType . " = new Super_" . "__99175f6d_dba8_4086_8a65_5c4ec175e61d___Power(\$"
						. $cryptionType . "key);";
				}
				elseif ($this->modelexpertfieldinitiator->
					exists("{$nameSingleCode}.get"))
				{
					foreach ($this->modelexpertfieldinitiator->
						get("{$nameSingleCode}.get") as $block)
					{
						$script .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . implode(
							PHP_EOL . Indent::_(1) . $tab . Indent::_(1), $block
						);
					}
				}
			}
		}

		// add the encryption script
		return $script . $forEachStart . $fix;
	}

	/**
	 * Get the registry holding the stored values of one build action.
	 *
	 * @param   string  $action  Either Eximport or List.
	 *
	 * @return  ItemsMethodEximportString|ItemsMethodListString
	 * @since   6.1.7
	 */
	protected function itemsMethodString(string $action)
	{
		return $action === 'Eximport'
			? $this->itemsmethodeximportstring
			: $this->itemsmethodliststring;
	}

	/**
	 * Get the statement that puts the current user in scope.
	 *
	 * @param   string  $tab  Extra indentation of the generated line.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getCurrentUser($tab): string
	{
		return PHP_EOL . Indent::_(1) . $tab . Indent::_(3)
			. "\$user = \$this->getCurrentUser();";
	}
}

