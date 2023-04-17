<?php

namespace App\Repository;

use App\Entity\Link;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Link>
 *
 * @method Link|null find( $id, $lockMode = null, $lockVersion = null )
 * @method Link|null findOneBy( array $criteria, array $orderBy = null )
 * @method Link[]    findAll()
 * @method Link[]    findBy( array $criteria, array $orderBy = null, $limit = null, $offset = null )
 */
class LinkRepository extends ServiceEntityRepository
{
	public function __construct( ManagerRegistry $registry )
	{
		parent::__construct( $registry, Link::class );
	}

	/**
	 * @throws EntityNotFoundException
	 */
	public function findAliveOneByHash( string $hash ): Link
	{
		if ( !$model = $this->findOneBy( [
			'hash' => $hash,
			'deleted_at' => null
		] ) ) {
			throw new EntityNotFoundException();
		}
		return $model;
	}

	public function add( Link $entity, bool $flush = false ): void
	{
		$this->getEntityManager()->persist( $entity );

		if ( $flush ) {
			$this->getEntityManager()->flush();
		}
	}

	public function remove( Link $entity, bool $flush = false ): void
	{
		$entity->setDeletedAt( new DateTime() );
		$this->getEntityManager()->persist( $entity );

		if ( $flush ) {
			$this->getEntityManager()->flush();
		}
	}

	public function restore( Link $entity, bool $flush = false ): void
	{
		$entity->setDeletedAt( null );
		$this->getEntityManager()->persist( $entity );

		if ( $flush ) {
			$this->getEntityManager()->flush();
		}
	}

	public function deleteExpired()
	{
		$query = $this->getEntityManager()
			->createQueryBuilder( 'l' )
			->update( 'App\Entity\Link', 'l' )
			->set( 'l.deleted_at', ':now' )
			->where( 'l.created_at < :expired' )
			->setParameter( 'expired', new DateTime( '-30 days' ) )
			->setParameter( 'now', new DateTime() );

		return $query->getQuery()->execute();
	}

//    /**
//     * @return Link[] Returns an array of Link objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Link
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
