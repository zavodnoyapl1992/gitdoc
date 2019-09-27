<?php

namespace GitDoc;

class Parse
{
	private const COMMAND = 'git log --stat ';

	private $fullCommand = self::COMMAND;

	private $dir;

	public function __construct($dir, string $addCommand = '')
	{
		$this->dir = $dir;
		$this->fullCommand .= $addCommand;
	}

	public function getLogs()
	{

	}
}

