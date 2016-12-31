<?php namespace System;

/**
 * Nano
 *
 * Just another php framework
 *
 * @package		nano
 * @link		http://madebykieron.co.uk
 * @copyright	http://unlicense.org/
 */

use Exception;
use ErrorException;

class Error {

	/**
	 * Register Exception handler
	 */
	public static function register() {
		set_exception_handler(array('Error', 'exception'));
		set_error_handler(array('Error', 'native'));
		register_shutdown_function(array('Error', 'shutdown'));
	}

	/**
	 * Unregister Exception handler
	 */
	public static function unregister() {
		restore_exception_handler();
		restore_error_handler();
	}

	/**
	 * Exception handler
	 *
	 * @param object
	 */
	public static function exception(Exception $e) {
		static::log($e);

		// get a error response handler
		$handler = Error\Report::handler($e, Config::error('report'));

		// generate the output
		$handler->response();

		// exit with a error code
		exit(1);
	}

	/**
	 * Error handler
	 *
	 * This will catch the php native error and treat it as a exception
	 * which will provide a full back trace on all errors
	 *
	 * @param int
	 * @param string
	 * @param string
	 * @param int
	 * @param array
	 */
	public static function native($code, $message, $file, $line) {
		if($code & error_reporting()) {
			static::exception(new ErrorException($message, $code, 0, $file, $line));
		}
	}

	/**
	 * Shutdown handler
	 *
	 * This will catch errors that are generated at the
	 * shutdown level of execution
	 */
	public static function shutdown() {
		if($error = error_get_last()) {
			extract($error);

			static::native($type, $message, $file, $line);
		}
	}

	/**
	 * Exception logger
	 *
	 * Log the exception depending on the application config
	 *
	 * @param object
	 */
	public static function log($e) {
		if(is_callable($logger = Config::error('log'))) {
			call_user_func($logger, $e);
		}
	}

}
