<?php
namespace TaskApp;
use Symfony\Component\Yaml\Parser;

/**
 * Very simple configuration storage
 * No variability of environment
 */
class Config
{
	protected static $instance = null;
	protected $config = null;

	protected function __construct()
	{
		$this->config = (new Parser())->parse(file_get_contents(__DIR__.'/config.yml'));
	}

	/**
	 * Get instance
	 * @return TaskApp\Config
	 */
	public static function get()
	{
		if (self::$instance === null) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Get section by name
	 * @param name $name 
	 * @return array
	 */
	public function getSection($name)
	{
		return array_key_exists($name, $this->config)?$this->config[$name]:null;
	}

	protected function __clone() {}

	protected function __wakeup() {}
}