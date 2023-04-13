<?php

namespace App\UseCase;

use App\Entity\Link;
use App\Repository\LinkRepository;
use App\Service\UrlHashInterface;
use App\ValueObject\Url;
use Doctrine\Persistence\ObjectManager;

class CreateLink
{

	private ObjectManager $manager;
	private UrlHashInterface $urlHash;

	public function __construct( ObjectManager $repository, UrlHashInterface $urlHash)
	{
		$this->manager = $repository;
		$this->urlHash = $urlHash;
	}

	public function execute( Url $url ): Link
	{
		$repository = $this->manager->getRepository(Link::class);
		if ($model = $repository->findOneBy(['hash' => $this->urlHash->execute($url)])) {
			return $model;
		}
		#$this->repository->get
	}
}