<?php

namespace App\Tests\Integration\UseCase;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\Service\UrlHash;
use App\Tests\Integration\BaseIntegrationTest;
use App\UseCase\CreateLink;
use App\ValueObject\Url;

class CreateLinkTest extends BaseIntegrationTest
{
	public function testExecute()
	{
		$uv = Url::fromString( $this->url() );
		$cl = new CreateLink( $this->doctrine, new UrlHash() );
		$result = $cl->execute( $uv );

		$this->assertEquals( $this->hash(), $result->getHash() );
		$this->assertEquals( $this->url(), $result->getUrl()->value() );
		$this->assertEquals( 0, $result->getStat()->getVisitCount() );
	}

	public function testReturnExistingModelForSameUrl()
	{
		$uv = Url::fromString( $this->url() );
		$cl = new CreateLink( $this->doctrine, new UrlHash() );
		$existingModel = $cl->execute( $uv );

		$cl = new CreateLink( $this->doctrine, new UrlHash() );
		$newModel = $cl->execute( $uv );

		$this->assertEquals( $existingModel->getHash(), $newModel->getHash() );
		$this->assertEquals( $existingModel->getUrl()->value(), $newModel->getUrl()->value() );
		$this->assertEquals( $existingModel->getId(), $newModel->getId() );
		$this->assertNull( $newModel->getDeletedAt() );
	}

	public function testCreateWithDuplicatedHash()
	{
		$link = new Link();
		$link->setHash( $this->hash() );
		$url = Url::fromString( 'https://bbbbbbb.co' );
		$link->setUrl( $url );
		$link->setHost( $url );
		$link->setStat( new LinkStat() );
		$this->doctrine->getManager()->persist( $link );
		$this->doctrine->getManager()->flush();

		$uv = Url::fromString( $this->url() );
		$cl = new CreateLink( $this->doctrine, new UrlHash() );
		$result = $cl->execute( $uv );

		// Full md5 hash for https://aaaaa.com is e0a7a048e544adfac1a47618aa95f1ce, 0a7a04 — next part after first char
		$this->assertEquals( '0a7a04', $result->getHash() );
	}
}
