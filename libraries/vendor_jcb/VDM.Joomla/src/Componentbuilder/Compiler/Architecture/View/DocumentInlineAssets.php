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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View\DocumentInlineAssetsInterface;


/**
 * View Document Inline Assets Class.
 * 
 * Builds the statements a view runs to add its own stylesheet and its own
 * script to the document, straight into the page rather than into a file.
 * 
 * How a view reaches the document to add them is what the compile target
 * decides, and it is the two extension points below.
 * 
 * @since  6.1.7
 */
class DocumentInlineAssets implements DocumentInlineAssetsInterface
{
	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 6.1.7
	 */
	protected Placeholder $placeholder;

	/**
	 * Constructor.
	 *
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Placeholder $placeholder)
	{
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the inline stylesheet a view adds to its document.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The statement, or nothing when the view declared none.
	 *
	 * @since   6.1.7
	 */
	public function css(array &$view): string
	{
		if ($view['settings']->add_css_document == 1)
		{
			$view['settings']->css_document = (array) explode(
				PHP_EOL, (string) $view['settings']->css_document
			);
			if (ArrayHelper::check(
				$view['settings']->css_document
			))
			{
				$script = $this->styleOpening();

				$cssDocument = PHP_EOL . Indent::_(3) . str_replace(
					'"', '\"', implode(
						PHP_EOL . Indent::_(3),
						$view['settings']->css_document
					)
				);

				return $script . $this->placeholder->update_(
					$cssDocument
				) . PHP_EOL . Indent::_(2) . '");';
			}
		}

		return '';
	}

	/**
	 * Build the inline script a view adds to its document.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The statement, or nothing when the view declared none.
	 *
	 * @since   6.1.7
	 */
	public function js(array &$view): string
	{
		if ($view['settings']->add_js_document == 1)
		{
			$view['settings']->js_document = (array) explode(
				PHP_EOL, (string) $view['settings']->js_document
			);
			if (ArrayHelper::check(
				$view['settings']->js_document
			))
			{
				$script = $this->scriptOpening();

				$jsDocument = PHP_EOL . Indent::_(3) . str_replace(
						'"', '\"', implode(
							PHP_EOL . Indent::_(3),
							$view['settings']->js_document
						)
					);

				return $script . $this->placeholder->update_(
						$jsDocument
					) . PHP_EOL . Indent::_(2) . '");';
			}
		}

		return '';
	}

	/**
	 * The statement a view opens its inline stylesheet with.
	 *
	 * @return  string  The comment and the opening call.
	 *
	 * @since   6.1.7
	 */
	protected function styleOpening(): string
	{
		return PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Set the Custom JS script to view" . PHP_EOL
			. Indent::_(2) . '$this->getDocument()->getWebAssetManager()->addInlineStyle("';
	}

	/**
	 * The statement a view opens its inline script with.
	 *
	 * @return  string  The comment and the opening call.
	 *
	 * @since   6.1.7
	 */
	protected function scriptOpening(): string
	{
		return PHP_EOL . Indent::_(2) . "//" . Line::_(
				__LINE__,__CLASS__
			) . " Set the Custom JS script to view" . PHP_EOL
			. Indent::_(2) . '$this->getDocument()->getWebAssetManager()->addInlineScript("';
	}
}

