<?php

namespace App\Service;

use App\Exception\UrlHashGenerateException;
use App\Service\Interfaces\UrlHashInterface;
use App\ValueObject\Url;

class UrlHash implements UrlHashInterface
{
	private const MAX_LENGTH = 6;
	private string $hash;
	private string $fullHash;
	private int $skipped_char = 0;

	public function value(): string
	{
		return $this->hash;
	}

	/**
	 * @param Url $url
	 * @return UrlHash
	 * @throws UrlHashGenerateException
	 */
	public function generate( Url $url ): UrlHash
	{
		if (isset($this->hash)) {
			throw new UrlHashGenerateException( 'Hash already generated' );
		}

		$this->fullHash = hash( 'md5', $url );
		$this->hash = substr( $this->fullHash, 0, self::MAX_LENGTH );

		return $this;
	}

	/**
	 * @throws UrlHashGenerateException
	 */
	public function next(): UrlHash
	{
		if (!isset($this->hash)) {
			throw new UrlHashGenerateException( 'First generate hash' );
		}

		$this->skipped_char++;
		$this->hash = substr( $this->fullHash, $this->skipped_char, self::MAX_LENGTH );
		if ( !$this->hash ) {
			// unlikely case, better to know about it
			throw new UrlHashGenerateException( 'Cannot generate unique hash for an url' );
		}

		return $this;
	}
}