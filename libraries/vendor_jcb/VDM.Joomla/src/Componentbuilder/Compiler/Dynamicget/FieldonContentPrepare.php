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

namespace VDM\Joomla\Componentbuilder\Compiler\Dynamicget;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\EventDispatcher;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Dynamic Get Field on Content Prepare
 * 
 * @since 5.1.2
 */
final class FieldonContentPrepare
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * The EventDispatcher Class.
	 *
	 * @var   EventDispatcher
	 * @since 5.1.2
	 */
	protected EventDispatcher $eventdispatcher;

	/**
	 * The loadTracker array.
	 *
	 * @var   array
	 * @since 5.1.2
	 */
	protected array $loadTracker = [];

	/**
	 * Constructor.
	 *
	 * @param Config            $config            The Config Class.
	 * @param ContentOne        $contentone        The ContentOne Class.
	 * @param EventDispatcher   $eventdispatcher   The EventDispatcher Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, ContentOne $contentone,
		EventDispatcher $eventdispatcher)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->eventdispatcher = $eventdispatcher;
	}

	/**
	 * Get the content preparation plugin logic for a field.
	 *
	 * @param  array   $get      The get array passed in.
	 * @param  array   $checker  The checker structure containing field info.
	 * @param  string  $string   The string name for the object.
	 * @param  string  $code     The code to use as fallback context.
	 * @param  string  $tab      Indentation tab prefix.
	 *
	 * @return string  The content preparation PHP string.
	 * @since  5.1.2
	 */
	public function get($get, $checker, $string, $code, $tab = ''): string
	{
		if (empty($get['key']) || empty($get['selection']['select']) || empty($checker) || empty($string) || empty($code))
		{
			return '';
		}

		$fieldPrepare = '';
		$runplugins   = '';

		// set component
		$Component = $this->contentone->get('Component');

		// set context
		$context = (isset($get['context'])) ? $get['context'] : $code;
		$context = 'com_' . $this->config->component_code_name . '.' . $context;

		// load params builder only once
		$params = false;

		$target_version = $this->config->get('joomla_version', 3);

		foreach ($checker as $field => $array)
		{
			// build load counter
			$key = md5($get['key'] . $string . $field);
			// check if we should load this again
			if (strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key]))
			{
				// set the key
				$this->loadTracker[$key] = $key;

				// build decoder string
				if (empty($runplugins))
				{
					if ($target_version == 3 || $target_version == 4)
					{
						$runplugins = PHP_EOL . $tab . Indent::_(1) . "//"
							. Line::_(__Line__, __Class__)
							. " Load the Event Dispatcher";
						$runplugins .= PHP_EOL . $tab . Indent::_(1)
							. "Joomla__" . "_7934665b_e432_4ec6_b38d_27bf32730eb9___Power::importPlugin('content');";
						$runplugins .= PHP_EOL . $tab . Indent::_(1)
							. '$this->_dispatcher = Joomla__'.'_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();';
					}
					else
					{
						$runplugins = PHP_EOL . $tab . Indent::_(1) . "//"
							. Line::_(__Line__, __Class__)
							. " Load the Event Dispatcher";
						$runplugins .= PHP_EOL . $tab . Indent::_(1)
							. "Joomla__" . "_7934665b_e432_4ec6_b38d_27bf32730eb9___Power::importPlugin('content');";
					}
				}

				if (!$params)
				{
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							1
						) . "//" . Line::_(__Line__, __Class__)
						. " Check if item has params, or pass whole item.";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(
							1
						) . "\$params = (isset(" . $string . "->params) && "
						. "Super_" . "__4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check(" . $string
						. "->params)) ? json_decode(" . $string . "->params) : "
						. $string . ";";
					$params       = true;
				}

				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "//" . Line::_(__Line__, __Class__)
					. " Make sure the content prepare plugins fire on "
					. $field;
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$_" . $field . " = new \stdClass();";
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "\$_" . $field . '->text =& ' . $string . '->' . $field
					. '; //' . Line::_(__Line__, __Class__)
					. ' value must be in text';
				$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
					. "//" . Line::_(__Line__, __Class__)
					. " Since all values are now in text (Joomla Limitation), we also add the field name ("
					. $field . ") to context";

				if ($target_version == 3 || $target_version == 4)
				{
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
						. '$this->_dispatcher->triggerEvent("onContentPrepare", array(\''
						. $context . '.' . $field . '\', &$_' . $field
						. ', &$params, 0));';
				}
				else
				{
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "//" . Line::_(__Line__, __Class__) . " onContentPrepare Event Trigger";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "\$this->getDispatcher()->dispatch('onContentPrepare',";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . "new Joomla__" . "_6ee61914_64ed_4a3a_b156_dfc4891ae00d___Power(";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "'onContentPrepare',";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "[";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "'context' => '{$context}.{$field}',";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "'subject' => \$_{$field},";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "'params' => \$params,";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(4) . "'page' => 0";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(3) . "]";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . ")";
					$fieldPrepare .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . ");";
				}
			}
		}

		// load dispatcher
		if (!empty($runplugins))
		{
			$this->eventdispatcher->set($code, $runplugins);
		}

		// return content prepare fix
		return $fieldPrepare;
	}
}

