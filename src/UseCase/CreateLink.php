<?php

namespace App\UseCase;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\Service\Interfaces\UrlHashInterface;
use App\ValueObject\Url;
use Doctrine\Persistence\ObjectManager;

class CreateLink
{

	private ObjectManager $manager;
	private UrlHashInterface $urlHash;

	public function __construct( ObjectManager $manager, UrlHashInterface $urlHash )
	{
		$this->manager = $manager;
		$this->urlHash = $urlHash;
	}

	public function execute( Url $url ): Link
	{
		$repository = $this->manager->getRepository( Link::class );
		$hash = $this->urlHash->generate( $url )->value();
		if ( $model = $repository->findOneBy( [
			'hash' => $hash,
			'url' => $url->value()
		] ) ) {
			return $model;
		}

		$link = new Link();
		$link->setHash( $hash );
		$link->setUrl( $url );
		$linkStat = new LinkStat();
		$linkStat->setVisitCount( 0 );
		$link->setStat( $linkStat );

		$this->manager->persist( $link );
		$this->manager->flush();

		return $link;
	}
}