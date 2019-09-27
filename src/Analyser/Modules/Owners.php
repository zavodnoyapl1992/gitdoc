<?php

namespace GitDoc\Analyser\Modules;


use GitDoc\Analyser\Modules\Interfaces\AnalyserInterface;
use GitDoc\DTO\BaseCommitDTO;
use GitDoc\DTO\ChangesDTO;

class Owners implements AnalyserInterface
{
	private $map = [];

	public function getName(): string
	{
		return 'owners';
	}

	public function getResult(): array
	{
		$map = array_map(function (array $map) {
			arsort($map);
			return array_slice($map, 0, 3);
		}, $this->map);

		return $map;
	}

	/**
	 * @param ChangesDTO|BaseCommitDTO $commitDTO
	 */
	public function analyse(BaseCommitDTO $commitDTO): void
	{
		foreach ($commitDTO->getChanges() as $change) {
			if (strpos($change->getFilename(),' => ') !== false) {
				[$rootDir, $other] = explode('{', $change->getFilename());
				[$changes, $endPath] = explode('}', $other);
				[$old, $new] = explode('=>', $changes);
				$oldPath = trim($rootDir) . trim($old) . trim($endPath);
				$newPath = trim($rootDir) . trim($new) . trim($endPath);
				if (isset($this->map[$oldPath])) {
					$this->map[$newPath] = $this->map[$oldPath];
					unset($this->map[$oldPath]);
				}
				$newPath = str_replace('//', '/', $newPath);
			} else {
				$newPath = $change->getFilename();
			}
			if (!isset($this->map[$newPath][$commitDTO->getAuthor()])) {
				$this->map[$newPath][$commitDTO->getAuthor()] = 0;
			}
			$this->map[$newPath][$commitDTO->getAuthor()] += $change->getChangesCount();
		}
	}
}