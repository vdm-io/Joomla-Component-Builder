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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Filter Field File Class.
 * 
 * Builds the custom filter field type file a list view filter needs, once per
 * filter type.
 * 
 * The file is the same on every Joomla target, so this is one class.
 * 
 * @since  6.1.7
 */
final class FilterFieldFile
{
	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

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
	 * @param ContentMulti  $contentmulti  The ContentMulti Class.
	 * @param Structure     $structure     The Structure Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(ContentMulti $contentmulti, Structure $structure)
	{
		$this->contentmulti = $contentmulti;
		$this->structure = $structure;
	}

	/**
	 * Set the custom filter field type file of one filter.
	 *
	 * @param   string  $getOptions  The get options php string/code.
	 * @param   array   $filter      The filter details.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set($getOptions, $filter)
	{
		// make sure it is not already been build
		if (!$this->contentmulti->
			isArray('customfilterfield_' . $filter['filter_type']))
		{
			// start loading the field type
			// $this->fileContentDynamic['customfilterfield_'
			// . $filter['filter_type']]
			// = [];
			// JPREFIX <<DYNAMIC>>>
			$this->contentmulti->set('customfilterfield_' . $filter['filter_type'] . '|JPREFIX', 'J');
			// Type <<<DYNAMIC>>>
			$this->contentmulti->set('customfilterfield_' . $filter['filter_type'] . '|Type',
				StringHelper::safe(
					$filter['filter_type'], 'F'
				)
			);
			// type <<<DYNAMIC>>>
			$this->contentmulti->set('customfilterfield_' . $filter['filter_type'] . '|type',
				StringHelper::safe($filter['filter_type'])
			);
			// JFORM_GETOPTIONS_PHP <<<DYNAMIC>>>
			$this->contentmulti->set('customfilterfield_' . $filter['filter_type'] . '|JFORM_GETOPTIONS_PHP',
				$getOptions
			);
			// ADD_BUTTON <<<DYNAMIC>>>
			$this->contentmulti->set('customfilterfield_' . $filter['filter_type'] . '|ADD_BUTTON', '');
			// now build the custom filter field type file
			$target = array('admin' => 'customfilterfield');
			$this->structure->build(
				$target, 'fieldlist',
				$filter['filter_type']
			);
		}
	}
}

