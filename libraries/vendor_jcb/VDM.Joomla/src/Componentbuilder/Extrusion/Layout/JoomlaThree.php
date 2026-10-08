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
 * Joomla 3 component placement, inverted from the joomla_3 move map.
 * 
 * Most components an extrusion run will meet are of this generation, so this
 * map is not a legacy afterthought: it is the common case.
 * 
 * @since 6.1.6
 */
final class JoomlaThree extends Layout
{
	/**
	 * The target Joomla major version identity this layout describes.
	 *
	 * @return  string  The version identity.
	 * @since   6.1.6
	 */
	public function version(): string
	{
		return 'J3';
	}

	/**
	 * The build-relative placement map for the Joomla 3 layout.
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
			'form' => ['admin/models/forms/{view}.xml'],
			'form_dir' => ['admin/models/forms'],
			'model' => ['admin/models/{view}.php'],
			'model_dir' => ['admin/models'],
			'controller' => ['admin/controllers/{view}.php'],
			'controller_dir' => ['admin/controllers'],
			'table' => ['admin/tables/{view}.php'],
			'table_dir' => ['admin/tables'],
			'view_class' => ['admin/views/{view}/view.html.php'],
			'view_dir' => ['admin/views'],
			'tmpl' => ['admin/views/{view}/tmpl'],
			'tmpl_dir' => ['admin/views'],
			'layouts' => ['admin/layouts'],
			'layouts_view' => ['admin/layouts/{name}'],
			'field_class' => ['admin/models/fields'],
			'rule_class' => ['admin/models/rules'],
			'language' => ['admin/language/{tag}'],
			'language_file' => ['admin/language/{tag}/{tag}.{option}.ini'],
			'language_sys' => ['admin/language/{tag}/{tag}.{option}.sys.ini'],
			'config' => ['admin/config.xml'],
			'access' => ['admin/access.xml'],
			'site_form' => ['site/models/forms/{view}.xml'],
			'site_form_dir' => ['site/models/forms'],
			'site_tmpl' => ['site/views/{view}/tmpl'],
			'site_tmpl_dir' => ['site/views'],
			'site_layouts' => ['site/layouts'],
			'site_model_dir' => ['site/models'],
			'site_view_dir' => ['site/views']
		];
	}
}

