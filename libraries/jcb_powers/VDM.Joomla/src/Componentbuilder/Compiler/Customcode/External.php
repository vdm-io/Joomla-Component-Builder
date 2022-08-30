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

namespace VDM\Joomla\Componentbuilder\Compiler\Customcode;


use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Filesystem\Path;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder;


/**
 * Compiler External Custom Code
 * 
 * @since 3.2.0
 */
class External
{
	/**
	 * The external code/string to be added
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $code = [];

	/**
	 * The external code/string cutter
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $cutter = [];

	/**
	 * Compiler Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $placeholder;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

	/**
	 * User object
	 *
	 * @var    User
	 * @since 3.2.0
	 **/
	protected User $user;

	/**
	 * Database object to query local DB
	 *
	 * @var    CMSApplication
	 * @since 3.2.0
	 **/
	protected CMSApplication $app;

	/**
	 * Constructor.
	 *
	 * @param Placeholder|null        $placeholder   The compiler placeholder object.
	 * @param \JDatabaseDriver|null   $db            The Database Driver object.
	 * @param User|null               $user          The User object.
	 * @param CMSApplication|null     $app           The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Placeholder $placeholder = null,
		?\JDatabaseDriver $db = null, ?User $user = null, ?CMSApplication $app = null)
	{
		$this->placeholder = $placeholder ?: Compiler::_('Placeholder');
		$this->db = $db ?: Factory::getDbo();
		$this->user = $user ?: Factory::getUser();
		$this->app = $app ?: Factory::getApplication();
	}

	/**
	 * Set the external code string & load it in to string
	 *
	 * @param   string  $string  The content to check
	 * @param   int     $debug   The switch to debug the update
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, int $debug = 0): string
	{
		// check if content has custom code placeholder
		if (strpos($string, '[EXTERNA' . 'LCODE=') !== false)
		{
			// if debug
			if ($debug)
			{
				echo 'External Code String:';
				var_dump($string);
			}
			// target content
			$bucket = array();
			$found  = GetHelper::allBetween(
				$string, '[EXTERNA' . 'LCODE=', ']'
			);
			if (ArrayHelper::check($found))
			{
				// build local bucket
				foreach ($found as $target)
				{
					// check for cutting sequence
					// example: >{3|4
					// will cut 3 rows at top and 4 rows at bottom
					// if the external code has 8 or more lines
					if (($pos = strpos($target, '>{')) !== false)
					{
						// the length
						$target_len = strlen($target);
						// where to cut
						$cutting = $target_len - $pos;
						// get the sequence
						$sequence = substr($target, "-$cutting");
						// remove from the URL
						$target_url = str_replace($sequence, '', $target);
						// set the cut key for this target if not set
						$this->cutter[trim($target)] = str_replace('>{', '', $sequence);
					}
					else
					{
						$target_url = $target;
					}
					// check if the target is valid URL or path
					if ((!filter_var($target_url, FILTER_VALIDATE_URL) === false
							&& FileHelper::exists($target_url))
						|| (Path::clean($target_url) === $target_url
							&& FileHelper::exists($target_url)))
					{
						$this->getCode($target, $bucket);
					}
					// give notice that target is not a valid url/path
					else
					{
						// set key
						$key = '[EXTERNA' . 'LCODE=' . $target . ']';
						// set the notice
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_WARNINGHTHREE'
							), 'Warning'
						);
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_IS_NOT_A_VALID_URLPATH',
								$key
							), 'Warning'
						);
						// remove the placeholder
						$bucket[$key] = '';
					}
				}
				// now update local string if bucket has values
				if (ArrayHelper::check($bucket))
				{
					$string = $this->placeholder->update($string, $bucket);
				}
			}
			// if debug
			if ($debug)
			{
				echo 'External Code String After Update:';
				var_dump($string);
			}
		}

		return $string;
	}

	/**
	 * Get the External Code/String
	 *
	 * @param   string  $string  The content to check
	 * @param   array   $bucket  The Placeholders bucket
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function getCode(string $target, array &$bucket)
	{
		// set URL key
		$target_key = trim($target);
		// set key
		$key = '[EXTERNA' . 'LCODE=' . $target . ']';
		// remove the cut sequence from the url
		if (isset($this->cutter[$target_key]))
		{
			// remove from the URL
			$target_url = trim(str_replace('>{' . $this->cutter[$target_key], '', $target));
		}
		else
		{
			$target_url = trim($target);
		}
		// check if we already fetched this
		if (!isset($this->code[$target_key]))
		{
			// get the data string (code)
			$this->code[$target_key]
				= FileHelper::getContent($target_url);
			// check if we must cut this
			if (isset($this->cutter[$target_key]) &&
				$this->cutter[$target_key])
			{
				$this->code[$target_key] = $this->cut(
					$this->code[$target_key],
					$this->cutter[$target_key],
					$key
				);
			}
			// did we get any value
			if (StringHelper::check(
				$this->code[$target_key]
			))
			{
				// check for changes
				$live_hash = md5($this->code[$target_key]);
				// check if it exists local
				if ($hash = GetHelper::var(
					'external_code', $target_key, 'target', 'hash'
				))
				{
					// must be an admin make a change to use EXTERNAL code (we may add a custom access switch - use ADMIN for now)
					if ($hash !== $live_hash && $this->user->authorise(
						'core.admin', 'com_componentbuilder'
					))
					{
						// update the hash since it changed
						$object         = new stdClass();
						$object->target = $target_key;
						$object->hash   = $live_hash;
						// update local hash
						$this->db->updateObject(
							'#__componentbuilder_external_code', $object,
							'target'
						);
						// give notice of the change
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_WARNINGHTHREE'),
							'Warning'
						);
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_THE_CODESTRING_FROM_BSB_HAS_BEEN_BCHANGEDB_SINCE_THE_LAST_COMPILATION_PLEASE_INVESTIGATE_TO_ENSURE_THE_CHANGES_ARE_SAFE_BSHOULD_YOU_NOT_EXPECT_THIS_CHANGE_TO_THE_EXTERNAL_CODESTRING_BEING_ADDED_THEN_THIS_IS_A_SERIOUS_ISSUE_AND_REQUIRES_IMMEDIATE_ATTENTIONB_DO_NOT_IGNORE_THIS_WARNING_AS_IT_WILL_ONLY_SHOW_BONCEB',
								$key
							), 'Warning'
						);
					}
					elseif ($hash !== $live_hash)
					{
						// set the notice
						$this->app->enqueueMessage(
							Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_ERRORHTHREE'),
							'Error'
						);
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_S_WE_DETECTED_A_CHANGE_IN_BEXTERNALCODEB_BUT_YOU_DO_NOT_HAVE_PERMISSION_TO_ALLOW_THIS_CHANGE_SO_BSB_WAS_REMOVED_FROM_THE_COMPILATION_PLEASE_CONTACT_YOUR_SYSTEM_ADMINISTRATOR_FOR_MORE_INFOBR_SMALLADMIN_ACCESS_REQUIREDSMALL',
								$this->user->get('name'), $key
							), 'Error'
						);
						// remove the code/string
						$this->code[$target_key] = '';
					}
				}
				// only an admin can add new EXTERNAL code (we may add a custom access switch - use ADMIN for now)
				elseif ($this->user->authorise(
					'core.admin', 'com_componentbuilder'
				))
				{
					// add the hash to track changes
					$object         = new stdClass();
					$object->target = $target_key;
					$object->hash   = $live_hash;
					// insert local hash
					$this->db->insertObject(
						'#__componentbuilder_external_code', $object
					);
					// give notice the first time this is added
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_NOTICEHTHREE'),
						'Warning'
					);
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_THE_CODESTRING_FROM_BSB_HAS_BEEN_ADDED_FOR_THE_BFIRST_TIMEB_PLEASE_IINVESTIGATEI_TO_ENSURE_THE_CORRECT_CODESTRING_WAS_USED_BSHOULD_YOU_NOT_KNOW_ABOUT_THIS_NEW_EXTERNAL_CODESTRING_BEING_ADDED_THEN_THIS_IS_A_SERIOUS_DANGER_AND_REQUIRES_IMMEDIATE_ATTENTIONB_DO_NOT_IGNORE_THIS_WARNING_AS_IT_WILL_ONLY_SHOW_BONCEB',
							$key
						), 'Warning'
					);
				}
				else
				{
					// set the notice
					$this->app->enqueueMessage(
						Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_ERRORHTHREE'),
						'Error'
					);
					$this->app->enqueueMessage(
						Text::sprintf('COM_COMPONENTBUILDER_S_WE_DETECTED_BNEW_EXTERNALCODEB_BUT_YOU_DO_NOT_HAVE_PERMISSION_TO_ALLOW_THIS_NEW_CODESTRING_SO_BSB_WAS_REMOVED_FROM_THE_COMPILATION_PLEASE_CONTACT_YOU_SYSTEM_ADMINISTRATOR_FOR_MORE_INFOBR_SMALLADMIN_ACCESS_REQUIREDSMALL',
							$this->user->get('name'), $key
						), 'Error'
					);
					// remove the code/string
					$this->code[$target_key] = '';
				}
			}
			else
			{
				// set notice that we could not get a valid string from the target
				$this->app->enqueueMessage(
					Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_WARNINGHTHREE'), 'Error'
				);
				$this->app->enqueueMessage(
					Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_RETURNED_AN_INVALID_STRING', $key
					), 'Error'
				);
			}
		}
		// add to local bucket
		if (isset($this->code[$target_key]))
		{
			// update the placeholder with the external code string
			$bucket[$key] = $this->code[$target_key];
		}
		else
		{
			// remove the placeholder
			$bucket[$key] = '';
		}
	}

	/**
	 * Cut the External Code/String
	 *
	 * @param   string  $string    The content to cut
	 * @param   string  $sequence  The cutting sequence
	 * @param   string  $key       The content key
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	protected function cut(string $string, string $sequence, string $key): string
	{
		// we first break the string up in rows
		$rows = (array) explode(PHP_EOL, $string);
		// get the cutting sequence
		$cutter = (array) explode('|', $sequence);
		// we only continue if we have more rows than we have to cut
		if (array_sum($cutter) < ArrayHelper::check($rows))
		{
			// remove the rows at the bottom if needed
			if (isset($cutter[1]) && $cutter[1] > 0)
			{
				array_splice($rows, "-$cutter[1]");
			}
			// remove the rows at the top if needed
			if ($cutter[0] > 0)
			{
				$rows = array_splice($rows, $cutter[0]);
			}

			// return the remaining rows
			return implode(PHP_EOL, $rows);
		}

		// we set an error message about too few lines to cut
		$this->app->enqueueMessage(
			Text::_('COM_COMPONENTBUILDER_HR_HTHREEEXTERNAL_CODE_NOTICEHTHREE'),
			'Error'
		);
		$this->app->enqueueMessage(
			Text::sprintf('COM_COMPONENTBUILDER_THE_BSB_CUT_SEQUENCE_FAILED_ON_THE_RETURNED_EXTERNAL_CODESTRING_AS_MORE_LINES_HAS_TO_BE_CUT_THEN_WAS_FOUND_IN_THE_CODESTRING_WE_HAVE_COMPLETELY_REMOVED_THE_CODE_PLEASE_CHECK_THIS_CODESTRING',
				$key
			), 'Error'
		);

		return '';
	}

}

