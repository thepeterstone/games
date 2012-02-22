<?php

require_once dirname(__FILE__) . '/Autoload.php';
class Grid {
	private $size = 11;

	public function __construct() {
	}

	public function addLine(Point $a, Point $b) {
		if (!$this->contains($a)) {
			throw new InvalidArgumentException("Out of bounds: $a");
		}
		if (!$this->contains($b)) {
			throw new InvalidArgumentException("Out of bounds: $b");
		}
		if (!$a->isAdjacentTo($b)) {
			throw new InvalidArgumentException("Tried to add a line between non-adjacent points ($a, $b)");
		}
		if ($this->hasLine($a, $b)) {
			throw new RuntimeException("A line already eists between $a and $b");
		}

		throw new Exception("not implemented");
	}

	public function hasLine(Point $a, Point $b) {
		return false;
	}

	private function contains(Point $p) {
		return ($p->x >= 0 && $p->x < $this->size && $p->y >= 0 && $p->y < $this->size);
	}
}