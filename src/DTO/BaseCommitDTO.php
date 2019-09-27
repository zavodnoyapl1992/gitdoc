<?php

namespace GitDoc\DTO;

class BaseCommitDTO
{
	/**
	 * @var string|null
	 */
	private $hash;

	/**
	 * @var string
	 */
	private $author;

	/**
	 * @var \DateTimeImmutable
	 */
	private $dateTime;

	final public function __construct()
	{
	}

	/**
	 * @return string
	 */
	final public function getHash(): ?string
	{
		return $this->hash;
	}

	/**
	 * @param string $hash
	 */
	final public function setHash(string $hash): void
	{
		$this->hash = trim($hash);
	}

	/**
	 * @return string
	 */
	final public function getAuthor(): string
	{
		return $this->author;
	}

	/**
	 * @param string $author
	 */
	final public function setAuthor(string $author): void
	{
		$this->author = trim($author);
	}

	/**
	 * @return \DateTimeImmutable
	 */
	final public function getDateTime(): \DateTimeImmutable
	{
		return $this->dateTime;
	}

	/**
	 * @param \DateTimeImmutable $timestamp
	 */
	final public function setDateTime(\DateTimeImmutable $timestamp): void
	{
		$this->dateTime = $timestamp;
	}

	final public static  function getInstanceBy(BaseCommitDTO $commitDTO)
	{
		$obj = new static();
		$obj->setHash($commitDTO->getHash());
		$obj->setDateTime($commitDTO->getDateTime());
		$obj->setAuthor($commitDTO->getAuthor());

		return $obj;
	}
}