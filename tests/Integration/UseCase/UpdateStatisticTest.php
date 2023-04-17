<?php

namespace App\Tests\Integration\UseCase;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\Tests\Integration\BaseIntegration;
use App\UseCase\UpdateStatistic;
use App\ValueObject\Url;

class UpdateStatisticTest extends BaseIntegration
{
	public function testExecute()
	{
		$link = new Link();
		$url = Url::fromString( $this->url() );
		$link->setHost( $url );
		$link->setUrl( $url );
		$link->setStat( new LinkStat() );
		$link->setHash( $this->hash() );
		$this->doctrine->getManager()->persist( $link );
		$this->doctrine->getManager()->flush();

		$us = new UpdateStatistic( $this->doctrine );
		$us->execute( $link );
		$this->doctrine->getManager()->clear();

		$this->assertEquals( 1, $link->getStat()->getVisitCount() );


	}
}
