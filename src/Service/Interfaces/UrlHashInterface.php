<?php

namespace App\Service\Interfaces;

use App\Exception\UrlHashGenerateException;
use App\ValueObject\Hash;

interface UrlHashInterface
{
	/**
	 * @throws UrlHashGenerateException
	 */
	public function generate(): Hash;

}