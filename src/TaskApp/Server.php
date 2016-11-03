<?php
namespace TaskApp;

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use React\EventLoop\Factory;
use TaskApp\Server\Logger;
use TaskApp\Server\Messenger;
use TaskApp\Config;

class Server
{
	/**
	 * Start websocket server
	 * @return void
	 */
	public static function run()
	{
		Logger::init(Config::get()->getSection('logger'));
			
		$server = IoServer::factory(
			new HttpServer(
				new WsServer(
					new Messenger()
				)
			),
			8000
		);
		
		$server->run();
	}
}