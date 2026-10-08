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
use VDM\Joomla\Componentbuilder\Compiler\Power\Selection;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TemplateData;
use VDM\Joomla\Componentbuilder\Compiler\Alias\Data as Aliasdata;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Counter;
use VDM\Joomla\Utilities\ArrayHelper;


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
	 * Shared literal dependency selection.
	 *
	 * @var   Selection
	 * @since 6.2.0
	 */
	protected Selection $selection;

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
	 * The Counter Class.
	 *
	 * @var   Counter
	 * @since 5.1.4
	 */
	protected Counter $counter;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param LayoutData     $layoutdata     The LayoutData Class.
	 * @param TemplateData   $templatedata   The TemplateData Class.
	 * @param Aliasdata      $aliasdata      The AliasData Class.
	 * @param Counter        $counter        The Counter Class.
	 * @param Selection|null $selection      Shared literal dependency selection.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, LayoutData $layoutdata,
		TemplateData $templatedata, Aliasdata $aliasdata,
		Counter $counter, ?Selection $selection = null)
	{
		$this->config = $config;
		$this->selection = $selection ?? new Selection();
		$this->layoutdata = $layoutdata;
		$this->templatedata = $templatedata;
		$this->aliasdata = $aliasdata;
		$this->counter = $counter;
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
		$references = $this->selection->codeReferences($content);

		// check if template keys were passed
		if (!ArrayHelper::check($templates))
		{
			$templates = $references['template'];
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

						// count entity
						$this->counter->template++;
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
			$layouts = $references['layout'];
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

						// count entity
						$this->counter->layout++;
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

