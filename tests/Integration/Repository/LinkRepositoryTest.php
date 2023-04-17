<?php

namespace App\Tests\Integration\Repository;

use App\Entity\Link;
use App\Repository\LinkRepository;
use App\Tests\Integration\BaseIntegration;
use App\ValueObject\Url;

class LinkRepositoryTest extends BaseIntegration
{

	public function testDeleteExpired()
	{
		$link1 = new Link();
		$url = Url::fromString( $this->url() );
		$link1->setUrl( $url );
		$link1->setHost( $url );
		$link1->setHash( $this->hash() );
		$link2 = new Link();
		$url = Url::fromString( 'https://bbbbbb.com' );
		$link2->setUrl( $url );
		$link2->setHost( $url );
		$link2->setHash( 'aaaaaa' );
		$link2->setCreatedAt( new \DateTimeImmutable( '-31 days' ) );
		$this->doctrine->getManager()->persist( $link1 );
		$this->doctrine->getManager()->persist( $link2 );
		$this->doctrine->getManager()->flush();

		$repository = new LinkRepository( $this->doctrine );
		$repository->deleteExpired();
		$this->doctrine->getManager()->clear();
		$result1 = $repository->find( $link1->getId() );
		$result2 = $repository->find( $link2->getId() );

		$this->assertNull( $result1->getDeletedAt() );
		$this->assertNotNull( $result2->getDeletedAt() );

	}
}
