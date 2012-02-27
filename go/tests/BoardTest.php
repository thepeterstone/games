<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display_errors', TRUE);

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/Board.php';

class BoardTest extends PHPUnit_Framework_TestCase {
	private $board;
	private $white, $black, $blank;

	public function setUp() {
		$this->board = new Board();
		$this->white = preg_quote(Board::WHITE);
		$this->black = preg_quote(Board::BLACK);
		$this->blank = preg_quote(Board::BLANK);
	}
	public function testEmptyBoard() {
		$this->assertEquals(str_repeat(Board::BLANK, 81), $this->board->serialize());
	}

	public function testAddWhiteByCoordinates() {
		$this->board->white(3,3);
		$this->assertRegexp("/{$this->blank}{20}{$this->white}{$this->blank}{60}/", $this->board->serialize());
	}

	public function testAddBlackByOrdinal() {
		$this->board->black(32);
		$this->assertRegexp("/{$this->blank}{31}{$this->black}{$this->blank}{49}/", $this->board->serialize());
	}

	/**
	 * @expectedException IllegalPlacementException
	 */ 
	public function testOverlapFails() {
		$this->board->white(3, 3);
		$this->board->black(3, 3);
	}
}