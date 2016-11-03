<?php
namespace TaskApp\Server;
use Ratchet\ConnectionInterface;

/**
 * Wrapper for Ratchet\ConnectionInterface
 * Add Attribute Storage
 */
class ConnectionWrapper
{
	protected $connection = null;
	protected $attributeList = array();

	public function __construct(ConnectionInterface $connection)
	{
		$this->connection = $connection;
	}

	/**
	 * Set Attribute
	 * @param string $name 
	 * @param string $value 
	 * @return void
	 */
	public function setAttribute($name, $value)
	{
		$this->attributeList[$name] = $value;
	}

	/**
	 * Get attribute by name
	 * @param type $name 
	 * @return string
	 */
	public function getAttribute($name)
	{
		return array_key_exists($name, $this->attributeList)?$this->attributeList[$name]:null;
	}

	/**
	 * Get Ratchet\ConnectionInterface
	 * @return Ratchet\ConnectionInterface
	 */
	public function getConnection()
	{
		return $this->connection;
	}
}