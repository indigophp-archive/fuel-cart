<?php

/*
 * This file is part of the Indigo Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Cart\Store;

/**
 * Tests for Fuel Session Store
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 *
 * @coversDefaultClass Indigo\Cart\Store\FuelSessionStore
 */
class FuelSessionStoreTest extends AbstractStoreTest
{
	public function _before()
	{
		$this->store = new FuelSessionStore;

		parent::_before();
	}
}
