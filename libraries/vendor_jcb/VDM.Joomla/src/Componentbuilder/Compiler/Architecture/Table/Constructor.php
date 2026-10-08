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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Table;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CategoryCode;
use VDM\Joomla\Componentbuilder\Compiler\Builder\History;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Table Constructor Class.
 * 
 * The table class of a view watches its own rows for the features the view was
 * given, and this builds the observers that do the watching.
 * 
 * @since 6.1.7
 */
final class Constructor
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Tags Builder Class.
	 *
	 * @var   Tags
	 * @since 6.1.7
	 */
	protected Tags $tags;

	/**
	 * The History Builder Class.
	 *
	 * @var   History
	 * @since 6.1.7
	 */
	protected History $history;

	/**
	 * The Category Code Builder Class.
	 *
	 * @var   CategoryCode
	 * @since 6.1.7
	 */
	protected CategoryCode $categorycode;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Tags         $tags         The Tags Builder Class.
	 * @param History      $history      The History Builder Class.
	 * @param CategoryCode $categorycode The Category Code Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Tags $tags,
		History $history,
		CategoryCode $categorycode)
	{
		$this->config = $config;
		$this->tags = $tags;
		$this->history = $history;
		$this->categorycode = $categorycode;
	}

	/**
	 * Build the constructor of the table class of a view.
	 *
	 * A view that was given neither tags nor history gets no observers.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The observers.
	 *
	 * @since   6.1.7
	 */
	public function get(&$view): string
	{
		// reset
		$oserver = "";
		// set component name
		$component = $this->config->component_code_name;
		// add the tags observer
		if ($this->tags->exists($view))
		{
			$oserver .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__LINE__, __CLASS__) . " Adding Tag Options";
			$oserver .= PHP_EOL . Indent::_(2)
				. "Joomla__"."_fe63add8_0a40_4b3d_b548_f735fa6072fb___Power::createObserver(\$this, array('typeAlias' => 'com_"
				. $component . "." . $view . "'));";
		}
		// add the history/version observer
		if ($this->history->exists($view))
		{
			$oserver .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
				. Line::_(__LINE__, __CLASS__) . " Adding History Options";
			$oserver .= PHP_EOL . Indent::_(2)
				. "Joomla__"."_9ac794c2_f96d_4522_8acf_b8d48c4f51c5___Power::createObserver(\$this, array('typeAlias' => 'com_"
				. $component . "." . $view . "'));";
		}

		return $oserver;
	}

	/**
	 * Build the alias and category handling of the table class of a view.
	 *
	 * Only a view the compiler found a category for is given any.
	 *
	 * @param   array  $view  The view definition.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function aliasCategory(&$view): string
	{
		// only add Observers if both title, alias and category is available in view
		$code = $this->categorycode->get("{$view}.code");
		if ($code !== null)
		{
			return ", '" . $code . "' => \$this->" . $code;
		}

		return '';
	}
}

