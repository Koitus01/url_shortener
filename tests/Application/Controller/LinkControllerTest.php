<?php

namespace App\Tests\Application\Controller;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\ValueObject\Url;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkControllerTest extends WebTestCase
{
	public function testLocate(): void
	{
		$client = static::createClient();
		$kernel = self::bootKernel();
		$entityManager = $kernel->getContainer()
			->get('doctrine')
			->getManager();
		$link = new Link();
		$link->setHash('bibibi');
		$link->setUrl(Url::fromString('http://aaaaaaa.mo'));
		$link->setStat(new LinkStat());
		$entityManager->persist($link);
		$entityManager->flush();

		$client->request('GET', '/bibibi');

		$this->assertResponseRedirects('http://aaaaaaa.mo');
	}

	public function testLocateExpiredHash(): void
	{
		$client = static::createClient();
		$kernel = self::bootKernel();
		$entityManager = $kernel->getContainer()
			->get('doctrine')
			->getManager();
		$link = new Link();
		$link->setHash('bibibi');
		$link->setUrl(Url::fromString('http://aaaaaaa.mo'));
		$link->setStat(new LinkStat());
		$link->setDeletedAt((new DateTime())->modify('-31 day'));
		$entityManager->persist($link);
		$entityManager->flush();
		$this->expectException(NotFoundHttpException::class);
		$client->catchExceptions(false);

		$client->request('GET', '/bibibi');
	}

    public function testLocateNonExistentHash(): void
    {
		$client = static::createClient();
		$this->expectException(NotFoundHttpException::class);
		$client->catchExceptions(false);
		$client->request('GET', '/non-existent-hash');
	}
}
