<?php

namespace App\Service\Interfaces;

use Throwable;

interface ExceptionLoggerInterface
{
	/**
	 * Send exception to sentry or other error tracker
	 * @param Throwable $e
	 * @return void
	 */
	public function log( Throwable $e): void;

}