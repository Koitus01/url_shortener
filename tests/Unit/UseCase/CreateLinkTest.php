<?php

namespace App\Tests\Unit\UseCase;

use App\UseCase\CreateLink;
use App\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class CreateLinkTest extends TestCase
{
	public function testExecute()
	{
		$uv = Url::fromString('');
		$cl = new CreateLink();
		$cl->execute();
	}
}
