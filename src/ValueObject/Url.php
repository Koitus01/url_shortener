<?php

namespace App\ValueObject;

use App\Exception\InvalidUrlException;

class Url
{
	/**
	 * @see https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
	 */
	private const MAX_LENGTH = 2000;

	private string $url;

	private function __construct( string $url )
	{
		$this->url = $url;
	}

	public static function fromString( string $url ): self
	{
		// Обработка доменов в Punycode
		$url = trim( $url );
		self::validate( $url );
	}

	/**
	 * @throws InvalidUrlException
	 */
	private static function validate( string $url ): bool
	{
		if ( empty( $url ) ) {
			throw new InvalidUrlException( 'Url is empty' );
		}

		/*
		 * https://stackoverflow.com/questions/417142/what-is-the-maximum-length-of-a-url-in-different-browsers
		 * Нужно ли???
		if (strlen($url) > self::MAX_LENGTH) {
			throw new InvalidUrlException('Url is too long');
		}
		* */

		// https://regex101.com/r/ArkAD3/1
		$urlRegex = '^\D+:\/\/(\w|-)+\.\w+$';
		if ( !preg_match( $urlRegex, $url ) ) {
			throw new InvalidUrlException( 'It is not an url' );
		}


	}

	public function getIdnDecoded()
	{
		return idn_to_utf8( $this->url );
	}

	public function value(): string
	{
		return $this->url;
	}
}