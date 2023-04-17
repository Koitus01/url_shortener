<?php

namespace App\Tests\Integration;

use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BaseIntegration extends KernelTestCase
{
	/**
	 * @var ManagerRegistry
	 */
	protected $doctrine;

	protected function setUp(): void
	{
		$kernel = self::bootKernel();

		$this->doctrine = $kernel->getContainer()
			->get( 'doctrine' );
	}

	protected static function hash(): string
	{
		return '1';
	}

	protected static function url(): string
	{
		return 'https://aaaaa.com';
	}
}