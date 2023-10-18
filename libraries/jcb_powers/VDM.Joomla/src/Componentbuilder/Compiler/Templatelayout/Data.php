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

namespace VDM\Joomla\Componentbuilder\Compiler\Templatelayout;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TemplateData;
use VDM\Joomla\Componentbuilder\Compiler\Alias\Data as Aliasdata;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;


/**
 * Template Layout Data Class
 * 
 * @since 3.2.0
 */
class Data
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The LayoutData Class.
	 *
	 * @var   LayoutData
	 * @since 3.2.0
	 */
	protected LayoutData $layoutdata;

	/**
	 * The TemplateData Class.
	 *
	 * @var   TemplateData
	 * @since 3.2.0
	 */
	protected TemplateData $templatedata;

	/**
	 * The Data Class.
	 *
	 * @var   Aliasdata
	 * @since 3.2.0
	 */
	protected Aliasdata $aliasdata;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param LayoutData     $layoutdata     The LayoutData Class.
	 * @param TemplateData   $templatedata   The TemplateData Class.
	 * @param Aliasdata      $aliasdata      The AliasData Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, LayoutData $layoutdata, TemplateData $templatedata, Aliasdata $aliasdata)
	{
		$this->config = $config;
		$this->layoutdata = $layoutdata;
		$this->templatedata = $templatedata;
		$this->aliasdata = $aliasdata;
	}

	/**
	 * Set Template and Layout Data
	 *
	 * @param   string   $content    The content to check
	 * @param   string   $view       The view code name
	 * @param   bool     $found      The proof that something was found
	 * @param   array    $templates  The option to pass templates keys (to avoid search)
	 * @param   array    $layouts    The option to pass layout keys (to avoid search)
	 *
	 * @return  bool if something was found true
	 * @since 3.2.0
	 */
	public function set(string $content, string $view, bool $found = false,
		array $templates = [], array $layouts = []): bool
	{
		// to check inside the templates
		$again = [];

		// check if template keys were passed
		if (!ArrayHelper::check($templates))
		{
			// set the Template data
			$temp1 = GetHelper::allBetween(
				$content, "\$this->loadTemplate('", "')"
			);
			$temp2 = GetHelper::allBetween(
				$content, '$this->loadTemplate("', '")'
			);
			if (ArrayHelper::check($temp1)
				&& ArrayHelper::check($temp2))
			{
				$templates = array_merge($temp1, $temp2);
			}
			else
			{
				if (ArrayHelper::check($temp1))
				{
					$templates = $temp1;
				}
				elseif (ArrayHelper::check($temp2))
				{
					$templates = $temp2;
				}
			}
		}

		// check if we found templates
		if (ArrayHelper::check($templates, true))
		{
			foreach ($templates as $template)
			{
				if (!$this->templatedata->
					exists($this->config->build_target . '.' . $view . '.' . $template))
				{
					$data = $this->aliasdata->get(
						$template, 'template', $view
					);
					if (ArrayHelper::check($data))
					{
						// load it to the template data array
						$this->templatedata->
							set($this->config->build_target . '.' . $view . '.' . $template, $data);
						// call self to get child data
						$again[] = ['content' => $data['html'], 'view' => $view];
						$again[] = ['content' => $data['php_view'], 'view' => $view];
					}
				}

				// check if we have the template set (and nothing yet found)
				if (!$found && $this->templatedata->
					exists($this->config->build_target . '.' . $view . '.' . $template, null))
				{
					// something was found
					$found = true;
				}
			}
		}

		// check if layout keys were passed
		if (!ArrayHelper::check($layouts))
		{
			// set the Layout data
			$lay1 = GetHelper::allBetween(
				$content, "JLayoutHelper::render('", "',"
			);
			$lay2 = GetHelper::allBetween(
				$content, 'JLayoutHelper::render("', '",'
			);
			if (ArrayHelper::check($lay1)
				&& ArrayHelper::check($lay2))
			{
				$layouts = array_merge($lay1, $lay2);
			}
			else
			{
				if (ArrayHelper::check($lay1))
				{
					$layouts = $lay1;
				}
				elseif (ArrayHelper::check($lay2))
				{
					$layouts = $lay2;
				}
			}
		}

		// check if we found layouts
		if (ArrayHelper::check($layouts, true))
		{
			// get the other target if both
			$_target = null;
			if ($this->config->lang_target === 'both')
			{
				$_target = ($this->config->build_target === 'admin') ? 'site' : 'admin';
			}

			foreach ($layouts as $layout)
			{
				if (!$this->layoutdata->exists($this->config->build_target . '.' . $layout))
				{
					$data = $this->aliasdata->get($layout, 'layout', $view);
					if (ArrayHelper::check($data))
					{
						// load it to the layout data array
						$this->layoutdata->
							set($this->config->build_target . '.' . $layout, $data);
						// check if other target is set
						if ($this->config->lang_target === 'both' && $_target)
						{
							$this->layoutdata->set($_target . '.' . $layout, $data);
						}
						// call self to get child data
						$again[] = ['content' => $data['html'], 'view' => $view];
						$again[] = ['content' => $data['php_view'], 'view' => $view];
					}
				}

				// check if we have the layout set (and nothing yet found)
				if (!$found && $this->layoutdata->exists($this->config->build_target . '.' . $layout))
				{
					// something was found
					$found = true;
				}
			}
		}

		// check again
		if (ArrayHelper::check($again))
		{
			foreach ($again as $go)
			{
				$found = $this->set(
					$go['content'], $go['view'], $found
				);
			}
		}

		// return the proof that something was found
		return $found;
	}
}

