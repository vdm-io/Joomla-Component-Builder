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
use Joomla\CMS\Session\Session;
use Joomla\CMS\Uri\Uri;

// No direct access to this file
defined('JPATH_BASE') or die;

// always load these files.
Html::_('stylesheet', "media/com_componentbuilder/datatable/css/datatables.min.css", ['version' => 'auto']);
Html::_('script', "media/com_componentbuilder/datatable/js/pdfmake.min.js", ['version' => 'auto']);
Html::_('script', "media/com_componentbuilder/datatable/js/vfs_fonts.js", ['version' => 'auto']);
Html::_('script', "media/com_componentbuilder/datatable/js/datatables.min.js", ['version' => 'auto']);

// set the table details
$table_id = StringHelper::random(7);
$headers = ComponentbuilderHelper::getLanguageTranslationsHeaders() ?? [];
$fields = array_keys($headers);
$items = 1;
// set the file name
$file_name = 'Language_Translations';

?>
<div style="display: none;">
<?php echo LayoutHelper::render('table',
	[
		'id' => $table_id,
		'name' => $name,
		'headers' => $headers,
		'items' => $items,
		'init' => false
	]
); ?>
</div>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function () {
    // Create the toolbar export button using DOM methods
    function createExportButton() {
        const wrapper = document.createElement('joomla-toolbar-button');
        wrapper.innerHTML = `
            <button id="toolbar-export-language-translations" class="button-export btn btn-primary" type="button">
                <span aria-hidden="true" class="icon-download"></span>
                <?php echo Text::_('COM_COMPONENTBUILDER_EXPORT_TRANSLATIONS'); ?>
            </button>
        `;
        return wrapper;
    }
    // Insert the export button next to the Edit button
    function insertExportButton() {
        const editButton = document.getElementById('toolbar-edit');
        if (!editButton || !editButton.parentNode) {
            console.warn('Edit button not found. Export button not inserted.');
            return;
        }
        const exportButton = createExportButton();
        editButton.parentNode.insertBefore(exportButton, editButton.nextSibling);
        // Attach click event
        const exportBtn = document.getElementById('toolbar-export-language-translations');
        if (exportBtn) {
            exportBtn.addEventListener('click', exportLanguageTranslations);
        } else {
            console.warn('Export button element not found for event binding.');
        }
    }
    // Run insertion
    insertExportButton();
});
function exportLanguageTranslations() {
    document.getElementById("loading").style.display = 'block';
    const filterExtension = (() => {
        const val = document.getElementById('filter_extension')?.value;
        return val !== undefined && val !== '' ? val : 0;
    })();
    const filterTranslated = (() => {
        const val = document.getElementById('filter_translated')?.value;
        return val !== undefined && val !== '' ? val : 0;
    })();
    const filterNotTranslated = (() => {
        const val = document.getElementById('filter_not_translated')?.value;
        return val !== undefined && val !== '' ? val : 0;
    })();
    const token = '<?php echo Session::getFormToken(); ?>=1';
    const ajaxUrl = `<?php echo Uri::base(); ?>index.php?option=com_componentbuilder&task=ajax.exportLanguageTranslations&format=json&raw=true&${token}&filter_extension=${encodeURIComponent(filterExtension)}&filter_translated=${encodeURIComponent(filterTranslated)}&filter_not_translated=${encodeURIComponent(filterNotTranslated)}`;
    const tableElement = document.getElementById('<?php echo $table_id; ?>');
    if ($.fn.DataTable.isDataTable(tableElement)) {
        const table = $(tableElement).DataTable();
        table.ajax.url(ajaxUrl).load();
        table.off('draw.dt');
        table.on('draw.dt', function () {
            table.button(`.buttons-excel`).trigger();
            document.getElementById("loading").style.display = 'none';
        });
    } else {
        const table = $(tableElement).DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'excel',
                    text: 'Excel',
                    title: '<?php echo Text::_('COM_COMPONENTBUILDER_LANGUAGE_TRANSLATIONS'); ?>',
                    filename: '<?php echo $file_name; ?>'
                }
            ],
            select: false,
            ajax: { url: ajaxUrl },
            deferRender: true,
            columns: [<?php foreach ($fields as $field): ?>
                { data: '<?php echo $field; ?>' },
            <?php endforeach; ?>]
        });
        table.on('draw.dt', function () {
            table.button(`.buttons-excel`).trigger();
            document.getElementById("loading").style.display = 'none';
        });
    }
}
</script>
