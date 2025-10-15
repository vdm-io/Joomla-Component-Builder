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


use VDM\Joomla\Componentbuilder\Compiler\Power as CompilerPower;
use VDM\Joomla\Componentbuilder\Compiler\Power\Extractor;
use VDM\Joomla\Componentbuilder\Compiler\Power\Structure;
use VDM\Joomla\Componentbuilder\Compiler\Power\Infusion;
use VDM\Joomla\Componentbuilder\Compiler\Extension\FileContent;
use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Utilities\ObjectHelper;
use VDM\Joomla\Utilities\ArrayHelper;
use VDM\Joomla\Utilities\StringHelper;


/**
 * Power Files Updater Class
 * 
 * @since 5.1.2
 */
final class Power
{
	/**
	 * The Power Class.
	 *
	 * @var   CompilerPower
	 * @since 5.1.2
	 */
	protected CompilerPower $compilerpower;

	/**
	 * The Extractor Class.
	 *
	 * @var   Extractor
	 * @since 5.1.2
	 */
	protected Extractor $extractor;

	/**
	 * The Structure Class.
	 *
	 * @var   Structure
	 * @since 5.1.2
	 */
	protected Structure $structure;

	/**
	 * The Infusion Class.
	 *
	 * @var   Infusion
	 * @since 5.1.2
	 */
	protected Infusion $infusion;

	/**
	 * The FileContent Class.
	 *
	 * @var   FileContent
	 * @since 5.1.2
	 */
	protected FileContent $filecontent;

	/**
	 * The Files Class.
	 *
	 * @var   Files
	 * @since 5.1.2
	 */
	protected Files $files;

	/**
	 * The ContentMulti Class.
	 *
	 * @var   ContentMulti
	 * @since 5.1.2
	 */
	protected ContentMulti $contentmulti;

	/**
	 * Constructor.
	 *
	 * @param CompilerPower   $compilerpower   The Power Class.
	 * @param Extractor       $extractor       The Extractor Class.
	 * @param Structure       $structure       The Structure Class.
	 * @param Infusion        $infusion        The Infusion Class.
	 * @param FileContent     $filecontent     The FileContent Class.
	 * @param Files           $files           The Files Class.
	 * @param ContentMulti    $contentmulti    The ContentMulti Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(CompilerPower $compilerpower, Extractor $extractor,
		Structure $structure, Infusion $infusion,
		FileContent $filecontent, Files $files,
		ContentMulti $contentmulti)
	{
		$this->compilerpower = $compilerpower;
		$this->extractor = $extractor;
		$this->structure = $structure;
		$this->infusion = $infusion;
		$this->filecontent = $filecontent;
		$this->files = $files;
		$this->contentmulti = $contentmulti;
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
		if (($super_powers = $this->extractor->get_()) !== null)
		{
			$this->compilerpower->load($super_powers);
		}

		$this->structure->build();

		$this->infusion->set();

		if (ArrayHelper::check($this->compilerpower->active))
		{
			foreach ($this->compilerpower->active as $power)
			{
				if (ObjectHelper::check($power)
					&& $this->files->exists($power->key))
				{
					foreach ($this->files->get($power->key) as $power_file)
					{
						if (is_file($power_file['path']))
						{
							$this->filecontent->set(
								$power_file['name'], $power_file['path'], $bom, $power->key
							);
						}
					}

					$this->files->remove($power->key);
					$this->contentmulti->remove($power->key);
				}
			}
		}

		if (ArrayHelper::check($this->compilerpower->superpowers))
		{
			foreach ($this->compilerpower->superpowers as $path => $powers)
			{
				$key = StringHelper::safe($path);
				if ($this->files->exists($key))
				{
					foreach ($this->files->get($key) as $power_file)
					{
						if (is_file($power_file['path']))
						{
							$this->filecontent->set(
								$power_file['name'], $power_file['path'], $bom, $key
							);
						}
					}

					$this->files->remove($key);
					$this->contentmulti->remove($key);
				}
			}
		}
	}
}

