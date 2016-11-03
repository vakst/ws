<?php
namespace TaskApp\Server;
use Ratchet\ConnectionInterface;
use TaskApp\Server\ConnectionWrapper;

class ConnectionRegistry
{
	protected static $connectionList = array();

	private function __construct() {}

	/**
	 * Add new connection to registry
	 * @param ConnectionInterface $connection
	 * @return void
	 */
	public static function attach(ConnectionInterface $connection)
	{
		self::$connectionList[$connection->resourceId] = new ConnectionWrapper($connection);
	}

	/**
	 * Delete connection from registry
	 * @param ConnectionInterface $connection 
	 * @return void
	 */
	public static function detach(ConnectionInterface $connection)
	{
		unset(self::$connectionList[$connection->resourceId]);
	}

	/**
	 * Return wrapper
	 * @param int $resourceId
	 * @return TaskApp\Server\ConnectionWrapper
	 */
	public static function getConnectionWrapper($resourceId)
	{
		return array_key_exists($resourceId, self::$connectionList)?
			self::$connectionList[$resourceId]:
			null;
	}

	/**
	 * Get all elements
	 * @return TaskApp\Server\ConnectionWrapper[]
	 */
	public static function getList()
	{
		return self::$connectionList;
	}
}