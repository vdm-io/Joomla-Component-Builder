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



use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use VDM\Component\Componentbuilder\Administrator\Helper\ComponentbuilderHelper;
use VDM\Joomla\Utilities\StringHelper;

// No direct access to this file
defined('JPATH_BASE') or die;

// Extract all keys from $displayData as individual variables.
extract($displayData);

// Assign default values for variables that might not be present in $displayData.

// The 'table_id' parameter, defaulting to a randomly generated value if not set or is null.
$table_id = $id ?? StringHelper::random(7);

// The 'name' parameter, defaulting to false if not set or is null.
$name ??= false;

// The 'table_class' parameter, defaulting to 'uk-table' if not set or is null.
$table_class ??= 'uk-table';

// The 'table_other_class' parameter, defaulting to '' if not set or is null.
$table_other_class = !empty($table_other_class ?? '') ? ' ' . $table_other_class : '';

// The 'table_container_class' parameter, defaulting to 'uk-overflow-auto' if not set or is null.
$table_container_class ??= 'uk-overflow-auto';

// The 'headers' parameter, defaulting to an array of default header values if not set or is null.
$headers ??= [Text::_('COM_COMPONENTBUILDER_NO'), Text::_('COM_COMPONENTBUILDER_HEADERS'), Text::_('COM_COMPONENTBUILDER_FOUND')];

// The 'items' parameter, defaulting to 6 if not set or is null.
$items ??= 6;

// The 'default_items_number' parameter, defaulting to 0 if not set or is null.
$default_items_number ??= 0;

// tweak to add empty rows
$items_number = 0;
if (is_array($items))
{
	$items_number = count((array) $items);
}
elseif (is_numeric($items))
{
	$items_number = (int) $items;
}

$default_items_number = is_numeric($default_items_number) ? (float) $default_items_number : 0;
$items_number = is_numeric($items_number) ? (float) $items_number : 0;
$add_items = 0;

if ($default_items_number > $items_number)
{
	$add_items = (int) round($default_items_number - $items_number);
}

?>
<div class="<?php echo $table_container_class; ?>">
	<table id="<?php echo $table_id; ?>" class="<?php echo $table_class; ?><?php echo $table_other_class; ?>">
		<thead>
			<?php if (is_array($headers)): ?>
				<?php if ($name): ?>
				<tr>
					<th colspan="<?php echo count($headers); ?>" style="text-align:center"><b><?php echo $name; ?></b></th>
				</tr>
				<?php endif; ?>
				<tr>
				<?php foreach($headers as $code_name => $header): ?>
					<?php 
						if (is_numeric($code_name))
						{
							$code_name = StringHelper::safe($header);
						}
 					?>
					<th data-name="<?php echo $code_name; ?>"><?php echo $header; ?></th>
				<?php endforeach; ?>
				</tr>
			<?php elseif (is_numeric($headers)): ?>
				<?php if ($name): ?>
				<tr>
					<th colspan="<?php echo (int) $headers; ?>" style="text-align:center"><b><?php echo $name; ?></b></th>
				</tr>
				<?php endif; ?>
				<tr style="position: absolute; top: -9999px; left: -9999px;">
				<?php for( $row = 0; $row < $headers; $row++): ?>
					<th><?php echo StringHelper::safe($row); ?></th>
				<?php endfor; ?>
				</tr>
			<?php endif; ?>
		</thead>
		<tbody>
			<?php echo LayoutHelper::render('rows', ['headers' => $headers, 'items' => $items]); ?>
			<?php if ($add_items > 0): ?>
				<?php echo LayoutHelper::render('rows', ['headers' => $headers, 'items' => $add_items]); ?>
			<?php endif; ?>
		</tbody>
	</table>
</div>
<?php
// Initialize the table if [init is not set], or [is true]
// To stop initialization set $displayData['init'] = false;
if (!isset($displayData['init']) || $displayData['init']) :
?>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {
	var <?php echo $table_id; ?> = new DataTable('#<?php echo $table_id; ?>', {
		paging: false,
		select: true
	});
});
</script>
<?php endif; ?>
