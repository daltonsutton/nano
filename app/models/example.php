<?php

class Example extends Base {

	public static $table = 'example';

	public static function id($id) {
		return static::where('id', '=', $id)->fetch();
	}


}
