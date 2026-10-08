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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\Field\IfValueScript;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Field\OptionsScript;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Field\TargetControlsScript;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Field\TargetRelationScript;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Field\ValueScript;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptMediaSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ScriptUserSwitch;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ValidationFix;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ViewScript as ViewScriptBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Library\IncludeHelper;
use VDM\Joomla\Componentbuilder\Compiler\Model\Createdate;
use VDM\Joomla\Componentbuilder\Compiler\Model\Modifieddate;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Minify;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Admin View Script Class.
 * 
 * Builds the javascript an admin view carries. The conditions the view
 * declares become one function per condition, the listeners that call it, the
 * tests it runs and the statements that reveal, hide and re-require the fields
 * it steers; the view's own custom code is appended; and the result is
 * minified when the build asks for it and stored for the view's edit file, its
 * footer and its list file.
 * 
 * Nothing here is decided by the Joomla version being compiled for, so there
 * is one class for every target.
 * 
 * @since  6.1.7
 */
final class ViewScript
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
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The Library Include Helper Class.
	 *
	 * @var   IncludeHelper
	 * @since 6.1.7
	 */
	protected IncludeHelper $includehelper;

	/**
	 * The Create Date Class.
	 *
	 * @var   Createdate
	 * @since 6.1.7
	 */
	protected Createdate $createdate;

	/**
	 * The Modified Date Class.
	 *
	 * @var   Modifieddate
	 * @since 6.1.7
	 */
	protected Modifieddate $modifieddate;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Script Media Switch Class.
	 *
	 * @var   ScriptMediaSwitch
	 * @since 6.1.7
	 */
	protected ScriptMediaSwitch $scriptmediaswitch;

	/**
	 * The Script User Switch Class.
	 *
	 * @var   ScriptUserSwitch
	 * @since 6.1.7
	 */
	protected ScriptUserSwitch $scriptuserswitch;

	/**
	 * The Validation Fix Class.
	 *
	 * @var   ValidationFix
	 * @since 6.1.7
	 */
	protected ValidationFix $validationfix;

	/**
	 * The View Script Builder Class.
	 *
	 * @var   ViewScriptBuilder
	 * @since 6.1.7
	 */
	protected ViewScriptBuilder $viewscript;

	/**
	 * The Field Value Script Class.
	 *
	 * @var   ValueScript
	 * @since 6.1.7
	 */
	protected ValueScript $valuescript;

	/**
	 * The Field Options Script Class.
	 *
	 * @var   OptionsScript
	 * @since 6.1.7
	 */
	protected OptionsScript $optionsscript;

	/**
	 * The Field If Value Script Class.
	 *
	 * @var   IfValueScript
	 * @since 6.1.7
	 */
	protected IfValueScript $ifvaluescript;

	/**
	 * The Field Target Controls Script Class.
	 *
	 * @var   TargetControlsScript
	 * @since 6.1.7
	 */
	protected TargetControlsScript $targetcontrolsscript;

	/**
	 * The Field Target Relation Script Class.
	 *
	 * @var   TargetRelationScript
	 * @since 6.1.7
	 */
	protected TargetRelationScript $targetrelationscript;

	/**
	 * Constructor.
	 *
	 * @param Config                $config                The Config Class.
	 * @param Placeholder           $placeholder           The Placeholder Class.
	 * @param Dispenser             $dispenser             The Customcode Dispenser Class.
	 * @param Structure             $structure             The Structure Class.
	 * @param IncludeHelper         $includehelper         The Library Include Helper Class.
	 * @param Createdate            $createdate            The Create Date Class.
	 * @param Modifieddate          $modifieddate          The Modified Date Class.
	 * @param ContentMulti          $contentmulti          The Content Multi Builder Class.
	 * @param ScriptMediaSwitch     $scriptmediaswitch     The Script Media Switch Class.
	 * @param ScriptUserSwitch      $scriptuserswitch      The Script User Switch Class.
	 * @param ValidationFix         $validationfix         The Validation Fix Class.
	 * @param ViewScriptBuilder     $viewscript            The View Script Builder Class.
	 * @param ValueScript           $valuescript           The Field Value Script Class.
	 * @param OptionsScript         $optionsscript         The Field Options Script Class.
	 * @param IfValueScript         $ifvaluescript         The Field If Value Script Class.
	 * @param TargetControlsScript  $targetcontrolsscript  The Field Target Controls Script Class.
	 * @param TargetRelationScript  $targetrelationscript  The Field Target Relation Script Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Placeholder $placeholder,
		Dispenser $dispenser,
		Structure $structure,
		IncludeHelper $includehelper,
		Createdate $createdate,
		Modifieddate $modifieddate,
		ContentMulti $contentmulti,
		ScriptMediaSwitch $scriptmediaswitch,
		ScriptUserSwitch $scriptuserswitch,
		ValidationFix $validationfix,
		ViewScriptBuilder $viewscript,
		ValueScript $valuescript,
		OptionsScript $optionsscript,
		IfValueScript $ifvaluescript,
		TargetControlsScript $targetcontrolsscript,
		TargetRelationScript $targetrelationscript)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->dispenser = $dispenser;
		$this->structure = $structure;
		$this->includehelper = $includehelper;
		$this->createdate = $createdate;
		$this->modifieddate = $modifieddate;
		$this->contentmulti = $contentmulti;
		$this->scriptmediaswitch = $scriptmediaswitch;
		$this->scriptuserswitch = $scriptuserswitch;
		$this->validationfix = $validationfix;
		$this->viewscript = $viewscript;
		$this->valuescript = $valuescript;
		$this->optionsscript = $optionsscript;
		$this->ifvaluescript = $ifvaluescript;
		$this->targetcontrolsscript = $targetcontrolsscript;
		$this->targetrelationscript = $targetrelationscript;
	}
	/**
	 * Build the javascript this admin view carries.
	 *
	 * Nothing is returned: the three scripts the view ends up with are stored
	 * on the view script builder, and the list view's javascript file, if it
	 * gets one, is registered on the content builder here.
	 *
	 * @param   array  $viewArray  The admin view, as the component data carries it.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function get(array $viewArray): void
	{
		// set the view name
		$nameSingleCode = $viewArray['settings']->name_single_code;
		$this->validationfix->setConditions($nameSingleCode, []);
		// add conditions to this view
		if (isset($viewArray['settings']->conditions)
			&& ArrayHelper::check(
				$viewArray['settings']->conditions
			))
		{
			// reset defaults
			$getValue       = [];
			$ifValue        = [];
			$targetControls = [];
			$functions      = [];
			$serverConditions = [];
			$serverGroups = [];

			foreach ($viewArray['settings']->conditions as $condition)
			{
				if (isset($condition['match_name'])
					&& StringHelper::check(
						$condition['match_name']
					))
				{
					$uniqueVar      = Unique::get(7);
					$matchName      = $condition['match_name'] . '_'
						. $uniqueVar;
					$targetBehavior = ($condition['target_behavior'] == 1
						|| $condition['target_behavior'] == 3) ? 'show'
						: 'hide';
					$targetDefault  = ($condition['target_behavior'] == 1
						|| $condition['target_behavior'] == 3) ? 'hide'
						: 'show';

					// set the realtation if any
					if ($condition['target_relation'])
					{
						// chain to other items of the same target
						$relations = $this->targetrelationscript->get(
							(array) $viewArray['settings']->conditions,
							(array) $condition, (string) $nameSingleCode
						);
						if (ArrayHelper::check($relations))
						{
							// set behavior and default array
							$behaviors[$matchName] = $targetBehavior;
							$defaults[$matchName]  = $targetDefault;
							$toggleSwitch[$matchName]
								= ($condition['target_behavior']
								== 1
								|| $condition['target_behavior'] == 2) ? true
								: false;
							// set the type buket
							$typeBuket[$matchName] = $condition['match_type'];
							// set function array
							$functions[$uniqueVar][0] = $matchName;
							$matchNames[$matchName]
								= $condition['match_name'];
							// get the select value
							$getValue[$matchName] = $this->valuescript->get(
								$condition['match_type'],
								(string) $condition['match_name'],
								$condition['match_extends'],
								(string) $uniqueVar
							);
							// get the options
							$options = $this->optionsscript->get(
								$condition['match_type'],
								$condition['match_options']
							);
							$serverConditions[$matchName] = $this->validationCondition($condition, $options);
							// set the if values
							$ifValue[$matchName] = $this->ifvaluescript->get(
								(string) $matchName,
								$condition['match_behavior'],
								$condition['match_type'], $options
							);
							// set the target controls
							$targetControls[$matchName]
								= $this->targetcontrolsscript->get(
								(bool) $toggleSwitch[$matchName],
								$condition['target_field'],
								(string) $targetBehavior,
								(string) $targetDefault, (string) $uniqueVar,
								(string) $nameSingleCode
							);

							foreach ($relations as $relation)
							{
								if (StringHelper::check(
									$relation['match_name']
								))
								{
									$relationName = $relation['match_name']
										. '_' . $uniqueVar;
									// set the type buket
									$typeBuket[$relationName]
										= $relation['match_type'];
									// set function array
									$functions[$uniqueVar][] = $relationName;
									$matchNames[$relationName]
										= $relation['match_name'];
									// get the relation option
									$relationOptions = $this->optionsscript->get(
										$relation['match_type'],
										$relation['match_options']
									);
									$serverConditions[$relationName] = $this->validationCondition($relation, $relationOptions);
									$getValue[$relationName]
										= $this->valuescript->get(
										$relation['match_type'],
										(string) $relation['match_name'],
										$condition['match_extends'],
										(string) $uniqueVar
									);
									$ifValue[$relationName]
										= $this->ifvaluescript->get(
										(string) $relationName,
										$relation['match_behavior'],
										$relation['match_type'],
										$relationOptions
									);
								}
							}
						}
					}
					else
					{
						// set behavior and default array
						$behaviors[$matchName] = $targetBehavior;
						$defaults[$matchName]  = $targetDefault;
						$toggleSwitch[$matchName]
							= ($condition['target_behavior']
							== 1
							|| $condition['target_behavior'] == 2) ? true
							: false;
						// set the type buket
						$typeBuket[$matchName] = $condition['match_type'];
						// set function array
						$functions[$uniqueVar][0] = $matchName;
						$matchNames[$matchName]   = $condition['match_name'];
						// get the select value
						$getValue[$matchName] = $this->valuescript->get(
							$condition['match_type'],
							(string) $condition['match_name'],
							$condition['match_extends'], (string) $uniqueVar
						);
						// get the options
						$options = $this->optionsscript->get(
							$condition['match_type'],
							$condition['match_options']
						);
						$serverConditions[$matchName] = $this->validationCondition($condition, $options);
						// set the if values
						$ifValue[$matchName] = $this->ifvaluescript->get(
							(string) $matchName, $condition['match_behavior'],
							$condition['match_type'], $options
						);
						// set the target controls
						$targetControls[$matchName]
							= $this->targetcontrolsscript->get(
							(bool) $toggleSwitch[$matchName],
							$condition['target_field'],
							(string) $targetBehavior, (string) $targetDefault,
							(string) $uniqueVar, (string) $nameSingleCode
						);
					}
				}
			}
			// reset buckets
			$initial    = '';
			$func       = '';
			$validation = '';
			$isSet      = '';
			$listener   = '';
			if (ArrayHelper::check($functions))
			{
				// now build the initial script
				$initial .= "//" . Line::_(__Line__, __Class__) . " Initial Script"
					. PHP_EOL . "document.addEventListener('DOMContentLoaded', function()";
				$initial .= PHP_EOL . "{";
				foreach ($functions as $function => $matchKeys)
				{
					$func_call = $this->functionCall(
						$function, $matchKeys, $getValue
					);
					$initial   .= $func_call['code'];
				}
				$initial .= "});" . PHP_EOL;
				// for modal fields
				$modal = '';
				// now build the listener scripts
				foreach ($functions as $l_function => $l_matchKeys)
				{
					$funcCall = '';
					foreach ($l_matchKeys as $l_matchKey)
					{
						$name         = $matchNames[$l_matchKey];
						$matchTypeKey = $typeBuket[$l_matchKey];
						$funcCall     = $this->functionCall(
							$l_function, $l_matchKeys, $getValue
						);

						if ($this->scriptmediaswitch->inArray($matchTypeKey))
						{
							$modal .= $funcCall['code'];
						}
						else
						{
							if ($this->scriptuserswitch->inArray($matchTypeKey))
							{
								$name = $name . '_id';
							}

							$listener .= PHP_EOL . "//" . Line::_(
									__LINE__,__CLASS__
								) . " #jform_" . $name . " listeners for "
								. $l_matchKey . " function";
							$listener .= PHP_EOL . "jQuery('#jform_" . $name
								. "').on('keyup',function()";
							$listener .= PHP_EOL . "{";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});";
							$listener .= PHP_EOL
								. "jQuery('#adminForm').on('change', '#jform_"
								. $name . "',function (e)";
							$listener .= PHP_EOL . "{";
							$listener .= PHP_EOL . Indent::_(1)
								. "e.preventDefault();";
							$listener .= $funcCall['code'];
							$listener .= PHP_EOL . "});" . PHP_EOL;
						}
					}
				}
				if (StringHelper::check($modal))
				{
					$listener .= PHP_EOL . "window.SqueezeBox.initialize({";
					$listener .= PHP_EOL . Indent::_(1) . "onClose:function(){";
					$listener .= $modal;
					$listener .= PHP_EOL . Indent::_(1) . "}";
					$listener .= PHP_EOL . "});" . PHP_EOL;
				}

				// now build the function
				$func = '';
				$head = '';
				foreach ($functions as $f_function => $f_matchKeys)
				{
					$map = '';
					// does this function require an array
					$addArray = false;
					$func_    = $this->functionCall(
						$f_function, $f_matchKeys, $getValue
					);
					// set array switch
					if ($func_['array'])
					{
						$addArray = true;
					}
					$func      .= PHP_EOL . "//" . Line::_(__Line__, __Class__)
						. " the " . $f_function . " function";
					$func      .= PHP_EOL . "function " . $f_function . "(";
					$fucounter = 0;
					foreach ($f_matchKeys as $fu_matchKey)
					{
						if (StringHelper::check($fu_matchKey))
						{
							if ($fucounter == 0)
							{
								$func .= $fu_matchKey;
							}
							else
							{
								$func .= ',' . $fu_matchKey;
							}
							$fucounter++;
						}
					}
					$func .= ")";
					$func .= PHP_EOL . "{";
					if ($addArray)
					{
						foreach ($f_matchKeys as $a_matchKey)
						{
							$name = $matchNames[$a_matchKey];
							$func .= PHP_EOL . Indent::_(1) . "if (isSet("
								. $a_matchKey . ") && " . $a_matchKey
								. ".constructor !== Array)" . PHP_EOL
								. Indent::_(1) . "{" . PHP_EOL . Indent::_(2)
								. "var temp_" . $f_function . " = "
								. $a_matchKey . ";" . PHP_EOL . Indent::_(2)
								. "var " . $a_matchKey . " = [];" . PHP_EOL
								. Indent::_(2) . $a_matchKey . ".push(temp_"
								. $f_function . ");" . PHP_EOL . Indent::_(1)
								. "}";
							$func .= PHP_EOL . Indent::_(1) . "else if (!isSet("
								. $a_matchKey . "))" . PHP_EOL . Indent::_(1)
								. "{";
							$func .= PHP_EOL . Indent::_(2) . "var "
								. $a_matchKey . " = [];";
							$func .= PHP_EOL . Indent::_(1) . "}";
							$func .= PHP_EOL . Indent::_(1) . "var " . $name
								. " = " . $a_matchKey . ".some(" . $a_matchKey
								. "_SomeFunc);" . PHP_EOL;

							// setup the map function
							$map .= PHP_EOL . "//" . Line::_(__Line__, __Class__)
								. " the " . $f_function . " Some function";
							$map .= PHP_EOL . "function " . $a_matchKey
								. "_SomeFunc(" . $a_matchKey . ")";
							$map .= PHP_EOL . "{";
							$map .= PHP_EOL . Indent::_(1) . "//"
								. Line::_(__Line__, __Class__)
								. " set the function logic";
							$map .= PHP_EOL . Indent::_(1) . "if (";
							$if  = $ifValue[$a_matchKey];
							if (StringHelper::check($if))
							{
								$map .= $if;
							}
							$map .= ")";
							$map .= PHP_EOL . Indent::_(1) . "{";
							$map .= PHP_EOL . Indent::_(2) . "return true;";
							$map .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL
								. Indent::_(1) . "return false;";
							$map .= PHP_EOL . "}" . PHP_EOL;
						}
						$func .= PHP_EOL . PHP_EOL . Indent::_(1) . "//"
							. Line::_(__Line__, __Class__)
							. " set this function logic";
						$func .= PHP_EOL . Indent::_(1) . "if (";
						// set if counter
						$aifcounter = 0;
						foreach ($f_matchKeys as $af_matchKey)
						{
							$name = $matchNames[$af_matchKey];
							if ($aifcounter == 0)
							{
								$func .= $name;
							}
							else
							{
								$func .= ' && ' . $name;
							}
							$aifcounter++;
						}
						$func .= ")" . PHP_EOL . Indent::_(1) . "{";
					}
					else
					{
						$func .= PHP_EOL . Indent::_(1) . "//" . Line::_(
								__LINE__,__CLASS__
							) . " set the function logic";
						$func .= PHP_EOL . Indent::_(1) . "if (";
						// set if counter
						$ifcounter = 0;
						foreach ($f_matchKeys as $f_matchKey)
						{
							$if = $ifValue[$f_matchKey];
							if (StringHelper::check($if))
							{
								if ($ifcounter == 0)
								{
									$func .= $if;
								}
								else
								{
									$func .= ' && ' . $if;
								}
								$ifcounter++;
							}
						}
						$func .= ")" . PHP_EOL . Indent::_(1) . "{";
					}
					// get the controles
					$controls = $targetControls[$f_matchKeys[0]];
					// get target behavior and default
					$targetBehavior = $behaviors[$f_matchKeys[0]];
					$targetDefault  = $defaults[$f_matchKeys[0]];
					$requiredTargets = [];
					foreach ($controls as $target => $action)
					{
						if ($action['requiredVar'] !== '')
						{
							$requiredTargets[] = $target;
						}
					}
					if ($requiredTargets !== [])
					{
						$matches = [];
						foreach ($f_matchKeys as $key)
						{
							$matches[] = $serverConditions[$key] + [
								'array' => $addArray,
								'supported' => $ifValue[$key] !== 0,
							];
						}
						$serverGroups[] = [
							'matches' => $matches,
							'targets' => $requiredTargets,
							'show' => $targetBehavior === 'show',
							'toggle' => $toggleSwitch[$f_matchKeys[0]],
						];
					}
					// load the target behavior
					foreach ($controls as $target => $action)
					{
						$func .= $action['behavior'];
						if (StringHelper::check(
							$action[$targetBehavior]
						))
						{
							$func .= $action[$targetBehavior];
							$head .= $action['requiredVar'];
						}
					}
					// check if this is a toggle switch
					if ($toggleSwitch[$f_matchKeys[0]])
					{
						$func .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL
							. Indent::_(1) . "else" . PHP_EOL . Indent::_(1)
							. "{";
						// load the default behavior
						foreach ($controls as $target => $action)
						{
							$func .= $action['default'];
							if (StringHelper::check(
								$action[$targetDefault]
							))
							{
								$func .= $action[$targetDefault];
							}
						}
					}
					$func .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL . "}"
						. PHP_EOL . $map;
				}
				// add the needed validation to file
				$validation = $this->validationScript($nameSingleCode);

				// set the isSet function
				$this->validationfix->setConditions($nameSingleCode, $serverGroups);
				$isSet = $this->isSetFunction();
			}
			// load to this buket
			$fileScript   = $initial . $func . $validation . $isSet;
			$footerScript = $listener;
		}
		// add custom script to edit form JS file
		if (!isset($fileScript))
		{
			$fileScript = '';
		}
		$fileScript .= $this->dispenser->get(
			'view_file', $nameSingleCode, PHP_EOL . PHP_EOL, null, true, ''
		);
		// add custom script to footer
		if (isset($this->dispenser->hub['view_footer'][$nameSingleCode])
			&& StringHelper::check(
				$this->dispenser->hub['view_footer'][$nameSingleCode]
			))
		{
			$customFooterScript = PHP_EOL . PHP_EOL . $this->placeholder->update_(
					$this->dispenser->hub['view_footer'][$nameSingleCode]
				);
			if (strpos($customFooterScript, '<?php') === false)
			{
				// only add now if no php is added to the footer script
				if (!isset($footerScript))
				{
					$footerScript = '';
				}
				$footerScript .= $customFooterScript;
				unset($customFooterScript);
			}
		}
		// set view listname
		$nameListCode = $viewArray['settings']->name_list_code;
		// add custom script to list view JS file
		if (($list_fileScript = $this->dispenser->get(
				'views_file', $nameSingleCode, PHP_EOL . PHP_EOL, null, true,
				false
			)) !== false
			&& StringHelper::check($list_fileScript))
		{
			// get dates
			$_created  = $this->createdate->get($viewArray);
			$_modified = $this->modifieddate->get($viewArray);
			// add file to view
			$_target = array($this->config->build_target => $nameListCode);
			$_config = array(Placefix::_h('CREATIONDATE') => $_created,
				Placefix::_h('BUILDDATE') => $_modified,
				Placefix::_h('VERSION') => $viewArray['settings']->version);
			$this->structure->build($_target, 'javascript_file', false, $_config);
			// set path
			$_path = '/administrator/components/com_' . $this->config->component_code_name
				. '/assets/js/' . $nameListCode . '.js';
			// load the file to the list view
			$this->contentmulti->set($nameListCode . '|ADMIN_ADD_JAVASCRIPT_FILE', PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Add List View JavaScript File" . PHP_EOL . Indent::_(2)
				. $this->includehelper->get($_path)
			);
		}
		else
		{
			$list_fileScript = '';
			$this->contentmulti->set($nameListCode . '|ADMIN_ADD_JAVASCRIPT_FILE', '');
		}
		// minify the script
		if ($this->config->get('minify', 0) && isset($list_fileScript)
			&& StringHelper::check($list_fileScript))
		{
			// minify the fileScript javascript
			$list_fileScript = Minify::js($list_fileScript);
		}
		// minify the script
		if ($this->config->get('minify', 0) && isset($fileScript)
			&& StringHelper::check($fileScript))
		{
			// minify the fileScript javascript
			$fileScript = Minify::js($fileScript);
		}
		// minify the script
		if ($this->config->get('minify', 0) && isset($footerScript)
			&& StringHelper::check($footerScript))
		{
			// minify the footerScript javascript
			$footerScript = Minify::js($footerScript);
		}
		// make sure there is script to add
		if (isset($list_fileScript)
			&& StringHelper::check(
				$list_fileScript
			))
		{
			// load the script
			$this->viewscript->set(
				$nameListCode . '.list_fileScript', $list_fileScript
			);
		}
		// make sure there is script to add
		if (isset($fileScript)
			&& StringHelper::check(
				$fileScript
			))
		{
			// add the head script if set
			if (isset($head) && StringHelper::check($head))
			{
				$fileScript = "// Some Global Values" . PHP_EOL . $head
					. PHP_EOL . $fileScript;
			}
			// load the script
			$this->viewscript->set(
				$nameSingleCode . '.fileScript', $fileScript
			);
		}
		// make sure to add custom footer script if php was found in it, since we canot minfy it with php
		if (isset($customFooterScript)
			&& StringHelper::check(
				$customFooterScript
			))
		{
			if (!isset($footerScript))
			{
				$footerScript = '';
			}
			$footerScript .= $customFooterScript;
		}
		// make sure there is script to add
		if (isset($footerScript)
			&& StringHelper::check(
				$footerScript
			))
		{
			// add the needed script tags
			$footerScript = PHP_EOL
				. PHP_EOL . '<script type="text/javascript">' . PHP_EOL
				. $footerScript . PHP_EOL . "</script>";
			$this->viewscript->set(
				$nameSingleCode . '.footerScript', $footerScript
			);
		}
	}

	/**
	 * Preserve the browser's normalized match definition for model validation.
	 *
	 * @param   array  $condition  The normalized view condition.
	 * @param   array  $options    Options read by the shared options renderer.
	 *
	 * @return  array
	 * @since   6.2.0
	 */
	protected function validationCondition(array $condition, array $options): array
	{
		if (in_array((int) $condition['match_behavior'], [8, 9], true))
		{
			$options['keywords'] = array_map(
				static fn ($keyword) => StringHelper::safe($keyword, 'w'),
				$options['keywords'] ?? []
			);
		}

		return [
			'name' => $condition['match_name'],
			'behavior' => (int) $condition['match_behavior'],
			'options' => $options,
			'user' => $this->scriptuserswitch->inArray($condition['match_type']),
			'checkbox' => $condition['match_type'] === 'checkbox',
		];
	}

	/**
	 * Read back one of the scripts an admin view was given.
	 *
	 * @param   string  $view  The view code name.
	 * @param   string  $type  Which script: fileScript, footerScript or list_fileScript.
	 *
	 * @return  string  The script, or an empty string when the view has none of that kind.
	 *
	 * @since   6.1.7
	 */
	public function script(string $view, string $type): string
	{
		// the builder returns null for a view that was never given this script
		return (string) $this->viewscript->get($view . '.' . $type, '');
	}

	/**
	 * Build the statements that read every watched value and call one function.
	 *
	 * Public because the legacy helper's method of the same shape is public
	 * surface, and its shim delegates here.
	 *
	 * @param   string  $function   The name of the function to call.
	 * @param   array   $matchKeys  The keys of the values the function takes.
	 * @param   array   $getValue   The read statement of every key.
	 *
	 * @return  array{code: string, array: bool}  The call, and whether any value is an array.
	 *
	 * @since   6.1.7
	 */
	public function functionCall(string $function, array $matchKeys,
		array $getValue): array
	{
		$initial  = '';
		$funcsets = [];
		$array    = false;
		foreach ($matchKeys as $matchKey)
		{
			$value = $getValue[$matchKey];
			if ($value['isArray'])
			{
				$initial    .= PHP_EOL . Indent::_(1) . $value['get'];
				$funcsets[] = $matchKey;
				$array      = true;
			}
			else
			{
				$initial    .= PHP_EOL . Indent::_(1) . $value['get'];
				$funcsets[] = $matchKey;
			}
		}

		// make sure that the function is loaded only once
		if (ArrayHelper::check($funcsets))
		{
			$initial .= PHP_EOL . Indent::_(1) . $function . "(";
			$initial .= implode(',', $funcsets);
			$initial .= ");" . PHP_EOL;
		}

		return array('code' => $initial, 'array' => $array);
	}

	/**
	 * Build the form validation override this view's switched fields need.
	 *
	 * A field whose required attribute is switched at runtime has to be taken
	 * out of Joomla's own validation while it is hidden, and put back when it
	 * returns. A view where no condition does that needs none of this.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  string  The override, or an empty string when no field switches.
	 *
	 * @since   6.1.7
	 */
	protected function validationScript(string $nameSingleCode): string
	{
		$validation = '';

	// add the needed validation to file
	if (ArrayHelper::check(
		$this->validationfix->get($nameSingleCode)
	))
	{
		$validation .= PHP_EOL . "/**";
		$validation .= PHP_EOL . " * Update the \"not required\" field list by adding or removing a field name.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * Mirrors the original jQuery logic exactly but uses pure JavaScript.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @param  {string}  name    The field name to add or remove.";
		$validation .= PHP_EOL . " * @param  {number}  status  1 to add as not required, 0 to remove.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @return {void}";
		$validation .= PHP_EOL . " * @since  3.1.3";
		$validation .= PHP_EOL . " */";
		$validation .= PHP_EOL . "function updateFieldRequired(name, status) {";
		$validation .= PHP_EOL . Indent::_(1) . "// Check if #jform_not_required exists";
		$validation .= PHP_EOL . Indent::_(1) . "const notRequiredField = document.getElementById('jform_not_required');";
		$validation .= PHP_EOL . Indent::_(1) . "if (!notRequiredField) {";
		$validation .= PHP_EOL . Indent::_(2) . "return;";
		$validation .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL;
		$validation .= PHP_EOL . Indent::_(1) . "// Split the comma-separated list into an array";
		$validation .= PHP_EOL . Indent::_(1) . "let not_required = notRequiredField.value ? notRequiredField.value.split(',') : [];" . PHP_EOL;
		$validation .= PHP_EOL . Indent::_(1) . "// Add or remove the field name from the list";
		$validation .= PHP_EOL . Indent::_(1) . "if (status == 1) {";
		$validation .= PHP_EOL . Indent::_(2) . "not_required.push(name);";
		$validation .= PHP_EOL . Indent::_(1) . "} else {";
		$validation .= PHP_EOL . Indent::_(2) . "not_required = removeFieldFromNotRequired(not_required, name);";
		$validation .= PHP_EOL . Indent::_(1) . "}" . PHP_EOL;
		$validation .= PHP_EOL . Indent::_(1) . "// Clean and deduplicate the list";
		$validation .= PHP_EOL . Indent::_(1) . "const fixedList = fixNotRequiredArray(not_required);" . PHP_EOL;
		$validation .= PHP_EOL . Indent::_(1) . "// Write back the updated comma-separated list";
		$validation .= PHP_EOL . Indent::_(1) . "notRequiredField.value = fixedList.toString();";
		$validation .= PHP_EOL . "}" . PHP_EOL;
		$validation .= PHP_EOL . "/**";
		$validation .= PHP_EOL . " * Remove a specific field name from the \"not required\" array.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @param  {Array<string>} array  The list of not-required field names.";
		$validation .= PHP_EOL . " * @param  {string}        what   The field name to remove.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @return {Array<string>}        The updated array.";
		$validation .= PHP_EOL . " * @since  3.1.3";
		$validation .= PHP_EOL . " */";
		$validation .= PHP_EOL . "function removeFieldFromNotRequired(array, what) {";
		$validation .= PHP_EOL . Indent::_(1) . "return array.filter(function (element) {";
		$validation .= PHP_EOL . Indent::_(2) . "return element !== what;";
		$validation .= PHP_EOL . Indent::_(1) . "});";
		$validation .= PHP_EOL . "}" . PHP_EOL;
		$validation .= PHP_EOL . "/**";
		$validation .= PHP_EOL . " * Deduplicate and clean a \"not required\" array.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @param  {Array<string>} array  The array to fix.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @return {Array<string>}        A cleaned, unique array.";
		$validation .= PHP_EOL . " * @since  3.1.3";
		$validation .= PHP_EOL . " */";
		$validation .= PHP_EOL . "function fixNotRequiredArray(array) {";
		$validation .= PHP_EOL . Indent::_(1) . "const seen = {};";
		$validation .= PHP_EOL . Indent::_(1) . "return removeEmptyFromNotRequiredArray(array).filter(function (item) {";
		$validation .= PHP_EOL . Indent::_(2) . "return seen.hasOwnProperty(item) ? false : (seen[item] = true);";
		$validation .= PHP_EOL . Indent::_(1) . "});";
		$validation .= PHP_EOL . "}" . PHP_EOL;
		$validation .= PHP_EOL . "/**";
		$validation .= PHP_EOL . " * Remove empty or invalid entries from a \"not required\" array.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * Also removes the literal '一_一' token (legacy quirk preserved for compatibility).";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @param  {Array<string>} array  The array to process.";
		$validation .= PHP_EOL . " *";
		$validation .= PHP_EOL . " * @return {Array<string>}        The cleaned array.";
		$validation .= PHP_EOL . " * @since  3.1.3";
		$validation .= PHP_EOL . " */";
		$validation .= PHP_EOL . "function removeEmptyFromNotRequiredArray(array) {";
		$validation .= PHP_EOL . Indent::_(1) . "return array.filter(function (el) {";
		$validation .= PHP_EOL . Indent::_(2) . "return el && el.length > 0 && el !== '一_一';";
		$validation .= PHP_EOL . Indent::_(1) . "});";
		$validation .= PHP_EOL . "}" . PHP_EOL;
	}

		return $validation;
	}

	/**
	 * Build the helper every generated condition test calls.
	 *
	 * @return  string  The isSet function.
	 *
	 * @since   6.1.7
	 */
	protected function isSetFunction(): string
	{
		$isSet = '';

	// set the isSet function
	$isSet = PHP_EOL . "// the isSet function";
	$isSet .= PHP_EOL . "function isSet(val)";
	$isSet .= PHP_EOL . "{";
	$isSet .= PHP_EOL . Indent::_(1)
		. "if ((val != undefined) && (val != null) && 0 !== val.length){";
	$isSet .= PHP_EOL . Indent::_(2) . "return true;";
	$isSet .= PHP_EOL . Indent::_(1) . "}";
	$isSet .= PHP_EOL . Indent::_(1) . "return false;";
	$isSet .= PHP_EOL . "}";

		return $isSet;
	}
}

