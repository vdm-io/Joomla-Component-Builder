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
use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Language\Text;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;
use VDM\Joomla\Utilities\GetHelper;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Utilities\String\FieldHelper;
use VDM\Joomla\Componentbuilder\Compiler\Factory as Compiler;
use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Placeholder\Reverse;
use VDM\Joomla\Componentbuilder\Power\Parser;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\Customcode\GuiInterface;


/**
 * Compiler Gui Custom Code
 * 
 * @since 3.2.0
 */
class Gui implements GuiInterface
{
	/**
	 * Compiler Config
	 *
	 * @var    Config
	 * @since 3.2.0
	 **/
	protected Config $config;

	/**
	 * Compiler Placeholder Reverse
	 *
	 * @var    Reverse
	 * @since 3.2.0
	 **/
	protected Reverse $reverse;

	/**
	 * Compiler Powers Parser
	 *
	 * @var    Parser
	 * @since 3.2.0
	 **/
	protected Parser $parser;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $db;

	/**
	 * Database object to query local DB
	 *
	 * @since 3.2.0
	 **/
	protected $app;

	/**
	 * Constructor.
	 *
	 * @param Config|null             $config  The compiler config object.
	 * @param Reverse|null            $reverse The compiler placeholder reverse object.
	 * @param Parser|null             $parser  The powers parser object.
	 *
	 * @throws \Exception
	 * @since 3.2.0
	 */
	public function __construct(?Config $config = null, ?Reverse $reverse = null, ?Parser $parser = null)
	{
		$this->config = $config ?: Compiler::_('Config');
		$this->reverse = $reverse ?: Compiler::_('Placeholder.Reverse');
		$this->parser = $parser ?: Compiler::_('Power.Parser');
		$this->db = Factory::getDbo();
		$this->app = Factory::getApplication();
	}

	/**
	 * Set the JCB GUI code placeholder
	 *
	 * @param   string  $string  The code string
	 * @param   array   $config  The placeholder config values
	 *
	 * @return  string
	 * @since 3.2.0
	 */
	public function set(string $string, array $config): string
	{
		if (StringHelper::check($string))
		{
			if ($this->config->get('add_placeholders', false)
				&& $this->check($string) && ArrayHelper::check($config)
				&& isset($config['table']) && StringHelper::check($config['table'])
				&& isset($config['field']) && StringHelper::check($config['field'])
				&& isset($config['type']) && StringHelper::check($config['type'])
				&& isset($config['id']) && is_numeric($config['id']))
			{
				// if we have a key we must get the ID
				if (isset($config['key']) && StringHelper::check($config['key']) && $config['key'] !== 'id')
				{
					if (($id = GetHelper::var($config['table'], $config['id'], $config['key'], 'id')) !== false && is_numeric($id))
					{
						$config['id'] = $id;
					}
					else
					{
						// we must give a error message to inform the user of this issue. (should never happen)
						$this->app->enqueueMessage(
							Text::sprintf('COM_COMPONENTBUILDER_ID_MISMATCH_WAS_DETECTED_WITH_THE_SSSS_GUI_CODE_FIELD_SO_THE_PLACEHOLDER_WAS_NOT_SET',
								$config['table'], $config['field'],
								$config['key'], $config['id']
							), 'Error'
						);
						// check some config
						if (!isset($config['prefix']))
						{
							$config['prefix'] = '';
						}

						return $config['prefix'] . $string;
					}
				}
				// check some config
				if (!isset($config['prefix']))
				{
					$config['prefix'] = PHP_EOL;
				}
				// add placeholder based on type of code
				switch (strtolower((string) $config['type']))
				{
					// adding with html commenting
					case 'html':
						$front = $config['prefix'] . '<!--' . '[JCBGUI.';
						$sufix = '$$$$]-->' . PHP_EOL;
						$back  = '<!--[/JCBGUI' . $sufix;
						break;
					// adding with php commenting
					default:
						$front = $config['prefix'] . '/***' . '[JCBGUI.';
						$sufix = '$$$$]***/' . PHP_EOL;
						$back  = '/***[/JCBGUI' . $sufix;
						break;
				}

				return $front . $config['table'] . '.' . $config['field'] . '.'
					. $config['id'] . '.' . $sufix . $string . $back;
			}
			// check some config
			if (!isset($config['prefix']))
			{
				$config['prefix'] = '';
			}

			return $config['prefix'] . $string;
		}

		return $string;
	}

	/**
	 * search a file for gui code blocks that were updated in the IDE
	 *
	 * @param   string  $file          The file path to search
	 * @param   array   $placeholders  The values to replace in the code being stored
	 * @param   string  $today         The date for today
	 * @param   string  $target        The target path type
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function search(string &$file, array &$placeholders, string &$today, string &$target)
	{
		// get file content
		$file_content = FileHelper::getContent($file);

		// get the USE statements (to reverse engineer super power keys)
		$use_statements = $this->parser->getUseStatements($file_content);

		$guiCode = [];
		// we add a new search for the GUI CODE Blocks
		$guiCode[] = GetHelper::allBetween(
			$file_content, '/***[JCB' . 'GUI<>', '/***[/JCBGUI' . '$$$$]***/'
		);
		$guiCode[] = GetHelper::allBetween(
			$file_content, '<!--[JCB' . 'GUI<>', '<!--[/JCBGUI' . '$$$$]-->'
		);

		if (($guiCode = ArrayHelper::merge($guiCode)) !== false
			&& ArrayHelper::check($guiCode, true))
		{
			foreach ($guiCode as $code)
			{
				$first_line = strtok($code, PHP_EOL);
				// get the GUI target details
				$query = explode('.', trim($first_line, '.'));
				// only continue if we have 3 values in the query
				if (is_array($query) && count($query) >= 3)
				{
					// cleanup the newlines around the code
					$code = trim(str_replace($first_line, '', (string) $code), PHP_EOL)
						. PHP_EOL;
					// set the ID
					$id = (int) $query[2];
					// make the field name save
					$field = FieldHelper::safe($query[1]);
					// make the table name save
					$table = StringHelper::safe($query[0]);
					// reverse placeholder as much as we can
					$code = $this->reverse->engine(
						$code, $placeholders, $target, $id, $field, $table, $use_statements
					);
					// update the GUI/Tables/Database
					$object           = new \stdClass();
					$object->id       = $id;
					$object->{$field} = base64_encode(
						(string) $code
					); // (TODO) this may not always work...
					// update the value in GUI
					$this->db->updateObject(
						'#__componentbuilder_' . (string) $table, $object, 'id'
					);
				}
			}
		}
	}

	/**
	 * search a code to see if there is already any custom
	 * code or other reasons not to add the GUI code placeholders
	 *
	 * @param   string  $code  The code to check
	 *
	 * @return  bool   true if GUI code placeholders can be added
	 * @since 3.2.0
	 */
	protected function check(string &$code): bool
	{
		// check for customcode placeholders
		// we do not add GUI wrapper placeholder to code
		// that already has any customcode placeholders
		return strpos($code, '$$$$') === false;
	}

}

