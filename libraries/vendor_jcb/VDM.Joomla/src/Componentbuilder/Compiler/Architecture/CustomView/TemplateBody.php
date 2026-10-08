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
use VDM\Joomla\Componentbuilder\Compiler\Builder\TemplateData;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Model\Createdate;
use VDM\Joomla\Componentbuilder\Compiler\Model\Modifieddate;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Custom View Template Body Class.
 * 
 * Writes every template a custom view was drawn with into the component being
 * built, and fills in the code, the header and the default of each.
 * 
 * @since 6.1.7
 */
final class TemplateBody
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
	 * The Template Data Builder Class.
	 *
	 * @var   TemplateData
	 * @since 6.1.7
	 */
	protected TemplateData $templatedata;

	/**
	 * The Create Date Class.
	 *
	 * @var   Createdate
	 * @since 6.1.7
	 */
	protected Createdate $createdate;

	/**
	 * The Modified Date Class.
	 *
	 * @var   Modifieddate
	 * @since 6.1.7
	 */
	protected Modifieddate $modifieddate;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param Placeholder  $placeholder  The Placeholder Class.
	 * @param ContentMulti $contentmulti The Content Multi Builder Class.
	 * @param TemplateData $templatedata The Template Data Builder Class.
	 * @param Createdate   $createdate   The Create Date Class.
	 * @param Modifieddate $modifieddate The Modified Date Class.
	 * @param Structure    $structure    The Structure Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		Placeholder $placeholder,
		ContentMulti $contentmulti,
		TemplateData $templatedata,
		Createdate $createdate,
		Modifieddate $modifieddate,
		Structure $structure)
	{
		$this->config = $config;
		$this->placeholder = $placeholder;
		$this->contentmulti = $contentmulti;
		$this->templatedata = $templatedata;
		$this->createdate = $createdate;
		$this->modifieddate = $modifieddate;
		$this->structure = $structure;
	}

	/**
	 * Write the templates a custom view was drawn with.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  void
	 *
	 * @since   6.1.7
	 */
	public function set(array &$view): void
	{
		if (($data_ = $this->templatedata->
			get($this->config->build_target . '.' . $view['settings']->code)) !== null)
		{
			$created  = $this->createdate->get($view);
			$modified = $this->modifieddate->get($view);
			foreach ($data_ as $template => $data)
			{
				// build the file
				$target = [
					$this->config->build_target => $view['settings']->code
				];
				$config = [
					Placefix::_h('CREATIONDATE') => $created,
					Placefix::_h('BUILDDATE') => $modified,
					Placefix::_h('VERSION') => $view['settings']->version
				];
				$this->structure->build($target, 'template', $template, $config);
				// set the file data
				$TARGET = StringHelper::safe(
					$this->config->build_target, 'U'
				);
				if (!isset($data['html']) || $data['html'] === null)
				{
					echo '<pre>';
					var_dump($data);
					exit;
				}
				// SITE_TEMPLATE_BODY <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '_'
					. $template . '|' . $TARGET . '_TEMPLATE_BODY', PHP_EOL . $this->placeholder->update_(
						$data['html']
					));
				if (!isset($data['php_view']) || $data['php_view'] === null)
				{
					echo '<pre>';
					var_dump($data);
					exit;
				}
				// SITE_TEMPLATE_CODE_BODY <<<DYNAMIC>>>
				$this->contentmulti->set($view['settings']->code . '_'
					. $template . '|' . $TARGET . '_TEMPLATE_CODE_BODY',
					$this->templateCode($data['php_view'])
				);
			}
		}
	}
	/**
	 * Lay out the php of a template the way the generated file expects it.
	 *
	 * @param   string  $php  The php the template was drawn with.
	 *
	 * @return  string  The php, or nothing when the template carries none.
	 *
	 * @since   6.1.7
	 */
	protected function templateCode(&$php): string
	{
		if (StringHelper::check($php))
		{
			$php_view = (array) explode(PHP_EOL, (string) $php);
			if (ArrayHelper::check($php_view))
			{
				$php_view = PHP_EOL . PHP_EOL . implode(PHP_EOL, $php_view);

				return $this->placeholder->update_($php_view);
			}
		}

		return '';
	}
}

