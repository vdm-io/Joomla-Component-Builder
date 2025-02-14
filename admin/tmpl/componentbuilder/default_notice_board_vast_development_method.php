<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    30th April, 2015
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;

// No direct access to this file
defined('_JEXEC') or die;

?>
<?php
Html::_('script', "administrator/components/com_componentbuilder/assets/js/compiler.js", ['version' => 'auto']);
Html::_('stylesheet', "administrator/components/com_componentbuilder/assets/css/compiler.css", ['version' => 'auto']);
Html::_('script', "media/com_componentbuilder/js/marked.js", ['version' => 'auto']);
echo LayoutHelper::render('jcbnoticeboard', null);
?>
