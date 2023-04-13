<?php

require 'vendor/autoload.php';

class ShortURL {

	const ALPHABET = '23456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ-_';
	const BASE = 51; // strlen(self::ALPHABET)

	public static function encode($num) {
		$str = '';

		while ($num > 0) {
			$str = self::ALPHABET[($num % self::BASE)] . $str;
			$num = (int) ($num / self::BASE);
		}

		return $str;
	}

	public static function decode($str) {
		$num = 0;
		$len = strlen($str);

		for ($i = 0; $i < $len; $i++) {
			$num = $num * self::BASE + strpos(self::ALPHABET, $str[$i]);
		}

		return $num;
	}

}

$str = 'https://aaaaa.com';
dd($hashMd5 = hash('md5', $str), strlen($hashMd5));
$pipi = ShortURL::encode(2);
$cock = ShortURL::decode($str);
dd($pipi, $cock, ShortURL::encode($cock));

$str2 = 'https://aaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.coaaaaa.co';
$b = base64_encode($str);
$b2 = base64_encode($str2);
$int1 = intval($b, 35);
$int2 = intval($b2, 35);
$a1 = intval('420000000000000000000'); // 2147483647
$a2 = intval('420000000000000000000'); // 420000000000000000000
dd($b, $b2, $int1, $int2, $a1, $a2);
$unpack1 = unpack('I*', $str)[1];
$unpack2 = unpack('I*', $str2)[1];
$intbase = intval($str, 36);
$base = base_convert( $intbase, 10, 36 );
$hashMd5 = hash('md5', $str);
$h1 = hash('md5', 'd131dd02c5e6eec4693d9a0698aff95c');
$h2 = hash('md5', '55ad340609f4b30283e488832571415a');
dd($str, $intbase, $base, $hashMd5, $h1, $h2, $unpack1, $unpack2);
$intval = intval( $str, 36 );
$base = base_convert( $intval, 10, 36 );
$cocj = crypt( "1", 'https://aaaaa.com' );