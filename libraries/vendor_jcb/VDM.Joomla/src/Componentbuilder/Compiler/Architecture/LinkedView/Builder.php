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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView;


use VDM\Joomla\Componentbuilder\Compiler\Power\Selection;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\FootableScriptsInterface as FootableScripts;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\ListBodyInterface as ListBody;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\LinkedView\ListHead;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\ListQueryInterface as ListQuery;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Unique;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\LinkedView\BuilderInterface;


/**
 * Linked View Builder Class.
 * 
 * Assembles everything a linked admin view needs inside its parent's edit
 * tab: the header script that works out the referral, the table head and
 * body, the getter that loads the items, and the Footable assets.
 * 
 * Three things differ between Joomla targets — how the input object is
 * acquired, which referral block is emitted, and which task a new record
 * link points at — so those are the extension points the target variants
 * override.
 * 
 * @since  6.1.7
 */
class Builder implements BuilderInterface
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
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Footable Scripts Class.
	 *
	 * @var   FootableScripts
	 * @since 6.1.7
	 */
	protected FootableScripts $footablescripts;

	/**
	 * The Linked View List Body Class.
	 *
	 * @var   ListBody
	 * @since 6.1.7
	 */
	protected ListBody $listbody;

	/**
	 * The Linked View List Head Class.
	 *
	 * @var   ListHead
	 * @since 6.1.7
	 */
	protected ListHead $listhead;

	/**
	 * The Linked View List Query Class.
	 *
	 * @var   ListQuery
	 * @since 6.1.7
	 */
	protected ListQuery $listquery;

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Component          $component          The Component Class.
	 * @param ContentMulti       $contentmulti       The ContentMulti Class.
	 * @param FootableScripts    $footablescripts    The Footable Scripts Class.
	 * @param ListBody           $listbody           The Linked View List Body Class.
	 * @param ListHead           $listhead           The Linked View List Head Class.
	 * @param ListQuery          $listquery          The Linked View List Query Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Component $component,
		ContentMulti $contentmulti,
		FootableScripts $footablescripts,
		ListBody $listbody,
		ListHead $listhead,
		ListQuery $listquery)
	{
		$this->config = $config;
		$this->component = $component;
		$this->contentmulti = $contentmulti;
		$this->footablescripts = $footablescripts;
		$this->listbody = $listbody;
		$this->listhead = $listhead;
		$this->listquery = $listquery;
	}

	/**
	 * Build one linked view of a parent view.
	 *
	 * @param   array  $args  The linked view definition queued by the edit body.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set($args)
	{
		/**
		 * @var $viewGuid
		 * @var $nameSingleCode
		 * @var $codeName
		 * @var $layoutCodeName
		 * @var $key
		 * @var $parentKey
		 * @var $addNewButon
		 */
		extract($args, EXTR_PREFIX_SAME, "oops");
		// the legacy helper initialised $single here instead of
		// $name_single_code, and never gave $parent_key a value on the -OR>
		// path. Both then read as null, so these two initialisations keep the
		// generated output byte for byte the same without the notices.
		$single           = '';
		$name_single_code = '';
		$parent_key       = null;
		$name_list_code   = '';
		foreach ($this->component->get('admin_views') as $array)
		{
			if ($array['adminview'] == $viewGuid)
			{
				$name_single_code = $array['settings']->name_single_code;
				$name_list_code   = $array['settings']->name_list_code;
				break;
			}
		}
		if (StringHelper::check($name_single_code)
			&& StringHelper::check($name_list_code))
		{
			if (strpos((string) $parentKey, '-R>') !== false
				|| strpos((string) $parentKey, '-A>') !== false)
			{
				list($parent_key) = explode('-', (string) $parentKey);
			}
			elseif (strpos((string) $parentKey, '-OR>') !== false)
			{
				// this is not good... (TODO)
				$parent_keys = explode('-OR>', (string) $parentKey);
			}
			else
			{
				$parent_key = $parentKey;
			}

			$head         = $this->listhead->get(
				$name_single_code, $name_list_code, $addNewButon,
				$nameSingleCode
			);
			$body         = $this->listbody->get(
				$name_single_code, $name_list_code, $nameSingleCode
			);
			$functionName = StringHelper::safe($codeName, 'F');
			// LAYOUTITEMSTABLE <<<DYNAMIC>>>
			$this->contentmulti->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSTABLE',
				$head . $body
			);
			// LAYOUTITEMSHEADER <<<DYNAMIC>>>
			$headerscript = '//' . Line::_(__Line__, __Class__)
				. ' set the edit URL';
			$headerscript .= PHP_EOL . '$edit = "index.php?option=com_'
				. $this->config->component_code_name . '&view=' . $name_list_code
				. '&task='
				. $name_single_code . '.edit";';
			$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
				. ' set a return value';
			$headerscript .= PHP_EOL
				. '$return = ($id) ? "index.php?option=com_'
				. $this->config->component_code_name . '&view=' . $nameSingleCode
				. '&layout=edit&id=" . $id : "";';
			$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
				. ' check for a return value';
			$headerscript .= $this->getInputAcquisition();
			$headerscript .= PHP_EOL
				. "if (\$_return = \$jinput->get('return', null, 'base64'))";
			$headerscript .= PHP_EOL . '{';
			$headerscript .= PHP_EOL . Indent::_(1)
				. '$return .= "&return=" . $_return;';
			$headerscript .= PHP_EOL . '}';
			$headerscript .= $this->getReferralBlock($parent_key, $nameSingleCode);
			if ($addNewButon > 0)
			{
				$add_key = $this->getAddKey();
				// add the link for new
				if ($addNewButon == 1 || $addNewButon == 2)
				{
					$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' set the create new URL';
					$headerscript .= PHP_EOL . '$new = "index.php?option=com_'
						. $this->config->component_code_name . '&view=' . $name_list_code
						. '&task='
						. $name_single_code . '.' . $add_key . '" . $ref;';
				}
				// and the link for close and new
				if ($addNewButon == 2 || $addNewButon == 3)
				{
					$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
						. ' set the create new and close URL';
					$headerscript .= PHP_EOL
						. '$close_new = "index.php?option=com_'
						. $this->config->component_code_name . '&view=' . $name_list_code
						. '&task='
						. $name_single_code . '.' . $add_key . '";';
				}
				$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
					. ' load the action object';
				$headerscript .= PHP_EOL . '$can = ' . Selection::permittedActionsToken() . '::get(' . "'" . $name_single_code . "'" . ');';
			}
			$this->contentmulti->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSHEADER',
				$headerscript
			);
			// LINKEDVIEWITEMS <<<DYNAMIC>>>
			$this->contentmulti->add($nameSingleCode . '|LINKEDVIEWITEMS',
				PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Get Linked view data" . PHP_EOL . Indent::_(2)
				. "\$this->" . $codeName . " = \$this->get('" . $functionName
				. "');", false
			);
			// LINKEDVIEWTABLESCRIPTS <<<DYNAMIC>>>
			$this->contentmulti->set($nameSingleCode . '|LINKEDVIEWTABLESCRIPTS', $this->footablescripts->get());

			if (strpos((string) $key, '-R>') !== false || strpos((string) $key, '-A>') !== false)
			{
				list($_key) = explode('-', (string) $key);
			}
			elseif (strpos((string) $key, '-OR>') !== false)
			{
				$_key = str_replace('-OR>', '', (string) $key);
			}
			else
			{
				$_key = $key;
			}
			// LINKEDVIEWGLOBAL <<<DYNAMIC>>>
			if (isset($parent_keys)
				&& ArrayHelper::check(
					$parent_keys
				))
			{
				$globalKey = [];
				foreach ($parent_keys as $parent_key)
				{
					$globalKey[$parent_key]
						= StringHelper::safe(
						$_key . Unique::get(4)
					);
					$this->contentmulti->add($nameSingleCode . '|LINKEDVIEWGLOBAL',
						PHP_EOL . Indent::_(2) . "\$this->"
						. $globalKey[$parent_key] . " = \$item->" . $parent_key . ";", false
					);
				}
			}
			else
			{
				// set the global key
				$globalKey = StringHelper::safe(
					$_key . Unique::get(4)
				);
				$this->contentmulti->add($nameSingleCode . '|LINKEDVIEWGLOBAL',
					PHP_EOL . Indent::_(2) . "\$this->" . $globalKey
					. " = \$item->" . $parent_key . ";", false
				);
			}
			// LINKEDVIEWMETHODS <<<DYNAMIC>>>
			$this->contentmulti->add($nameSingleCode . '|LINKEDVIEWMETHODS',
				$this->listquery->get(
					$name_single_code, $name_list_code, $functionName, $key, $_key,
					$parentKey,
					$parent_key, $globalKey
				), false
			);
		}
		else
		{
			$this->contentmulti->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSTABLE',
				'oops! error.....'
			);
			$this->contentmulti->set($nameSingleCode . '_' . $layoutCodeName . '|LAYOUTITEMSHEADER', '');
		}
	}

	/**
	 * Get the statement that puts the input object in scope.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getInputAcquisition(): string
	{
		$headerscript = PHP_EOL . '//' . Line::_(__Line__, __Class__)
			. ' check for a return value';
		$headerscript .= PHP_EOL
			. '$jinput = $displayData->input ?? (method_exists($app, \'getInput\') ? $app->getInput() : $app->input);';

		return $headerscript;
	}

	/**
	 * Get the referral block the generated header script carries.
	 *
	 * A view keyed on a guid seeds the new record with that guid instead of
	 * passing a referring id, which only the targets that support guid keys
	 * can do.
	 *
	 * @param   string|null  $parent_key      The key of the parent view.
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getReferralBlock(?string $parent_key, string $nameSingleCode): string
	{
		if ($parent_key !== 'guid')
		{
			return $this->getIdReferralBlock($nameSingleCode);
		}

		$headerscript = PHP_EOL . '//' . Line::_(__Line__, __Class__)
			. ' get the GUID value';
		$headerscript .= PHP_EOL . '$guid = $displayData->item->guid ?? null;';

		$headerscript .= PHP_EOL . '//' . Line::_(__Line__, __Class__)
			. ' check if return value was set';
		$headerscript .= PHP_EOL . 'if ('
			. 'Super' . '___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($return))';
		$headerscript .= PHP_EOL . '{';
		$headerscript .= PHP_EOL . Indent::_(1) . '//' . Line::_(
				__LINE__,__CLASS__
			) . ' set the referral values';
		$headerscript .= PHP_EOL . Indent::_(1) . '$ref = $guid ? "&init_defaults=" . urlencode(\'{"' . $nameSingleCode . '":"\' . $guid . \'"}\') . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));';
		$headerscript .= PHP_EOL . '}';
		$headerscript .= PHP_EOL . 'else';
		$headerscript .= PHP_EOL . '{';

		$headerscript .= PHP_EOL . Indent::_(1) . '$ref = $guid ? "&init_defaults=" . urlencode(\'{"' . $nameSingleCode . '":"\' . $guid . \'"}\') : "";';
		$headerscript .= PHP_EOL . '}';

		return $headerscript;
	}

	/**
	 * Get the referral block that passes a referring id.
	 *
	 * @param   string  $nameSingleCode  The single view code name.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getIdReferralBlock(string $nameSingleCode): string
	{
		$headerscript = PHP_EOL . '//' . Line::_(__Line__, __Class__)
			. ' check if return value was set';
		$headerscript .= PHP_EOL . 'if ('
			. 'Super' . '___1f28cb53_60d9_4db1_b517_3c7dc6b429ef___Power::check($return))';
		$headerscript .= PHP_EOL . '{';
		$headerscript .= PHP_EOL . Indent::_(1) . '//' . Line::_(
				__LINE__,__CLASS__
			) . ' set the referral values';
		$headerscript .= PHP_EOL . Indent::_(1) . '$ref = ($id) ? "&ref='
			. $nameSingleCode
			. '&refid=" . $id . "&return=" . urlencode(base64_encode($return)) : "&return=" . urlencode(base64_encode($return));';
		$headerscript .= PHP_EOL . '}';
		$headerscript .= PHP_EOL . 'else';
		$headerscript .= PHP_EOL . '{';
		$headerscript .= PHP_EOL . Indent::_(1) . '$ref = ($id) ? "&ref='
			. $nameSingleCode . '&refid=" . $id : "";';
		$headerscript .= PHP_EOL . '}';

		return $headerscript;
	}

	/**
	 * Get the task a new record link points at.
	 *
	 * @return  string
	 * @since   6.1.7
	 */
	protected function getAddKey(): string
	{
		return 'add';
	}
}

