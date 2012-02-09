<?php

require 'SudokuGrid.php';
class SudokuSolver {
  private $grid;

  public function __construct($initial) {
    $this->grid = new SudokuGrid();
    $this->grid->deserialize($initial);
  }

  public function solve()
  {
    static $c = 0;
    if ($c++ > 50) {
      return FALSE;
    }
    $stock = array();
    for ($i=0; $i < $this->grid->count(); $i++) {
      if ((int) $this->grid->get($i) == 0) {
        $stock[$i] = $this->grid->possible($i);
      }
    }
    $left = 0;
    foreach ($stock as $index => $values) {
      if (count($values) == 1) {
        $this->grid->set($index, array_pop($values));
      } else {
        $left++;
      }
    }
    if ($left > 0) {
      return $this->solve();
    }
    return TRUE;

  }

  public function printGrid() {
    $this->grid->printGrid();
  }
}