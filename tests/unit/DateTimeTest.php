<?php

use WebChemistry\Utils\DateTime as Date;

class DateTimeTest extends \Codeception\TestCase\Test {

	/**
	 * @var \UnitTester
	 */
	protected $tester;

	protected function _before() {
	}

	protected function _after() {
	}

	// tests
	public function testTranslateMonth() {
		$this->assertSame('march', Date::translateMonth(strtotime('march')));
		$this->assertSame('march', Date::translateMonth(new \DateTime('march')));
		$this->assertSame('march', Date::translateMonth(3));
		$this->assertSame('foo', Date::translateMonth('foo'));
	}

	public function testTranslateDay() {
		$this->assertSame('sunday', Date::translateDay(strtotime('sunday')));
		$this->assertSame('sunday', Date::translateDay(new \DateTime('sunday')));
		$this->assertSame('sunday', Date::translateDay(0));
		$this->assertSame('foo', Date::translateDay('foo'));
	}

	public function testBaseFormat() {
		$this->assertSame(date('Y-m-d H:i:s'), (new Date())->baseFormat());
	}

	public function testToString() {
		$this->assertSame(date(Date::$datetime), (string) new Date());
	}

	public function testToDateTime() {
		$this->assertSame(date(Date::$datetime), Date::toDateTime(new Date()));
	}

	public function testToDate() {
		$this->assertSame(date(Date::$date), Date::toDate(new Date()));
	}

	public function testToTime() {
		$this->assertSame(date(Date::$time), Date::toTime(new Date()));
	}

	public function testStart() {
		$v = array(
			date('Y'), date('m'), date('d'), date('H'), date('i'), date('s')
		);
		$this->assertSame("$v[0]-01-01 00:00:00", Date::start('year')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-01 00:00:00", Date::start('month')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] 00:00:00", Date::start('day')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:00:00", Date::start('hours')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:$v[4]:00", Date::start('minutes')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:$v[4]:$v[5]", Date::start('seconds')->baseFormat());

		$this->assertSame("$v[0]-$v[1]-19 00:00:00", Date::start('day', 19)->baseFormat());
	}

	public function testEnd() {
		$v = array(
			date('Y'), date('m'), date('d'), date('H'), date('i'), date('s')
		);
		
		$this->assertSame("$v[0]-12-31 23:59:59", Date::end('year')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-31 23:59:59", Date::end('month')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] 23:59:59", Date::end('day')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:59:59", Date::end('hours')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:$v[4]:59", Date::end('minutes')->baseFormat());
		$this->assertSame("$v[0]-$v[1]-$v[2] $v[3]:$v[4]:$v[5]", Date::end('seconds')->baseFormat());

		$this->assertSame("$v[0]-$v[1]-19 23:59:59", Date::end('day', 19)->baseFormat());
	}

}