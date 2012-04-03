<?php
error_reporting(E_ALL|E_STRICT);
ini_set('display.errors', TRUE);

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/SudokuGrid.php';

class SudokuGridTest extends PHPUnit_Framework_TestCase {
	
	public function testBoundingBox() {
		$sudoku = new SudokuGrid(9);
		$this->assertEquals(array(0,0), $sudoku->getBoundingBox(0,0));
		$this->assertEquals(array(6,6), $sudoku->getBoundingBox(8,6));
		$this->assertEquals(array(3,6), $sudoku->getBoundingBox(4,8));
		$this->assertEquals(array(3,0), $sudoku->getBoundingBox(5,2));
		$sudoku = new SudokuGrid(4);
		$this->assertEquals(array(0,0), $sudoku->getBoundingBox((float) 0, 0));
		$this->assertEquals(array(0,2), $sudoku->getBoundingBox(0,3));
		$this->assertEquals(array(2,2), $sudoku->getBoundingBox(3,3));
		$this->assertEquals(array(0,2), $sudoku->getBoundingBox(1,3));
	}

	/**
	* @expectedException InvalidArgumentException
	*/
	public function testBoundingBoxRejectsBadValues() {
		$sudoku = new SudokuGrid(9);
		$sudoku->getBoundingBox(9,0);
	}

	public function testBoundingBoxIsInBounds() {
		$base = 3;
		$size = pow($base, 2);
		$sudoku = new SudokuGrid($size);
		list($v, $h) = $sudoku->getBoundingBox($base, $size - 1);
		$ret = array();
		for ($a = 0; $a < $base; $a++) {
			for ($b = 0; $b < $base; $b++) {
				$this->assertTrue($v + $a < $size);
				$this->assertTrue($h + $b < $size);
			}
		}

	}

	public function testSerializeLengthIsPerfectSquare() {
		$size = 9;
		$sudoku = new SudokuGrid($size);
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), $sudoku->serialize());//"New grid should be correct length");
		$sudoku->populate();
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), "populate() shouldn't change length");
		$sudoku->elide();
		$this->assertEquals(pow($size, 2), strlen($sudoku->serialize()), "elide() shouldn't change length");

	}

	public function testDeserializeSetsSizeAndBase() {
		$sudoku = new SudokuGrid();
		$sudoku->deserialize('1');
		$this->assertEquals(1, $sudoku->count());
		$this->assertEquals(1, $sudoku->base());
		$this->assertEquals(1, $sudoku->size());
	}

}
