<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    3rd September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Search;


use VDM\Joomla\Componentbuilder\Abstraction\Registry;


/**
 * Search Configurations
 * 
 * @since 3.2.0
 */
class Config extends Registry
{
	/**
	 * get posted search value
	 *
	 * @return  string|null  Raw search value
	 * @since 3.2.0
	 */
	protected function getSearchvalue(): ?string
	{
		return $this->input->post->get('search_value', null, 'RAW');
	}

	/**
	 * get posted replace value
	 *
	 * @return  string  Raw replace value
	 * @since 3.2.0
	 */
	protected function getReplacevalue(): string
	{
		return $this->input->post->get('replace_value', '', 'RAW');
	}

	/**
	 * get posted search match case
	 *
	 * @return  int  Match case
	 * @since 3.2.0
	 */
	protected function getMatchcase(): int
	{
		return $this->input->post->get('match_case', 0, 'INT');
	}

	/**
	 * get posted search whole word
	 *
	 * @return  int  Whole word
	 * @since 3.2.0
	 */
	protected function getWholeword(): int
	{
		return $this->input->post->get('whole_word', 0, 'INT');
	}

	/**
	 * get posted search regex
	 *
	 * @return  int  Regex
	 * @since 3.2.0
	 */
	protected function getRegex(): int
	{
		return $this->input->post->get('regex_search', 0, 'INT');
	}

	/**
	 * get posted component
	 *
	 * @return  int  Component ID
	 * @since 3.2.0
	 */
	protected function getComponentid(): int
	{
		return $this->input->post->get('component_id', 0, 'INT');
	}

	/**
	 * get posted area/table
	 *
	 * @return  string  Table name
	 * @since 3.2.0
	 */
	protected function getTablename(): string
	{
		return $this->input->post->get('table_name', null, 'word');
	}

	/**
	 * get posted field
	 *
	 * @return  string  Field name
	 * @since 3.2.0
	 */
	protected function getFieldname(): string
	{
		return $this->input->post->get('field_name', null, 'word');
	}

	/**
	 * get posted item id
	 *
	 * @return  int  Item id
	 * @since 3.2.0
	 */
	protected function getItemid(): int
	{
		return $this->input->post->get('item_id', 0, 'INT');
	}

	/**
	 * get the start marker
	 *
	 * @return  string  The string to use as the start marker
	 * @since 3.2.0
	 */
	protected function getMarkerstart(): string
	{
		return '{+' . '|' . '=[';
	}

	/**
	 * get the end marker
	 *
	 * @return  string  The string to use as the end marker
	 * @since 3.2.0
	 */
	protected function getMarkerend(): string
	{
		return ']=' . '|' . '+}';
	}

}

