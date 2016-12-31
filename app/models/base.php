<?php

class Base extends Record {

	public static function table($name = null) {

		if( ! is_null($name)) return static::$name;

		return static::$table;
	}

	public static function __callStatic($method, $arguments) {
		$obj = Query::table(static::table())->apply(get_called_class());

		if(method_exists($obj, $method)) {
			return call_user_func_array(array($obj, $method), $arguments);
		}
	}

}
