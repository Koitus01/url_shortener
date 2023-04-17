<?php

namespace App\Tests\Unit\ValueObject;

use App\Exception\UrlHashGenerateException;
use App\ValueObject\Hash;
use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
	public function test()
	{
		$hashStr = 'abcded';
		$h = new Hash($hashStr);

		$this->assertEquals($hashStr, $h->value());
	}

	public function testEmptyHashWillThrow()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('Hash is empty');

		new Hash('');
	}

	public function testTooLongHashWillThrow()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('Hash is become too long');

		new Hash('abcdefgh');
	}
}
