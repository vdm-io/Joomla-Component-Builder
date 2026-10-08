<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    15th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\Menu;


use Joomla\CMS\Factory;
use Joomla\CMS\Application\CMSApplicationInterface as CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Builder\FrontendParams;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Request;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\Menu\CustomViewInterface;


/**
 * Custom View Menu Class.
 * 
 * Builds the `default.xml` menu metadata for a site or custom admin view,
 * including its request fields and frontend page parameters. The rule and
 * field lookup attributes of the generated fieldsets are supplied by the
 * Joomla-target variants through the `getPathAttributes()` extension
 * point; this shared implementation carries the Joomla 4+ namespace
 * prefixes.
 * 
 * @since  6.1.7
 */
class CustomView implements CustomViewInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * The ContentOne Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The FrontendParams Class.
	 *
	 * @var   FrontendParams
	 * @since 6.1.7
	 */
	protected FrontendParams $frontendparams;

	/**
	 * The Request Class.
	 *
	 * @var   Request
	 * @since 6.1.7
	 */
	protected Request $request;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 6.1.7
	 */
	protected Structure $structure;

	/**
	 * The CMS Application.
	 *
	 * @var   CMSApplication
	 * @since 6.1.7
	 */
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Config                $config           The Config Class.
	 * @param Language              $language         The Language Class.
	 * @param ContentOne            $contentone       The ContentOne Class.
	 * @param FrontendParams        $frontendparams   The FrontendParams Class.
	 * @param Request               $request          The Request Class.
	 * @param Structure             $structure        The Structure Class.
	 * @param CMSApplication|null   $app              The CMS Application object.
	 *
	 * @since 6.1.7
	 */
	public function __construct(Config $config, Language $language,
		ContentOne $contentone, FrontendParams $frontendparams,
		Request $request, Structure $structure, ?CMSApplication $app = null)
	{
		$this->config = $config;
		$this->language = $language;
		$this->contentone = $contentone;
		$this->frontendparams = $frontendparams;
		$this->request = $request;
		$this->structure = $structure;
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Get the custom/site view menu metadata XML.
	 *
	 * When the menu file cannot be added to the build structure a warning
	 * is enqueued and an empty string is returned.
	 *
	 * @param   array  $view  The view definition with its settings object.
	 *
	 * @return  string  The menu metadata XML, or an empty string.
	 *
	 * @since   6.1.7
	 */
	public function get(array $view): string
	{
		$target_area = 'Administrator';
		if ($this->config->build_target === 'site')
		{
			$target_area = 'Site';
		}
		$xml = '';
		// build the file target values
		$target = array('site' => $view['settings']->code);
		// build the default.xml file
		if ($this->structure->build($target, 'menu'))
		{
			// set the lang
			$lang = StringHelper::safe(
				'com_' . $this->config->component_code_name . '_menu_'
				. $view['settings']->code, 'U'
			);
			$this->language->set(
				'adminsys', $lang . '_TITLE', $view['settings']->name
			);
			$this->language->set(
				'adminsys', $lang . '_OPTION', $view['settings']->name
			);
			$this->language->set(
				'adminsys', $lang . '_DESC', $view['settings']->description
			);
			//start loading xml
			$xml = '<?xml version="1.0" encoding="utf-8" ?>';
			$xml .= PHP_EOL . '<metadata>';
			$xml .= PHP_EOL . Indent::_(1) . '<layout title="' . $lang
				. '_TITLE" option="' . $lang . '_OPTION">';
			$xml .= PHP_EOL . Indent::_(2) . '<message>';
			$xml .= PHP_EOL . Indent::_(3) . '<![CDATA[' . $lang . '_DESC]]>';
			$xml .= PHP_EOL . Indent::_(2) . '</message>';
			$xml .= PHP_EOL . Indent::_(1) . '</layout>';
			if ($this->request->isArray("id.{$view['settings']->code}")
				|| $this->request->isArray("catid.{$view['settings']->code}"))
			{
				$xml .= PHP_EOL . Indent::_(1) . '<!--' . Line::_(
						__LINE__,__CLASS__
					)
					. ' Add fields to the request variables for the layout. -->';
				$xml .= PHP_EOL . Indent::_(1) . '<fields name="request">';
				$xml .= PHP_EOL . Indent::_(2) . '<fieldset name="request"';
				$xml .= $this->getPathAttributes($target_area);

				if ($this->request->isArray("id.{$view['settings']->code}"))
				{
					foreach ($this->request->
						get("id.{$view['settings']->code}") as $requestFieldXML)
					{
						$xml .= PHP_EOL . Indent::_(3) . $requestFieldXML;
					}
				}
				if ($this->request->isArray("catid.{$view['settings']->code}"))
				{
					foreach ($this->request->
						get("catid.{$view['settings']->code}") as $requestFieldXML)
					{
						$xml .= PHP_EOL . Indent::_(3) . $requestFieldXML;
					}
				}
				$xml .= PHP_EOL . Indent::_(2) . '</fieldset>';
				$xml .= PHP_EOL . Indent::_(1) . '</fields>';
			}
			if ($this->frontendparams->exists($view['settings']->name))
			{
				// first we must setup the fields for the page use
				$params = $this->params(
					$this->frontendparams->get($view['settings']->name),
					$view['settings']->code
				);
				// now load the fields
				if (ArrayHelper::check($params))
				{
					$xml .= PHP_EOL . Indent::_(1) . '<!--' . Line::_(
							__LINE__,__CLASS__
						) . ' Adding page parameters -->';
					$xml .= PHP_EOL . Indent::_(1) . '<fields name="params">';
					$xml .= PHP_EOL . Indent::_(2)
						. '<fieldset name="basic" label="COM_'
						. $this->contentone->get('COMPONENT') . '"';
					$xml .= $this->getPathAttributes($target_area);
					$xml .= implode(Indent::_(3), $params);
					$xml .= PHP_EOL . Indent::_(2) . '</fieldset>';
					$xml .= PHP_EOL . Indent::_(1) . '</fields>';
				}
			}
			$xml .= PHP_EOL . '</metadata>';
		}
		else
		{
			$this->app->enqueueMessage(
				Text::sprintf(
					'<hr /><p>Site menu for <b>%s</b> was not build.</p>',
					$view['settings']->code
				), 'Warning'
			);
		}

		return $xml;
	}

	/**
	 * Prepare frontend parameter fields for menu use.
	 *
	 * Keeps fields whose display target is unset or `menu`, adds the
	 * global option to option sets that are not menu-only, and relaxes
	 * their defaults, filters, and required state.
	 *
	 * @param   array   $params  The parameter field XML strings.
	 * @param   string  $view    The view code name.
	 *
	 * @return  array  The parameter fields to keep.
	 *
	 * @since   6.1.7
	 */
	public function params(array $params, string $view): array
	{
		$keep       = [];
		$menuSetter = $view . '_menu';
		foreach ($params as $field)
		{
			// some switch to see if it should be added to front end params
			$target = GetHelper::between(
				$field, 'display="', '"'
			);
			if (!StringHelper::check($target)
				|| $target === 'menu')
			{
				$field = str_replace('display="menu"', '', (string) $field);
				// we update fields that have options if not only added to menu
				if ($target !== 'menu'
					&& strpos($field, 'Option Set. -->') !== false
					&& strpos($field, $menuSetter) === false
					&& !StringHelper::check($target))
				{
					// we add the global option
					$field = str_replace(
						'Option Set. -->',
						Line::_(__Line__, __Class__) . ' Global & Option Set. -->'
						. PHP_EOL . Indent::_(3) . '<option value="">' . PHP_EOL
						. Indent::_(4) . 'JGLOBAL_USE_GLOBAL</option>', $field
					);
					// update the default to be global
					$field = preg_replace(
						'/default=".+"/', 'default=""', $field
					);
					// update the default to be filter
					$field = preg_replace(
						'/filter=".+"/', 'filter="string"', $field
					);
					// update required
					$field = str_replace(
						'required="true"', 'required="false"', $field
					);
					// add to keeper array
					$keep[] = $field;
				}
				else
				{
					$keep[] = $field;
				}
			}
		}

		return $keep;
	}

	/**
	 * Get the fieldset rule and field lookup attributes.
	 *
	 * The shared implementation emits the Joomla 4+ namespace prefixes;
	 * the Joomla 3 variant overrides this with its path attributes.
	 *
	 * @param   string  $targetArea  The application area of the build target.
	 *
	 * @return  string  The fieldset lookup attribute XML.
	 *
	 * @since   6.1.7
	 */
	protected function getPathAttributes(string $targetArea): string
	{
		$xml = PHP_EOL . Indent::_(3)
			. 'addruleprefix="' . $this->config->namespace_prefix
			. '\Component\\' . $this->contentone->get('ComponentNamespace')
			. '\\' . $targetArea . '\Rule"';
		$xml .= PHP_EOL . Indent::_(3)
			. 'addfieldprefix="' . $this->config->namespace_prefix
			. '\Component\\' . $this->contentone->get('ComponentNamespace')
			. '\\' . $targetArea . '\Field">';

		return $xml;
	}
}

