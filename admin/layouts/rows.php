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

// No direct access to this file
defined('JPATH_BASE') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;

$headers = $displayData['headers'];
$items = $displayData['items'];

?>
<?php if (is_array($items)): ?>
	<?php foreach ($items as $row => $values): ?>
		<tr>
		<?php foreach($values as $value): ?>
			<td class=""><?php echo $value; ?></td>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>
<?php elseif (is_numeric($items) && is_array($headers)): ?>
	<?php for( $row = 0; $row < $items; $row++): ?>
		<tr class="">
		<?php foreach($headers as $header): ?>
			<td class="">&nbsp;&nbsp;</td>
		<?php endforeach; ?>
		</tr>
	<?php endfor; ?>
<?php elseif (is_numeric($items) && is_numeric($headers)): ?>
	<?php for( $row = 0; $row < $items; $row++): ?>
		<tr class="">
		<?php for( $column = 0; $column < $headers; $column++): ?>
			<td class="">&nbsp;&nbsp;</td>
		<?php endfor; ?>
		</tr>
	<?php endfor; ?>
<?php endif; ?>
