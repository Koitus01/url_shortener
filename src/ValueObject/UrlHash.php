<?php

namespace App\ValueObject;

class UrlHash
{
	private const MAX_LENGTH = 6;
	private string $hash;
	private string $fullHash;
	private int $skipped_char = 0;

	/**
	 * @param Url $url
	 */
	public function __construct( Url $url )
	{
		$this->fullHash = hash('md5', $url);
		$this->hash = substr($this->fullHash, 0, self::MAX_LENGTH);
	}

	public function value()
	{
		return $this->hash;
	}

	/**
	 * @throws \Exception
	 */
	public function next(): UrlHash
	{
		$this->skipped_char++;
		$this->hash = substr($this->fullHash, $this->skipped_char, self::MAX_LENGTH);
		if (!$this->hash) {
			// крайне маловероятный случай, но лучше знать о нем
			throw new \Exception('Cannot generate unique hash for an url');
		}

		return $this;
	}

	public function fullHash(): string
	{
		return $this->fullHash;
	}
}