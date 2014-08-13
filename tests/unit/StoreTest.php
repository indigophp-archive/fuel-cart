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

use Codeception\TestCase\Test;

/**
 * Tests for Store
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Fuel\Cart\Store
 * @group              Cart
 */
class StoreTest extends Test
{
	/**
	 * @covers ::forge
	 */
	public function testForge()
	{
		$class = Store::forge();

		$this->assertInstanceOf('Indigo\\Cart\\Store\\StoreInterface', $class);
	}

	/**
	 * @covers            ::forge
	 * @expectedException InvalidArgumentException
	 */
	public function testForgeFailure()
	{
		Store::forge('THIS_SHOULD_NEVER_EXIST');
	}
}
