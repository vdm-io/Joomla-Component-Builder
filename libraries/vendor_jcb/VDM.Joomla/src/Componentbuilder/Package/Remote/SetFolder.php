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

namespace VDM\Joomla\Componentbuilder\Package\Remote;


use Joomla\CMS\Language\Text;
use Joomla\Filesystem\File;
use VDM\Joomla\Utilities\FileHelper;
use VDM\Joomla\Interfaces\Remote\SetInterface;
use VDM\Joomla\Componentbuilder\Package\Remote\SetContent;


/**
 * Set folder on remote repository
 * 
 * @since 5.1.1
 */
final class SetFolder extends SetContent implements SetInterface
{
	/**
	 * Get the folder content
	 *
	 * @param  string   $fullPath  The full path to the folder
	 * @param  string   $guid        The folder key/guid
	 *
	 * @return string|null
	 * @since  5.1.1
	 */
	protected function getContent(string $fullPath, string $guid): ?string
	{
		$zip_path = "{$fullPath}.{$guid}";
		$content = null;

		try {
			$done = FileHelper::zip($fullPath, $zip_path);
			$content = ($done && is_file($zip_path))
				? FileHelper::getContent($zip_path)
				: null;
		} catch (\Throwable $e) {
			$this->messages->add('error', Text::sprintf(
				'System:Folder [%s] could not be ::zipped:: from full path:%s.<br><br><b>Error Message</b>:<br>%s',
				$guid, $fullPath ?? 'missing', $e->getMessage()
			));
		} finally {
			if (is_file($zip_path))
			{
				File::delete($zip_path);
			}
		}

		return $content;
	}
}

