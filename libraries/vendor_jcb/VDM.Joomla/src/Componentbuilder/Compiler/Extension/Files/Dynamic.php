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


use VDM\Joomla\Componentbuilder\Compiler\Utilities\Files;
use VDM\Joomla\Componentbuilder\Compiler\Builder\ContentMulti;
use VDM\Joomla\Componentbuilder\Compiler\Extension\FileContent;
use VDM\Joomla\Componentbuilder\Compiler\Interfaces\ExtensionFilesUpdateInterface;


/**
 * Dynamic Files Updater Class
 * 
 * @since 5.1.2
 */
final class Dynamic implements ExtensionFilesUpdateInterface
{
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
	 * The FileContent Class.
	 *
	 * @var   FileContent
	 * @since 5.1.2
	 */
	protected FileContent $filecontent;

	/**
	 * Constructor.
	 *
	 * @param Files          $files          The Files Class.
	 * @param ContentMulti   $contentmulti   The ContentMulti Class.
	 * @param FileContent    $filecontent    The FileContent Class.
	 *
	 * @since 5.1.2
	 */
	public function __construct(Files $files, ContentMulti $contentmulti,
		FileContent $filecontent)
	{
		$this->files = $files;
		$this->contentmulti = $contentmulti;
		$this->filecontent = $filecontent;
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
		if ($this->files->exists('dynamic'))
		{
			// now we do the dynamic files
			foreach ($this->files->get('dynamic') as $view => $files)
			{
				if ($this->contentmulti->isArray($view))
				{
					foreach ($files as $file)
					{
						if ($file['view'] == $view)
						{
							if (is_file($file['path']))
							{
								$this->filecontent->set(
									$file['name'], $file['path'], $bom, $file['view']
								);
							}
						}
					}
				}
			}
		}
	}
}

