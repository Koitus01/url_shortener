<?php

namespace App\Tests\Integration\UseCase;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\Service\UrlHash;
use App\UseCase\CreateLink;
use App\ValueObject\Url;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

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
		$uv = Url::fromString($this->url());
		$cl = new CreateLink($this->entityManager, new UrlHash());
		$result = $cl->execute($uv);

		$this->assertEquals($this->hash(), $result->getHash());
		$this->assertEquals($this->url(), $result->getUrl());
		$this->assertEquals(0, $result->getStat()->getVisitCount());
	}

	public function testReturnExistingModelForSameDomain()
	{
		$uv = Url::fromString($this->url());
		$cl = new CreateLink($this->entityManager, new UrlHash());
		$existingModel = $cl->execute($uv);

		$cl = new CreateLink($this->entityManager, new UrlHash());
		$newModel = $cl->execute($uv);

		$this->assertEquals($existingModel->getHash(), $newModel->getHash());
		$this->assertEquals($existingModel->getUrl(), $newModel->getUrl());
		$this->assertEquals($existingModel->getId(), $newModel->getId());
	}

	public function testCreateWithDuplicatedHash()
	{
		$link = new Link();
		$link->setHash($this->hash());
		$link->setUrl(Url::fromString('https://bbbbbbb.co'));
		$link->setStat(new LinkStat());
		$this->entityManager->persist($link);
		$this->entityManager->flush();

		$uv = Url::fromString($this->url());
		$cl = new CreateLink($this->entityManager, new UrlHash());
		$result = $cl->execute($uv);

		// Full md5 hash for https://aaaaa.com is e0a7a048e544adfac1a47618aa95f1ce, 0a7a04 — next part after first char
		$this->assertEquals('0a7a04', $result->getHash());
	}


	private static function hash(): string
	{
		return 'e0a7a0';
	}

		private static function url(): string
	{
		return 'https://aaaaa.com';
	}
}
