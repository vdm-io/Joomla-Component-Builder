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

namespace VDM\Joomla\Componentbuilder\Compiler\JoomlaThree;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\EventInterface as Event;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Builder\UikitComp;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AdminFilterType;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Category;
use VDM\Joomla\Componentbuilder\Compiler\Builder\AccessSwitchList;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Filter;
use VDM\Joomla\Componentbuilder\Compiler\Builder\Tags;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\HeaderInterface;


/**
 * Build headers for all Joomla 3 files
 * 
 * @since 3.2.0
 */
final class Header implements HeaderInterface
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The EventInterface Class.
	 *
	 * @var   Event
	 * @since 3.2.0
	 */
	protected Event $event;

	/**
	 * The Placeholder Class.
	 *
	 * @var   Placeholder
	 * @since 3.2.0
	 */
	protected Placeholder $placeholder;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 3.2.0
	 */
	protected Language $language;

	/**
	 * The UikitComp Class.
	 *
	 * @var   UikitComp
	 * @since 3.2.0
	 */
	protected UikitComp $uikitcomp;

	/**
	 * The AdminFilterType Class.
	 *
	 * @var   AdminFilterType
	 * @since 3.2.0
	 */
	protected AdminFilterType $adminfiltertype;

	/**
	 * The Category Class.
	 *
	 * @var   Category
	 * @since 3.2.0
	 */
	protected Category $category;

	/**
	 * The AccessSwitchList Class.
	 *
	 * @var   AccessSwitchList
	 * @since 3.2.0
	 */
	protected AccessSwitchList $accessswitchlist;

	/**
	 * The Filter Class.
	 *
	 * @var   Filter
	 * @since 3.2.0
	 */
	protected Filter $filter;

	/**
	 * The Tags Class.
	 *
	 * @var   Tags
	 * @since 3.2.0
	 */
	protected Tags $tags;

	/**
	 * The Header Context array
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected array $headers = [];

	/**
	 * Constructor.
	 *
	 * @param Config             $config             The Config Class.
	 * @param Event              $event              The EventInterface Class.
	 * @param Placeholder        $placeholder        The Placeholder Class.
	 * @param Language           $language           The Language Class.
	 * @param UikitComp          $uikitcomp          The UikitComp Class.
	 * @param AdminFilterType    $adminfiltertype    The AdminFilterType Class.
	 * @param Category           $category           The Category Class.
	 * @param AccessSwitchList   $accessswitchlist   The AccessSwitchList Class.
	 * @param Filter             $filter             The Filter Class.
	 * @param Tags               $tags               The Tags Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, Event $event, Placeholder $placeholder,
		Language $language, UikitComp $uikitcomp,
		AdminFilterType $adminfiltertype, Category $category,
		AccessSwitchList $accessswitchlist, Filter $filter,
		Tags $tags)
	{
		$this->config = $config;
		$this->event = $event;
		$this->placeholder = $placeholder;
		$this->language = $language;
		$this->uikitcomp = $uikitcomp;
		$this->adminfiltertype = $adminfiltertype;
		$this->category = $category;
		$this->accessswitchlist = $accessswitchlist;
		$this->filter = $filter;
		$this->tags = $tags;
	}

	/**
	 * Get the headers for a file
	 *
	 * @param   string  $context    The name of the context
	 * @param   string  $codeName   The view, views, or layout code name
	 *
	 * @return  string  The header string to place in the header of the file
	 * @since 3.2.0
	 */
	public function get(string $context, string $codeName): string
	{
		// get static headers
		$headers = $this->getHeaders($context);

		// get dynamic headers
		switch ($context)
		{
			case 'admin.helper':
			case 'site.helper':
				$this->setHelperClassHeader($headers, $codeName);
				break;

			case 'admin.view.html':
			case 'admin.views.html':
			case 'custom.admin.view.html':
			case 'custom.admin.views.html':
			case 'site.admin.view.html':
			case 'site.view.html':
			case 'site.views.html':
				if ((2 == $this->config->uikit || 1 == $this->config->uikit)
					&& $this->uikitcomp->exists($codeName))
				{
					$headers[] = 'use Joomla\CMS\Filesystem\File;';
				}
				break;

			case 'admin.views':
				$this->setChosenMultiSelectionHeaders($headers, $codeName);
				break;

			case 'admin.view.model':
			case 'site.admin.view.model':
			case 'custom.admin.view.model':
			case 'site.view.model':
			case 'admin.views.model':
			case 'site.views.model':
				$headers[] = 'use Joomla\CMS\Helper\TagsHelper;';
				break;

			default:
				break;
		}

		// Trigger Event: jcb_ce_setClassHeader
		$this->event->trigger(
			'jcb_ce_setClassHeader', [&$context, &$codeName, &$headers]
		);

		// return the headers
		return $this->placeholder->update_(implode(PHP_EOL, $headers));
	}

	/**
	 * Get the headers for a file
	 *
	 * @param   string  $context    The name of the context
	 *
	 * @return  array  The header string to place in the header of the file
	 * @since 3.2.0
	 */
	protected function getHeaders(string $context): array
	{
		if (isset($this->headers[$context]))
		{
			return $this->headers[$context];
		}

		// set the defaults
		$headers = [];
		$headers[] = 'use Joomla\CMS\Factory;';
		$headers[] = 'use Joomla\CMS\Language\Text;';

		switch ($context)
		{
			case 'admin.component':
				$headers[] = 'use Joomla\CMS\Access\Exception\NotAllowed;';
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\MVC\Controller\BaseController;';
				break;

			case 'admin.helper':
			case 'site.helper':
				$headers[] = 'use Joomla\CMS\Access\Access;';
				$headers[] = 'use Joomla\CMS\Access\Rules as AccessRules;';
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\Filesystem\File;';
				$headers[] = 'use Joomla\CMS\Language\Language;';
				$headers[] = 'use Joomla\CMS\MVC\Model\BaseDatabaseModel;';
				$headers[] = 'use Joomla\CMS\Object\CMSObject;';
				$headers[] = 'use Joomla\CMS\Table\Table;';
				$headers[] = 'use Joomla\CMS\Uri\Uri;';
				$headers[] = 'use Joomla\CMS\Version;';
				$headers[] = 'use Joomla\Registry\Registry;';
				$headers[] = 'use Joomla\String\StringHelper;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				break;

			case 'admin.layout':
			case 'site.layout':
			case 'custom.admin.layout':
			case 'override.layout':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\Layout\LayoutHelper;';
				break;

			case 'admin.view':
			case 'custom.admin.view':
			case 'custom.admin.views':
			case 'site.admin.view':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\Layout\LayoutHelper;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'Html::addIncludePath(JPATH_COMPONENT.\'/helpers/html\');';
				$headers[] = 'Html::_(\'behavior.formvalidator\');';
				$headers[] = 'Html::_(\'formbehavior.chosen\', \'select\');';
				$headers[] = 'Html::_(\'behavior.keepalive\');';
				break;

			case 'admin.view.controller':
			case 'site.admin.view.controller':
			case 'site.view.controller':
				$headers[] = 'use Joomla\CMS\MVC\Controller\FormController;';
				$headers[] = 'use Joomla\CMS\MVC\Model\BaseDatabaseModel;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'use Joomla\CMS\Session\Session;';
				$headers[] = 'use Joomla\CMS\Uri\Uri;';
				break;

			case 'admin.view.html':
			case 'admin.views.html':
			case 'site.admin.view.html':
				$headers[] = 'use Joomla\CMS\Form\FormHelper;';
				$headers[] = 'use Joomla\CMS\Session\Session;';
				$headers[] = 'use Joomla\CMS\Uri\Uri;';
			case 'site.view.html':
			case 'site.views.html':
				$headers[] = 'use Joomla\CMS\Toolbar\Toolbar;';
			case 'custom.admin.view.html':
			case 'custom.admin.views.html':
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\Layout\FileLayout;';
				$headers[] = 'use Joomla\CMS\MVC\View\HtmlView;';
				$headers[] = 'use Joomla\CMS\Plugin\PluginHelper;';
				$headers[] = 'use Joomla\CMS\Toolbar\ToolbarHelper;';
				break;

			case 'admin.view.model':
			case 'site.admin.view.model':
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\Filter\InputFilter;';
				$headers[] = 'use Joomla\CMS\Filter\OutputFilter;';
				$headers[] = 'use Joomla\CMS\MVC\Model\AdminModel;';
				$headers[] = 'use Joomla\CMS\Table\Table;';
				$headers[] = 'use Joomla\CMS\UCM\UCMType;';
				$headers[] = 'use Joomla\Registry\Registry;';
				$headers[] = 'use Joomla\String\StringHelper;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				break;

			case 'admin.views':
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\Layout\LayoutHelper;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'Html::_(\'behavior.multiselect\');';
				$headers[] = 'Html::_(\'dropdown.init\');';
				$headers[] = 'Html::_(\'formbehavior.chosen\', \'select\');';
				break;

			case 'admin.views.controller':
			case 'custom.admin.views.controller':
			case 'dashboard.controller':
				$headers[] = 'use Joomla\CMS\MVC\Controller\AdminController;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'use Joomla\CMS\Session\Session;';
				break;

			case 'dashboard.model':
				$headers[] = 'use Joomla\CMS\Uri\Uri;';
				$headers[] = 'use Joomla\CMS\Session\Session;';
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
			case 'admin.views.model':
			case 'ajax.admin.model':
			case 'ajax.site.model':
			case 'custom.admin.views.model':
			case 'site.views.model':
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\MVC\Model\ListModel;';
				$headers[] = 'use Joomla\CMS\Plugin\PluginHelper;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				break;

			case 'custom.admin.view.controller':
			case 'import.controller':
			case 'import.custom.controller':
				$headers[] = 'use Joomla\CMS\MVC\Controller\BaseController;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'use Joomla\CMS\Session\Session;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				break;

			case 'custom.admin.view.model':
			case 'site.view.model':
				$headers[] = 'use Joomla\CMS\Component\ComponentHelper;';
				$headers[] = 'use Joomla\CMS\MVC\Model\ItemModel;';
				$headers[] = 'use Joomla\CMS\Plugin\PluginHelper;';
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'use Joomla\CMS\Uri\Uri;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';

				break;
			case 'import.custom.model':
			case 'import.model':
				$headers[] = 'use Joomla\CMS\Filesystem\File;';
				$headers[] = 'use Joomla\CMS\Filesystem\Folder;';
				$headers[] = 'use Joomla\CMS\Filesystem\Path;';
				$headers[] = 'use Joomla\CMS\Filter\OutputFilter;';
				$headers[] = 'use Joomla\CMS\Installer\InstallerHelper;';
				$headers[] = 'use Joomla\CMS\MVC\Model\BaseDatabaseModel;';
				$headers[] = 'use Joomla\String\StringHelper;';
				$headers[] = 'use Joomla\Utilities\ArrayHelper;';
				$headers[] = 'use PhpOffice\PhpSpreadsheet\IOFactory;';
				break;

			case 'dashboard.view':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				break;

			case 'dashboard.view.html':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\MVC\View\HtmlView;';
				$headers[] = 'use Joomla\CMS\Toolbar\ToolbarHelper;';
				break;

			case 'site.component':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = 'use Joomla\CMS\MVC\Controller\BaseController;';
				break;

			case 'site.view':
			case 'site.views':
				$headers[] = 'use Joomla\CMS\Router\Route;';
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				break;

			case 'form.custom.field':
				$headers[] = 'use Joomla\CMS\HTML\HTMLHelper as Html;';
				$headers[] = "jimport('joomla.form.helper');";
				$headers[] = "JFormHelper::loadFieldClass('###JFORM_extends###');";
				break;

			default:
				break;
		}

		$this->headers[$context] = $headers;

		return $headers;
	}

	/**
	 * set Helper Dynamic Headers
	 *
	 * @param   array   $headers  The headers array
	 * @param   string  $target_client
	 *
	 * @return void
	 * @since 3.2.0
	 */
	protected function setHelperClassHeader(&$headers, $target_client)
	{
		// add only to admin client
		if ('admin' === $target_client && $this->config->get('add_eximport', false))
		{
			$headers[] = 'use PhpOffice\PhpSpreadsheet\IOFactory;';
			$headers[] = 'use PhpOffice\PhpSpreadsheet\Spreadsheet;';
			$headers[] = 'use PhpOffice\PhpSpreadsheet\Writer\Xlsx;';
		}
	}

	/**
	 * Build chosen multi selection headers for the view
	 *
	 * @param   array   $headers       The headers array
	 * @param   string  $nameListCode  The list view name
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function setChosenMultiSelectionHeaders(&$headers, $nameListCode)
	{
		// check that the filter type is the new filter option (2 = topbar)
		if ($this->adminfiltertype->get($nameListCode, 1) == 2)
		{
			// add category switch
			$add_category = false;
			if ($this->category->exists("{$nameListCode}.extension")
				&& $this->category->get("{$nameListCode}.filter", 0) >= 1)
			{
				// is found so add it
				$add_category = true;
			}
			// add accessLevels switch
			$add_access_levels = false;
			if ($this->accessswitchlist->exists($nameListCode))
			{
				// is found so add it
				$add_access_levels = true;
			}
			// check if this view have filters
			if ($this->filter->exists($nameListCode))
			{
				foreach ($this->filter->get($nameListCode) as $filter)
				{
					// we need this only for filters that are multi
					if (isset($filter['multi']) && $filter['multi'] == 2)
					{
						// if this is a category we should make sure it must be added
						if (!$add_category && $filter['type'] === 'category')
						{
							continue;
						}
						elseif ($add_category && $filter['type'] === 'category')
						{
							// already added here so no need to add again
							$add_category = false;
						}
						// check if this was an access field
						elseif ($filter['type'] === 'accesslevel')
						{
							// already added here so no need to add again
							$add_access_levels = false;
						}
						// add the header
						$headers[]
							= 'Html::_(\'formbehavior.chosen\', \'.multiple'
							. $filter['class']
							. '\', null, [\'placeholder_text_multiple\' => \'- \' . Text::_(\''
							. $filter['lang_select'] . '\') . \' -\']);';
					}
					elseif ($add_category && $filter['type'] === 'category')
					{
						// add the header
						$headers[]
							= 'Html::_(\'formbehavior.chosen\', \'.multipleCategories'
							. '\', null, [\'placeholder_text_multiple\' => \'- \' . Text::_(\''
							. $filter['lang_select'] . '\') . \' -\']);';
						// already added here so no need to add again
						$add_category = false;
					}
				}
			}
			// add category if not already added
			if ($add_category)
			{
				// add the header
				$headers[]
					= 'Html::_(\'formbehavior.chosen\', \'.multipleCategories'
					. '\', null, [\'placeholder_text_multiple\' => \'- \' . Text::_(\''
					. $this->category->exists("{$nameListCode}.name", 'error')
					. '\') . \' -\']);';
			}
			// add accessLevels if not already added
			if ($add_access_levels)
			{
				// set the language strings for selection
				$filter_name_select      = 'Select Access';
				$filter_name_select_lang = $this->config->lang_prefix . '_FILTER_'
					. StringHelper::safe(
						$filter_name_select, 'U'
					);
				// and to translation
				$this->language->set(
					$this->config->lang_target, $filter_name_select_lang, $filter_name_select
				);
				// add the header
				$headers[]
					= 'Html::_(\'formbehavior.chosen\', \'.multipleAccessLevels'
					. '\', null, [\'placeholder_text_multiple\' => \'- \' . Text::_(\''
					. $filter_name_select_lang . '\') . \' -\']);';
			}
		}
	}
}

