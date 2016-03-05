<?php

class ObjectArrayTest extends \Codeception\TestCase\Test {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {
	}

	protected function _after() {
	}

	public function testObjectArray() {
		$objectArray = new \WebChemistry\Utils\ObjectArray();
		$objectArray['asd'] = 'asd';

		$this->assertTrue(isset($objectArray['asd']));
		$this->assertFalse(isset($objectArray['false']));
		$this->assertSame('asd', $objectArray['asd']);

		unset($objectArray['asd']);
		$this->assertFalse(isset($objectArray['asd']));
	}
}