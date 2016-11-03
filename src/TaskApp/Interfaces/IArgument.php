<?php
namespace TaskApp\Interfaces;

interface IArgument {
	public function parseArguments($argList);
	public function getByName($name);
	public function isExist($name);
}