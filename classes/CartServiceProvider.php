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
 * Provides cart services
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CartServiceProvider extends ServiceProvider
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
		$this->registerSingleton('cart', function($dic, $id = '__default__', $store = 'store', $autoSave = true)
		{
			$store = \Config::get('cart.'.$id.'.store', $store);
			$autoSave = \Config::get('cart.'.$id.'.auto_save', $autoSave);

			$cart = $dic->resolve('Indigo\\Cart\\SimpleCart', [$id]);

			$store = $dic->resolve($store);

			$store->load($cart);

			if ($autoSave)
			{
				\Event::register('shutdown', function() use($cart, $store) {
					$store->save($cart);
				});
			}

			return $cart;
		});

		$this->registerSingleton('store', 'Indigo\\Fuel\\Cart\\SessionStore');

		$this->registerSingleton('store.session', 'Indigo\\Cart\\SessionStore');
	}
}
