<?php

namespace App\UseCase;

use App\Entity\Link;
use Doctrine\Persistence\ManagerRegistry;

class UpdateStatistic
{
	private ManagerRegistry $doctrine;

	/**
	 * @param ManagerRegistry $doctrine
	 */
	public function __construct( ManagerRegistry $doctrine )
	{
		$this->doctrine = $doctrine;
	}

	public function execute(Link $link): void
	{
		$stat = $link->getStat();
		$stat->setVisitCount($stat->getVisitCount() + 1);
		$this->doctrine->getManager()->persist($stat);
		$this->doctrine->getManager()->flush();
	}
}