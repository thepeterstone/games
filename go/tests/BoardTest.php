<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', TRUE);

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/Board.php';

class BoardTest extends PHPUnit_Framework_TestCase {
	private $board;

	public function setUp() {
		$this->board = new Board();
	}
	public function testEmptyBoard() {
		$this->assertEquals(str_repeat("+", 81), $this->board->serialize());
	}

	public function testAddWhiteByCoordinates() {
		$this->board->white(3,3);
		$n = Board::BLANK;
		$w = Board::WHITE;
		$this->assertRegexp("/\\$n{20}$w\\$n{60}/", $this->board->serialize());
	}

	public function testAddBlackByOrdinal() {
		$this->board->black(32);
		$n = Board::BLANK;
		$b = Board::BLACK;
		$this->assertRegexp("/\\$n{31}$b\\$n{49}/", $this->board->serialize());
	}
}