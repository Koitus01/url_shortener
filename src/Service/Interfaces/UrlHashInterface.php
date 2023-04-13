<?php

namespace App\Service\Interfaces;

use App\Exception\UrlHashGenerateException;
use App\Service\UrlHash;
use App\ValueObject\Url;

interface UrlHashInterface
{
	public function value(): string;

	public function generate( Url $url ): UrlHash;

}