<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display.errors', TRUE);

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/SudokuGrid.php';

class SudokuGridTest extends PHPUnit_Framework_TestCase {
	
	/**
	* @expectedException InvalidArgumentException
	*/
	public function testNonSquareSizeThrowsException() {
		$sudoku = new SudokuGrid(3);
		$this->fail("Non-square argument accepted");
	}

	public function testPopulateSmallGrid() {
		$size = 4;
		$sudoku = new SudokuGrid($size);
		$grid = $sudoku->populate();
		foreach($grid as $line_no => $line) {
			$hist = array_count_values($line);
			foreach ($hist as $entry => $count) {
				$this->assertEquals(1, $count, "Line $line_no contains $count ${entry}s");
			}
			$this->assertEquals($size, count($line));
		}
	}

	public function testBoundingBox() {
		$sudoku = new SudokuGrid(9);
		$this->assertEquals(array(0,0), $sudoku->getBoundingBox(0,0));
		$this->assertEquals(array(6,6), $sudoku->getBoundingBox(8,6));
		$this->assertEquals(array(3,6), $sudoku->getBoundingBox(4,8));
		$this->assertEquals(array(3,0), $sudoku->getBoundingBox(5,2));
	}

	public function testSerializeLengthIsPerfectSquare() {
		$size = 9;
		$sudoku = new SudokuGrid($size);
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), "New grid should be correct length");
		$sudoku->populate();
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), "populate() shouldn't change length");
		$sudoku->elide();
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), "elide() shouldn't change length");

	}

}