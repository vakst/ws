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
 * Command "Get tasks by user id"
 */
class GetTasksCommand implements ICommand
{
	/**
	 * Send command on WS
	 * @param LaunchArgument $launchArgument 
	 * @return void
	 */
	public function sendRequest(LaunchArgument $argument)
	{
		if (!($userId = $argument->getByName('get-all-user-task'))) {
			throw new ConnectionException('UserId is requered');
		}

		connectws(Config::get()->getSection('ws')['protocol'].'://'.Config::get()->getSection('ws')['host'].':'.Config::get()->getSection('ws')['port'])->then(function($conn) use ($userId) {
			$conn->send(json_encode(array('command' => 'get-tasks', 'userId' => $userId)));
	        $conn->on('message', function($msg) use ($conn) {
		            if (!empty($msg) && ($decodedArray = json_decode($msg, true)) && is_array($decodedArray)) {
		            	echo "Next tasks connected:\n";
		            	foreach ($decodedArray as $taskId) {
		            		echo "$taskId\n";
		            	}
		            } else {
		            	echo "No connected tasks\n";
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
		$taskList = array();
		
		foreach (ConnectionRegistry::getList() as $uConnection) {
			if (
				($taskId = $uConnection->getAttribute('taskId'))
				&& (
					$argument->getByName('userId') === null
					|| $argument->getByName('userId') == $uConnection->getAttribute('userId')
				)
			 	&& !in_array($taskId, $taskList)
			 ) {
				$taskList[] = $taskId;
			}
		}

		$connection->send(json_encode($taskList));
	}
}