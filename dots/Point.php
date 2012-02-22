<?php

class Point {
	public $x, $y;

	public function __construct($x = null, $y = null) {
		if (!is_int($x)) {
			throw new InvalidArgumentException("$x is not an integer");
		}
		if (!is_int($y)) {
			throw new InvalidArgumentException("$y is not an integer");
		}
		$this->x = $x;
		$this->y = $y;
		return $this;
	}

	public function isAdjacentTo(Point $p) {
		$distance = abs($this->x - $p->x) + abs($this->y - $p->y);
		return $distance === 1;
	}
}