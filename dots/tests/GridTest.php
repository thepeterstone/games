<?php

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/Autoload.php';

class GridTest extends PHPUnit_Framework_TestCase {
	public function setUp() {
		$this->grid = new Grid();
	}

	public function testGridIsInitiallyEmpty() {
		$this->markTestSkipped();
	}
}