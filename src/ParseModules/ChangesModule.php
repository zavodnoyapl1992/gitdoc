<?php

namespace GitDoc\ParseModules;

use GitDoc\DTO\BaseCommitDTO;
use GitDoc\DTO\ChangeFileDTO;
use GitDoc\DTO\ChangesDTO;
use GitDoc\ParseModules\Interfaces\ParseModuleInterface;

class ChangesModule implements ParseModuleInterface
{
	/**
	 * @param string $line
	 * @param ChangesDTO|BaseCommitDTO $commitDTO
	 */
	public function parse(string $line, BaseCommitDTO $commitDTO)
	{
		$arr = explode(' | ', $line);
		if (count($arr) === 2) {
			$allChanges = (int)$arr[1];
			$add = substr_count($arr[1],'+');
			$remove = substr_count($arr[1],'-');
			$fileChange = new ChangeFileDTO();
			$fileChange->setAddLines( $add === 0 ? 0 : (int)round($allChanges * $add/($add + $remove)));
			$fileChange->setFilename(trim($arr[0]));
			$fileChange->setChangesCount((int)$arr[1]);
			$fileChange->setRemoveCount($remove === 0 ? 0 : (int)round($allChanges * $remove/($add + $remove)));
			$fileChange->setCommitHash($commitDTO->getHash());
			$commitDTO->addChanges($fileChange);
		}
	}
}