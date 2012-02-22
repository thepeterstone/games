<?php

class Autoload {
	public static function load($cname) {
		require_once dirname(__FILE__) . '/' . $cname . '.php';
	}
}

spl_autoload_register('Autoload::load');