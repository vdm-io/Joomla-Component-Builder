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

namespace VDM\Joomla\Componentbuilder\Compiler\Architecture\ComHelperClass;


use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentOne;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Language;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Indent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Line;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Component Helper User Permission Check Access Class.
 * 
 * Builds the access check the component helper runs before it lets a user
 * reach a view.
 * 
 * @since 6.1.7
 */
final class UserPermissionCheckAccess
{
	/**
	 * The Content One Builder Class.
	 *
	 * @var   ContentOne
	 * @since 6.1.7
	 */
	protected ContentOne $contentone;

	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 6.1.7
	 */
	protected Config $config;

	/**
	 * The Language Class.
	 *
	 * @var   Language
	 * @since 6.1.7
	 */
	protected Language $language;

	/**
	 * Constructor.
	 *
	 * @param ContentOne $contentone The Content One Builder Class.
	 * @param Config     $config     The Config Class.
	 * @param Language   $language   The Language Class.
	 *
	 * @since 6.1.7
	 */
	public function __construct(ContentOne $contentone,
		Config $config,
		Language $language)
	{
		$this->contentone = $contentone;
		$this->config = $config;
		$this->language = $language;
	}

	/**
	 * Build the access check of a view.
	 *
	 * The check names the permissions the view was given and the message the
	 * user is shown when none of them let them through.
	 *
	 * @param   array   $view  The view being built.
	 * @param   string  $type  The kind of view.
	 *
	 * @return  string  The statements.
	 *
	 * @since   6.1.7
	 */
	public function get($view, $type): string
	{
		if (isset($view['access']) && $view['access'] == 1)
		{
			switch ($type)
			{
				case 1:
					$userString = '$this->user';
					break;
				default:
					$userString = '$user';
					break;
			}
			// check that the default and the redirect page is not the same
			if ($this->contentone->exists('SITE_DEFAULT_VIEW')
				&& $this->contentone->get('SITE_DEFAULT_VIEW') != $view['settings']->code)
			{
				$redirectMessage = Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					)
					. " redirect away to the default view if no access allowed.";
				$redirectString  = "Joomla__"."_d4c76099_4c32_408a_8701_d0a724484dfd___Power::_('index.php?option=com_"
					. $this->config->component_code_name . "&view="
					. $this->contentone->get('SITE_DEFAULT_VIEW') . "')";
			}
			else
			{
				$redirectMessage = Indent::_(3) . "//" . Line::_(
						__LINE__,__CLASS__
					) . " redirect away to the home page if no access allowed.";
				$redirectString  = 'Joomla__'.'_eecc143e_b5cf_4c33_ba4d_97da1df61422___Power::root()';
			}
			$accessCheck[] = PHP_EOL . Indent::_(2) . "//" . Line::_(
					__LINE__,__CLASS__
				) . " check if this user has permission to access item";
			$accessCheck[] = Indent::_(2) . "if (!" . $userString
				. "->authorise('site." . $view['settings']->code
				. ".access', 'com_" . $this->config->component_code_name . "'))";
			$accessCheck[] = Indent::_(2) . "{";
			$accessCheck[] = Indent::_(3)
				. "\$app = Joomla__"."_39403062_84fb_46e0_bac4_0023f766e827___Power::getApplication();";
			// set lang
			$langKeyWord = $this->config->lang_prefix . '_'
				. StringHelper::safe(
					'Not authorised to view ' . $view['settings']->code . '!',
					'U'
				);
			$this->language->set(
				'site', $langKeyWord,
				'Not authorised to view ' . $view['settings']->code . '!'
			);
			$accessCheck[] = Indent::_(3) . "\$app->enqueueMessage(Text:"
				. ":_('" . $langKeyWord . "'), 'error');";
			$accessCheck[] = $redirectMessage;
			$accessCheck[] = Indent::_(3) . "\$app->redirect(" . $redirectString
				. ");";
			$accessCheck[] = Indent::_(3) . "return false;";
			$accessCheck[] = Indent::_(2) . "}";

			// return the access check
			return implode(PHP_EOL, $accessCheck);
		}

		return '';
	}
}

