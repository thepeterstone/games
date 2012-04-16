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
        $this->grid[$i][$j] = NULL;
      }
    }
    return $this;
  }

  public function populate() {
    $c = 0;
    $stock = array(FALSE);
    $grid = array();
    $elements = pow($this->size, 2);
    while ($c < $elements) {
      for ($i=$c+1; $i < $elements; $i++) {
        $stock[$i] = FALSE;
      }
      if ($stock[$c] === FALSE) $stock[$c] = $this->possible($c);
      if (empty($stock[$c])) {
        $this->set($c, 0);
        $c--;
        if ($c < 0) return FALSE;
        continue;
      }
      shuffle($stock[$c]);
      $this->set($c,array_pop($stock[$c]));

      $c++;
    }
    return $this->grid;
  }

  public function row($index) {
    return (array)$this->grid[$index];
  }

  public function column($index) {
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

  public function possible($index) {
    $i = floor($index / $this->size);
    $j = $index % $this->size;
    $forbidden = array_unique(array_merge($this->row($i), $this->column($j), $this->region($i, $j)));
    $stock = array_diff($this->chars, $forbidden);
    return $stock;
  }

  public function printGrid() {
    $string = "";
    foreach ($this->grid as $i => $line) {
      if (($i % $this->base) == 0) {
        $string .= str_repeat("-", 2 * ($this->base + 1) * $this->base + 1) . "\n";
      }
      foreach ($line as $j => $digit) {
        if ($j % $this->base == 0) {
          $string .= "| ";
        }
        $string .= $this->formatDigit($digit) . " ";
      }
      $string .= "|\n";

    }
    print $string . str_repeat("-", 2 * ($this->base + 1) * $this->base + 1) . "\n";
    // don't warn if the buffer is empty
    @ob_flush();
    return $this;
  }

  private function formatDigit($digit) {
    return ($digit == 0 ? ' ' : $digit);
  }

  public function serialize() {
    $string = '';
    foreach ($this->grid as $line) {
      foreach($line as $digit) {
        $string .= $this->formatDigit($digit);
      }
    }
    return $string;
  }

  public function deserialize($string) {
    $this->size = sqrt(strlen($string));
    if ($this->size != floor($this->size)) {
      throw new InvalidArgumentException("length of input must be a perfect square (".strlen($string).")");
    }
    $this->grid = array_chunk(str_split($string), $this->size);
  }

  public function count() {
    return pow($this->size,2);
  }

  public function base() {
    return $this->base;
  }

  public function get($index) {
    $i = floor($index / $this->size);
    $j = $index % $this->size;
    return $this->grid[$i][$j];
  }

  public function set($index, $value) {
    $i = floor($index / $this->size);
    $j = $index % $this->size;
    $this->grid[$i][$j] = $value;
  }

  public function elide($level = 2) {
    for ($pass = 0; $pass < $level; $pass++) {
      for ($i=0; $i < $this->count(); $i++) {
        $index = rand(1, $this->count()) - 1;
        $temp = $this->get($index);
        $this->set($index, NULL);
        if (count($this->possible($index)) > 1) {
          $this->set($index, $temp);
        }
      }
    }
  }
}
