<?php

class Board {
	private $values = array();

	public function __construct() {
		for ($i = 0; $i < 81; $i++) {
			$this->values[$i] = chr(197);
		}
		return $this;
	}

	public function __toString() {
		$square = sqrt(count($this->values));
		foreach ($this->values as $i => $val) {
			if (($i) % $square === 0) {
				print "\n" . str_repeat("  |   ", $square) . "\n";
			}
			print "- " . $val . " - ";
		}
		print "\n" . str_repeat("  ".chr(179)."   ", $square) . "\n";
		print "\n";
	}


}