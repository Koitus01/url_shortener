<?php

namespace App\Tests\Application\Controller;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\ValueObject\Url;
use DateTime;
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
		$url = Url::fromString('http://aaaaaaa.mo');
		$link->setUrl($url);
		$link->setStat(new LinkStat());
		$link->setHost($url);
		$entityManager->persist($link);
		$entityManager->flush();

		$client->request('GET', '/bibibi');

		$this->assertResponseRedirects('http://aaaaaaa.mo');
	}

	public function testLocateExpiredHashThrow(): void
	{
		$client = static::createClient();
		$kernel = self::bootKernel();
		$entityManager = $kernel->getContainer()
			->get('doctrine')
			->getManager();
		$link = new Link();
		$link->setHash('bibibi');
		$url = Url::fromString('http://aaaaaaa.mo');
		$link->setUrl($url);
		$link->setHost($url);
		$link->setStat(new LinkStat());
		$link->setDeletedAt((new DateTime())->modify('-31 day'));
		$entityManager->persist($link);
		$entityManager->flush();
		$this->expectException(NotFoundHttpException::class);
		$client->catchExceptions(false);

		$client->request('GET', '/bibibi');
	}

    public function testLocateNonExistentHashThrow(): void
    {
		$client = static::createClient();
		$this->expectException(NotFoundHttpException::class);
		$client->catchExceptions(false);
		$client->request('GET', '/non-existent-hash');
	}
}
