<?php

class SudokuGrid {
	private $grid = array();
	private $base = 3;
	private $size = 9;
	private $chars = array();

	public function __construct($gridSize = 9) {
		$this->base = floor(sqrt($gridSize));
		if (pow($this->base, 2) != $gridSize) {
			throw new InvalidArgumentException("gridSize must be a perfect square ($gridSize / {$this->base})");
		}
		$this->size = $gridSize;
		$this->chars = range(1, $this->size);

		for ($i = 0; $i < $this->size; $i++) {
			$this->grid[$i] = array();
			for ($j = 0; $j < $this->size; $j++) {
				$this->grid[$i][$j] = join('', $this->chars);
			}
		}
		return $this;
	}

	public function populate($c = 0) {
		//for ($c = 0; $c < $this->size * $this->size; $c++) {
			$i = floor($c / $this->size);
			$j = $c % $this->size;
			$stock = $this->generate($i, $j);
			if(empty($stock)) return false;
			$this->grid[$i][$j] = array_pop($stock);
			while(!$this->populate($c + 1)) {
				if(empty($stock)) return false;
				$this->grid[$i][$j] = array_pop($stock);
			}
//		}
		if ($c > pow($this->size, 2)) {
			$this->printGrid();
			return $this->grid;
		}
						
	}

	private function generate($i, $j) {
		$forbidden = array_unique(array_merge($this->row($i), $this->col($j), $this->region($i, $j)));
		$stock = @array_diff($this->chars, $forbidden);
		@shuffle($stock);
		return $stock;
	}

	public function row($index) {
		return (array)$this->grid[$index];
	}

	public function col($index) {
		$ret = array();
		for ($i = 0; $i < $this->size; $i++) {
			$ret[] = $this->grid[$i][$index];
		}
		return $ret;
	}

	public function region($i, $j) {
		list($v, $h) = $this->getBoundingBox($i, $j);
		$ret = array();
		for ($a = 0; $a < $this->base; $a++) {
			for ($b = 0; $b < $this->base; $b++) {
				$ret[] = $this->grid[$v + $a][$h + $b];
			}
		}
		return $ret;
	}

	public function getBoundingBox($i, $j) {
		$i_box = $i - ($i % $this->base);
		$j_box = $j - ($j % $this->base);
		return array($i_box, $j_box);
	}

	public function printGrid()
	{
		$string = "";
		foreach ($this->grid as $i => $line) {
			if (($i % $this->base) == 0) {
				$string .= str_repeat("-", 2 * ($this->base + 1) * $this->base + 1) . "\n";
			}
			foreach ($line as $j => $digit) {
				if ($j % $this->base == 0) {
					$string .= "| ";
				}
				$string .= $digit . " ";
			}
			$string .= "|\n";

		}
		print $string . str_repeat("-", 2 * ($this->base + 1) * $this->base + 1) . "\n";
		// don't warn if the buffer is empty
		@ob_flush();
		return $this;
	}

	public function serialize() {
		$string = '';
		foreach ($this->grid as $line) {
			foreach($line as $digit) {
				$string .= $digit;
			}
		}
		return $string;
	}
}