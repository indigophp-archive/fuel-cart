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
use Indigo\Cart\Item;
use Indigo\Webshop\Model\CartModel;
use Indigo\Webshop\Model\CartItemModel;

/**
 * ORM Store
 *
 * Save cart content to database
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class OrmStore
{
	/**
	 * {@inheritdoc}
	 */
	public function load(CartInterface $cart)
	{
		$model = CartModel::query()
			->related('items')
			->where('identifier', $cart->getId())
			->get_one();

		if ($model)
		{
			foreach ($model->items as $item)
			{
				$cart->add($item->forgeItem());
			}
		}

		return true;
	}

	/**
	 * {@inheritdoc}
	 */
	public function save(CartInterface $cart)
	{
		$model = CartModel::query()
			->related('items')
			->where('identifier', $cart->getId())
			->get_one();

		$items = $cart->getContents();

		if ($model)
		{
			foreach ($model->items as $item)
			{
				$identifier = $item->forgeItem()->getId();

				if (array_key_exists($identifier, $items))
				{
					$item->quantity = $items[$identifier]->quantity;
					unset($items[$identifier]);
				}
				else
				{
					unset($model->items[$item->id]);
					$item->delete();
				}
			}
		}
		else
		{
			$model = CartModel::forgeFromCart($cart);
		}

		foreach ($items as $id => $item)
		{
			$model->items[] = CartItemModel::forgeFromItem($item);
		}

		return $model->save(true);
	}

	/**
	 * {@inheritdoc}
	 */
	public function delete(CartInterface $cart)
	{
		$model = CartModel::query()
			->where('identifier', $cart->getId())
			->get_one();

		if ($model)
		{
			return (bool) $model->delete();
		}

		return false;
	}
}
