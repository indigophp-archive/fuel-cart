<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel\Cart;

use Fuel\Dependency\ServiceProvider;

/**
 * Provides services required by webshop
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelServiceProvider extends ServiceProvider
{
	/**
	 * {@inheritdoc}
	 */
	public $provides = [
		'cart',
		'store',
		'store.plain_session',
	];

	/**
	 * Default configuration
	 *
	 * @var []
	 */
	protected $defaultConfig = [
		'id'        => 'default',
		'store'     => 'store',
		'auto_save' => true,
	];

	/**
	 * Load cart configs
	 */
	public function __construct()
	{
		\Config::load('cart', true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function provide()
	{
		$this->registerSingleton('cart', function($dic, array $config = [])
		{
			$config = $this->defaultConfig + $config;

			$config = $config + \Config::get('cart.' . $config['id'], array());

			$cart = $dic->resolve('Indigo\\Cart\\SimpleCart', [$config['id']]);

			$store = $dic->resolve($config['store']);

			$store->load($cart);

			if ($config['auto_save'])
			{
				\Event::register('shutdown', function() use($cart, $store) {
					$store->save($cart);
				});
			}

			return $cart;
		});

		$this->registerSingleton('store', function($dic, array $config = [])
		{
			return $dic->resolve('Indigo\\Fuel\\Cart\\SessionStore', $config);
		});

		$this->registerSingleton('store.session', function($dic, array $config = [])
		{
			return $dic->resolve('Indigo\\Cart\\SessionStore', $config);
		});
	}
}
