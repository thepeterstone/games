<?php

class Point {
	public function __construct() {
		return $this;
	}

	public function isAdjacentTo(Point $b) {
		return false;
	}
}