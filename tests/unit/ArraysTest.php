<?php

use WebChemistry\Utils\Arrays as Arrays;

class ArraysTest extends \Codeception\TestCase\Test {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {
	}

	protected function _after() {
	}

	public function testCount() {
		$array = array('asd');
		$iterator = \Nette\Utils\ArrayHash::from($array);

		$this->assertSame(1, Arrays::count($array));
		$this->assertSame(1, Arrays::count($iterator));
	}

	public function testToArray() {
		$array = array('asd');

		$iterator = \Nette\Utils\ArrayHash::from($array);

		$this->assertSame($array, Arrays::toArray($array));
		$this->assertSame($array, Arrays::toArray($iterator));
	}

}
