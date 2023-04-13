<?php

namespace App\UseCase;

use App\Entity\Link;
use App\ValueObject\Url;
use Doctrine\Persistence\ObjectManager;

class CreateLink
{

	private ObjectManager $manager;

	public function __construct( ObjectManager $repository)
	{
		$this->manager = $repository;
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