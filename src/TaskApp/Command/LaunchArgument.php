<?php
namespace TaskApp\Command;
use TaskApp\Interfaces\IArgument;

/**
*   Parse and return command line arguments
*   @todo Can use getopt, it's requered change input format
**/
class LaunchArgument implements IArgument
{
	protected $argumentList = array();

	public function __construct($argList) {
		$this->parseArguments($argList);
	}

	/**
	 * Parse and split command and arguments
	 * @param array $argList
	 * @return void
	 */
	public function parseArguments($argList)
	{
		if (!empty($argList) && count($argList) > 1) {
			//$argList[0] - script name. Skip it
			for($i=1; $i< count($argList); $i++) {
				$data = split("=", $argList[$i]);
				if (array_key_exists($data[0],$this->argumentList)) {
					throw new WrongArgumentException("Dublicate argument");					
				}

				$this->argumentList[$data[0]] = array_key_exists(1,$data)?$data[1]:null;	
			}
		}
	}

	/**
	 * Get argument by name
	 * @param string $name 
	 * @return string
	 * @return void
	 */
	public function getByName($name)
	{
		return array_key_exists($name, $this->argumentList)?$this->argumentList[$name]:null;
	}

	/**
	 * Checking argument by name
	 * @param string $name 
	 * @return boolean
	 * @return void
	 */
	public function isExist($name)
	{
		return array_key_exists($name, $this->argumentList)?true:false;
	}
}