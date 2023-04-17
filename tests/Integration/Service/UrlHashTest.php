<?php

namespace App\Tests\Integration\Service;

use App\Entity\Counter;
use App\Exception\UrlHashGenerateException;
use App\Repository\CounterRepository;
use App\Service\UrlHash;
use App\Tests\Integration\BaseIntegrationTest;

class UrlHashTest extends BaseIntegrationTest
{
	protected CounterRepository $repository;

	protected function setUp(): void
	{
		parent::setUp();
		$this->repository = $this->doctrine->getRepository( Counter::class );
	}


	/**
	 * @dataProvider hashExamples
	 */
	public function testGenerate( $hashExample )
	{
		$uh = new UrlHash( $this->doctrine );
		$counter = $this->repository->getCounter();
		$counter->setValue( $hashExample['int'] );

		$result = $uh->generate();

		$this->assertEquals( $hashExample['hash'], $result->value() );
	}

	public function testGenerateTrillionCounterWillThrow()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('Hash is become too long');

		$uh = new UrlHash( $this->doctrine );
		$counter = $this->repository->getCounter();
		$counter->setValue( 1000000000000 );
		$uh->generate();

	}

	public function testGenerateZeroCounterWillThrow()
	{
		$this->expectException(UrlHashGenerateException::class);
		$this->expectExceptionMessage('Hash is empty');

		$uh = new UrlHash( $this->doctrine );
		$counter = $this->repository->getCounter();
		$counter->setValue( 0 );
		$uh->generate();

	}

	public function hashExamples(): \Generator
	{
		yield '100000' => [[
			'int' => 100000,
			'hash' => 'uJV'
		]];
		yield '1' => [[
			'int' => 1,
			'hash' => '1'
		]];
		yield '10214548' => [[
			'int' => 10214548,
			'hash' => 'QKnW'
		]];
		yield '2324422112' => [[
			'int' => 2324422112,
			'hash' => '3ePJvX'
		]];
	}
}
