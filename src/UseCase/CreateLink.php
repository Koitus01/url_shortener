<?php

namespace App\UseCase;

use App\Entity\Link;
use App\Entity\LinkStat;
use App\Exception\UrlHashGenerateException;
use App\Repository\LinkRepository;
use App\Service\Interfaces\UrlHashInterface;
use App\Service\UrlHash;
use App\ValueObject\Url;
use Doctrine\Persistence\ObjectManager;

class CreateLink
{

	private ObjectManager $manager;
	private UrlHashInterface $urlHash;

	/**
	 * @param ObjectManager $manager
	 * @param UrlHashInterface|UrlHash $urlHash
	 */
	public function __construct( ObjectManager $manager, UrlHashInterface $urlHash )
	{
		$this->manager = $manager;
		$this->urlHash = $urlHash;
	}

	/**
	 * No need begin transaction, because flush() already handle it
	 * @param Url $url
	 * @return Link
	 * @throws UrlHashGenerateException
	 */
	public function execute( Url $url ): Link
	{
		/** @var LinkRepository $repository */
		$repository = $this->manager->getRepository( Link::class );
		$hash = $this->urlHash->generate( $url )->value();
		// Same url must have same hash
		if ( $model = $repository->findOneBy( [
			'hash' => $hash,
			'url' => $url->value()
		] ) ) {
			// Restore model, if it's expired
			if ( $model->getDeletedAt() ) $repository->restore($model, true);
			return $model;
		}

		// Extremely rare collisions are possible, so generating new hash, if it already exists
		while ( $repository->findOneBy( ['hash' => $hash] ) ) {
			$hash = $this->urlHash->next()->value();
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