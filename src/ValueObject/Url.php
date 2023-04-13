<?php

namespace App\ValueObject;

use App\Exception\InvalidUrlException;

class Url
{
	private const MAX_LENGTH = 2000;

	private string $url;

	private function __construct( string $url )
	{
		$this->url = $url;
	}

	/**
	 * @throws InvalidUrlException
	 */
	public static function fromString( string $url ): self
	{
		#TODO: urlencode?
		$url = strtolower( trim( $url ) );
		self::validate( idn_to_ascii( $url ) );

		return new self( $url );
	}

	/**
	 * @throws InvalidUrlException
	 */
	private static function validate( string $url ): void
	{
		/*
		 * https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
		 * Another same services has no such restriction
		if (strlen($url) > self::MAX_LENGTH) {
			throw new InvalidUrlException('Url is too long');
		}
		* */

		// https://regex101.com/r/ArkAD3/2
		$urlRegex = '/^\D+:\/\/(\w|-)+\.(\w|-)+/';
		if ( !preg_match( $urlRegex, $url ) ) {
			throw new InvalidUrlException( 'It is not an url' );
		}


	}

	public function idnDecoded()
	{
		return idn_to_utf8( $this->url );
	}

	public function idnEncoded()
	{
		return idn_to_ascii( $this->url );
	}

	public function value(): string
	{
		return $this->url;
	}

	public function __toString()
	{
		return $this->url;
	}
}