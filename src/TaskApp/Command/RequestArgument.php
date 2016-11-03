<?php
namespace TaskApp\Command;
use TaskApp\Interfaces\IArgument;

class RequestArgument implements IArgument
{
	protected $argumentList = array();

	public function __construct($argList) {
		$this->parseArguments($argList);
	}

	/**
	 * Parse and split commands
	 * @param string $argList
	 * @return void
	 */
	public function parseArguments($argList)
	{
		$decodedList = json_decode($argList, true);
		if (is_array($decodedList)) {
			foreach ($decodedList as $key => $value) {
				//for example, we can filter arguments here
				$this->argumentList[$key] = $value;
			}
		}
	}

	/**
	 * Get argument by name
	 * @param type $name 
	 * @return string
	 */
	public function getByName($name)
	{
		return array_key_exists($name, $this->argumentList)?$this->argumentList[$name]:null;
	}

	/**
	 * Check is argument exist
	 * @param string $name 
	 * @return boolean
	 */
	public function isExist($name)
	{
		return array_key_exists($name, $this->argumentList)?true:false;
	}
}