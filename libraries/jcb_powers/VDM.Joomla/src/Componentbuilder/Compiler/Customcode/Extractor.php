<?php
/**
 * @package    Joomla.Component.Builder
 *
 * @created    4th September, 2022
 * @author     Llewellyn van der Merwe <https://dev.vdm.io>
 * @git        Joomla Component Builder <https://git.vdm.dev/joomla/Component-Builder>
 * @copyright  Copyright (C) 2015 Vast Development Method. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace VDM\Joomla\Componentbuilder\Compiler\Customcode;


use Joomla\CMS\Factory;
use Joomla\CMS\User\User;
use Joomla\CMS\Filesystem\Folder;
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Gui;
use VDM\Joomla\Componentbuilder\Compiler\Customcode\Extractor\Paths;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder\Reverse;
use VDM\Joomla\Componentbuilder\Compiler\Component\Placeholder;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Placefix;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Path;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\ExtractorInterface;


/**
 * Compiler Custom Code Extractor
 * 
 * The custom script placeholders - we use the (xxx) to avoid detection it should be (***)
 * ##################################--->  PHP/JS  ---####################################
 * 
 * New Insert Code        = /xxx[INSERT>$$$$]xxx/                /xxx[/INSERT>$$$$]xxx/
 * New Replace Code    = /xxx[REPLACE>$$$$]xxx/               /xxx[/REPLACE>$$$$]xxx/
 * 
 * //////////////////////////////// when JCB adds it back //////////////////////////////////
 * JCB Add Inserted Code    = /xxx[INSERTED$$$$]xxx//xx23xx/          /xxx[/INSERTED$$$$]xxx/
 * JCB Add Replaced Code    = /xxx[REPLACED$$$$]xxx//xx25xx/          /xxx[/REPLACED$$$$]xxx/
 * 
 * /////////////////////////////// changeing existing custom code /////////////////////////
 * Update Inserted Code    = /xxx[INSERTED>$$$$]xxx//xx23xx/        /xxx[/INSERTED>$$$$]xxx/
 * Update Replaced Code    = /xxx[REPLACED>$$$$]xxx//xx25xx/        /xxx[/REPLACED>$$$$]xxx/
 * 
 * The custom script placeholders - we use the (==) to avoid detection it should be (--)
 * ###################################--->  HTML  ---#####################################
 * 
 * New Insert Code        = !==[INSERT>$$$$]==>                 !==[/INSERT>$$$$]==>
 * New Replace Code    = !==[REPLACE>$$$$]==>                !==[/REPLACE>$$$$]==>
 * 
 * ///////////////////////////////// when JCB adds it back ///////////////////////////////
 * JCB Add Inserted Code    =         
 * JCB Add Replaced Code    =         
 * 
 * //////////////////////////// changeing existing custom code ///////////////////////////
 * Update Inserted Code    = !==[INSERTED>$$$$]==>      !==[/INSERTED>$$$$]==>
 * Update Replaced Code    = !==[REPLACED>$$$$]==>      !==[/REPLACED>$$$$]==>
 * 
 * ////////23 is the ID of the code in the system don't change it!!!!!!!!!!!!!!!!!!!!!!!!!!
 * 
 * More info read: https://git.vdm.dev/joomla/Component-Builder/wiki/TIPS:-Custom-Code
 * 
 * @since 3.2.0
 */
class Extractor implements ExtractorInterface
{
	/**
	 * The placeholder keys
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $PKeys
		= [
			1 => 'REPLACE<>$$$$]',
			2 => 'INSERT<>$$$$]',
			3 => 'REPLACED<>$$$$]',
			4 => 'INSERTED<>$$$$]'
		];

	/**
	 * The custom code in local files that already exist in system
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $existing = [];

	/**
	 * The custom code in local files that are new
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $new = [];

	/**
	 * The index of code already loaded
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $done = [];

	/**
	 * The search counter
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $counter = [1 => 0, 2 => 0];

	/**
	 * The file types to search
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $fileTypes = ['\.php', '\.js', '\.xml'];

	/**
	 * The local placeholders
	 *
	 * @var      array
	 * @since 3.2.0
	 */
	protected array $placeholders;

	/**
	 * Today's date in SQL format
	 *
	 * @var      string
	 * @since 3.2.0
	 */
	protected string $today;

	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Customcode Gui
	 *
	 * @var    Gui
	 * @since 3.2.0
	 **/
	protected Gui $gui;

	/**
	 * Compiler Customcode Extractor Paths
	 *
	 * @var    Paths
	 * @since 3.2.0
	 **/
	protected Paths $paths;

	/**
	 * Compiler Placeholder Reverse
	 *
	 * @var    Reverse
	 * @since 3.2.0
	 **/
	protected Reverse $reverse;

	/**
	 * Compiler Component Placeholder
	 *
	 * @var    Placeholder
	 * @since 3.2.0
	 **/
	protected Placeholder $componentPlaceholder;

	/**
	 * Current User Object
	 *
	 * @var    User
	 * @since 3.2.0
	 **/
	protected User $user;

	/**
	 * Database object to query local DB
	 *
	 * @var    \JDatabaseDriver
	 * @since 3.2.0
	 **/
	protected \JDatabaseDriver $db;

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
	 * @param Config|null             $config      The compiler config object.
	 * @param Gui|null                $gui         The compiler customcode gui object.
	 * @param Paths|null              $paths       The compiler customcode extractor paths object.
	 * @param Reverse|null            $reverse     The compiler placeholder reverse object.
	 * @param Placeholder|null        $placeholder The compiler component placeholder object.
	 * @param User|null               $user        The current User object.
	 * @param \JDatabaseDriver|null   $db          The Database Driver object.
	 * @param CMSApplication|null     $app         The CMS Application object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Gui $gui = null, ?Paths $paths = null,
		?Reverse $reverse = null, ?Placeholder $placeholder = null,
		?User $user = null, ?\JDatabaseDriver $db = null, ?CMSApplication $app = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->gui = $gui ?: Compiler::_('Customcode.Gui');
		$this->paths = $paths ?: Compiler::_('Customcode.Extractor.Paths');
		$this->reverse = $reverse ?: Compiler::_('Placeholder.Reverse');
		$this->componentPlaceholder = $placeholder ?: Compiler::_('Component.Placeholder');
		$this->user = $user ?: Factory::getUser();
		$this->db = $db ?: Factory::getDbo();
		$this->app = $app ?: Factory::getApplication();

		// set today's date
		$this->today = Factory::getDate()->toSql();

		// set some local placeholders
		$placeholders = array_flip(
			$this->componentPlaceholder->get()
		);

		$placeholders[StringHelper::safe(
			$this->config->component_code_name, 'F'
		) . 'Helper::'] = Placefix::_('Component') . 'Helper::';

		$placeholders['COM_' . StringHelper::safe(
			$this->config->component_code_name, 'U'
		)] = 'COM_' . Placefix::_('COMPONENT');

		$placeholders['com_' . $this->config->component_code_name] = 'com_' . Placefix::_('component');

		// set the local placeholders
		$this->placeholders = array_reverse($placeholders, true);
	}

	/**
	 * get the custom code from the local files
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function run()
	{
		// we must first store the current working directory
		$joomla  = getcwd();

		foreach ($this->paths->active as $target => $path)
		{
			// we are changing the working directory to the component path
			chdir($path);
			foreach ($this->fileTypes as $type)
			{
				// get a list of files in the current directory tree (only PHP, JS and XML for now)
				$files = Folder::files('.', $type, true, true);

				// check if files found
				if (ArrayHelper::check($files))
				{
					foreach ($files as $file)
					{
						// search the file
						$this->searchFileContent($file, $target);

						// insert new code
						$this->insert(100);

						// update existing custom code
						$this->update(30);
					}
				}
			}
		}

		// change back to Joomla working directory
		chdir($joomla);

		// make sure all code is stored
		$this->insert();
		// update existing custom code
		$this->update();
	}

	/**
	 * search a file for placeholders and store result
	 *
	 * @param   string  $file          The file path to search
	 *
	 * @return  array    on success
	 * @since 3.2.0
	 */
	protected function searchFileContent(&$file, &$target)
	{
		// we add a new search for the GUI CODE Blocks
		$this->gui->search($file, $this->placeholders, $this->today, $target);

		// reset each time per file
		$loadEndFingerPrint = false;
		$endFingerPrint = [];
		$fingerPrint = [];
		$codeBucket = [];
		$pointer = [];
		$reading = [];
		$reader = 0;

		// reset found Start type
		$commentType = 0;

		// make sure we have the path correct (the script file is not in admin path for example)
		// there may be more... will nead to keep our eye on this... since files could be moved during install
		$file = str_replace('./', '', (string) $file); # TODO (windows path issues)
		$path = $file !== 'script.php' ? $target . '/' . $file : $file;

		// now we go line by line
		foreach (new \SplFileObject($file) as $lineNumber => $lineContent)
		{
			// we must keep last few lines to dynamic find target entry later
			$fingerPrint[$lineNumber] = trim($lineContent);

			// load the end fingerprint
			if ($loadEndFingerPrint)
			{
				$endFingerPrint[$lineNumber] = trim($lineContent);
			}

			foreach ($this->PKeys as $type => $search)
			{
				$i     = (int) ($type == 3 || $type == 4) ? 2 : 1;
				$_type = (int) ($type == 1 || $type == 3) ? 1 : 2;

				if ($reader === 0 || $reader === $i)
				{
					$targetKey = $type;

					$start     = '/***[' . $search . '***/';
					$end       = '/***[/' . $search . '***/';
					$startHTML = '<!--[' . $search . '-->';
					$endHTML   = '<!--[/' . $search . '-->';

					// check if the ending placeholder was found
					if (isset($reading[$targetKey]) && $reading[$targetKey]
						&& ((trim((string) $lineContent) === $end
							|| strpos((string) $lineContent, $end) !== false)
							|| (trim((string) $lineContent) === $endHTML
							|| strpos((string) $lineContent, $endHTML) !== false)))
					{
						// trim the placeholder and if there is still data then load it
						if (isset($endReplace)
							&& ($_line = $this->addLineChecker($endReplace, 2, $lineContent)) !== false)
						{
							$codeBucket[$pointer[$targetKey]][] = $_line;
						}

						// deactivate the reader
						$reading[$targetKey] = false;

						if ($_type == 2)
						{
							// deactivate search
							$reader = 0;
						}
						else
						{
							// activate fingerPrint for replacement end target
							$loadEndFingerPrint = true;
							$backupTargetKey    = $targetKey;
							$backupI            = $i;
						}

						// all new records we can do a bulk insert
						if ($i === 1)
						{
							// end the bucket info for this code block
							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								(int) $lineNumber
							);   // 'toline'

							// first reverse engineer this code block
							$c0de = $this->reverse->engine(
								implode('', $codeBucket[$pointer[$targetKey]]),
								$this->placeholders, $target
							);

							$this->new[$pointer[$targetKey]][]
							      = $this->db->quote(
								base64_encode((string) $c0de)
							);  // 'code'

							if ($_type == 2)
							{
								// load the last value
								$this->new[$pointer[$targetKey]][]
									= $this->db->quote(0); // 'hashendtarget'
							}
						}
						// the record already exist so we must update instead
						elseif ($i === 2)
						{
							// end the bucket info for this code block
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('to_line') . ' = '
								. $this->db->quote($lineNumber);

							// first reverse engineer this code block
							$c0de = $this->reverse->engine(
								implode('', $codeBucket[$pointer[$targetKey]]),
								$this->placeholders, $target,
								$this->existing[$pointer[$targetKey]]['id']
							);

							$this->existing[$pointer[$targetKey]]['fields'][]
							      = $this->db->quoteName('code') . ' = '
								. $this->db->quote(base64_encode((string) $c0de));

							if ($_type == 2)
							{
								// load the last value
								$this->existing[$pointer[$targetKey]]['fields'][]
									= $this->db->quoteName('hashendtarget')
									. ' = ' . $this->db->quote(0);
							}
						}
					}

					// check if the endfingerprint is ready to save
					if (count((array) $endFingerPrint) === 3)
					{
						$hashendtarget = '3__' . md5(
								implode('', $endFingerPrint)
							);

						// all new records we can do a bulk insert
						if ($i === 1)
						{
							// load the last value
							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								$hashendtarget
							); // 'hashendtarget'
						}
						// the record already exist so we must update
						elseif ($i === 2)
						{
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('hashendtarget') . ' = '
								. $this->db->quote($hashendtarget);
						}

						// reset the needed values
						$endFingerPrint     = [];
						$loadEndFingerPrint = false;

						// deactivate reader (to allow other search)
						$reader = 0;
					}

					// then read in the code
					if (isset($reading[$targetKey]) && $reading[$targetKey])
					{
						$codeBucket[$pointer[$targetKey]][] = $lineContent;
					}

					// see if the custom code line starts now with PHP/JS comment type
					if ((!isset($reading[$targetKey]) || !$reading[$targetKey])
						&& (($i === 1 && trim((string) $lineContent) === $start)
							|| strpos((string) $lineContent, $start) !== false))
					{
						$commentType  = 1; // PHP/JS type
						$startReplace = $start;
						$endReplace   = $end;
					}
					// see if the custom code line starts now with HTML comment type
					elseif ((!isset($reading[$targetKey])
							|| !$reading[$targetKey])
						&& (($i === 1 && trim((string) $lineContent) === $startHTML)
							|| strpos((string) $lineContent, $startHTML) !== false))
					{
						$commentType  = 2; // HTML type
						$startReplace = $startHTML;
						$endReplace   = $endHTML;
					}

					// check if the starting place holder was found
					if ($commentType > 0)
					{
						// if we have all on one line we have a problem (don't load it TODO)
						if (strpos((string) $lineContent, (string) $endReplace) !== false)
						{
							// reset found comment type
							$commentType = 0;
							$this->app->enqueueMessage(
								Text::_('COM_COMPONENTBUILDER_HR_HTHREECUSTOM_CODES_WARNINGHTHREE'),
								'Warning'
							);
							$this->app->enqueueMessage(
								Text::sprintf('COM_COMPONENTBUILDER_WE_FOUND_DYNAMIC_CODE_BALL_IN_ONE_LINEB_AND_IGNORED_IT_PLEASE_REVIEW_S_FOR_MORE_DETAILS',
									$path
								), 'Warning'
							);
							continue;
						}

						// do a quick check to insure we have an id
						$id = false;
						if ($i === 2)
						{
							$id = $this->getSystemID(
								$lineContent,
								array(1 => $start, 2 => $startHTML),
								$commentType
							);
						}

						if ($i === 2 && $id > 0)
						{
							// make sure we update it only once even if found again.
							if (isset($this->done[$id]))
							{
								// reset found comment type
								$commentType = 0;
								continue;
							}
							// store the id to avoid duplication
							$this->done[$id] = (int) $id;
						}

						// start replace
						$startReplace = $this->setStartReplace(
							$id, $commentType, $startReplace
						);

						// set active reader (to lock out other search)
						$reader = $i;

						// set pointer
						$pointer[$targetKey] = $this->counter[$i];

						// activate the reader
						$reading[$targetKey] = true;

						// start code bucket
						$codeBucket[$pointer[$targetKey]] = [];

						// trim the placeholder and if there is still data then load it
						if ($_line = $this->addLineChecker(
							$startReplace, 1, $lineContent
						))
						{
							$codeBucket[$pointer[$targetKey]][] = $_line;
						}

						// get the finger print around the custom code
						$inFinger   = count($fingerPrint);
						$getFinger  = $inFinger - 1;
						$hasharray  = array_slice(
							$fingerPrint, -$inFinger, $getFinger, true
						);
						$hasleng    = count($hasharray);
						$hashtarget = $hasleng . '__' . md5(
								implode('', $hasharray)
							);

						// for good practice
						Path::fix($path);

						// all new records we can do a bulk insert
						if ($i === 1 || !$id)
						{
							// start the bucket for this code
							$this->new[$pointer[$targetKey]] = [];
							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								$path
							);   // 'path'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								(int) $_type
							);  // 'type'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								1
							); // 'target'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								$commentType
							);  // 'comment_type'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								(int) $this->config->component_id
							); // 'component'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								1
							); // 'published'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								$this->today
							);   // 'created'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								(int) $this->user->id
							); // 'created_by'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								1
							); // 'version'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								1
							); // 'access'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								$hashtarget
							);  // 'hashtarget'

							$this->new[$pointer[$targetKey]][]
								= $this->db->quote(
								(int) $lineNumber
							);  // 'fromline'

						}
						// the record already exist so we must update instead
						elseif ($i === 2 && $id > 0)
						{
							// start the bucket for this code
							$this->existing[$pointer[$targetKey]] = [];
							$this->existing[$pointer[$targetKey]]['id']
								= (int) $id;
							$this->existing[$pointer[$targetKey]]['conditions'] = [];
							$this->existing[$pointer[$targetKey]]['conditions'][]
								= $this->db->quoteName('id') . ' = '
								. $this->db->quote($id);
							$this->existing[$pointer[$targetKey]]['fields'] = [];
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('path') . ' = '
								. $this->db->quote($path);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('type') . ' = '
								. $this->db->quote($_type);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('comment_type') . ' = '
								. $this->db->quote($commentType);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('component') . ' = '
								. $this->db->quote($this->config->component_id);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('from_line') . ' = '
								. $this->db->quote($lineNumber);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('modified') . ' = '
								. $this->db->quote($this->today);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('modified_by') . ' = '
								. $this->db->quote($this->user->id);
							$this->existing[$pointer[$targetKey]]['fields'][]
								= $this->db->quoteName('hashtarget') . ' = '
								. $this->db->quote($hashtarget);
						}
						else // this should actualy never happen
						{
							// de activate the reader
							$reading[$targetKey] = false;
							$reader              = 0;
						}

						// reset found comment type
						$commentType = 0;
						// update the counter
						$this->counter[$i]++;
					}
				}
			}

			// make sure only a few lines is kept at a time
			if (count((array) $fingerPrint) > 10)
			{
				$fingerPrint = array_slice($fingerPrint, -6, 6, true);
			}
		}

		// if the code is at the end of the page and there were not three more lines
		if (count((array) $endFingerPrint) > 0 || $loadEndFingerPrint)
		{
			if (count((array) $endFingerPrint) > 0)
			{
				$leng          = count($endFingerPrint);
				$hashendtarget = $leng . '__' . md5(
						implode('', $endFingerPrint)
					);
			}
			else
			{
				$hashendtarget = 0;
			}

			// all new records we can do a buldk insert
			if ($backupI === 1)
			{
				// load the last value
				$this->new[$pointer[$backupTargetKey]][]
					= $this->db->quote($hashendtarget); // 'hashendtarget'
			}
			// the record already exist so we must use module to update
			elseif ($backupI === 2)
			{
				$this->existing[$pointer[$backupTargetKey]]['fields'][]
					= $this->db->quoteName('hashendtarget') . ' = '
					. $this->db->quote($hashendtarget);
			}
		}
	}

	/**
	 * Insert the code
	 *
	 * @param   int  $when  To set when to update
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function insert(int $when = 1)
	{
		if (ArrayHelper::check($this->new) >= $when)
		{
			// Create a new query object.
			$query    = $this->db->getQuery(true);
			$continue = false;
			// Insert columns.
			$columns = array('path', 'type', 'target', 'comment_type',
				'component', 'published', 'created', 'created_by',
				'version', 'access', 'hashtarget', 'from_line',
				'to_line', 'code', 'hashendtarget');
			// Prepare the insert query.
			$query->insert(
				$this->db->quoteName('#__componentbuilder_custom_code')
			);
			$query->columns($this->db->quoteName($columns));
			foreach ($this->new as $values)
			{
				if (count((array) $values) == 15)
				{
					$query->values(implode(',', $values));
					$continue = true;
				}
				else
				{
					// TODO line mismatch... should not happen
				}
			}
			// clear the values array
			$this->new = [];
			if (!$continue)
			{
				return; // insure we don't continue if no values were loaded
			}
			// Set the query using our newly populated query object and execute it.
			$this->db->setQuery($query);
			$this->db->execute();
		}
	}

	/**
	 * Update the code
	 *
	 * @param   int  $when  To set when to update
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	protected function update(int $when = 1)
	{
		if (ArrayHelper::check($this->existing) >= $when)
		{
			foreach ($this->existing as $code)
			{
				// Create a new query object.
				$query = $this->db->getQuery(true);
				// Prepare the update query.
				$query->update(
					$this->db->quoteName('#__componentbuilder_custom_code')
				)->set($code['fields'])->where($code['conditions']);
				// Set the query using our newly populated query object and execute it.
				$this->db->setQuery($query);
				$this->db->execute();
			}
			// clear the values array
			$this->existing = [];
		}
	}

	/**
	 * set the start replace placeholder
	 *
	 * @param   int     $id            The comment id
	 * @param   int     $commentType   The comment type
	 * @param   string  $startReplace  The main replace string
	 *
	 * @return  string    on success
	 * @since 3.2.0
	 */
	protected function setStartReplace(int $id, int $commentType, string $startReplace): string
	{
		if ($id > 0)
		{
			switch ($commentType)
			{
				case 1: // the PHP & JS type
					$startReplace .= '/*' . $id . '*/';
					break;
				case 2: // the HTML type
					$startReplace .= '<!--' . $id . '-->';
					break;
			}
		}

		return $startReplace;
	}

	/**
	 * Check if this line should be added
	 *
	 * @param   string  $replaceKey   The key to remove from line
	 * @param   int     $type         The line type
	 * @param   string  $lineContent  The line to check
	 *
	 * @return  bool|int true    on success
	 * @since 3.2.0
	 */
	protected function addLineChecker(string $replaceKey, int $type, string $lineContent)
	{
		$check = explode($replaceKey, $lineContent);
		switch ($type)
		{
			case 1:
				// beginning of code
				if (isset($check[1]) && StringHelper::check($check[1]))
				{
					return trim($check[1]);
				}
				break;
			case 2:
				// end of code
				if (isset($check[0]) && StringHelper::check($check[0]))
				{
					return trim($check[0]);
				}
				break;
		}

		return false;
	}

	/**
	 * search for the system id in the line given
	 *
	 * @param   string  $lineContent   The file path to search
	 * @param   array   $placeholders  The values to search for
	 * @param   int     $commentType   The comment type
	 *
	 * @return  mixed    on success
	 * @since 3.2.0
	 */
	protected function getSystemID(string &$lineContent, array $placeholders, int $commentType)
	{
		$trim = '/';
		if ($commentType == 2)
		{
			$trim = '<!--';
		}
		// remove place holder from content
		$string = trim(
			str_replace($placeholders[$commentType] . $trim, '', $lineContent)
		);
		// now get all numbers
		$numbers = [];
		preg_match_all('!\d+!', $string, $numbers);
		// return the first number
		if (isset($numbers[0])
			&& ArrayHelper::check(
				$numbers[0]
			))
		{
			return reset($numbers[0]);
		}

		return false;
	}

}

