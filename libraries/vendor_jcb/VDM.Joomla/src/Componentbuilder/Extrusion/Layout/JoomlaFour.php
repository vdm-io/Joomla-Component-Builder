<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    17th August, 2026
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Extrusion\Layout;


use VDM\Joomla\Componentbuilder\Extrusion\Abstraction\Layout;


/**
 * Joomla 4 component placement, inverted from the joomla_4 move map.
 * 
 * @since 6.1.6
 */
class JoomlaFour extends Layout
{
	/**
	 * The target Joomla major version identity this layout describes.
	 *
	 * @return  string  The version identity.
	 * @since   6.1.6
	 */
	public function version(): string
	{
		return 'J4';
	}

	/**
	 * The build-relative placement map for the modern layout.
	 *
	 * @return  array<string, array<string>>  Artifact kind keyed to its patterns.
	 * @since   6.1.6
	 */
	protected function map(): array
	{
		return [
			'manifest' => ['admin/{option}.xml', 'admin/manifest.xml'],
			'schema' => ['admin/sql/install.mysql.utf8.sql'],
			'schema_dir' => ['admin/sql'],
			'schema_updates' => ['admin/sql/updates/mysql'],
			'form' => ['admin/forms/{view}.xml'],
			'form_dir' => ['admin/forms'],
			'model' => ['admin/src/Model/{Name}Model.php'],
			'model_dir' => ['admin/src/Model'],
			'controller' => ['admin/src/Controller/{Name}Controller.php'],
			'controller_dir' => ['admin/src/Controller'],
			'table' => ['admin/src/Table/{Name}Table.php'],
			'table_dir' => ['admin/src/Table'],
			'view_class' => ['admin/src/View/{Name}/HtmlView.php'],
			'view_dir' => ['admin/src/View'],
			'tmpl' => ['admin/tmpl/{name}'],
			'tmpl_dir' => ['admin/tmpl'],
			'layouts' => ['admin/layouts'],
			'layouts_view' => ['admin/layouts/{name}'],
			'field_class' => ['admin/src/Field'],
			'rule_class' => ['admin/src/Rule'],
			'language' => ['admin/language/{tag}'],
			'language_file' => ['admin/language/{tag}/{option}.ini'],
			'language_sys' => ['admin/language/{tag}/{option}.sys.ini'],
			'config' => ['admin/config.xml'],
			'access' => ['admin/access.xml'],
			'provider' => ['admin/services/provider.php'],
			'site_form' => ['site/forms/{view}.xml'],
			'site_form_dir' => ['site/forms'],
			'site_tmpl' => ['site/tmpl/{name}'],
			'site_tmpl_dir' => ['site/tmpl'],
			'site_layouts' => ['site/layouts'],
			'site_model_dir' => ['site/src/Model'],
			'site_view_dir' => ['site/src/View']
		];
	}
}

