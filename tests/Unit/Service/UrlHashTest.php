<?php

namespace App\Tests\Unit\Service;

use App\Exception\UrlHashGenerateException;
use App\Service\UrlHash;
use App\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class UrlHashTest extends TestCase
{
	public function test()
	{
		$urlValue = Url::fromString('https://aaaaa.com');
		$urlHash = new UrlHash();
		$this->assertEquals('e0a7a0', $urlHash->generate($urlValue)->value());
	}

	public function testNextValue()
	{
		$urlValue = Url::fromString('https://aaaaa.com');
		$urlHash = new UrlHash();
		$this->assertEquals('0a7a04', $urlHash->generate($urlValue)->next()->value());
	}

	public function testCannotGenerateHashTwice()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('Hash already generated');

		$urlValue = Url::fromString('https://aaaaa.com');
		$urlHash = new UrlHash();

		$urlHash->generate($urlValue)->generate($urlValue);
	}

	public function testCannotGetNextValueBeforeGenerate()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('First generate hash');

		$urlHash = new UrlHash();

		$urlHash->next();
	}
}
