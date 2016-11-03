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

class SendMessageCommand implements ICommand
{
	/**
	 * Send command on WS
	 * @param LaunchArgument $launchArgument
	 * @return void 
	 */
	public function sendRequest(LaunchArgument $argument)
	{
		if (!($userId = $argument->getByName('send-message'))) {
			throw new ConnectionException('UserId or all options are requered');
		} elseif ($userId == 'all') {
			$userId = null;
		}

		if (!($message = $argument->getByName('message'))) {
			throw new ConnectionException('Message is requered');
		}
		$taskId = $argument->getByName('task');

		connectws(Config::get()->getSection('ws')['uri'])->then(function($conn) use ($userId, $taskId, $message) {
			$conn->send(json_encode(array('command' => 'send-message', 'userId' => $userId, 'taskId' => $taskId, 'message' => $message)));
	        $conn->on('message', function($msg) use ($conn) {
		            if (!empty($msg) && ($decodedArray = json_decode($msg, true)) && is_array($decodedArray)) {
		            	echo "Message was sent:\n";
		            	foreach ($decodedArray as $result) {
		            		echo "userId = ".$result['userId'].", taskId = ".$result['taskId']."\n";
		            	}
		            } else {
		            	echo "No messages was sent\n";
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
		$this->validateHandleRequest($argument);

		$filterChain = new FilterChain();
		if ($argument->isExist('userId')) {
			$filterChain->
	            addFilter(
	                (new AttributeFilter())
	                ->setName('userId')
	                ->setValue($argument->getByName('userId'))
	            );
	    }

	    if ($argument->isExist('taskId')) {
			$filterChain->
	            addFilter(
	                (new AttributeFilter())
	                ->setName('taskId')
	                ->setValue($argument->getByName('taskId'))
	            );
	    }

	    $responce = array();
	    $recipientList = $filterChain->execute(ConnectionRegistry::getList());
	    foreach ($recipientList as $recipient) {
	    	$recipient->getConnection()->send($argument->getByName('message'));
	    	$responce[] = array('userId' => $recipient->getAttribute('userId'), 'taskId' => $recipient->getAttribute('taskId'));
	    }

	    $connection->send(json_encode($responce));
	}

	/**
	 * Validate all request parameters
	 * @param RequestArgument $argument 
	 * @return void
	 */
	public function validateHandleRequest(RequestArgument $argument)
	{
		if (!($message = $argument->getByName('message'))) {
			throw new WrongArgumentException('Missed parameter "message"');
		}
	}
}