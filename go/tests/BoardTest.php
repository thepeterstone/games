<?php

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/Board.php';

class BoardTest extends PHPUnit_Framework_TestCase {
	public function testEmptyBoard() {
		$board = new Board();
		$this->markTestIncomplete();
	}
}