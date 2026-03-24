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

namespace VDM\Joomla\Componentbuilder\Compiler\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomButtons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\DynamicButtons;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ToolbarComposer as AdminViewsToolbarComposer;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\AddToolBarInterface as AdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\AdminView\AddToolBar as J6AdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\AdminView\AddToolBar as J5AdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\AdminView\AddToolBar as J4AdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminView\AddToolBar as J3AdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminView\AddModalToolBarInterface as AdminViewAddModalToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\AdminView\AddModalToolBar as J6AdminViewAddModalToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\AdminView\AddModalToolBar as J5AdminViewAddModalToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\AdminView\AddModalToolBar as J4AdminViewAddModalToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminView\AddModalToolBar as J3AdminViewAddModalToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\AdminViews\AddToolBarInterface as AdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\AdminViews\AddToolBar as J6AdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\AdminViews\AddToolBar as J5AdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\AdminViews\AddToolBar as J4AdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\AdminViews\AddToolBar as J3AdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\SiteView\AddToolBarInterface as SiteViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\SiteView\AddToolBar as J6SiteViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\SiteView\AddToolBar as J5SiteViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\SiteView\AddToolBar as J4SiteViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\SiteView\AddToolBar as J3SiteViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Architecture\CustomAdmin\AddToolBarInterface as CustomAdminAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\CustomAdminView\AddToolBar as J6CustomAdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\CustomAdminView\AddToolBar as J5CustomAdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\CustomAdminView\AddToolBar as J4CustomAdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\CustomAdminView\AddToolBar as J3CustomAdminViewAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\CustomAdminViews\AddToolBar as J6CustomAdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFive\CustomAdminViews\AddToolBar as J5CustomAdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaFour\CustomAdminViews\AddToolBar as J4CustomAdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaThree\CustomAdminViews\AddToolBar as J3CustomAdminViewsAddToolBar;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItemBuilder;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\ItemCode;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\Link;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\LinkAuthority;
use VDM\Joomla\Componentbuilder\Compiler\Architecture\AdminViews\ListItem\LinkLogic;


/**
 * Architecture View Service Provider
 * 
 * @since 5.1.4
 */
class ArchitectureView implements ServiceProviderInterface
{
	/**
	 * Current Joomla Version Being Build
	 *
	 * @var    int
	 * @since  5.1.4
	 **/
	protected $targetVersion;

	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since   5.1.4
	 */
	public function register(Container $container)
	{
		$container->alias(CustomButtons::class, 'Architecture.CustomButtons')
			->share('Architecture.CustomButtons', [$this, 'getCustomButtons'], true);

		$container->alias(DynamicButtons::class, 'Architecture.DynamicButtons')
			->share('Architecture.DynamicButtons', [$this, 'getDynamicButtons'], true);


		$container->alias(AdminViewAddToolBar::class, 'Architecture.AdminView.AddToolBar')
			->share('Architecture.AdminView.AddToolBar', [$this, 'getAdminViewAddToolBar'], true);

		$container->alias(J6AdminViewAddToolBar::class, 'Architecture.AdminView.J6.AddToolBar')
			->share('Architecture.AdminView.J6.AddToolBar', [$this, 'getJ6AdminViewAddToolBar'], true);

		$container->alias(J5AdminViewAddToolBar::class, 'Architecture.AdminView.J5.AddToolBar')
			->share('Architecture.AdminView.J5.AddToolBar', [$this, 'getJ5AdminViewAddToolBar'], true);

		$container->alias(J4AdminViewAddToolBar::class, 'Architecture.AdminView.J4.AddToolBar')
			->share('Architecture.AdminView.J4.AddToolBar', [$this, 'getJ4AdminViewAddToolBar'], true);

		$container->alias(J3AdminViewAddToolBar::class, 'Architecture.AdminView.J3.AddToolBar')
			->share('Architecture.AdminView.J3.AddToolBar', [$this, 'getJ3AdminViewAddToolBar'], true);


		$container->alias(AdminViewAddModalToolBar::class, 'Architecture.AdminView.AddModalToolBar')
			->share('Architecture.AdminView.AddModalToolBar', [$this, 'getAdminViewAddModalToolBar'], true);

		$container->alias(J6AdminViewAddModalToolBar::class, 'Architecture.AdminView.J6.AddModalToolBar')
			->share('Architecture.AdminView.J6.AddModalToolBar', [$this, 'getJ6AdminViewAddModalToolBar'], true);

		$container->alias(J5AdminViewAddModalToolBar::class, 'Architecture.AdminView.J5.AddModalToolBar')
			->share('Architecture.AdminView.J5.AddModalToolBar', [$this, 'getJ5AdminViewAddModalToolBar'], true);

		$container->alias(J4AdminViewAddModalToolBar::class, 'Architecture.AdminView.J4.AddModalToolBar')
			->share('Architecture.AdminView.J4.AddModalToolBar', [$this, 'getJ4AdminViewAddModalToolBar'], true);

		$container->alias(J3AdminViewAddModalToolBar::class, 'Architecture.AdminView.J3.AddModalToolBar')
			->share('Architecture.AdminView.J3.AddModalToolBar', [$this, 'getJ3AdminViewAddModalToolBar'], true);


		$container->alias(AdminViewsToolbarComposer::class, 'Architecture.AdminViews.ToolbarComposer')
			->share('Architecture.AdminViews.ToolbarComposer', [$this, 'getAdminViewsToolbarComposer'], true);

		$container->alias(AdminViewsAddToolBar::class, 'Architecture.AdminViews.AddToolBar')
			->share('Architecture.AdminViews.AddToolBar', [$this, 'getAdminViewsAddToolBar'], true);

		$container->alias(J6AdminViewsAddToolBar::class, 'Architecture.AdminViews.J6.AddToolBar')
			->share('Architecture.AdminViews.J6.AddToolBar', [$this, 'getJ6AdminViewsAddToolBar'], true);

		$container->alias(J5AdminViewsAddToolBar::class, 'Architecture.AdminViews.J5.AddToolBar')
			->share('Architecture.AdminViews.J5.AddToolBar', [$this, 'getJ5AdminViewsAddToolBar'], true);

		$container->alias(J4AdminViewsAddToolBar::class, 'Architecture.AdminViews.J4.AddToolBar')
			->share('Architecture.AdminViews.J4.AddToolBar', [$this, 'getJ4AdminViewsAddToolBar'], true);

		$container->alias(J3AdminViewsAddToolBar::class, 'Architecture.AdminViews.J3.AddToolBar')
			->share('Architecture.AdminViews.J3.AddToolBar', [$this, 'getJ3AdminViewsAddToolBar'], true);

		$container->alias(SiteViewAddToolBar::class, 'Architecture.SiteView.AddToolBar')
			->share('Architecture.SiteView.AddToolBar', [$this, 'getSiteViewAddToolBar'], true);

		$container->alias(J6SiteViewAddToolBar::class, 'Architecture.SiteView.J6.AddToolBar')
			->share('Architecture.SiteView.J6.AddToolBar', [$this, 'getJ6SiteViewAddToolBar'], true);

		$container->alias(J5SiteViewAddToolBar::class, 'Architecture.SiteView.J5.AddToolBar')
			->share('Architecture.SiteView.J5.AddToolBar', [$this, 'getJ5SiteViewAddToolBar'], true);

		$container->alias(J4SiteViewAddToolBar::class, 'Architecture.SiteView.J4.AddToolBar')
			->share('Architecture.SiteView.J4.AddToolBar', [$this, 'getJ4SiteViewAddToolBar'], true);

		$container->alias(J3SiteViewAddToolBar::class, 'Architecture.SiteView.J3.AddToolBar')
			->share('Architecture.SiteView.J3.AddToolBar', [$this, 'getJ3SiteViewAddToolBar'], true);


		$container->alias(CustomAdminAddToolBar::class, 'Architecture.CustomAdminView.AddToolBar')
			->share('Architecture.CustomAdminView.AddToolBar', [$this, 'getCustomAdminViewAddToolBar'], true);

		$container->alias(J6CustomAdminViewAddToolBar::class, 'Architecture.CustomAdminView.J6.AddToolBar')
			->share('Architecture.CustomAdminView.J6.AddToolBar', [$this, 'getJ6CustomAdminViewAddToolBar'], true);

		$container->alias(J5CustomAdminViewAddToolBar::class, 'Architecture.CustomAdminView.J5.AddToolBar')
			->share('Architecture.CustomAdminView.J5.AddToolBar', [$this, 'getJ5CustomAdminViewAddToolBar'], true);

		$container->alias(J4CustomAdminViewAddToolBar::class, 'Architecture.CustomAdminView.J4.AddToolBar')
			->share('Architecture.CustomAdminView.J4.AddToolBar', [$this, 'getJ4CustomAdminViewAddToolBar'], true);

		$container->alias(J3CustomAdminViewAddToolBar::class, 'Architecture.CustomAdminView.J3.AddToolBar')
			->share('Architecture.CustomAdminView.J3.AddToolBar', [$this, 'getJ3CustomAdminViewAddToolBar'], true);


		$container->alias(CustomAdminAddToolBar::class, 'Architecture.CustomAdminViews.AddToolBar')
			->share('Architecture.CustomAdminViews.AddToolBar', [$this, 'getCustomAdminViewsAddToolBar'], true);

		$container->alias(J6CustomAdminViewsAddToolBar::class, 'Architecture.CustomAdminViews.J6.AddToolBar')
			->share('Architecture.CustomAdminViews.J6.AddToolBar', [$this, 'getJ6CustomAdminViewsAddToolBar'], true);

		$container->alias(J5CustomAdminViewsAddToolBar::class, 'Architecture.CustomAdminViews.J5.AddToolBar')
			->share('Architecture.CustomAdminViews.J5.AddToolBar', [$this, 'getJ5CustomAdminViewsAddToolBar'], true);

		$container->alias(J4CustomAdminViewsAddToolBar::class, 'Architecture.CustomAdminViews.J4.AddToolBar')
			->share('Architecture.CustomAdminViews.J4.AddToolBar', [$this, 'getJ4CustomAdminViewsAddToolBar'], true);

		$container->alias(J3CustomAdminViewsAddToolBar::class, 'Architecture.CustomAdminViews.J3.AddToolBar')
			->share('Architecture.CustomAdminViews.J3.AddToolBar', [$this, 'getJ3CustomAdminViewsAddToolBar'], true);


		$container->alias(ListItemBuilder::class, 'Architecture.AdminViews.ListItemBuilder')
			->share('Architecture.AdminViews.ListItemBuilder', [$this, 'getAdminViewsListItemBuilder'], true);

		$container->alias(ListItem::class, 'Architecture.AdminViews.ListItem')
			->share('Architecture.AdminViews.ListItem', [$this, 'getAdminViewsListItem'], true);

		$container->alias(ItemCode::class, 'Architecture.AdminViews.ListItem.ItemCode')
			->share('Architecture.AdminViews.ListItem.ItemCode', [$this, 'getAdminViewsListItemItemCode'], true);

		$container->alias(Link::class, 'Architecture.AdminViews.ListItem.Link')
			->share('Architecture.AdminViews.ListItem.Link', [$this, 'getAdminViewsListItemLink'], true);

		$container->alias(LinkAuthority::class, 'Architecture.AdminViews.ListItem.LinkAuthority')
			->share('Architecture.AdminViews.ListItem.LinkAuthority', [$this, 'getAdminViewsListItemLinkAuthority'], true);

		$container->alias(LinkLogic::class, 'Architecture.AdminViews.ListItem.LinkLogic')
			->share('Architecture.AdminViews.ListItem.LinkLogic', [$this, 'getAdminViewsListItemLinkLogic'], true);
	}

	/**
	 * Get The CustomButtons Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomButtons
	 * @since   5.1.4
	 */
	public function getCustomButtons(Container $container): CustomButtons
	{
		return new CustomButtons(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Builder.Content.Multi'),
			$container->get('Compiler.Builder.Custom.Form'),
			$container->get('Compiler.Builder.Only.Function.Buttons'),
			$container->get('Utilities.Structure'),
			$container->get('Language'),
			$container->get('Placeholder'),
			$container->get('Registry')
		);
	}

	/**
	 * Get The DynamicButtons Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DynamicButtons
	 * @since   5.1.4
	 */
	public function getDynamicButtons(Container $container): DynamicButtons
	{
		return new DynamicButtons(
			$container->get('Config'),
			$container->get('Compiler.Builder.Dynamic.Buttons'),
			$container->get('Language')
		);
	}

	/**
	 * Get The AddToolBarInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getAdminViewAddToolBar(Container $container): AdminViewAddToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.AdminView.J' . $this->targetVersion . '.AddToolBar');
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6AdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ6AdminViewAddToolBar(Container $container): J6AdminViewAddToolBar
	{
		return new J6AdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Compiler.Builder.History'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5AdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ5AdminViewAddToolBar(Container $container): J5AdminViewAddToolBar
	{
		return new J5AdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Compiler.Builder.History'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4AdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ4AdminViewAddToolBar(Container $container): J4AdminViewAddToolBar
	{
		return new J4AdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Compiler.Builder.History'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3AdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ3AdminViewAddToolBar(Container $container): J3AdminViewAddToolBar
	{
		return new J3AdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Compiler.Builder.History'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AdminView AddModalToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminViewAddModalToolBar
	 * @since   5.1.4
	 */
	public function getAdminViewAddModalToolBar(Container $container): AdminViewAddModalToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.AdminView.J' . $this->targetVersion . '.AddModalToolBar');
	}

	/**
	 * Get The AddModalToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6AdminViewAddModalToolBar
	 * @since   5.1.4
	 */
	public function getJ6AdminViewAddModalToolBar(Container $container): J6AdminViewAddModalToolBar
	{
		return new J6AdminViewAddModalToolBar(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddModalToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5AdminViewAddModalToolBar
	 * @since   5.1.4
	 */
	public function getJ5AdminViewAddModalToolBar(Container $container): J5AdminViewAddModalToolBar
	{
		return new J5AdminViewAddModalToolBar(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddModalToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4AdminViewAddModalToolBar
	 * @since   5.1.4
	 */
	public function getJ4AdminViewAddModalToolBar(Container $container): J4AdminViewAddModalToolBar
	{
		return new J4AdminViewAddModalToolBar(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddModalToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3AdminViewAddModalToolBar
	 * @since   5.1.4
	 */
	public function getJ3AdminViewAddModalToolBar(Container $container): J3AdminViewAddModalToolBar
	{
		return new J3AdminViewAddModalToolBar(
			$container->get('Config'),
			$container->get('Compiler.Creator.Permission'),
			$container->get('Language'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The Admin Views Toolbar Composer Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminViewsToolbarComposer
	 * @since 5.1.4
	 */
	public function getAdminViewsToolbarComposer(Container $container): AdminViewsToolbarComposer
	{
		return new AdminViewsToolbarComposer();
	}

	/**
	 * Get The AdminViews AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getAdminViewsAddToolBar(Container $container): AdminViewsAddToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.AdminViews.J' . $this->targetVersion . '.AddToolBar');
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6AdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ6AdminViewsAddToolBar(Container $container): J6AdminViewsAddToolBar
	{
		return new J6AdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.AdminViews.ToolbarComposer'),
			$container->get('Architecture.DynamicButtons'),
			$container->get('Architecture.CustomButtons'),
			$container->get('Compiler.Builder.Only.Function.Buttons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5AdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ5AdminViewsAddToolBar(Container $container): J5AdminViewsAddToolBar
	{
		return new J5AdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.AdminViews.ToolbarComposer'),
			$container->get('Architecture.DynamicButtons'),
			$container->get('Architecture.CustomButtons'),
			$container->get('Compiler.Builder.Only.Function.Buttons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4AdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ4AdminViewsAddToolBar(Container $container): J4AdminViewsAddToolBar
	{
		return new J4AdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.DynamicButtons'),
			$container->get('Architecture.CustomButtons'),
			$container->get('Compiler.Builder.Only.Function.Buttons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3AdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ3AdminViewsAddToolBar(Container $container): J3AdminViewsAddToolBar
	{
		return new J3AdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.DynamicButtons'),
			$container->get('Architecture.CustomButtons'),
			$container->get('Compiler.Builder.Only.Function.Buttons')
		);
	}

	/**
	 * Get The AddToolBarInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  SiteViewAddToolBar
	 * @since   5.1.4
	 */
	public function getSiteViewAddToolBar(Container $container): SiteViewAddToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.SiteView.J' . $this->targetVersion . '.AddToolBar');
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6SiteViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ6SiteViewAddToolBar(Container $container): J6SiteViewAddToolBar
	{
		return new J6SiteViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5SiteViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ5SiteViewAddToolBar(Container $container): J5SiteViewAddToolBar
	{
		return new J5SiteViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4SiteViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ4SiteViewAddToolBar(Container $container): J4SiteViewAddToolBar
	{
		return new J4SiteViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3SiteViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ3SiteViewAddToolBar(Container $container): J3SiteViewAddToolBar
	{
		return new J3SiteViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBarInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomAdminAddToolBar
	 * @since   5.1.4
	 */
	public function getCustomAdminViewAddToolBar(Container $container): CustomAdminAddToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.CustomAdminView.J' . $this->targetVersion . '.AddToolBar');
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6CustomAdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ6CustomAdminViewAddToolBar(Container $container): J6CustomAdminViewAddToolBar
	{
		return new J6CustomAdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CustomAdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ5CustomAdminViewAddToolBar(Container $container): J5CustomAdminViewAddToolBar
	{
		return new J5CustomAdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CustomAdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ4CustomAdminViewAddToolBar(Container $container): J4CustomAdminViewAddToolBar
	{
		return new J4CustomAdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CustomAdminViewAddToolBar
	 * @since   5.1.4
	 */
	public function getJ3CustomAdminViewAddToolBar(Container $container): J3CustomAdminViewAddToolBar
	{
		return new J3CustomAdminViewAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBarInterface Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  CustomAdminAddToolBar
	 * @since   5.1.4
	 */
	public function getCustomAdminViewsAddToolBar(Container $container): CustomAdminAddToolBar
	{
		if (empty($this->targetVersion))
		{
			$this->targetVersion = $container->get('Config')->joomla_version;
		}

		return $container->get('Architecture.CustomAdminViews.J' . $this->targetVersion . '.AddToolBar');
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J6CustomAdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ6CustomAdminViewsAddToolBar(Container $container): J6CustomAdminViewsAddToolBar
	{
		return new J6CustomAdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J5CustomAdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ5CustomAdminViewsAddToolBar(Container $container): J5CustomAdminViewsAddToolBar
	{
		return new J5CustomAdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Placeholder'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J4CustomAdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ4CustomAdminViewsAddToolBar(Container $container): J4CustomAdminViewsAddToolBar
	{
		return new J4CustomAdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The AddToolBar Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  J3CustomAdminViewsAddToolBar
	 * @since   5.1.4
	 */
	public function getJ3CustomAdminViewsAddToolBar(Container $container): J3CustomAdminViewsAddToolBar
	{
		return new J3CustomAdminViewsAddToolBar(
			$container->get('Config'),
			$container->get('Compiler.Builder.Content.One'),
			$container->get('Architecture.CustomButtons')
		);
	}

	/**
	 * Get The ListItemBuilder Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ListItemBuilder
	 * @since   5.1.5
	 */
	public function getAdminViewsListItemBuilder(Container $container): ListItemBuilder
	{
		return new ListItemBuilder(
			$container->get('Placeholder'),
			$container->get('Architecture.AdminViews.ListItem'),
			$container->get('Compiler.Builder.Field.Relations'),
			$container->get('Compiler.Builder.List.Join')
		);
	}

	/**
	 * Get The ListItem Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ListItem
	 * @since   5.1.5
	 */
	public function getAdminViewsListItem(Container $container): ListItem
	{
		return new ListItem(
			$container->get('Architecture.AdminViews.ListItem.ItemCode'),
			$container->get('Architecture.AdminViews.ListItem.Link'),
			$container->get('Architecture.AdminViews.ListItem.LinkAuthority'),
			$container->get('Architecture.AdminViews.ListItem.LinkLogic')
		);
	}

	/**
	 * Get The ItemCode Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  ItemCode
	 * @since   5.1.5
	 */
	public function getAdminViewsListItemItemCode(Container $container): ItemCode
	{
		return new ItemCode(
			$container->get('Config'),
			$container->get('Compiler.Builder.Selection.Translation'),
			$container->get('Compiler.Builder.Do.Not.Escape')
		);
	}

	/**
	 * Get The Link Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Link
	 * @since   5.1.5
	 */
	public function getAdminViewsListItemLink(Container $container): Link
	{
		return new Link(
			$container->get('Compiler.Builder.Category')
		);
	}

	/**
	 * Get The LinkAuthority Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LinkAuthority
	 * @since   5.1.5
	 */
	public function getAdminViewsListItemLinkAuthority(Container $container): LinkAuthority
	{
		return new LinkAuthority(
			$container->get('Config'),
			$container->get('Compiler.Builder.Category.Code'),
			$container->get('Compiler.Creator.Permission')
		);
	}

	/**
	 * Get The LinkLogic Class.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  LinkLogic
	 * @since   5.1.5
	 */
	public function getAdminViewsListItemLinkLogic(Container $container): LinkLogic
	{
		return new LinkLogic(
			$container->get('Config')
		);
	}
}

