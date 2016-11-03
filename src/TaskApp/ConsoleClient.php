<?php
namespace TaskApp;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use TaskApp\Command\LaunchArgument;
use TaskApp\Command\ConsoleCommandFactory;
use TaskApp\Exception\WrongArgumentException;
use TaskApp\Exception\ConnectionException;


class ConsoleClient
{
	/**
	 * Start console client
	 * @param array $argv 
	 * @return void
	 */
	public static function run($argv)
	{
		try {
		    $launchArgument = new LaunchArgument($argv);
		    $command = ConsoleCommandFactory::getCommand($launchArgument);
		    $command->sendRequest($launchArgument);
		    
		} catch (\Exception $e) {
		    if ($e instanceOf WrongArgumentException) {
		        echo $e->getMessage()."\n";
		    } elseif ($e instanceOf ConnectionException) {
		    	echo "Connection error ".$e->getMessage()."\n";
		    } else {
		        echo "Internal error\n";
		    }
		}
	}
}