<?php

namespace App\Tests\Integration\UseCase;

use App\Service\UrlHash;
use App\UseCase\CreateLink;
use App\ValueObject\Url;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use LogicException;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

class CreateLinkTest extends KernelTestCase
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	protected function setUp(): void
	{
		$kernel = self::bootKernel();

		$this->entityManager = $kernel->getContainer()
			->get('doctrine')
			->getManager();
	}

	public function testExecute()
	{
		$uv = Url::fromString('https://aaaaa.com');
		$cl = new CreateLink($this->entityManager, new UrlHash());
		$cl->execute($uv);
	}
}
