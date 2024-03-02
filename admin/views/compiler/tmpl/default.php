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
defined('_JEXEC') or die('Restricted access');

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper as Html;
use Joomla\CMS\Layout\LayoutHelper;
use Joomla\CMS\Router\Route;
Html::addIncludePath(JPATH_COMPONENT.'/helpers/html');
Html::_('behavior.formvalidator');
Html::_('formbehavior.chosen', 'select');
Html::_('behavior.keepalive');
use Joomla\CMS\Session\Session;
use VDM\Joomla\Utilities\StringHelper;

$this->app->input->set('hidemainmenu', false);
$selectNotice = '<h3>' . Text::_('COM_COMPONENTBUILDER_HI') . ' ' . $this->user->name . '</h3>';
$selectNotice .= '<p>' . Text::_('COM_COMPONENTBUILDER_PLEASE_SELECT_A_COMPONENT_THAT_YOU_WOULD_LIKE_TO_COMPILE') . '</p>';

// set the noticeboard options
$noticeboardOptions = array('vdm', 'pro');
?>
<?php if ($this->canDo->get('compiler.access')): ?>

<script type="text/javascript">
Joomla.submitbutton = function(task, key) {
	if (task === '') {
		return false;
	} else {
		var component = document.getElementById('component_id').value;
		var isValid = true;

		if (component === '' && task === 'compiler.compiler') {
			isValid = false;
		}
		if (isValid) {
			document.getElementById('form').style.display = 'none';
			var form = document.getElementById('adminForm');
			if (task === 'compiler.installCompiledModule' || task === 'compiler.installCompiledPlugin') {
				form.install_item_id.value = key;
			}
			form.task.value = task;
			setTimeout(function() {
				form.submit();
			}, 100);

			if (task === 'compiler.compiler') {
				let component_name = document.querySelector("#component_id option:checked").textContent;
				document.querySelectorAll(".component-name").forEach(elem => {
					elem.textContent = component_name;
				});
				setTimeout(function() {
					document.getElementById('compiler').style.display = 'block';
					document.getElementById('compiling').style.display = 'block';
					setTimeout(function() {
						document.getElementById('compiler-spinner').style.display = 'block';
						document.getElementById('compiler-notice').style.display = 'block';
					}, 100);
				}, 100);
			} else if (task === 'compiler.clearTmp') {
				document.getElementById('clear').style.display = 'block';
				document.getElementById('loading').style.display = 'block';
			} else if (task === 'compiler.getCompilerAnimations') {
				document.getElementById('get-compiler-animations').style.display = 'block';
				document.getElementById('loading').style.display = 'block';
			} else {
				document.getElementById('loading').style.display = 'block';
			}
			return true;
		} else {
			document.querySelectorAll('.notice').forEach(elem => {
				elem.style.display = 'block';
			});
			return false;
		}
	}
}
// Add spindle-wheel for importations:
document.addEventListener('DOMContentLoaded', function() {

	// get page body
	var outerBodyDiv = document.querySelector('body');

	// start loading spinner
	var loadingDiv = document.createElement('div');
	loadingDiv.id = 'loading';

	// Set CSS properties individually
	loadingDiv.style.background = "rgba(255, 255, 255, .8) url('components/com_componentbuilder/assets/images/import.gif') 50% 15% no-repeat";
	loadingDiv.style.top = (outerBodyDiv.getBoundingClientRect().top + window.pageYOffset) + "px";
	loadingDiv.style.left = (outerBodyDiv.getBoundingClientRect().left + window.pageXOffset) + "px";
	loadingDiv.style.width = outerBodyDiv.offsetWidth + "px";
	loadingDiv.style.height = outerBodyDiv.offsetHeight + "px";
	loadingDiv.style.position = 'fixed';
	loadingDiv.style.opacity = '0.80';
	loadingDiv.style.msFilter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=80)";
	loadingDiv.style.filter = "alpha(opacity=80)";
	loadingDiv.style.display = 'none';

	// add to page body
	outerBodyDiv.appendChild(loadingDiv);

	// waiting compiler overlay
	var compilingDiv = document.createElement('div');
	compilingDiv.id = 'compiling';

	// Set CSS properties individually
	compilingDiv.style.background = "rgba(16, 164, 230, .4)";
	compilingDiv.style.top = (outerBodyDiv.getBoundingClientRect().top + window.pageYOffset) + "px";
	compilingDiv.style.left = (outerBodyDiv.getBoundingClientRect().left + window.pageXOffset) + "px";
	compilingDiv.style.width = outerBodyDiv.offsetWidth + "px";
	compilingDiv.style.height = outerBodyDiv.offsetHeight + "px";
	compilingDiv.style.position = 'fixed';
	compilingDiv.style.opacity = '0.40';
	compilingDiv.style.msFilter = "progid:DXImageTransform.Microsoft.Alpha(Opacity=40)";
	compilingDiv.style.filter = "alpha(opacity=40)";
	compilingDiv.style.display = 'none';

	// add to page
	outerBodyDiv.appendChild(compilingDiv);
});
</script>
<?php if(!empty( $this->sidebar)): ?>
<div id="j-sidebar-container" class="span2">
	<?php echo $this->sidebar; ?>
</div>
<div id="j-main-container" class="span10">
<?php else : ?>
<div id="j-main-container">
<?php endif; ?>
	<?php if (StringHelper::check($this->SuccessMessage)): ?>
		<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
			<?php echo $this->SuccessMessage; ?>
		</div>
	<?php endif; ?>
	<form action="<?php echo Route::_('index.php?option=com_componentbuilder&view=compiler'); ?>"
		method="post" name="adminForm" id="adminForm" class="form-validate" enctype="multipart/form-data">
		<div id="form" >
			<div class="span4">
				<h3><?php echo Text::_('COM_COMPONENTBUILDER_READY_TO_COMPILE_A_COMPONENT'); ?></h3>
				<div id="compilerForm">
					<div>
					<span class="notice" style="display:none; color:red;"><?php echo Text::_('COM_COMPONENTBUILDER_YOU_MUST_SELECT_A_COMPONENT'); ?></span><br />
					<?php if ($this->form): ?>
						<?php echo $this->form->renderFieldset('builder'); ?>
					<?php endif; ?>
					</div>
					<br />
					<div class="clearfix"></div>
					<button class="btn btn-small btn-success" onclick="Joomla.submitbutton('compiler.compiler')"><span class="icon-cog icon-white"></span>
						<?php echo Text::_('COM_COMPONENTBUILDER_COMPILE_COMPONENT'); ?>
					</button>
					<input type="hidden" name="install_item_id" value="0"> 
					<input type="hidden" name="version" value="3" />
				</div>
			</div>
			<div class="span7">
				<div id="advance-details"><?php echo $this->form->renderFieldset('advanced'); ?></div>
				<div id="component-details"><?php echo $selectNotice; ?></div>
				<?php echo LayoutHelper::render('jcbnoticeboardtabs', array('id' => 'noticeboard' , 'active' => $noticeboardOptions[array_rand($noticeboardOptions)])); ?>
			</div>
		</div>
		<div id="get-compiler-animations" style="display:none;">
			<h1><?php echo Text::_('COM_COMPONENTBUILDER_PLEASE_WAIT'); ?></h1>
			<h4><?php echo Text::_('COM_COMPONENTBUILDER_WHILE_WE_DOWNLOAD_ALL_TWENTY_SIX_COMPILER_GIF_ANIMATIONS_RANDOMLY_USED_IN_THE_COMPILER_GUI_DURING_COMPILATION'); ?> <span class="loading-dots">.</span></h4>
			<div class="clearfix"></div>
		</div>
		<div id="clear" style="display:none;">
			<h1><?php echo Text::_('COM_COMPONENTBUILDER_PLEASE_WAIT'); ?></h1>
			<h4><?php echo Text::_('COM_COMPONENTBUILDER_REMOVING_ALL_ZIP_PACKAGES_FROM_THE_TEMPORARY_FOLDER_OF_THE_JOOMLA_INSTALL'); ?> <span class="loading-dots">.</span></h4>
			<div class="clearfix"></div>
		</div>
		<div id="compiler" style="display:none;">
			<div id="compiler-spinner" class="span4" style="display:none;">
				<h3><?php echo Text::sprintf('COM_COMPONENTBUILDER_S_PLEASE_WAIT', $this->user->name); ?></h3>
				<p style="font-size: smaller;"><?php echo Text::_('COM_COMPONENTBUILDER_THIS_MAY_TAKE_A_WHILE_DEPENDING_ON_THE_SIZE_OF_YOUR_PROJECT'); ?></p>
				<p><b><span class="component-name"><?php echo Text::_('COM_COMPONENTBUILDER_THE_COMPONENT'); ?></span></b> <?php echo Text::_('COM_COMPONENTBUILDER_IS_BEING_COMPILED'); ?> <span class="loading-dots">.</span></p>
				<div style="text-align: center;"><?php echo ComponentbuilderHelper::getDynamicContent('builder-gif', $this->builder_gif_size); ?></div>
				<div class="clearfix"></div>
			</div>
			<div id="compiler-notice" class="span7" style="display:none;">
				<?php echo LayoutHelper::render('jcbnoticeboard' . $noticeboardOptions[array_rand($noticeboardOptions)], null); ?>
				<div><?php echo ComponentbuilderHelper::getDynamicContent('banner', '728-90'); ?></div>
			</div>
		</div>
		<input type="hidden" name="task" value="" />
		<?php echo Html::_('form.token'); ?>
	</form>
</div>
<script type="text/javascript">
// token 
var token = '<?php echo Session::getFormToken(); ?>';
var all_is_good = '<?php echo Text::_('COM_COMPONENTBUILDER_ALL_IS_GOOD_THERE_IS_NO_NOTICE_AT_THIS_TIME'); ?>';
jQuery('#compilerForm').on('change', '#component_id', function (e) {
	var componentSelect = document.getElementById('component_id');
	if (componentSelect) {
		var component = componentSelect.value;
		if (component === "") {
			document.getElementById('component-details').innerHTML = "<?php echo $selectNotice; ?>";
			document.getElementById("noticeboard").style.display = 'block';
			document.querySelectorAll('.notice').forEach(function (elem) {
				elem.style.display = 'block';
			});
		} else {
			getComponentDetails(component);
			document.getElementById("noticeboard").style.display = 'none';
			document.querySelectorAll('.notice').forEach(function (elem) {
				elem.style.display = 'none';
			});
		}
	}
});

document.addEventListener("DOMContentLoaded", function() {
	document.querySelectorAll(".loading-dots").forEach(function(loading_dots) {
		let x = 0;
		let intervalId = setInterval(function() {
			if (!loading_dots.classList.contains("loading-dots")) {
				clearInterval(intervalId);
				return;
			}
			let dots = ".".repeat(x % 8);
			loading_dots.textContent = dots;
			x++;
		}, 500);
	});
});

<?php
	$app = Factory::getApplication();
?>
function JRouter(link) {
<?php
	if ($app->isClient('site'))
	{
		echo 'var url = "'. \Joomla\CMS\Uri\Uri::root() . '";';
	}
	else
	{
		echo 'var url = "";';
	}
?>
	return url+link;
}
</script>
<?php else: ?>
		<h1><?php echo Text::_('COM_COMPONENTBUILDER_NO_ACCESS_GRANTED'); ?></h1>
<?php endif; ?>
