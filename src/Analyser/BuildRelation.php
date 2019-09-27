<?php

namespace GitDoc\Analyser;

use GitDoc\Analyser\Modules\Interfaces\AnalyserInterface;
use GitDoc\DTO\BaseCommitDTO;
use GitDoc\Parse;

class BuildRelation
{
	/**
	 * @var Parse
	 */
	private $parser;

	/**
	 * @var AnalyserInterface[]
	 */
	private $analysers;

	/**
	 * BuildRelation constructor.
	 * @param Parse $parser
	 */
	public function __construct(Parse $parser)
	{
		$this->parser = $parser;
	}

	/**
	 * @param AnalyserInterface $analyser
	 * @param string $classNameDTO
	 * @throws \ErrorException
	 */
	public function registerAnalyser(AnalyserInterface $analyser, string $classNameDTO)
	{
		if (!is_subclass_of($classNameDTO, BaseCommitDTO::class)) {
			throw new \ErrorException('$classNameDTO must be instance of AbstractCommitDTO');
		}
		$this->analysers[$classNameDTO] = $analyser;
	}

	/**
	 * @return \Generator|AnalyserInterface[]
	 */
	public function run()
	{
		foreach ($this->analysers as $classDTO => $analyser) {
			/** @var BaseCommitDTO $commitDTO */
			foreach ($this->parser->parseByDTO() as $commitDTO) {
				if (!is_a($commitDTO, $classDTO)) {
					continue;
				}
				$analyser->analyse($commitDTO);
			}
			yield $analyser;
		}

	}
}