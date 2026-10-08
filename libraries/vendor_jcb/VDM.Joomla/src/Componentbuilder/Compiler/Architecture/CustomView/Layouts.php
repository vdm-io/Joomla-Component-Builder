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


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Builder\LayoutData;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom View Layouts Class.
 * 
 * Writes every layout the build target collected into the component being
 * built, and fills in the code, the header and the default of each.
 * 
 * @since 6.1.7
 */
final class Layouts
{
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
	 * The Content Multi Builder Class.
	 *
	 * @var   ContentMulti
	 * @since 6.1.7
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Layout Data Builder Class.
	 *
	 * @var   LayoutData
	 * @since 6.1.7
	 */
	protected LayoutData $layoutdata;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The Header Class.
	 *
	 * @var   HeaderInterface
	 * @since 6.1.7
	 */
	protected HeaderInterface $header;

	/**
	 * Constructor.
	 *
	 * @param Config          $config       The Config Class.
	 * @param Placeholder     $placeholder  The Placeholder Class.
	 * @param ContentMulti    $contentmulti The Content Multi Builder Class.
	 * @param LayoutData      $layoutdata   The Layout Data Builder Class.
	 * @param Structure       $structure    The Structure Class.
	 * @param HeaderInterface $header       The Header Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Placeholder $placeholder,
		ContentMulti $contentmulti,
		LayoutData $layoutdata,
		Structure $structure,
		HeaderInterface $header)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->layoutdata = $layoutdata;
		$this->structure = $structure;
		$this->header = $header;
	}

	/**
	 * Write the layouts of the build target.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(): void
	{
		if (($data_ = $this->layoutdata->
			get($this->config->build_target)) !== null)
		{
			foreach ($data_ as $layout => $data)
			{
				// build the file
				$target = array($this->config->build_target => $layout);
				$this->structure->build($target, 'layout');
				// set the file data
				$TARGET = StringHelper::safe(
					$this->config->build_target, 'U'
				);
				// SITE_LAYOUT_CODE <<<DYNAMIC>>>
				$php_view = (array) explode(PHP_EOL, (string) $data['php_view']);
				if (ArrayHelper::check($php_view))
				{
					$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);
					$this->contentmulti->set($layout . '|' . $TARGET . '_LAYOUT_CODE',
						$this->placeholder->update_(
							$php_view
						)
					);
				}
				else
				{
					$this->contentmulti->set($layout . '|' . $TARGET
						. '_LAYOUT_CODE',  '');
				}
				// SITE_LAYOUT_BODY <<<DYNAMIC>>>
				$this->contentmulti->set($layout . '|' . $TARGET . '_LAYOUT_BODY',
					PHP_EOL . $this->placeholder->update_(
						$data['html']
					)
				);
				// SITE_LAYOUT_HEADER <<<DYNAMIC>>>
				$this->contentmulti->set($layout . '|' . $TARGET . '_LAYOUT_HEADER',
					(($header = $this->header->get(
							str_replace('_', '.', (string) $this->config->build_target) . '.layout',
							$layout, false)) !== false) ? PHP_EOL . PHP_EOL . $header : ''
				);
			}
		}
	}
}

