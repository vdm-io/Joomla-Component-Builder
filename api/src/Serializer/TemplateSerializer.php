<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
namespace VDM\Component\Componentbuilder\Api\Serializer;

use Joomla\CMS\Serializer\JoomlaSerializer;
use Joomla\CMS\Tag\TagApiSerializerTrait;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Relationship;
use Tobscure\JsonApi\Resource;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;

// No direct access to this file
\defined('_JEXEC') or die;

/**
 * Template Api Serializer
 *
 * Builds the relationships of the template resource, for the item and
 * the list representation alike.
 *
 * @since  4.0.0
 */
class TemplateSerializer extends JoomlaSerializer
{

	/**
	 * Build the dynamic_get relationship.
	 *
	 * @param   \stdClass  $item  The item.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	public function dynamicGet($item)
	{
		// Relate the dynamic_get to the dynamic_gets resource.
		return $this->related($item->dynamic_get ?? null, 'dynamic_gets');
	}

	/**
	 * Build the snippet relationship.
	 *
	 * @param   \stdClass  $item  The item.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	public function snippet($item)
	{
		// Relate the snippet to the snippets resource.
		return $this->related($item->snippet ?? null, 'snippets');
	}

	/**
	 * Build the libraries relationship.
	 *
	 * @param   \stdClass  $item  The item.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	public function libraries($item)
	{
		// Relate the libraries to the libraries resource.
		return $this->related($item->libraries ?? null, 'libraries');
	}

	/**
	 * Build the created_by relationship.
	 *
	 * @param   \stdClass  $item  The item.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	public function createdBy($item)
	{
		// Relate the created_by to the users resource.
		return $this->related($item->created_by ?? null, 'users');
	}

	/**
	 * Build the modified_by relationship.
	 *
	 * @param   \stdClass  $item  The item.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	public function modifiedBy($item)
	{
		// Relate the modified_by to the users resource.
		return $this->related($item->modified_by ?? null, 'users');
	}

	/**
	 * Build the relationship to one related resource, or to many when the value holds several ids.
	 *
	 * @param   mixed   $value  The id of the related resource, or the ids of the related resources.
	 * @param   string  $type   The type of the related resource.
	 *
	 * @return  Relationship
	 *
	 * @since   4.0.0
	 */
	protected function related($value, string $type): Relationship
	{
		$serializer = new JoomlaSerializer($type);

		if (is_array($value))
		{
			$resources = [];

			foreach ($value as $id)
			{
				if ($id !== null && $id !== '' && !is_array($id) && !is_object($id))
				{
					$resources[] = new Resource($id, $serializer);
				}
			}

			return new Relationship(new Collection($resources, $serializer));
		}

		return new Relationship(new Resource($value, $serializer));
	}
}
