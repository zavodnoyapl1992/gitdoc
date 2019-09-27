<?php

namespace GitDoc\DTO;

/**
 * Class ChangeFileDTO
 * @package GitDoc\DTO
 * 'filename' => trim($arr[0]),
'changes' => (int)$arr[1],
'add_lines' => $add === 0 ? 0 : round($allChanges * $add/($add + $remove)),
'remove_lines' => $remove === 0 ? 0 : round($allChanges * $remove/($add + $remove)),
'message' => $line,
 */
class ChangeFileDTO
{
	private $filename;
	
	private $changesCount;
	
	private $commitHash;
	
	private $addLines;
	
	private $removeCount;

	/**
	 * @return string
	 */
	public function getFilename(): string
	{
		return $this->filename;
	}

	/**
	 * @param mixed $filename
	 */
	public function setFilename(string $filename): void
	{
		$this->filename = $filename;
	}

	/**
	 * @return int
	 */
	public function getChangesCount(): int
	{
		return $this->changesCount;
	}

	/**
	 * @param int $changesCount
	 */
	public function setChangesCount(int $changesCount): void
	{
		$this->changesCount = $changesCount;
	}

	/**
	 * @return string
	 */
	public function getCommitHash(): string
	{
		return $this->commitHash;
	}

	/**
	 * @param mixed $commitHash
	 */
	public function setCommitHash($commitHash): void
	{
		$this->commitHash = $commitHash;
	}

	/**
	 * @return int
	 */
	public function getAddLines(): int
	{
		return $this->addLines;
	}

	/**
	 * @param int $addLines
	 */
	public function setAddLines(int $addLines): void
	{
		$this->addLines = $addLines;
	}

	/**
	 * @return mixed
	 */
	public function getRemoveCount(): int
	{
		return $this->removeCount;
	}

	/**
	 * @param int $removeCount
	 */
	public function setRemoveCount(int $removeCount): void
	{
		$this->removeCount = $removeCount;
	}
}