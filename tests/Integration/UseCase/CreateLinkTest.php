<?php

namespace App\Tests\Integration\UseCase;

use App\Entity\Counter;
use App\Service\UrlHash;
use App\Tests\Integration\BaseIntegrationTest;
use App\UseCase\CreateLink;
use App\ValueObject\Url;

class CreateLinkTest extends BaseIntegrationTest
{
	public function testExecute()
	{
		$uv = Url::fromString( $this->url() );
		$cl = new CreateLink( $this->doctrine, new UrlHash( $this->doctrine ) );
		$result = $cl->execute( $uv );

		$this->assertEquals( $this->hash(), $result->getHash() );
		$this->assertEquals( $this->url(), $result->getUrl()->value() );
		$this->assertEquals( 0, $result->getStat()->getVisitCount() );
	}

	public function testReturnExistingModelForSameUrl()
	{
		$uv = Url::fromString( $this->url() );
		$cl = new CreateLink( $this->doctrine, new UrlHash( $this->doctrine ) );
		$existingModel = $cl->execute( $uv );

		$cl = new CreateLink( $this->doctrine, new UrlHash( $this->doctrine ) );
		$newModel = $cl->execute( $uv );

		$this->assertEquals( $existingModel->getHash(), $newModel->getHash() );
		$this->assertEquals( $existingModel->getUrl()->value(), $newModel->getUrl()->value() );
		$this->assertEquals( $existingModel->getId(), $newModel->getId() );
		$this->assertNull( $newModel->getDeletedAt() );
	}

	public function testCounterUpdatedAfterCreate()
	{
		$cl = new CreateLink( $this->doctrine, new UrlHash( $this->doctrine ) );
		$cl->execute( Url::fromString( 'https://bbbbbbb.co' ) );
		$counter = $this->doctrine->getRepository( Counter::class )->getCounter();

		$this->assertEquals( 2, $counter->getValue() );
	}
}
