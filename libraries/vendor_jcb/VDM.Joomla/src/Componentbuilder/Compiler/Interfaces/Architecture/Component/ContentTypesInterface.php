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

namespace VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Component;


/**
 * Component Content Types Interface
 * 
 * @since  6.1.7
 */
interface ContentTypesInterface
{
	/**
	 * Build the content type declarations of every admin view that needs one.
	 *
	 * @param   string  $action  Whether the component is installing or updating.
	 *
	 * @return  string  The generated declarations, or nothing when no view keeps history or carries tags.
	 *
	 * @since   6.1.7
	 */
	public function get(string $action): string;

	/**
	 * Build one admin view's content type declaration.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array|false  The declaration, or false when the view needs none.
	 *
	 * @since   6.1.7
	 */
	public function contentType(string $view, string $component);

	/**
	 * Build the content type declaration of one view's own category.
	 *
	 * @param   string  $view       The single view code name.
	 * @param   string  $views      The list view code name, which the declaration does not use.
	 * @param   string  $component  The component code name.
	 *
	 * @return  array  The declaration.
	 *
	 * @since   6.1.7
	 */
	public function categoryContentType(string $view, string $views, string $component): array;
}

