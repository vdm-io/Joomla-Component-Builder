<?php
/**
 * @package    FrameworkOnFramework
 * @subpackage encrypt
 * @copyright   Copyright (C) 2010-2016 Nicholas K. Dionysopoulos / Akeeba Ltd. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 * @note	This file has been modified by the Joomla! Project and no longer reflects the original work of its author.
 */

namespace VDM\Joomla\Componentbuilder\Package\Display;


use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\ArrayHelper;


/**
 * Package Display Details Class
 * 
 * @since 3.2.0
 */
class Details
{
	/**
	 * The Owner details template
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	private array $owner = [
		'company' => 'COM_COMPONENTBUILDER_DTCOMPANYDTDDSDD',
		'owner' => 'COM_COMPONENTBUILDER_DTOWNERDTDDSDD',
		'email' => 'COM_COMPONENTBUILDER_DTEMAILDTDDSDD',
		'website' => 'COM_COMPONENTBUILDER_DTWEBSITEDTDDSDD',
		'license' => 'COM_COMPONENTBUILDER_DTLICENSEDTDDSDD',
		'copyright' => 'COM_COMPONENTBUILDER_DTCOPYRIGHTDTDDSDD'
	];

	/**
	 * The Component details template
	 *
	 * @var    array
	 * @since 3.2.0
	 */
	private array $component = [
		'ul' => [
			'companyname' => 'COM_COMPONENTBUILDER_ICOMPANYI_BSB',
			'author' => 'COM_COMPONENTBUILDER_IAUTHORI_BSB',
			'email' => 'COM_COMPONENTBUILDER_IEMAILI_BSB',
			'website' => 'COM_COMPONENTBUILDER_IWEBSITEI_BSB',
		],
		'other' => [
			'license' => 'COM_COMPONENTBUILDER_HFOUR_CLASSNAVHEADERLICENSEHFOURPSP',
			'copyright' => 'COM_COMPONENTBUILDER_HFOUR_CLASSNAVHEADERCOPYRIGHTHFOURPSP'
		]
	];

	/**
	 * get the JCB package owner details display
	 *
	 * @param   array    $info     The package info object
	 * @param   bool     $trust    The trust switch
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function owner(array $info, $trust = false): string
	{
		$hasOwner = false;

		$ownerDetails = '<h2 class="module-title nav-header">' . Text::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_DETAILS') . '</h2>';
		$ownerDetails .= '<dl class="uk-description-list-horizontal">';

		// load the list items
		foreach ($this->owner as $key => $dd)
		{
			if ($value = $this->getInfoValue($key, $info))
			{
				$ownerDetails .= Text::sprintf($dd, $value);

				// check if we have a owner/source name
				if (('owner' === $key || 'company' === $key) && !$hasOwner)
				{
					$hasOwner = true;
					$owner = $value;
				}
			}
		}
		$ownerDetails .= '</dl>';

		// provide some details to how the user can get a key
		if ($hasOwner && isset($info['getKeyFrom']['buy_link']) && StringHelper::check($info['getKeyFrom']['buy_link']))
		{
			$ownerDetails .= '<hr />';
			$ownerDetails .= Text::sprintf('COM_COMPONENTBUILDER_BGET_THE_KEY_FROMB_A_SSA', 'class="btn btn-primary" href="' . $info['getKeyFrom']['buy_link'] . '" target="_blank" title="get a key from ' . $owner . '"', $owner);
		}
		// add more custom links
		elseif ($hasOwner && isset($info['getKeyFrom']['buy_links']) && ArrayHelper::check($info['getKeyFrom']['buy_links']))
		{
			$buttons = array();
			foreach ($info['getKeyFrom']['buy_links'] as $keyName => $link)
			{
				$buttons[] = Text::sprintf('COM_COMPONENTBUILDER_BGET_THE_KEY_FROM_SB_FOR_A_SSA', $owner, 'class="btn btn-primary" href="' . $link . '" target="_blank" title="get a key from ' . $owner . '"', $keyName);
			}
			$ownerDetails .= '<hr />';
			$ownerDetails .= implode('<br />', $buttons);
		}

		// return the owner details
		if (!$hasOwner)
		{
			$ownerDetails = '<h2>' . Text::_('COM_COMPONENTBUILDER_PACKAGE_OWNER_DETAILS_NOT_FOUND') . '</h2>';

			if (!$trust)
			{
				$ownerDetails .= '<p style="color: #922924;">' . Text::_('COM_COMPONENTBUILDER_BE_CAUTIOUS_DO_NOT_CONTINUE_UNLESS_YOU_TRUST_THE_ORIGIN_OF_THIS_PACKAGE') . '</p>';
			}
		}

		return '<div>'.$ownerDetails.'</div>';
	}

	/**
	 * Check if info details has owner values set
	 *
	 * @param   array    $info     The package info object
	 *
	 * @return  bool
	 * @since 3.2.0
	 **/
	public function hasOwner(array &$info): bool
	{
		if ($this->getInfoValue('owner', $info) || $this->getInfoValue('company', $info))
		{
			return true;
		}

		return false;
	}

	/**
	 * get the JCB package components details display
	 *
	 * @param   array   $info  The package info object
	 *
	 * @return  string
	 * @since 3.2.0
	 **/
	public function components(array &$info): string
	{
		// check if these components need a key
		$needKey = $this->hasKey($info);

		if (isset($info['name']) && ArrayHelper::check($info['name'])) 
		{
			$cAmount = count((array) $info['name']);
			$class2 = ($cAmount == 1) ? 'span12' : 'span6';
			$counter = 1;
			$display = array();
			foreach ($info['name'] as $key => $value)
			{
				// set the name
				$name = $value . ' v' . $info['component_version'][$key];
				if ($cAmount > 1 && $counter == 3)
				{
					$display[] = '</div>';
					$counter = 1;
				}
				if ($cAmount > 1 && $counter == 1)
				{
					$display[] = '<div>';
				}
				$display[] = '<div class="well well-small ' . $class2 . '">';
				$display[] = '<h3>';
				$display[] = $name;
				if ($needKey)
				{
					$display[] = ' - <em>' . Text::sprintf('COM_COMPONENTBUILDER_PAIDLOCKED') . '</em>';
				}
				else
				{
					$display[] = ' - <em>' . Text::sprintf('COM_COMPONENTBUILDER_FREEOPEN') . '</em>';
				}
				$display[] = '</h3><h4>';
				$display[] = $info['short_description'][$key];
				$display[] = '</h4>';
				$display[] = '<ul class="uk-list uk-list-striped">';

				// load the list items
				foreach ($this->component['ul'] as $li => $value)
				{
					if (isset($info[$li]) && isset($info[$li][$key]))
					{
						$display[] = '<li>'.Text::sprintf($value, $info[$li][$key]).'</li>';
					}
				}
				$display[] = '</ul>';

				// if we have a source link we add it
				if (isset($info['joomla_source_link']) && ArrayHelper::check($info['joomla_source_link']) && isset($info['joomla_source_link'][$key]) && StringHelper::check($info['joomla_source_link'][$key]))
				{
					$display[] = '<a class="uk-button uk-button-mini uk-width-1-1 uk-margin-small-bottom" href="' .
						$info['joomla_source_link'][$key] . '" target="_blank" title="' . Text::_('COM_COMPONENTBUILDER_SOURCE_CODE_FOR_JOOMLA_COMPONENT') . ' ('. $name . ')">' . Text::_('COM_COMPONENTBUILDER_SOURCE_CODE') . '</a>';
				}

				// load other
				foreach ($this->component['other'] as $other => $value)
				{
					if (isset($info[$other]) && isset($info[$other][$key]))
					{
						$display[] = Text::sprintf($value, $info[$other][$key]);
					}
				}

				$display[] = '</div>';

				$counter++;
			}

			// close the div if needed
			if ($cAmount > 1)
			{
				$display[] = '</div>';
			}

			return implode(PHP_EOL, $display);
		}

		return '<div>' . Text::_('COM_COMPONENTBUILDER_NO_COMPONENT_DETAILS_FOUND_SO_IT_IS_NOT_SAFE_TO_CONTINUE') . '</div>';
	}

	/**
	 * get the value from INFO array
	 *
	 * @param   string   $key      The value key
	 * @param   array    $info     The package info object
	 *
	 * @return  string|null
	 * @since 3.2.0
	 **/
	private function getInfoValue(string $key, array &$info): ?string
	{
		$source = (isset($info['source']) && isset($info['source'][$key])) ? 'source' : ((isset($info['getKeyFrom']) && isset($info['getKeyFrom'][$key])) ? 'getKeyFrom' : null);
		if ($source && StringHelper::check($info[$source][$key]))
		{
			return $info[$source][$key];
		}
		return null;
	}

	/**
	 * Check if the JCB package has a key
	 *
	 * @param   array   $info  The package info object
	 *
	 * @return  bool
	 * @since 3.2.0
	 **/
	private function hasKey(array &$info): bool
	{
		// check the package key status
		if (!isset($info['key']))
		{
			if (isset($info['getKeyFrom']) && isset($info['getKeyFrom']['owner']))
			{
				// has a key
				$info['key'] = true;
			}
			else
			{
				// does not have a key
				$info['key'] = false;
			}
		}

		return (bool) $info['key'];
	}

}

