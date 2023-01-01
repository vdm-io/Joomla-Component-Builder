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

namespace VDM\Joomla\Componentbuilder\Service;


use Joomla\DI\Container;
use Joomla\DI\ServiceProviderInterface;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\Rijndael;
use phpseclib3\Crypt\DES;
use VDM\Joomla\Componentbuilder\Crypt as Crypto;
use VDM\Joomla\Componentbuilder\Crypt\KeyLoader;
use VDM\Joomla\Componentbuilder\Crypt\Random;
use VDM\Joomla\Componentbuilder\Crypt\Password;
use VDM\Joomla\Componentbuilder\Crypt\FOF;


/**
 * Phpseclib Crypt Service Provider
 * 
 * @since 3.2.0
 */
class Crypt implements ServiceProviderInterface
{
	/**
	 * Registers the service provider with a DI container.
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  void
	 * @since 3.2.0
	 */
	public function register(Container $container)
	{
		$container->alias(Crypto::class, 'Crypt')
			->share('Crypt', [$this, 'getCrypt'], true);

		$container->alias(Random::class, 'Crypt.Random')
			->share('Crypt.Random', [$this, 'getRandom'], true);

		$container->alias(Password::class, 'Crypt.Password')
			->share('Crypt.Password', [$this, 'getPassword'], true);

		$container->alias(FOF::class, 'Crypt.FOF')
			->share('Crypt.FOF', [$this, 'getFOF'], true);

		$container->alias(KeyLoader::class, 'Crypt.Key')
			->share('Crypt.Key', [$this, 'getKeyLoader'], true);

		$container->alias(AES::class, 'Crypt.AES')
			->share('Crypt.AES', [$this, 'getAesCBC'], true)
			->share('Crypt.AES.CBC', [$this, 'getAesCBC'], true)
			->share('Crypt.AES.CTR', [$this, 'getAesCTR'], true)
			->share('Crypt.AES.ECB', [$this, 'getAesECB'], true)
			->share('Crypt.AES.CBC3', [$this, 'getAesCBC3'], true)
			->share('Crypt.AES.CFB', [$this, 'getAesCFB'], true)
			->share('Crypt.AES.CFB8', [$this, 'getAesCFB8'], true)
			->share('Crypt.AES.OFB', [$this, 'getAesOFB'], true)
			->share('Crypt.AES.GCM', [$this, 'getAesGCM'], true);

		$container->alias(Rijndael::class, 'Crypt.Rijndael')
			->share('Crypt.Rijndael', [$this, 'getRijndaelCBC'], true)
			->share('Crypt.Rijndael.CBC', [$this, 'getRijndaelCBC'], true)
			->share('Crypt.Rijndael.CTR', [$this, 'getRijndaelCTR'], true)
			->share('Crypt.Rijndael.ECB', [$this, 'getRijndaelECB'], true)
			->share('Crypt.Rijndael.CBC3', [$this, 'getRijndaelCBC3'], true)
			->share('Crypt.Rijndael.CFB', [$this, 'getRijndaelCFB'], true)
			->share('Crypt.Rijndael.CFB8', [$this, 'getRijndaelCFB8'], true)
			->share('Crypt.Rijndael.OFB', [$this, 'getRijndaelOFB'], true)
			->share('Crypt.Rijndael.GCM', [$this, 'getRijndaelGCM'], true);

		$container->alias(DES::class, 'Crypt.DES')
			->share('Crypt.DES', [$this, 'getDesCBC'], true)
			->share('Crypt.DES.CBC', [$this, 'getDesCBC'], true)
			->share('Crypt.DES.CTR', [$this, 'getDesCTR'], true)
			->share('Crypt.DES.ECB', [$this, 'getDesECB'], true)
			->share('Crypt.DES.CBC3', [$this, 'getDesCBC3'], true)
			->share('Crypt.DES.CFB', [$this, 'getDesCFB'], true)
			->share('Crypt.DES.CFB8', [$this, 'getDesCFB8'], true)
			->share('Crypt.DES.OFB', [$this, 'getDesOFB'], true)
			->share('Crypt.DES.GCM', [$this, 'getDesGCM'], true)
			->share('Crypt.DES.STREAM', [$this, 'getDesSTREAM'], true);
	}

	/**
	 * Get the Crypto class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Crypto
	 * @since 3.2.0
	 */
	public function getCrypt(Container $container): Crypto
	{
		return new Crypto(
			$container->get('Crypt.FOF'),
			$container->get('Crypt.Password')
		);
	}

	/**
	 * Get the Password class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Password
	 * @since 3.2.0
	 */
	public function getPassword(Container $container): Password
	{
		return new Password();
	}

	/**
	 * Get the Random class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Random
	 * @since 3.2.0
	 */
	public function getRandom(Container $container): Random
	{
		return new Random();
	}

	/**
	 * Get the FOF AES Cyper with CBC mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  FOF
	 * @since 3.2.0
	 */
	public function getFOF(Container $container): FOF
	{
		return new FOF(
			$container->get('Crypt.AES.CBC'),
			$container->get('Crypt.Random')
		);
	}

	/**
	 * Get the KeyLoader class
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  KeyLoader
	 * @since 3.2.0
	 */
	public function getKeyLoader(Container $container): KeyLoader
	{
		return new KeyLoader();
	}

	/**
	 * Get the AES Cyper with CBC mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesCBC(Container $container): AES
	{
		return new AES('cbc');
	}

	/**
	 * Get the AES Cyper with CTR mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesCTR(Container $container): AES
	{
		return new AES('ctr');
	}

	/**
	 * Get the AES Cyper with ECB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesECB(Container $container): AES
	{
		return new AES('ecb');
	}

	/**
	 * Get the AES Cyper with CBC3 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesCBC3(Container $container): AES
	{
		return new AES('cbc3');
	}

	/**
	 * Get the AES Cyper with CFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesCFB(Container $container): AES
	{
		return new AES('cfb');
	}

	/**
	 * Get the AES Cyper with CFB8 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesCFB8(Container $container): AES
	{
		return new AES('cfb8');
	}

	/**
	 * Get the AES Cyper with OFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesOFB(Container $container): AES
	{
		return new AES('ofb');
	}

	/**
	 * Get the AES Cyper with GCM mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  AES
	 * @since 3.2.0
	 */
	public function getAesGCM(Container $container): AES
	{
		return new AES('gcm');
	}

	/**
	 * Get the Rijndael Cyper with CBC mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelCBC(Container $container): Rijndael
	{
		return new Rijndael('cbc');
	}

	/**
	 * Get the Rijndael Cyper with CTR mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelCTR(Container $container): Rijndael
	{
		return new Rijndael('ctr');
	}

	/**
	 * Get the Rijndael Cyper with ECB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelECB(Container $container): Rijndael
	{
		return new Rijndael('ecb');
	}

	/**
	 * Get the Rijndael Cyper with CBC3 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelCBC3(Container $container): Rijndael
	{
		return new Rijndael('cbc3');
	}

	/**
	 * Get the Rijndael Cyper with CFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelCFB(Container $container): Rijndael
	{
		return new Rijndael('cfb');
	}

	/**
	 * Get the Rijndael Cyper with CFB8 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelCFB8(Container $container): Rijndael
	{
		return new Rijndael('cfb8');
	}

	/**
	 * Get the Rijndael Cyper with OFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelOFB(Container $container): Rijndael
	{
		return new Rijndael('ofb');
	}

	/**
	 * Get the Rijndael Cyper with GCM mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  Rijndael
	 * @since 3.2.0
	 */
	public function getRijndaelGCM(Container $container): Rijndael
	{
		return new Rijndael('gcm');
	}

	/**
	 * Get the DES Cyper with CBC mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesCBC(Container $container): DES
	{
		return new DES('cbc');
	}

	/**
	 * Get the DES Cyper with CTR mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesCTR(Container $container): DES
	{
		return new DES('ctr');
	}

	/**
	 * Get the DES Cyper with ECB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesECB(Container $container): DES
	{
		return new DES('ecb');
	}

	/**
	 * Get the DES Cyper with CBC3 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesCBC3(Container $container): DES
	{
		return new DES('cbc3');
	}

	/**
	 * Get the DES Cyper with CFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesCFB(Container $container): DES
	{
		return new DES('cfb');
	}

	/**
	 * Get the DES Cyper with CFB8 mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesCFB8(Container $container): DES
	{
		return new DES('cfb8');
	}

	/**
	 * Get the DES Cyper with OFB mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesOFB(Container $container): DES
	{
		return new DES('ofb');
	}

	/**
	 * Get the DES Cyper with GCM mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesGCM(Container $container): DES
	{
		return new DES('gcm');
	}

	/**
	 * Get the DES Cyper with STREAM mode
	 *
	 * @param   Container  $container  The DI container.
	 *
	 * @return  DES
	 * @since 3.2.0
	 */
	public function getDesSTREAM(Container $container): DES
	{
		return new DES('stream');
	}

}

