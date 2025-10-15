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
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ModelExpertField;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteDecrypt;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;


/**
 * Custom View Decode Column
 * 
 * @since 5.1.2
 */
final class DecodeColumn
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ModelExpertField Class.
	 *
	 * @var   ModelExpertField
	 * @since 5.1.2
	 */
	protected ModelExpertField $expert;

	/**
	 * The SiteDecrypt Class.
	 *
	 * @var   SiteDecrypt
	 * @since 5.1.2
	 */
	protected SiteDecrypt $sitedecrypt;

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
	 * @param Config             $config             The Config Class.
	 * @param Placeholder        $placeholder        The Placeholder Class.
	 * @param ModelExpertField   $modelexpertfield   The ModelExpertField Class.
	 * @param SiteDecrypt        $sitedecrypt        The SiteDecrypt Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Placeholder $placeholder,
		ModelExpertField $modelexpertfield, SiteDecrypt $sitedecrypt)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->expert = $modelexpertfield;
		$this->sitedecrypt = $sitedecrypt;
	}

	/**
	 * Generate the decode logic for a column in the custom view.
	 *
	 * @param  array   $get      The get array with view configuration.
	 * @param  array   $checker  Field decode configuration.
	 * @param  string  $string   The variable representing the row object.
	 * @param  string  $code     The calling context code string.
	 * @param  string  $tab      Optional indentation tab prefix.
	 *
	 * @return string  The generated decode logic.
	 * @since  5.1.2
	 */
	public function get(array $get, array $checker, string $string, string $code, string $tab = ''): string
	{
		if (empty($get['key']) || empty($get['selection']['select']) || empty($checker) || empty($string) || empty($code))
		{
			return '';
		}

		$fieldDecode = '';

		foreach ($checker as $field => $array)
		{
			$key = md5($code . $get['key'] . $string . $field);

			if (strpos((string) $get['selection']['select'], (string) $field) !== false
				&& !isset($this->loadTracker[$key])
				&& ArrayHelper::check($array['decode']))
			{
				$this->loadTracker[$key] = $key;

				$array['decode'] = (array) array_unique(array_reverse((array) $array['decode']));

				foreach ($array['decode'] as $decode)
				{
					$if      = '';
					$decoder = '';

					if ($decode === 'json')
					{
						$if = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "if (isset({$string}->{$field}) && Super__"."_4b225c51_d293_48e4_b3f6_5136cf5c3f18___Power::check({$string}->{$field}))" . PHP_EOL
							. Indent::_(1) . $tab . Indent::_(1) . "{";
						$decoder = "{$string}->{$field} = json_decode({$string}->{$field}, true);";
					}
					elseif ($decode === 'base64')
					{
						$if = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "if (!empty({$string}->{$field}) && {$string}->{$field} === base64_encode(base64_decode({$string}->{$field})))" . PHP_EOL
							. Indent::_(1) . $tab . Indent::_(1) . "{";
						$decoder = "{$string}->{$field} = base64_decode({$string}->{$field});";
					}
					elseif (strpos((string) $decode, '_encryption') !== false || $decode === 'expert_mode')
					{
						foreach ($this->config->cryption_types as $cryptionType)
						{
							if ($decode === $cryptionType . '_encryption' || $decode === $cryptionType . '_mode')
							{
								if ($cryptionType !== 'expert')
								{
									$if = PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
										. "if (!empty({$string}->{$field}) && \${$cryptionType}key && !is_numeric({$string}->{$field}) && {$string}->{$field} === base64_encode(base64_decode({$string}->{$field}, true)))" . PHP_EOL
										. Indent::_(1) . $tab . Indent::_(1) . "{";
									$decoder = "{$string}->{$field} = rtrim(\${$cryptionType}->decryptString({$string}->{$field}), \"\0\");";
								}
								elseif ($this->expert->exists($array['admin_view'] . '.' . $field))
								{
									$_placeholder_for_field = [
										'[[[field]]]' => "{$string}->{$field}"
									];

									$fieldDecode .= $this->placeholder->update(
										PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
										. implode(
											PHP_EOL . Indent::_(1) . $tab . Indent::_(1),
											$this->{$cryptionType}->get($array['admin_view'] . '.' . $field . '.get', ['error'])
										),
										$_placeholder_for_field
									);
								}

								$this->sitedecrypt->set("{$cryptionType}.{$code}", $decode);
							}
						}
					}

					if (StringHelper::check($if))
					{
						$fieldDecode .= PHP_EOL . Indent::_(1) . $tab . Indent::_(1)
							. "//" . Line::_(__LINE__, __CLASS__) . " Check if we can decode {$field}" . $if
							. PHP_EOL . Indent::_(1) . $tab . Indent::_(2)
							. "//" . Line::_(__LINE__, __CLASS__) . " Decode {$field}";
					}

					if (StringHelper::check($decoder))
					{
						$fieldDecode .= PHP_EOL . Indent::_(1) . $tab . Indent::_(2) . $decoder
							. PHP_EOL . Indent::_(1) . $tab . Indent::_(1) . "}";
					}
				}
			}
		}

		return $fieldDecode;
	}
}

