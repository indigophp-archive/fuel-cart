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

use Codeception\TestCase\Test;

/**
 * Tests for Cart
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Fuel\Cart
 * @group              Cart
 */
class CartTest extends Test
{
	/**
	 * @covers ::forge
	 */
	public function testForge()
	{
		\Config::set('cart.cart.test', array());

		$class = Cart::forge('test');

		$this->assertInstanceOf('Indigo\\Cart\\Cart', $class);

		\Config::set('cart.cart.test2', 'test2');

		$class = Cart::forge('test2');

		$this->assertInstanceOf('Indigo\\Cart\\Cart', $class);
	}

	/**
	 * @covers ::autoSave
	 */
	public function testAutoSave()
	{
		\Config::set('cart.cart.save', array());

		Cart::forge('save');

		Cart::autoSave();
	}

	/**
	 * @covers            ::forge
	 * @expectedException InvalidArgumentException
	 */
	public function testForgeFailure()
	{
		Cart::forge('THIS_SHOULD_NEVER_EXIST');
	}
}
