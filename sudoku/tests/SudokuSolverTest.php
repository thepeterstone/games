<?php

error_reporting(E_ALL|E_STRICT);
ini_set('display.errors', TRUE);

require_once 'PHPUnit/Autoload.php';
require_once dirname(dirname(__FILE__)) . '/SudokuSolver.php';

class SudokuSolverTest extends PHPUnit_Framework_TestCase {
	private $grid;

	public function setUp() {
		$this->grid = new SudokuGrid();
	}

	public function testSolvedGrid($value='') {
		$this->grid->populate();
		$e = new SudokuSolver($this->grid->serialize());
		$this->assertTrue($e->solve());
	}

}