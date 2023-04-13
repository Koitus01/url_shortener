<?php

namespace App\Service;

use App\ValueObject\Url;

interface UrlHashInterface
{
	public function execute( Url $url );

}