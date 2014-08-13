<?php
// Here you can initialize variables that will be available to your tests

$package = \Codeception\Configuration::projectDir();

\Package::load('cart', $package);

\Config::load('cart', true);

$mock = \Mockery::mock('Indigo\\Cart\\Store\\StoreInterface');

$mock->shouldReceive('load')
	->andReturn(true)
	->byDefault();

$mock->shouldReceive('save')
	->andReturn(true)
	->byDefault();

\Config::set('cart.store.default', $mock);
