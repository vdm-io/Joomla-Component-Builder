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

namespace VDM\Joomla\Componentbuilder\Console;


use VDM\Joomla\Componentbuilder\Abstraction\Console\Import;


/**
 * Componentbuilder Item Import
 * 
 * @since  5.0.2
 */
final class ItemImport extends Import
{
	/**
	 * The main import target name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetName = 'item';

	/**
	 * The default command name.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected static $defaultName = 'componentbuilder:item:import';

	/**
	 * The target import class.
	 *
	 * @var string
	 * @since  5.0.2
	 */
	protected string $targetImportClass = 'Import.Persistent';

	/**
	 * The target items class.
	 *
	 * @var string
	 * @since  5.1.4
	 */
	protected string $targetItemsClass = 'Data.Items';

	/**
	 * The target entity class.
	 *
	 * @var string
	 * @since  5.1.4
	 */
	protected string $targetEntityClass = 'Import.Persistent.Entity';

	/**
	 * Configure the command.
	 *
	 * @return  void
	 *
	 * @since   2.0.0
	 */
	protected function configure(): void
	{
		parent::configure();

		// CHANGE THIS TO TARGET YOUR VIEW BEING IMPORTED!
		// CHECK THE ENTITY CLASS FOR MORE OPTIONS
		$this->entity->setParentTable('look')
			->setParentKey('guid')->setParentJoinKey('entity')
			->setLinkField('guid')->setJoinFields([
				'detail' => ['link_fields' => ['entity']]
			]);
	}
}

