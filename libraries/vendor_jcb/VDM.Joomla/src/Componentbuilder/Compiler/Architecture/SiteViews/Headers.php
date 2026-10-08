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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\SiteViews;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Utilities\StringHelper;


/**
 * The site view file headers, keyed on the main get type the view was given.
 * 
 * @since 6.1.7
 */
final class Headers
{
	/**
	 * The Header Class.
	 *
	 * @var   HeaderInterface
	 * @since 6.1.7
	 */
	protected HeaderInterface $header;

	/**
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param HeaderInterface $header              The Header Class.
	 * @param ContentMulti    $contentmulti        The Content Multi Builder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(HeaderInterface $header,
		ContentMulti $contentmulti)
	{
		$this->header = $header;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Set the file headers one site view asks for.
	 *
	 * A view built around a single item is given the single view headers,
	 * one built around a list the list view headers. Either is given a
	 * controller header only when it carries controller code of its own.
	 *
	 * @param   array  $view  The site view the component was given.
	 *
	 * @return  void
	 * @since   6.1.7
	 */
	public function set(array $view): void
	{
		// set headers based on the main get type
		if ($view['settings']->main_get->gettype == 1)
		{
			// insure the controller headers are added
			if (StringHelper::check(
					$view['settings']->php_controller
				)
				&& $view['settings']->php_controller != '//')
			{
				// SITE_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the model
				$this->contentmulti->set($view['settings']->code . '|SITE_VIEW_CONTROLLER_HEADER',
					$this->header->get(
						'site.view.controller', $view['settings']->code
					)
				);
			}
			// SITE_VIEW_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEW_MODEL_HEADER',
				$this->header->get(
					'site.view.model', $view['settings']->code
				)
			);
			// SITE_VIEW_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEW_HTML_HEADER',
				$this->header->get(
					'site.view.html', $view['settings']->code
				)
			);
			// SITE_VIEW_HEADER <<<DYNAMIC>>> add the header details for the view
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEW_HEADER',
				$this->header->get(
					'site.view', $view['settings']->code
				)
			);
		}
		elseif ($view['settings']->main_get->gettype == 2)
		{
			// insure the controller headers are added
			if (StringHelper::check(
					$view['settings']->php_controller
				)
				&& $view['settings']->php_controller != '//')
			{
				// SITE_VIEW_CONTROLLER_HEADER <<<DYNAMIC>>> add the header details for the model
				$this->contentmulti->set($view['settings']->code . '|SITE_VIEW_CONTROLLER_HEADER',
					$this->header->get(
						'site.views.controller', $view['settings']->code
					)
				);
			}
			// SITE_VIEWS_MODEL_HEADER <<<DYNAMIC>>> add the header details for the model
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEWS_MODEL_HEADER',
				$this->header->get(
					'site.views.model', $view['settings']->code
				)
			);
			// SITE_VIEWS_HTML_HEADER <<<DYNAMIC>>> add the header details for the view
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEWS_HTML_HEADER',
				$this->header->get(
					'site.views.html', $view['settings']->code
				)
			);
			// SITE_VIEWS_HEADER <<<DYNAMIC>>> add the header details for the view
			$this->contentmulti->set($view['settings']->code . '|SITE_VIEWS_HEADER',
				$this->header->get(
					'site.views', $view['settings']->code
				)
			);
		}
	}
}

