<?php
namespace TaskApp\Command;
use TaskApp\Exception\WrongArgumentException;


class ConsoleCommandFactory
{
	/**
	*	Initialise suitable command class 
	*   
	*	@param   array  $LaunchArgument
	*	@return ICommand
	**/
	public static function getCommand(LaunchArgument $argument) {

		if ($argument->isExist('get-all-users')) {
			return new GetUsersCommand();
		} else if ($argument->isExist('get-all-user-task')) {
			return new GetTasksCommand();
		} else if ($argument->isExist('send-message')) {
			return new SendMessageCommand();
		} else {
			throw new WrongArgumentException("Command does not exist");			
		}
	}
}