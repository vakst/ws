<?php
namespace TaskApp\Command;
use TaskApp\Server\ConnectionRegistry;
use Ratchet\ConnectionInterface;
use TaskApp\Exception\WrongArgumentException;
use TaskApp\Exception\ConnectionException;
use TaskApp\Interfaces\ICommand;
use TaskApp\Server\FilterChain;
use TaskApp\Server\AttributeFilter;
use TaskApp\Config;
use function Ratchet\Client\connect as connectws;

/**
 * Command "Get all register users ids"
 */
class GetUsersCommand implements ICommand
{
	/**
	 * Send command on WS
	 * @param LaunchArgument $launchArgument
	 * @return void
	 */
	public function sendRequest(LaunchArgument $argument)
	{
		connectws(Config::get()->getSection('ws')['protocol'].'://'.Config::get()->getSection('ws')['host'].':'.Config::get()->getSection('ws')['port'])->then(function($conn) {
			$conn->send(json_encode(array('command' => 'get-users')));
	        $conn->on('message', function($msg) use ($conn) {
		            if (!empty($msg) && ($decodedArray = json_decode($msg, true)) && is_array($decodedArray)) {
		            	echo "Next users connected:\n";
		            	foreach ($decodedArray as $userId) {
		            		echo "$userId\n";
		            	}
		            } else {
		            	echo "No connected users\n";
		            }

		            $conn->close();
		    });

		    }, function ($e) {
		        throw new ConnectionException($e->getMessage());
	    });
	}

	/**
	 * Handle Request
	 * @param LaunchArgument $launchArgument
	 * @param ConnectionInterface $connection
	 * @return void
	 */
	public function handleRequest(RequestArgument $argument, ConnectionInterface $connection)
	{
		$userList = array();
		foreach (ConnectionRegistry::getList() as $uConnection) {
			if (($userId = $uConnection->getAttribute('userId')) && !in_array($userId, $userList)) {
				$userList[] = $userId;
			}
		}

		$connection->send(json_encode($userList));
	}
}