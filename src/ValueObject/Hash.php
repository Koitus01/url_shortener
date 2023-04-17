<?php

namespace App\ValueObject;

use App\Exception\UrlHashGenerateException;

class Hash
{
	private string $hash;

	/**
	 * @throws UrlHashGenerateException
	 */
	public function __construct( string $hash )
	{
		if ( !$hash ) {
			throw new UrlHashGenerateException( 'Hash is empty' );
		}

		if ( strlen( $hash ) > 6 ) {
			throw new UrlHashGenerateException( 'Hash is become too long' );
		}

		$this->hash = $hash;
	}

	public function value(): string
	{
		return $this->hash;
	}
}