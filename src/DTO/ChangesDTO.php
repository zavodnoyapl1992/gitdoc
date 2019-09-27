<?php

namespace GitDoc\DTO;

class ChangesDTO extends BaseCommitDTO
{
	private $changes = [];

	private $message = '';

	/**
	 * @return ChangeFileDTO[]
	 */
	public function getChanges(): array
	{
		return $this->changes;
	}

	/**
	 * @param ChangeFileDTO $changes
	 */
	public function addChanges(ChangeFileDTO $changes): void
	{
		$this->changes[] = $changes;
	}

	/**
	 * @return mixed
	 */
	public function getMessage()
	{
		return $this->message;
	}




}
