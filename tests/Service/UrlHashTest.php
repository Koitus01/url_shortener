<?php

namespace Service;

use App\Service\UrlHash;
use App\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class UrlHashTest extends TestCase
{
	public function test()
	{
		$urlHash = new UrlHash();
		$result = $urlHash->execute(Url::fromString('https://aaaaa.com'));


	}

}
