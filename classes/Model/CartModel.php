<?php

/*
 * This file is part of the Fuel Cart package.
 *
 * (c) Indigo Development Team
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Indigo\Fuel\Model;

use Indigo\Cart\CartInterface;
use Orm\Model;

/**
 * Cart Model
 *
 * @author Márk Sági-Kazár <mark.sagikazar@gmail.com>
 */
class CartModel extends Model
{
	/**
	 * {@inheritdoc}
	 */
	protected static $_has_many = array(
		'items' => array(
			'model_to' => 'Model\\Cart\\ItemModel',
			'key_to'   => 'cart_id',
			'cascade_delete' => true,
		),
	);

	/**
	 * {@inheritdoc}
	 */
	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events'          => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events'          => array('before_save'),
			'mysql_timestamp' => false,
			'relations'       => array('items'),
		),
	);

	/**
	 * {@inheritdoc}
	 */
	protected static $_properties = array(
		'id',
		'user_id',
		'identifier',
		'created_at',
		'updated_at',
	);

	/**
	 * {@inheritdoc}
	 */
	protected static $_table_name = 'carts';

	/**
	 * Creates a new model from a cart
	 *
	 * @param CartInterface $cart
	 *
	 * @return this
	 */
	public static function forgeFromCart(CartInterface $cart)
	{
		return static::forge(array(
			'identifier' => $cart->getId()
		));
	}
}
