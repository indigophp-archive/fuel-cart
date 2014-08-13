<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Store;

use Indigo\Cart\CartInterface;

/**
 * Fuel Session Store
 *
 * Save cart using Fuel Session
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class FuelSessionStore extends SessionStore
{
	/**
	 * {@inheritdoc}
	 */
	public function load(CartInterface $cart)
	{
		$items = \Session::get($this->sessionKey . '.' . $cart->getId(), array());

		$cart->setContents($items);

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(CartInterface $cart)
	{
		$data = $cart->getContents();
		\Session::set($this->sessionKey . '.' . $cart->getId(), $data);

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(CartInterface $cart)
	{
		\Session::delete($this->sessionKey . '.' . $cart->getId());

		return true;
	}
}
