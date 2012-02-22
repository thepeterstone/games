<?php

require_once dirname(__FILE__) . '/Autoload.php';
class Grid {
	private $size = 11;

	public function __construct() {
	}

	public function addLine(Point $a, Point $b) {
		if ($a->isAdjacentTo($b)) {
			$this->lines[] = array($a, $b);
		}
	}
}