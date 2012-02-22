<?php

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/Autoload.php';

class PointTest extends PHPUnit_Framework_TestCase {

	public function testAdjacent() {
		$a = new Point(0, 0);
		$b = new Point(0, 1);
		$c = new Point(1, 1);
		$this->assertTrue($a->isAdjacentTo($b));
		$this->assertTrue($b->isAdjacentTo($a));

		$this->assertTrue($b->isAdjacentTo($c));
		$this->assertTrue($c->isAdjacentTo($b));

		$this->assertFalse($a->isAdjacentTo($c));
		$this->assertFalse($c->isAdjacentTo($a));
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testConstructInvalid() {
		$p = new Point();
		$this->fail("Constructor shouldn't be called with no arguments");
	}
}