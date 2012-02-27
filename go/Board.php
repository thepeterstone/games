<?php

class Board {
	const WHITE = "•";
	const BLACK = "O";
	const BLANK = "+";

	private $values = array();

	public $score = array('white' => 0, 'black' => 0);

	public function __construct() {
		for ($i = 0; $i < 81; $i++) {
			$this->values[$i] = self::BLANK; 
		}
		return $this;
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
		$success = is_null($b) ? $this->_byOrdinal($color, $a) : $this->_byCoordinates($color, $a, $b);
		$this->_updateScore();
	}

	private function _byOrdinal($color, $position) {
		$zeroOffset = $position - 1;
		if ($this->values[$zeroOffset] !== self::BLANK) {
			throw new IllegalPlacementException("That square is not empty");
		}
		$this->values[$zeroOffset] = $color;
		return true;
	}

	private function _byCoordinates($color, $x, $y) {
		$square = (int) sqrt(count($this->values));
		$position = (($x - 1) * $square) + $y;
		return $this->_byOrdinal($color, $position);
	}

	private function _updateScore() {
		$white = substr_count($this->serialize(), self::WHITE);
		$black = substr_count($this->serialize(), self::BLACK);
		$this->score = compact('white', 'black');
	}	


}


require_once '../Exceptions.php';
class IllegalPlacementException extends GameRulesException {}