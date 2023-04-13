<?php

namespace App\Tests\Integration\UseCase;

use App\UseCase\CreateLink;
use App\ValueObject\Url;
use Doctrine\ORM\EntityManagerInterface;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class CreateLinkTest extends KernelTestCase
{
	public function testExecute()
	{
		$uv = Url::fromString('https://aaaaa.com');
		$cl = new CreateLink();
		$cl->execute($uv);
	}
}
