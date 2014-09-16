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

use Indigo\Cart\Store as StoreInterface;

/**
 * Store Facade class
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class Store extends \Facade
{
	use \Indigo\Core\Facade\Instance;

	/**
	 * {@inheritdoc}
	 */
	protected static $_config = 'cart';

	/**
	 * {@inheritdoc}
	 *
	 * @param string $instance
	 *
	 * @return Indigo\Cart\Store\StoreInterface
	 */
	public static function forge($instance = 'default')
	{
		$store = \Config::get('cart.store.' . $instance);

		if ($store instanceof StoreInterface === false)
		{
			throw new \InvalidArgumentException('Invalid Store');
		}

		return static::newInstance($instance, $store);
	}
}
