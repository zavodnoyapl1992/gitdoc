<?php

namespace GitDoc;

use GitDoc\DTO\BaseCommitDTO;
use GitDoc\ParseModules\Interfaces\ParseModuleInterface;
use GitDoc\SkipParseResult\Interfaces\FilterParseResultInterface;

class Parse
{
	/**
	 * @var string
	 */
	private $fullCommand = 'git --git-dir %s/.git log --stat --reverse';

	/**
	 * @var string
	 */
	private $dir;

	/**
	 * @var ParseModuleInterface[]
	 */
	private $parseModules = [];

	/**
	 * Parse constructor.
	 * @param string $dir
	 * @param string $addCommand
	 */
	public function __construct(string $dir)
	{
		$this->dir = $dir;
	}

	/**
	 * @param ParseModuleInterface $parseModule
	 * @param string $classNameDTO
	 * @throws \ErrorException
	 */
	public function moduleRegister(ParseModuleInterface $parseModule, string $classNameDTO)
	{
		if (!is_subclass_of($classNameDTO, BaseCommitDTO::class)) {
			throw new \ErrorException('$classNameDTO must be instance of AbstractCommitDTO');
		}
		$this->parseModules[$classNameDTO] = $parseModule;
	}

	public function parseByDTO()
	{
		/** @var BaseCommitDTO $commitDTO */
		$commitDTO = new BaseCommitDTO();
		exec(sprintf($this->fullCommand, $this->dir),$output);
		$commit = null;
		$container = [];
		$lastKey = count($output) - 1;
		foreach($output as $key => $line){
			switch (true) {
				case strpos($line, 'commit') === 0 || $lastKey === $key:
					if (!empty($commitDTO->getHash())) {
						$commitDTO = new BaseCommitDTO();
						foreach ($container as $fullObject) {
							yield $fullObject;
						}
						$container = [];
					}
					$commitDTO->setHash(substr($line, strlen('commit')));
					break;
				case strpos($line, 'Author:') === 0:
					$commitDTO->setAuthor(substr($line, strlen('Author:')));
					break;
				case strpos($line, 'Date:') === 0:
					$commitDTO->setDateTime(new \DateTimeImmutable(substr($line, strlen('Date:'))));
					break;
				case trim($line) !== '':
					foreach ($this->parseModules as $commitDTOCustomClass => $parseModule) {
						if (!isset($container[$commitDTOCustomClass])) {
							$container[$commitDTOCustomClass] = $commitDTOCustomClass::getInstanceBy($commitDTO);
						} else {
							$parseModule->parse($line, $container[$commitDTOCustomClass]);
						}
					}
					break;
			}
		}
	}
}

