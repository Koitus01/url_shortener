<?php

namespace App\Service;

class SentryLogger implements Interfaces\ExceptionLoggerInterface
{
	public function log(): void
	{
		// send to sentry code
	}
}