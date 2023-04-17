<?php

namespace App\Tests\Application\Controller;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\ValueObject\Url;
use DateTime;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LinkControllerTest extends WebTestCase
{
	private $entityManager;
	private KernelBrowser $client;

	protected function setUp(): void
	{
		parent::setUp();

		$this->client = static::createClient();
		$kernel = self::bootKernel();
		$this->entityManager = $kernel->getContainer()
			->get( 'doctrine' )
			->getManager();
	}

	public function testLocate(): void
	{
		$link = new Link();
		$link->setHash( 'bibibi' );
		$url = Url::fromString( 'http://aaaaaaa.mo' );
		$link->setUrl( $url );
		$link->setStat( new LinkStat() );
		$link->setHost( $url );
		$this->entityManager->persist( $link );
		$this->entityManager->flush();

		$this->client->request( 'GET', '/bibibi' );

		$this->assertResponseRedirects( 'http://aaaaaaa.mo' );
	}

	public function testLocateExpiredHashThrow(): void
	{
		$link = new Link();
		$link->setHash( 'bibibi' );
		$url = Url::fromString( 'http://aaaaaaa.mo' );
		$link->setUrl( $url );
		$link->setHost( $url );
		$link->setStat( new LinkStat() );
		$link->setDeletedAt( ( new DateTime() )->modify( '-31 day' ) );
		$this->entityManager->persist( $link );
		$this->entityManager->flush();
		$this->expectException( NotFoundHttpException::class );
		$this->client->catchExceptions( false );

		$this->client->request( 'GET', '/bibibi' );
	}

	public function testLocateNonExistentHashThrow(): void
	{
		$this->expectException( NotFoundHttpException::class );
		$this->client->catchExceptions( false );
		$this->client->request( 'GET', '/non-existent-hash' );
	}

	public function testLocateUpdateVisitStat(): void
	{
		$link = new Link();
		$link->setHash( 'bibibi' );
		$url = Url::fromString( 'http://aaaaaaa.mo' );
		$link->setUrl( $url );
		$link->setStat( new LinkStat() );
		$link->setHost( $url );
		$this->entityManager->persist( $link );
		$this->entityManager->flush();

		$this->client->request( 'GET', '/bibibi' );
		$this->entityManager->clear();
		$updatedEntity = $this->entityManager->getRepository( Link::class )->find( $link->getId() );

		$this->assertResponseRedirects( 'http://aaaaaaa.mo' );
		$this->assertEquals( 1, $updatedEntity->getStat()->getVisitCount() );
	}
}
