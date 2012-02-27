<?php

class Board {
	const WHITE = "•";
	const BLACK = "O";
	const BLANK = "+";

	private $values = array();

	public function __construct() {
		for ($i = 0; $i < 81; $i++) {
			$this->values[$i] = self::BLANK; 
		}
		return $this;
	}

	public function __toString() {
		return $this->serialize();
	}

	public function serialize() {
		return join("", $this->values);
	}

	public function printBoard() {
		$square = (int) sqrt(count($this->values));
		// we need a perfect square
		assert($square * $square === count($this->values));
		foreach ($this->values as $i => $val) {
			if ($i % $square === 0) {
				print "\n" . str_repeat("  |   ", $square) . "\n";
			}
			print "- " . $val . " - ";
		}
		print "\n" . str_repeat("  |   ", $square) . "\n";
		print "\n";
	}

	public function white($a, $b = null) {
		return $this->_move(self::WHITE, $a, $b);
	}

	public function black($a, $b = null) {
		return $this->_move(self::BLACK, $a, $b);
	}

	private function _move($color, $a, $b) {
		return is_null($b) ? $this->_byOrdinal($color, $a) : $this->_byCoordinates($color, $a, $b);
	}

	private function _byOrdinal($color, $position) {
		$this->values[$position - 1] = $color;
		return true;
	}

	private function _byCoordinates($color, $x, $y) {
		$square = (int) sqrt(count($this->values));
		$position = (($x - 1) * $square) + $y;
		return $this->_byOrdinal($color, $position);
	}


}


require_once '../Exceptions.php';
class IllegalPlacementException extends GameRulesException {}