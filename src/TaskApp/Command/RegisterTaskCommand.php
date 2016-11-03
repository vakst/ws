<?php
namespace TaskApp\Command;

use TaskApp\Server\ConnectionRegistry;
use Ratchet\ConnectionInterface;
use TaskApp\Exception\WrongArgumentException;
use TaskApp\Interfaces\ICommand;

class RegisterTaskCommand implements ICommand
{
	/**
	 * Send command on WS
	 * @param LaunchArgument $launchArgument
	 * @return void
	 */
	public function sendRequest(LaunchArgument $argument)
	{
		//no requirements
	}

	/**
	 * Perform command
	 * @param LaunchArgument $launchArgument
	 * @return void
	 */
	public function handleRequest(RequestArgument $requestArgument, ConnectionInterface $connection)
	{
		if (
			$requestArgument->isExist('userId')
			&& $requestArgument->isExist('taskId')
		) {
			ConnectionRegistry::getConnectionWrapper($connection->resourceId)->setAttribute('userId', $requestArgument->getByName('userId'));
			ConnectionRegistry::getConnectionWrapper($connection->resourceId)->setAttribute('taskId', $requestArgument->getByName('taskId'));
			
		} else {
			throw new WrongArgumentException("Invalid input for connection {$connection->resourceId}\n");
		}
	}
}