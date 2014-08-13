<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel;

use Indigo\Cart\CartInterface;
use Indigo\Cart\Store\StoreInterface;

/**
 * Cart Facade class
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Cart extends \Facade
{
	use \Indigo\Core\Facade\Instance;

	/**
	 * Auto save instances
	 *
	 * @var array
	 */
	protected static $autoSave = array();

	/**
	 * {@inheritdoc}
	 */
	protected static $_config = 'cart';

	/**
	 * Default values for carts
	 *
	 * @var array
	 */
	protected static $_defaults = array(
		'id'        => 'default',
		'class'     => 'Indigo\\Cart\\Cart',
		'store'     => 'default',
		'auto_save' => true,
	);

	/**
	 * {@inheritdoc}
	 *
	 * @codeCoverageIgnore
	 */
	public static function _init()
	{
		parent::_init();

		\Event::register('shutdown', 'static::autoSave');
	}

	/**
	 * {@inheritdoc}
	 *
	 * @param string $instance
	 *
	 * @return Indigo\Cart\CartInterface
	 */
	public static function forge($instance = 'default')
	{
		$cart = \Config::get('cart.cart.' . $instance, false);

		if ($cart !== false and $cart instanceof CartInterface === false)
		{
			$defaults = static::$_defaults;
			$defaults['id'] = $instance;

			if (is_array($cart))
			{
				extract($cart, EXTR_SKIP);
			}
			elseif (is_string($cart))
			{
				$id = $cart;
			}

			extract($defaults, EXTR_SKIP);

			$class = \Fuel::value($class);

			if ($class instanceof CartInterface === false)
			{
				$cart = new $class($id);
			}
		}

		if ($cart instanceof CartInterface === false)
		{
			throw new \InvalidArgumentException('Invalid Cart');
		}

		if ($store)
		{
			if ($auto_save)
			{
				static::$autoSave[$instance] = $store;
			}

			$store = \Cart\Store::instance($store);

			$store->load($cart);
		}


		return static::newInstance($instance, $cart);
	}

	/**
	 * Autosave callback
	 */
	public static function autoSave()
	{
		foreach (static::$autoSave as $cart => $store)
		{
			$cart = static::instance($cart);
			$store = \Cart\Store::forge($store);

			$store->save($cart);
		}
	}
}
