<?php
namespace TaskApp\Server;

class Logger
{
	protected static $instance = null;

	protected  function __construct($config) {
		//Do something, connect to log server
	}

	/**
	 * Init Logger
	 * @param type $config 
	 * @return void
	 */
	public static function init($config)
	{
		if (self::$instance === null) {
			self::$instance = new self($config);
		}
	}

	/**
	 * Log message somewhere
	 * @param string $message 
	 * @return void
	 */
	public static function log($message)
	{
		if (self::$instance === null) {
			throw new Exception('Logger have to be init first');
		}
		//now just send to stdout
		echo "New message: ".$message."\n";
	}
}