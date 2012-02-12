<?php

require 'SudokuGrid.php';
class SudokuSolver {
	private $grid;

	public function __construct($initial) {
		$this->grid = new SudokuGrid();
		$this->grid->deserialize($initial);
	}

	public function solve() {
		static $c = 0;
		if ($c++ > 5) {
			return FALSE;
		}

		$left = $this->fillCellsWithOnePossible();	
		if ($left === 0) {
			return TRUE;
		}
		
		return $this->solve();

	}

	public function printGrid() {
		$this->grid->printGrid();
	}

	private function fillCellsWithOnePossible() {
		$left = 0;
		$stock = array();

		for ($i = 0; $i < $this->grid->count(); $i++) { 
			if ((int) $this->grid->get($i) === 0) {
				$stock[$i] = $this->grid->possible($i);
			} 
		}
		foreach ($stock as $index => $values) {
			if (count($values) == 1) {
				$this->grid->set($index, array_pop($values));
			} else {
				$left++;
			}
		}
		return $left;
	}
}