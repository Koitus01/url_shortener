<?php

namespace App\Service;

use Throwable;

class SentryLogger implements Interfaces\ExceptionLoggerInterface
{
	public function log( Throwable $e ): void
	{

	}
}