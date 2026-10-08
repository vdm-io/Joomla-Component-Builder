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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\JoomlaSix\CustomView;


use VDM\Joomla\Componentbuilder\Compiler\Architecture\CustomView\Form as SharedForm;


/**
 * Joomla 6 Custom View Form Class.
 * 
 * A Joomla 6 site form posts to index.php on its own, the component it belongs
 * to being carried by the route rather than by the query.
 * 
 * @since  6.1.7
 */
final class Form extends SharedForm
{
	/**
	 * The form tag a site view is wrapped in.
	 *
	 * @param   string  $view  The view being built.
	 *
	 * @return  string  The markup.
	 *
	 * @since   6.1.7
	 */
	protected function siteAction(&$view): string
	{
		// yes we only need index.php
		return '<form action="<?php echo Joomla__'.'_d4c76099_4c32_408a_8701_d0a724484dfd___Power::_(\'index.php'
			. '\'); ?>" method="post" name="adminForm" id="adminForm">'
			. PHP_EOL;
	}
}

