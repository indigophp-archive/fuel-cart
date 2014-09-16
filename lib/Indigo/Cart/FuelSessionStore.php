<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart;

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
	public function load(Cart $cart)
	{
		$items = \Session::get($this->sessionKey . '.' . $cart->getId(), array());

		$cart->setItems($items);

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(Cart $cart)
	{
		$data = $cart->getItems();

		\Session::set($this->sessionKey . '.' . $cart->getId(), $data);

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(Cart $cart)
	{
		\Session::delete($this->sessionKey . '.' . $cart->getId());

		return true;
	}
}
