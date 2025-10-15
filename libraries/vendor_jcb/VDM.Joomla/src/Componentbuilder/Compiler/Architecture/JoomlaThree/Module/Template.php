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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\Module;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\DispenserInterface as Dispenser;
use VDM\Joomla\Componentbuilder\Compiler\Builder\TemplateData;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Module\TemplateInterface;


/**
 * Module Template Joomla 3
 * 
 * @since 5.1.2
 */
final class Template implements TemplateInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 5.1.2
	 */
	protected Config $config;

	/**
	 * The Dispenser Class.
	 *
	 * @var   Dispenser
	 * @since 5.1.2
	 */
	protected Dispenser $dispenser;

	/**
	 * The TemplateData Class.
	 *
	 * @var   TemplateData
	 * @since 5.1.2
	 */
	protected TemplateData $templatedata;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 5.1.2
	 */
	protected Placeholder $placeholder;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 5.1.2
	 */
	protected ContentOne $contentone;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.2
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param Dispenser      $dispenser      The Dispenser Class.
	 * @param TemplateData   $templatedata   The TemplateData Class.
	 * @param Placeholder    $placeholder    The Placeholder Class.
	 * @param ContentOne     $contentone     The ContentOne Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Config $config, Dispenser $dispenser,
		TemplateData $templatedata, Placeholder $placeholder,
		ContentOne $contentone, ContentMulti $contentmulti)
	{
		$this->config = $config;
		$this->dispenser = $dispenser;
		$this->templatedata = $templatedata;
		$this->placeholder = $placeholder;
		$this->contentone = $contentone;
		$this->contentmulti = $contentmulti;
	}

	/**
	 * Get the updated placeholder default template content for the given module.
	 *
	 * @param  object  $module   The module object containing the necessary data.
	 * @param  string  $key      The dispenser key for this given module.
	 *
	 * @return string  The updated placeholder content.
	 * @since  5.1.2
	 */
	public function default(object $module, string $key): string
	{
		// first add the header
		$default = PHP_EOL . ($module->default_header ?? '') . PHP_EOL . '?>';

		// add any css from the fields
		$default .= $this->dispenser->get(
			'css_views',
			$key,
			PHP_EOL . '<style>',
			'',
			true,
			null,
			PHP_EOL . '</style>' . PHP_EOL
		);

		// now add the body
		$default .= PHP_EOL . ($module->default ?? '') . PHP_EOL;

		// add any JavaScript from the fields
		$default .= $this->dispenser->get(
			'views_footer',
			$key,
			PHP_EOL . '<script type="text/javascript">',
			'',
			true,
			null,
			PHP_EOL . '</script>' . PHP_EOL
		);

		// return the default content for the model default area
		return $this->placeholder->update($default, $this->contentone->allActive());
	}

	/**
	 * Get the updated placeholder extra template content for the given module.
	 *
	 * @param  object  $module   The module object containing the necessary data.
	 *
	 * @return void
	 * @since  5.1.2
	 */
	public function extra(object $module): void
	{
		$dataKey = $this->config->build_target . '.' . $module->code_name;

		if (($data = $this->templatedata->get($dataKey)) !== null)
		{
			foreach ($data as $template => $item)
			{
				$header  = $item['php_view'] ?? null;
				$body    = $item['html'] ?? '';
				$default = ($header ? PHP_EOL . $header . PHP_EOL . '?>' : PHP_EOL . '?>') . PHP_EOL . $body;

				$TARGET = StringHelper::safe("MODDEFAULT_{$template}", 'U');
				$key    = $module->key . '|' . $TARGET;

				$this->contentmulti->set(
					$key,
					$this->placeholder->update($default, $this->contentone->allActive())
				);
			}
		}
	}
}

