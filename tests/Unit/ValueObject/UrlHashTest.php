<?php

namespace App\Tests\Unit\ValueObject;

use App\ValueObject\Url;
use App\ValueObject\UrlHash;
use PHPUnit\Framework\TestCase;

class UrlHashTest extends TestCase
{
	public function test()
	{
		$urlValue = Url::fromString('https://aaaaa.com');
		$urlHash = new UrlHash($urlValue);
		$this->assertEquals('e0a7a0', $urlHash->value());
	}

	public function testNextValue()
	{
		$urlValue = Url::fromString('https://aaaaa.com');
		$urlHash = new UrlHash($urlValue);
		$this->assertEquals('0a7a04', $urlHash->next()->value());
	}

}
