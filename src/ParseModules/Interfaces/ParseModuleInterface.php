<?php

namespace GitDoc\ParseModules\Interfaces;

use GitDoc\DTO\BaseCommitDTO;

interface ParseModuleInterface
{
	public function parse(string $line, BaseCommitDTO $commitDTO);
}