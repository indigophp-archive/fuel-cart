<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel\Model\Cart;

use Indigo\Cart\ItemInterface;
use Indigo\Cart\Item;
use Orm\Model;

/**
 * Cart Item Model
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class ItemModel extends Model
{
	/**
	 * {@inheritdoc}
	 */
	protected static $_belongs_to = array(
		'cart' => array(
			'key_from' => 'cart_id',
			'model_to' => 'Indigo\\Webshop\\Model\\CartModel',
		)
	);

	/**
	 * {@inheritdoc}
	 */
	protected static $_properties = array(
		'id',
		'cart_id',
		'identifier',
		'item_id',
		'name',
		'price',
		'quantity',
		'option',
	);

	/**
	 * {@inheritdoc}
	 */
	protected static $_table_name = 'cart_items';

	/**
	 * Creates a new model from an item
	 *
	 * @param ItemInterface $item
	 *
	 * @return this
	 */
	public static function forgeFromItem(ItemInterface $item)
	{
		$data = array(
			'identifier' => $item->getId(),
			'item_id'    => $item->id,
			'name'       => $item->name,
			'price'      => $item->price,
			'quantity'   => $item->quantity,
		);

		if (isset($item['option']))
		{
			$data['option'] = serialize($item['option']);
		}

		return static::forge($data);
	}

	/**
	 * Creates a new item from a model
	 *
	 * @param string $class
	 *
	 * @return ItemInterface
	 */
	public function forgeItem($class = 'Indigo\\Cart\\Item')
	{
		$item = array(
			'id'       => (int) $this->item_id,
			'name'     => $this->name,
			'price'    => (float) $this->price,
			'quantity' => (int) $this->quantity,
		);

		if (empty($this->option) === false)
		{
			$item['option'] = unserialize($this->option);
		}

		$item = new $class($item);

		if (!$item instanceof ItemInterface) {
			throw new \InvalidArgumentException($class . ' does not implement Indigo\\Cart\\ItemInterface.');
		}

		return $item;
	}
}
