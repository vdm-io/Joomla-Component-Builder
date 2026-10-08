<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    18th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\View;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UikitComp;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\View\UikitLoaderInterface;


/**
 * View Uikit Loader Class.
 * 
 * Builds the statements a view runs to load the uikit assets it needs: the
 * options the component was built with, the styles and scripts of the uikit
 * version in use, and the components the view's own fields ask for.
 * 
 * @since  6.1.7
 */
class UikitLoader implements UikitLoaderInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Site Field Data Class.
	 *
	 * @var   SiteFieldData
	 * @since 6.1.7
	 */
	protected SiteFieldData $sitefielddata;

	/**
	 * The Uikit Comp Class.
	 *
	 * @var   UikitComp
	 * @since 6.1.7
	 */
	protected UikitComp $uikitcomp;

	/**
	 * Constructor.
	 *
	 * @param Config         $config         The Config Class.
	 * @param ContentOne     $contentone     The ContentOne Class.
	 * @param SiteFieldData  $sitefielddata  The Site Field Data Class.
	 * @param UikitComp      $uikitcomp      The Uikit Comp Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config,
		ContentOne $contentone,
		SiteFieldData $sitefielddata,
		UikitComp $uikitcomp)
	{
		$this->config = $config;
		$this->contentone = $contentone;
		$this->sitefielddata = $sitefielddata;
		$this->uikitcomp = $uikitcomp;
	}

	/**
	 * Build the statements that load the uikit assets a view needs.
	 *
	 * @param   array  $view  The view being built.
	 *
	 * @return  string
	 *
	 * @since   6.1.7
	 */
	public function get(array $view): string
	{
		// reset setter
		$setter = '';
		// load the defaults needed
		if ($this->config->uikit > 0)
		{
			$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Load uikit options.";
			$setter .= PHP_EOL . Indent::_(2)
				. "\$uikit = \$this->params->get('uikit_load');";
			$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(__Line__, __Class__)
				. " Set script size.";
			$setter .= PHP_EOL . Indent::_(2)
				. "\$size = \$this->params->get('uikit_min');";
			$tabV   = "";
			// if both versions should be loaded then add some more logic
			if (2 == $this->config->uikit)
			{
				$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Load uikit version.";
				$setter .= PHP_EOL . Indent::_(2)
					. "\$this->uikitVersion = \$this->params->get('uikit_version', 2);";
				$setter .= PHP_EOL . PHP_EOL . Indent::_(2) . "//"
					. Line::_(__Line__, __Class__) . " Use Uikit Version 2";
				$setter .= PHP_EOL . Indent::_(2)
					. "if (2 == \$this->uikitVersion)";
				$setter .= PHP_EOL . Indent::_(2) . "{";
				$tabV   = Indent::_(1);
			}
		}
		// load the defaults needed
		if (2 == $this->config->uikit || 1 == $this->config->uikit)
		{
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Set css style.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "\$style = \$this->params->get('uikit_style');";

			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/css/uikit'.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/js/uikit'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		// load the components need
		if ((2 == $this->config->uikit || 1 == $this->config->uikit)
			&& ($data_ = $this->uikitcomp->get($view['settings']->code)) !== null)
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the script to find all uikit components needed.";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "if (\$uikit != 2)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " Set the default uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "\$uikitComp = [];";
			foreach ($data_ as $class)
			{
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "\$uikitComp[] = '"
					. $class . "';";
			}
			// check content for more needed components
			if ($this->sitefielddata->exists('uikit.' . $view['settings']->code))
			{
				$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(3) . "//"
					. Line::_(__Line__, __Class__)
					. " Get field uikit components needed in this view.";
				$setter .= PHP_EOL . $tabV . Indent::_(3)
					. "\$uikitFieldComp = \$this->get('UikitComp');";
				$setter .= PHP_EOL . $tabV . Indent::_(3)
					. "if (isset(\$uikitFieldComp) && "
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitFieldComp))";
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(4)
					. "if (isset(\$uikitComp) && "
					. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = array_merge(\$uikitComp, \$uikitFieldComp);";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = array_unique(\$uikitComp);";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "else";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
				$setter .= PHP_EOL . $tabV . Indent::_(5)
					. "\$uikitComp = \$uikitFieldComp;";
				$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
				$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			}
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if (\$uikit != 2 && isset(\$uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " loading...";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "foreach ("
				. $this->contentone->get('Component') . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the css.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('stylesheet', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the js.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('script', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		elseif ((2 == $this->config->uikit || 1 == $this->config->uikit)
			&& $this->sitefielddata->exists('uikit.' . $view['settings']->code))
		{
			$setter .= PHP_EOL . PHP_EOL . $tabV . Indent::_(2) . "//"
				. Line::_(__Line__, __Class__)
				. " Load the needed uikit components in this view.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "\$uikitComp = \$this->get('UikitComp');";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if (\$uikit != 2 && isset(\$uikitComp) && "
				. "Super_" . "__0a59c65c_9daf_4bc9_baf4_e063ff9e6a8a___Power::check(\$uikitComp))";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " loading...";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "foreach (\$uikitComp as \$class)";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "foreach ("
				. $this->contentone->get('Component') . "Helper::\$uk_components[\$class] as \$name)";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the CSS file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the css.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('stylesheet', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/css/components/'.\$name.\$style.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if the JavaScript file exists.";
			$setter .= PHP_EOL . $tabV . Indent::_(5)
				. "if (@file_exists(JPATH_ROOT.'/media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js'))";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(6) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " load the js.";
			$setter .= PHP_EOL . $tabV . Indent::_(6)
				. "Html::_('script', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v2/js/components/'.\$name.\$size.'.js', ['version' => 'auto'], ['type' => 'text/javascript', 'async' => 'async']);";
			$setter .= PHP_EOL . $tabV . Indent::_(5) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(4) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(3) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
		}
		// now set the version 3
		if (2 == $this->config->uikit || 3 == $this->config->uikit)
		{
			if (2 == $this->config->uikit)
			{
				$setter .= PHP_EOL . Indent::_(2) . "}";
				$setter .= PHP_EOL . Indent::_(2) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " Use Uikit Version 3";
				$setter .= PHP_EOL . Indent::_(2)
					. "elseif (3 == \$this->uikitVersion)";
				$setter .= PHP_EOL . Indent::_(2) . "{";
			}
			// add version 3 fiels to page
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit css.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->css_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('stylesheet', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v3/css/uikit'.\$size.'.css', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " The uikit js.";
			$setter .= PHP_EOL . $tabV . Indent::_(2)
				. "if ((!\$HeaderCheck->js_loaded('uikit.min') || \$uikit == 1) && \$uikit != 2 && \$uikit != 3)";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "{";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v3/js/uikit'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(3)
				. "Html::_('script', 'media/com_"
				. $this->config->component_code_name
				. "/uikit-v3/js/uikit-icons'.\$size.'.js', ['version' => 'auto']);";
			$setter .= PHP_EOL . $tabV . Indent::_(2) . "}";
			if (2 == $this->config->uikit)
			{
				$setter .= PHP_EOL . Indent::_(2) . "}";
			}
		}

		return $setter;
	}
}

