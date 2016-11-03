<?php
namespace TaskApp\Command;
use TaskApp\Exception\WrongArgumentException;

class RequestCommandFactory
{
	/**
	*	Initialise suitable command class 
	*   
	*	@param   RequestArgument  $argument
	*	@return ICommand
	**/
	public static function getCommand(RequestArgument $argument) {
		/**
		 *  Only Command new requered argument and format 
		 *
		**/
		switch ($argument->getByName('command')) {
			case 'get-users':
				return new GetUsersCommand();
				break;
			case 'get-tasks':
				return new GetTasksCommand();
				break;
			case 'send-message':
				return new SendMessageCommand();
				break;
			case 'register-task':
				return new RegisterTaskCommand();
				break;

			default:
				throw new WrongArgumentException("Command does not exist");
				break;
		}
	}
}