<?php

declare(strict_types=1);

namespace WebChemistry\Utils;

use Nette\Utils;

class Strings extends Utils\Strings {

	/** @var string */
	public static $decPoint = ',';

	/** @var string */
	public static $sepThousands = ' ';

	/**
	 * Format number
	 *
	 * @param float|int $num
	 * @param int $decimals
	 * @param null|string $decPoint
	 * @param null|string $sepThousands
	 * @return string
	 */
	public static function number($num, int $decimals = 0, string $decPoint = NULL, string $sepThousands = NULL): string {
		return number_format($num, $decimals, $decPoint !== NULL ? $decPoint : self::$decPoint, $sepThousands !== NULL ? $sepThousands : self::$sepThousands);
	}

	/**
	 * @param string $s
	 * @return string
	 */
	public static function detectEncoding(string $s): string {
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
			return 'UTF-8';

		if (preg_match('#[\x7F-\x9F\xBC]#', $s))
			return 'WINDOWS-1250';

		return 'ISO-8859-2';
	}

	/**
	 * @param string $s
	 * @return string
	 */
	public static function toUTF8(string $s): string {
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
			return $s;

		if (preg_match('#[\x7F-\x9F\xBC]#', $s))
			return iconv('WINDOWS-1250', 'UTF-8', $s);

		return iconv('ISO-8859-2', 'UTF-8', $s);
	}

}
