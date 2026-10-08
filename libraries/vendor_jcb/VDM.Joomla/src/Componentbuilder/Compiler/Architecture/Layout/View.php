<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    16th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Layout;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Templatelayout\Data as TemplatelayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface as Header;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * View Layout Class.
 * 
 * Builds the layout files of a view and fills their content placeholders.
 * A layout is emitted either from the component's own generated items or,
 * when a matching template-layout override exists, from that override's
 * header, code and body.
 * 
 * Overrides are resolved from the most specific key to the least: component
 * plus view plus layout, component plus layout, view plus layout, and
 * finally the layout name on its own.
 * 
 * @since  6.1.7
 */
final class View
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
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The LayoutData Class.
	 *
	 * @var   LayoutData
	 * @since 6.1.7
	 */
	protected LayoutData $layoutdata;

	/**
	 * The Templatelayout Data Class.
	 *
	 * @var   TemplatelayoutData
	 * @since 6.1.7
	 */
	protected TemplatelayoutData $templatelayoutdata;

	/**
	 * The Header Class.
	 *
	 * @var   Header
	 * @since 6.1.7
	 */
	protected Header $header;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * Constructor.
	 *
	 * @param Config               $config               The Config Class.
	 * @param Placeholder          $placeholder          The Placeholder Class.
	 * @param ContentMulti         $contentmulti         The ContentMulti Class.
	 * @param LayoutData           $layoutdata           The LayoutData Class.
	 * @param TemplatelayoutData   $templatelayoutdata   The Templatelayout Data Class.
	 * @param Header               $header               The Header Class.
	 * @param Structure            $structure            The Structure Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		ContentMulti $contentmulti, LayoutData $layoutdata,
		TemplatelayoutData $templatelayoutdata, Header $header,
		Structure $structure)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->layoutdata = $layoutdata;
		$this->templatelayoutdata = $templatelayoutdata;
		$this->header = $header;
		$this->structure = $structure;
	}

	/**
	 * Build one layout of a view.
	 *
	 * When an override exists it is emitted instead of the generated items.
	 * Otherwise the layout file is added to the build structure and its
	 * items are stored, and when the language target is both areas the file
	 * is added to the site area as well.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $layoutName      The layout name.
	 * @param   string  $items           The generated layout items.
	 * @param   string  $type            The structure type of the layout file.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(string $nameSingleCode, string $layoutName, $items, string $type): void
	{
		// we check if there is a local override
		if (!$this->setOverride($nameSingleCode, $layoutName, $items))
		{
			// first build the layout file
			$target = array('admin' => $nameSingleCode);
			$this->structure->build($target, $type, $layoutName);
			// add to front if needed
			if ($this->config->lang_target === 'both')
			{
				$target = array('site' => $nameSingleCode);
				$this->structure->build($target, $type, $layoutName);
			}
			if (StringHelper::check($items))
			{
				// LAYOUTITEMS <<<DYNAMIC>>>
				$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|LAYOUTITEMS', $items);
			}
			else
			{
				// LAYOUTITEMS <<<DYNAMIC>>>
				$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|bogus', 'boom');
			}
		}
	}

	/**
	 * Build a layout from its template-layout override.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $layoutName      The layout name.
	 * @param   string  $items           The generated layout items.
	 *
	 * @return  bool  True when an override was found and emitted.
	 *
	 * @since   6.1.7
	 */
	protected function setOverride(string $nameSingleCode, string $layoutName, $items): bool
	{
		if (($data = $this->getOverride($nameSingleCode, $layoutName))
			!== null)
		{
			// first build the layout file
			$target = array('admin' => $nameSingleCode);
			$this->structure->build($target, 'layoutoverride', $layoutName);
			// add to front if needed
			if ($this->config->lang_target === 'both')
			{
				$target = array('site' => $nameSingleCode);
				$this->structure->build($target, 'layoutoverride', $layoutName);
			}
			// make sure items is an empty string (should not be needed.. but)
			if (!StringHelper::check($items))
			{
				$items = '';
			}
			// set placeholder
			$placeholder                                    = $this->placeholder->active;
			$placeholder[Placefix::_h('LAYOUTITEMS')] = $items;
			// OVERRIDE_LAYOUT_CODE <<<DYNAMIC>>>
			$php_view = (array) explode(PHP_EOL, (string) $data['php_view'] ?? '');
			if (ArrayHelper::check($php_view))
			{
				$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
				$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_CODE',
					$this->placeholder->update(
						$php_view, $placeholder
					)
				);
			}
			else
			{
				$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_CODE', '');
			}
			// OVERRIDE_LAYOUT_BODY <<<DYNAMIC>>>
			$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_BODY',
				PHP_EOL . $this->placeholder->update(
					$data['html'] ?? '', $placeholder
				)
			);
			// OVERRIDE_LAYOUT_HEADER <<<DYNAMIC>>>
			// the header service returns a string, so the false comparison is
			// always true; an empty header therefore still emits two new lines
			$this->contentmulti->set($nameSingleCode . '_' . $layoutName . '|OVERRIDE_LAYOUT_HEADER',
				(($header = $this->header->get(
						'override.layout',
						$layoutName)
					) !== false) ? PHP_EOL . PHP_EOL . $header : ''
			);

			// since override was found
			return true;
		}

		return false;
	}

	/**
	 * Get the template-layout override of a layout.
	 *
	 * The override is claimed as it is returned: its data is removed from the
	 * layout registry so the same override is not emitted twice.
	 *
	 * @param   string  $nameSingleCode  The single code name of the view.
	 * @param   string  $layoutName      The layout name.
	 *
	 * @return  array|null  The override data, or null when none matches.
	 *
	 * @since   6.1.7
	 */
	protected function getOverride(string $nameSingleCode, string $layoutName): ?array
	{
		$get_key = null;
		// check if there is an override by component name, view name, & layout name
		if ($this->templatelayoutdata->set(
			'override', $nameSingleCode, false, array(''),
			array($this->config->component_code_name . $nameSingleCode . $layoutName)
		))
		{
			$get_key = $this->config->component_code_name . $nameSingleCode . $layoutName;
		}
		// check if there is an override by component name & layout name
		elseif ($this->templatelayoutdata->set(
			'override', $nameSingleCode, false, array(''),
			array($this->config->component_code_name . $layoutName)
		))
		{
			$get_key = $this->config->component_code_name . $layoutName;
		}
		// check if there is an override by view & layout name
		elseif ($this->templatelayoutdata->set(
			'override', $nameSingleCode, false, array(''),
			array($nameSingleCode . $layoutName)
		))
		{
			$get_key = $nameSingleCode . $layoutName;
		}
		// check if there is an override by layout name (global layout)
		elseif ($this->templatelayoutdata->set(
			'override', $nameSingleCode, false, array(''),
			array($layoutName)
		))
		{
			$get_key = $layoutName;
		}

		// check if we have a get key
		if ($get_key)
		{
			$data = $this->layoutdata->
				get($this->config->build_target . '.' . $get_key);

			if ($data === null)
			{
				var_dump($this->config->build_target . '.' . $get_key);
				var_dump('admin.' . $get_key);
				var_dump($this->layoutdata->get('admin.' . $get_key));
				var_dump('site.' . $get_key);
				var_dump($this->layoutdata->get('site.' . $get_key));
				var_dump('both.' . $get_key);
				var_dump($this->layoutdata->get('both.' . $get_key));
				exit;
			}
			// remove since we will add the layout now
			if ($this->config->lang_target === 'both')
			{
				$this->layoutdata->remove('admin.' . $get_key);
				$this->layoutdata->remove('site.' . $get_key);
				$this->layoutdata->remove('both.' . $get_key);
			}
			else
			{
				$this->layoutdata->remove($this->config->build_target . '.' . $get_key);
			}

			return $data;
		}

		return null;
	}
}

