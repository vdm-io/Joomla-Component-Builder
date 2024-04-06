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

namespace VDM\Joomla\Componentbuilder\Compiler\Creator;


use VDM\Joomla\Componentbuilder\Compiler\Config;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFields;
use VDM\Joomla\Componentbuilder\Compiler\Builder\SiteFieldData as SiteField;


/**
 * Site Field Data Creator Class
 * 
 * @since 3.2.0
 */
final class SiteFieldData
{
	/**
	 * The Config Class.
	 *
	 * @var   Config
	 * @since 3.2.0
	 */
	protected Config $config;

	/**
	 * The SiteFields Class.
	 *
	 * @var   SiteFields
	 * @since 3.2.0
	 */
	protected SiteFields $sitefields;

	/**
	 * The SiteFieldData Class.
	 *
	 * @var   SiteField
	 * @since 3.2.0
	 */
	protected SiteField $sitefield;

	/**
	 * The decoding options
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected  array $decode = [
		'json',
		'base64',
		'basic_encryption',
		'whmcs_encryption',
		'medium_encryption',
		'expert_mode'
	];

	/**
	 * The text areas
	 *
	 * @var   array
	 * @since 3.2.0
	 */
	protected  array $textareas = [
		'textarea',
		'editor'
	];

	/**
	 * Constructor.
	 *
	 * @param Config       $config       The Config Class.
	 * @param SiteFields   $sitefields   The SiteFields Class.
	 * @param SiteField    $sitefield    The SiteFieldData Class.
	 *
	 * @since 3.2.0
	 */
	public function __construct(Config $config, SiteFields $sitefields,
		SiteField $sitefield)
	{
		$this->config = $config;
		$this->sitefields = $sitefields;
		$this->sitefield = $sitefield;
	}

	/**
	 * set the site field data needed
	 *
	 * @param   string  $view   The single edit view code name
	 * @param   string  $field  The field name
	 * @param   string  $set    The decoding set this field belongs to
	 * @param   string  $type   The field type
	 *
	 * @return  void
	 *
	 */
	public function set(string $view, string $field, string $set, string $type): void
	{
		if (($site_fields = $this->sitefields->get($view . '.' . $field)) !== null)
		{
			foreach ($site_fields as $codeString => $site_field)
			{
				// get the code array
				$codeArray = explode('___', (string) $codeString);
				// set the code
				$code = trim($codeArray[0]);
				// set the path
				$path = $site_field['site'] . '.' . $code . '.' . $site_field['as'] . '.' . $site_field['key'];

				// set the decoding methods
				if (in_array($set, $this->decode))
				{
					if ($this->sitefield->exists('decode.' . $path . '.decode'))
					{
						if (!$this->sitefield->inArray($set, 'decode.' . $path . '.decode'))
						{
							$this->sitefield->add('decode.' . $path . '.decode', $set, true);
						}
					}
					else
					{
						$this->sitefield->set('decode.' . $path, [
							'decode' => [$set],
							'type' => $type,
							'admin_view' => $view
						]);
					}
				}

				// set the uikit checker
				if ((2 == $this->config->uikit || 1 == $this->config->uikit)
					&& in_array($type, $this->textareas))
				{
					$this->sitefield->add('uikit.' . $path, (array) $site_field, true);
				}

				// set the text area checker
				if (in_array($type, $this->textareas))
				{
					$this->sitefield->add('textareas.' . $path, (array) $site_field, true);
				}
			}
		}
	}
}

