<?php
namespace TaskApp\Server;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use TaskApp\Exception\WrongArgumentException;
use TaskApp\Server\Logger;
use TaskApp\Server\ConnectionRegistry;
use TaskApp\Command\RequestCommandFactory;
use TaskApp\Command\RequestArgument;


class Messenger implements MessageComponentInterface
{ 
    /**
     * Connection was opened
     * @param ConnectionInterface $conn 
     * @return void
     */
    public function onOpen(ConnectionInterface $conn) {
        ConnectionRegistry::attach($conn);
        Logger::log("New connection! ({$conn->resourceId})");
    }

    /**
     * Message was recieved
     * @param ConnectionInterface $from 
     * @param string $msg 
     * @return void
     */
    public function onMessage(ConnectionInterface $from, $msg) {
        try {
            $arguments = new RequestArgument($msg);
            $command = RequestCommandFactory::getCommand($arguments);
            $command->handleRequest($arguments, $from);
        } catch (WrongArgumentException $e) {
            Logger::log($e->getMessage());
        } catch (Exception $e) {
            Logger::log($e->getMessage());
        }
    }

    /**
     * Connection was closed
     * @param ConnectionInterface $conn 
     * @return void
     */
    public function onClose(ConnectionInterface $conn) {
        ConnectionRegistry::detach($conn);
        Logger::log("Connection {$conn->resourceId} has disconnected");
    }

    /**
     * Get Error
     * @param ConnectionInterface $conn 
     * @param \Exception $e 
     * @return void
     */
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
        Logger::log("An error has occurred: {$e->getMessage()}");
    }
}