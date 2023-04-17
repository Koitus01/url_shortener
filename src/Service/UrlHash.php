<?php

namespace App\Service;

use App\Entity\Counter;
use App\Exception\UrlHashGenerateException;
use App\Repository\CounterRepository;
use App\Service\Interfaces\UrlHashInterface;
use App\ValueObject\Hash;
use Doctrine\Persistence\ManagerRegistry;

class UrlHash implements UrlHashInterface
{
	private ManagerRegistry $doctrine;

	const ALPHABET = '0123456789abcdefghjkmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ';
	const BASE = 59; // strlen(self::ALPHABET)

	public function __construct( ManagerRegistry $doctrine )
	{
		$this->doctrine = $doctrine;
	}

	/**
	 * No need locks, because this action is not in transaction
	 * @return Hash
	 * @throws UrlHashGenerateException
	 */
	public function generate(): Hash
	{
		/** @var CounterRepository $repository */
		$repository = $this->doctrine->getRepository( Counter::class );
		$counter = $repository->getCounter();
		$int = $counter->getValue();
		$counter->setValue( $int + 1 );
		$this->doctrine->getManager()->persist( $counter );
		$this->doctrine->getManager()->flush();

		return new Hash( $this->encode( $int ) );
	}

	private function encode( int $num ): string
	{
		$str = '';

		while ( $num > 0 ) {
			$str = self::ALPHABET[( $num % self::BASE )] . $str;
			$num = (int)( $num / self::BASE );
		}

		return $str;
	}
}