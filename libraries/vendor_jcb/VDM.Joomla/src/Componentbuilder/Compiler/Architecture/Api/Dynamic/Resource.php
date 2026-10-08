<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    2nd September, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Dynamic;


use VDM\Joomla\Componentbuilder\Compiler\Component;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface as Header;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\Api\Resources;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The API resource of a site view or custom admin view
 * 
 * Sets every placeholder of the dynamic API templates for one view, keyed
 * by the API name the resources map resolved for it.
 * 
 * @since 6.1.7
 */
class Resource
{
	/**
	 * The Api Resources Class.
	 *
	 * @var   Resources
	 * @since 6.1.7
	 */
	protected Resources $resources;

	/**
	 * The Component Class.
	 *
	 * @var   Component
	 * @since 6.1.7
	 */
	protected Component $component;

	/**
	 * The Header Class.
	 *
	 * @var   Header
	 * @since 6.1.7
	 */
	protected Header $header;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Api Dynamic GetModel Class.
	 *
	 * @var   GetModel
	 * @since 6.1.7
	 */
	protected GetModel $getmodel;

	/**
	 * The Api Dynamic AllowView Class.
	 *
	 * @var   AllowView
	 * @since 6.1.7
	 */
	protected AllowView $allowview;

	/**
	 * The Api Dynamic Expectations Class.
	 *
	 * @var   Expectations
	 * @since 6.1.7
	 */
	protected Expectations $expectations;

	/**
	 * The Api Dynamic PrepareItem Class.
	 *
	 * @var   PrepareItem
	 * @since 6.1.7
	 */
	protected PrepareItem $prepareitem;

	/**
	 * The Api Dynamic Meta Class.
	 *
	 * @var   Meta
	 * @since 6.1.7
	 */
	protected Meta $meta;

	/**
	 * Constructor.
	 *
	 * @param Resources     $resources     The Api Resources Class.
	 * @param Component     $component     The Component Class.
	 * @param Header        $header        The Header Class.
	 * @param ContentMulti  $contentmulti  The ContentMulti Class.
	 * @param GetModel      $getmodel      The Api Dynamic GetModel Class.
	 * @param AllowView     $allowview     The Api Dynamic AllowView Class.
	 * @param Expectations  $expectations  The Api Dynamic Expectations Class.
	 * @param PrepareItem   $prepareitem   The Api Dynamic PrepareItem Class.
	 * @param Meta          $meta          The Api Dynamic Meta Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Resources $resources, Component $component,
		Header $header, ContentMulti $contentmulti, GetModel $getmodel,
		AllowView $allowview, Expectations $expectations,
		PrepareItem $prepareitem, Meta $meta)
	{
		$this->resources = $resources;
		$this->component = $component;
		$this->header = $header;
		$this->contentmulti = $contentmulti;
		$this->getmodel = $getmodel;
		$this->allowview = $allowview;
		$this->expectations = $expectations;
		$this->prepareitem = $prepareitem;
		$this->meta = $meta;
	}

	/**
	 * Set the placeholders of the API resource of a view.
	 *
	 * @param   array   $view  The view link with its settings.
	 * @param   string  $area  The area of the view.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(array $view, string $area): void
	{
		$code = $view['settings']->code ?? null;

		if (!is_string($code) || $code === '')
		{
			return;
		}

		if (!$this->resources->mapped())
		{
			$this->resources->map(
				$this->links('admin_views'),
				$this->links('custom_admin_views'),
				$this->links('site_views')
			);
		}

		$resource = $this->resources->get($area, $code);

		if ($resource === null)
		{
			return;
		}

		$name = $resource['name'];
		$Name = StringHelper::safe($name, 'F');

		$this->contentmulti->set($name . '|ApiName', $Name);
		$this->contentmulti->set($name . '|apiname', $name);
		$this->contentmulti->set($name . '|SView', $view['settings']->Code ?? StringHelper::safe($code, 'F'));
		$this->contentmulti->set($name . '|sview', $code);

		if ($resource['item'])
		{
			$this->item($resource, $name, $Name);
		}
		elseif ($resource['list'])
		{
			$this->list($resource, $name, $Name);
		}
	}

	/**
	 * Set the placeholders of an item resource.
	 *
	 * @param   array   $resource  The resource.
	 * @param   string  $name      The API name.
	 * @param   string  $Name      The API name in class case.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	private function item(array $resource, string $name, string $Name): void
	{
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_CONTROLLER_HEADER',
			$this->header->get('api.dynamic.view.controller', $Name)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_CONTROLLER_GETMODEL',
			$this->getmodel->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_CONTROLLER_ALLOWVIEW',
			$this->allowview->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_CONTROLLER_EXPECTATIONS',
			$this->expectations->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_JSON_HEADER',
			$this->header->get('api.dynamic.view.json', $Name)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEW_JSON_PREPAREITEM',
			$this->prepareitem->get($resource, false)
		);
	}

	/**
	 * Set the placeholders of a list resource.
	 *
	 * @param   array   $resource  The resource.
	 * @param   string  $name      The API name.
	 * @param   string  $Name      The API name in class case.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	private function list(array $resource, string $name, string $Name): void
	{
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_CONTROLLER_HEADER',
			$this->header->get('api.dynamic.views.controller', $Name)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_CONTROLLER_GETMODEL',
			$this->getmodel->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_CONTROLLER_ALLOWVIEW',
			$this->allowview->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_CONTROLLER_EXPECTATIONS',
			$this->expectations->get($resource)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_JSON_HEADER',
			$this->header->get('api.dynamic.views.json', $Name)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_JSON_PREPAREITEM',
			$this->prepareitem->get($resource, true)
		);
		$this->contentmulti->set($name . '|API_DYNAMIC_VIEWS_JSON_META',
			$this->meta->get($resource)
		);
	}

	/**
	 * The view links of one area of the component.
	 *
	 * @param   string  $key  The component key of the links.
	 *
	 * @return  array
	 * @since   6.1.7
	 */
	private function links(string $key): array
	{
		return $this->component->isArray($key) ? $this->component->get($key) : [];
	}
}

