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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Builder\CustomForm;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom View Body Class.
 * 
 * Gives back the body a custom view was drawn with, with the pagination
 * pieces put where the view asked for them and its placeholders filled in.
 * 
 * @since 6.1.7
 */
final class Body
{
	/**
	 * The Custom Form Builder Class.
	 *
	 * @var   CustomForm
	 * @since 6.1.7
	 */
	protected CustomForm $customform;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

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
	 * @param CustomForm  $customform  The Custom Form Builder Class.
	 * @param Config      $config      The Config Class.
	 * @param Placeholder $placeholder The Placeholder Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(CustomForm $customform,
		Config $config,
		Placeholder $placeholder)
	{
		$this->customform = $customform;
		$this->config = $config;
		$this->placeholder = $placeholder;
	}

	/**
	 * Build the body of a custom view.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string  The body, or nothing when the view was drawn with none.
	 *
	 * @since   6.1.7
	 */
	public function get(array &$view): string
	{
		if (StringHelper::check($view['settings']->default))
		{
			if ($view['settings']->main_get->gettype == 2
				&& $view['settings']->main_get->pagination == 1)
			{
				// does this view have a custom limitbox position
				$has_limitbox = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('LIMITBOX')
					) !== false);
				// does this view have a custom pages counter position
				$has_pagescounter = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGESCOUNTER')
					) !== false);
				// does this view have a custom pages links position
				$has_pageslinks = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGESLINKS')
					) !== false);
				// does this view have a custom pagination start position
				$has_pagination_start = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGINATIONSTART')
					) !== false);
				// does this view have a custom pagination end position
				$has_pagination_end = (strpos(
						(string) $view['settings']->default,
						(string) Placefix::_('PAGINATIONEND')
					) !== false);
				// if both page link and limit box is on the page, and page counter we don't need to add START and END stuff
				$has_pagination = ($has_limitbox && $has_pagescounter && $has_pageslinks);

				// add pagination start
				$this->placeholder->add_('PAGINATIONSTART', PHP_EOL
					. '<?php if (isset($this->items) && isset($this->pagination) && isset($this->pagination->pagesTotal) && $this->pagination->pagesTotal > 1): ?>');
				$this->placeholder->add_('PAGINATIONSTART',
					PHP_EOL . Indent::_(1) . '<div class="pagination">');
				$this->placeholder->add_('PAGINATIONSTART',
					PHP_EOL . Indent::_(2)
					. '<?php if ($this->params->def(\'show_pagination_results\', 1)) : ?>');

				// add pagination end
				$this->placeholder->set_('PAGINATIONEND',
						Indent::_(2) . '<?php endif; ?>');

				// only add if no custom page link is found
				if (!$has_pageslinks)
				{
					if ($this->config->build_target === 'custom_admin')
					{
						$this->placeholder->add_('PAGINATIONEND',
							PHP_EOL . Indent::_(2)
							. '<?php echo $this->pagination->getListFooter(); ?>');
					}
					else
					{
						$this->placeholder->add_('PAGINATIONEND',
							PHP_EOL . Indent::_(2)
							. '<?php echo $this->pagination->getPagesLinks(); ?>');
					}
				}

				$this->placeholder->add_('PAGINATIONEND',
					PHP_EOL . Indent::_(1) . '</div>');
				$this->placeholder->add_('PAGINATIONEND',
					PHP_EOL . '<?php endif; ?>');

				// add limit box
				$this->placeholder->set_('LIMITBOX',
					'<?php echo $this->pagination->getLimitBox(); ?>');

				// add pages counter
				$this->placeholder->set_('PAGESCOUNTER',
					'<?php echo $this->pagination->getPagesCounter(); ?>');

				// add pages links
				if ($this->config->build_target === 'custom_admin')
				{
					$this->placeholder->set_('PAGESLINKS',
						'<?php echo $this->pagination->getListFooter(); ?>');
				}
				else
				{
					$this->placeholder->set_('PAGESLINKS',
						'<?php echo $this->pagination->getPagesLinks(); ?>');
				}

				// build body
				$body = [];
				// Load the default values to the body
				$body[] = $this->placeholder->update_(
					$view['settings']->default
				);

				// add pagination start
				if (!$has_pagination && !$has_pagination_start)
				{
					$body[] = $this->placeholder->get_('PAGINATIONSTART');
				}

				if (!$has_limitbox && !$has_pagescounter)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				elseif (!$has_limitbox)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getLimitBox(); ?></p>';
				}
				elseif (!$has_pagescounter)
				{
					$body[] = Indent::_(3)
						. '<p class="counter pull-right"> <?php echo $this->pagination->getPagesCounter(); ?> </p>';
				}
				// add pagination end
				if (!$has_pagination && !$has_pagination_end)
				{
					$body[] = $this->placeholder->get_('PAGINATIONEND');
				}

				// lets clear the placeholders just in case
				$this->placeholder->remove_('LIMITBOX');
				$this->placeholder->remove_('PAGESCOUNTER');
				$this->placeholder->remove_('PAGESLINKS');
				$this->placeholder->remove_('PAGINATIONSTART');
				$this->placeholder->remove_('PAGINATIONEND');

				// insure the form is added (only if no form exist)
				if (strpos((string) $view['settings']->default, '<form') === false)
				{
					$this->customform->set($this->config->build_target . "." . $view['settings']->code, true);
				}

				// return the body
				return implode(PHP_EOL, $body);
			}
			else
			{
				// insure the form is added (only if no form exist)
				if ('site' !== $this->config->build_target
					&& strpos((string) $view['settings']->default, '<form') === false)
				{
					$this->customform->set($this->config->build_target . "." . $view['settings']->code, true);
				}

				return PHP_EOL . $this->placeholder->update_(
						$view['settings']->default
					);
			}
		}

		return '';
	}
}

