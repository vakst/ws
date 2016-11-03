<?php
namespace TaskApp\Interfaces;
use Ratchet\ConnectionInterface;
use TaskApp\Command\LaunchArgument;
use TaskApp\Command\RequestArgument;

interface ICommand {
	public function sendRequest(LaunchArgument $launchArgument);
	public function handleRequest(RequestArgument $launchArgument, ConnectionInterface $connection);
}