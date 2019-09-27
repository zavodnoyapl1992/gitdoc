<?php

namespace GitDoc\Analyser\Modules\Interfaces;

use GitDoc\DTO\BaseCommitDTO;

interface AnalyserInterface
{
	public function analyse(BaseCommitDTO $commitDTO) :void;

	public function getResult() :array;

	public function getName() :string;
}