<?php

namespace App\Tests\Unit\ValueObject;

use App\Exception\InvalidUrlException;
use App\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase
{

	/**
	 * @dataProvider validUrl
	 */
	public function testFromString( $validUrl )
	{
		$url = Url::fromString( $validUrl );

		$this->assertEquals( Url::class, get_class( $url ) );
	}

	/**
	 * @dataProvider invalidUrl
	 */
	public function testFromStringValidate( $invalidUrl )
	{
		$this->expectException( InvalidUrlException::class );
		$this->expectExceptionMessage( 'It is not an url' );
		Url::fromString( $invalidUrl );
	}

	public function testValueIsTrimmedAndInLowercase()
	{
		$url = Url::fromString( ' https://aVaCaVaBaN.bb ' );

		$this->assertEquals( $url->value(), 'https://avacavaban.bb' );
	}

	public function testHost()
	{
		$url1 = Url::fromString( 'https://abcd.ru?saewewqsda' );
		$url2 = Url::fromString( 'https://abcd.ru#ooooo' );
		$url3 = Url::fromString( 'https://ффффффф.рф/iiiiiiiiiiikkkkkkkkkkkkk' );
		$url4 = Url::fromString( 'ftp://185.1.2.3.4' );

		$this->assertEquals('abcd.ru', $url1->host());
		$this->assertEquals('abcd.ru', $url2->host());
		$this->assertEquals('ффффффф.рф', $url3->host());
		$this->assertEquals('185.1.2.3.4', $url4->host());
	}

	public function validUrl(): \Generator
	{
		yield 'normal domain' => ['https://abcd.ru'];
		yield 'punycode domain with hyphen' => ['https://кириллический-домен-с-дефисом.рф'];
		yield 'uppercase domain' => ['http://DOMAININUPPERCASE.COM'];
		yield 'url with query string' => ['https://aaaaa.ccc?aaaaa=bbbbb&jjjjjj=iiiiii'];
		yield 'ftp url' => ['ftp://abcd.ru'];
		yield 'ssh url' => ['ssh://abcd.ru'];
		yield 'url with ip address' => ['http://185.1.1.10'];
	}

	public function invalidUrl(): \Generator
	{
		yield 'empty string' => [''];
		yield 'only latin letters' => ['aaaaaaaaaaaaabbbbbbbbb'];
		yield 'with whitespaces' => ['https://aaaa bbbb ccc .com'];
		yield 'only domain without scheme' => ['domain.com'];
		yield 'only scheme' => ['https://'];
		yield 'only punycode domain' => ['фффффф.рф'];
		yield 'only slashes' => ['/////////'];
		yield 'with restricted special symbols' => ['https://domain$%^&&#%#^#%@#%@#.com'];
	}
}
