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

namespace VDM\Joomla\Componentbuilder\Compiler\Extension\Files;


use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ModuleDataInterface as Data;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\MoveFieldsRulesInterface as MoveFieldsRules;
use VDM\Joomla\Componentbuilder\Compiler\Extension\FileContent;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ExtensionFilesUpdateInterface;


/**
 * Module Files Updater Class
 * 
 * @since 5.1.2
 */
final class Module implements ExtensionFilesUpdateInterface
{
	/**
	 * The ModuleData Class.
	 *
	 * @var   Data
	 * @since 5.1.2
	 */
	protected Data $data;

	/**
	 * The MoveFieldsRules Class.
	 *
	 * @var   MoveFieldsRules
	 * @since 5.1.2
	 */
	protected MoveFieldsRules $movefieldsrules;

	/**
	 * The FileContent Class.
	 *
	 * @var   FileContent
	 * @since 5.1.2
	 */
	protected FileContent $filecontent;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.2
	 */
	protected ContentMulti $contentmulti;

	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 5.1.2
	 */
	protected Files $files;

	/**
	 * Constructor.
	 *
	 * @param Data              $data              The ModuleData Class.
	 * @param MoveFieldsRules   $movefieldsrules   The MoveFieldsRules Class.
	 * @param FileContent       $filecontent       The FileContent Class.
	 * @param ContentMulti      $contentmulti      The ContentMulti Class.
	 * @param Files             $files             The Files Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Data $data, MoveFieldsRules $movefieldsrules,
		FileContent $filecontent, ContentMulti $contentmulti,
		Files $files)
	{
		$this->data = $data;
		$this->movefieldsrules = $movefieldsrules;
		$this->filecontent = $filecontent;
		$this->contentmulti = $contentmulti;
		$this->files = $files;
	}

	/**
	 * Update all files
	 *
	 * @param string   $bom   The header details [BOM] of the file
	 *
	 * @return  void
	 * @since 5.1.2
	 */
	public function update(string $bom): void
	{
		if ($this->data->exists())
		{
			foreach ($this->data->get() as $module)
			{
				if (ObjectHelper::check($module)
					&& $this->files->exists($module->key))
				{
					if (isset($module->fields_rules_paths)
						&& $module->fields_rules_paths == 2)
					{
						if (isset($module->config_fields)
							&& ArrayHelper::check($module->config_fields))
						{
							foreach ($module->config_fields as $field_name => $fieldsets)
							{
								foreach ($fieldsets as $fieldset => $fields)
								{
									foreach ($fields as $field)
									{
										$this->movefieldsrules->move(
											$field, $module->folder_path
										);
									}
								}
							}
						}

						if (isset($module->form_files) && ArrayHelper::check($module->form_files))
						{
							foreach ($module->form_files as $file => $files)
							{
								foreach ($files as $field_name => $fieldsets)
								{
									foreach ($fieldsets as $fieldset => $fields)
									{
										foreach ($fields as $field)
										{
											$this->movefieldsrules->move(
												$field, $module->folder_path
											);
										}
									}
								}
							}
						}
					}

					foreach ($this->files->get($module->key) as $module_file)
					{
						if (is_file($module_file['path']))
						{
							$this->filecontent->set(
								$module_file['name'], $module_file['path'], $bom, $module->key
							);
						}
					}

					$this->files->remove($module->key);
					$this->contentmulti->remove($module->key);
				}
			}
		}
	}
}

