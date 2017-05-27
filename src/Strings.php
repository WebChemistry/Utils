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
	 * @param float|int $number
	 * @param int $decimals
	 * @param null|string $decPoint
	 * @param null|string $sepThousands
	 * @return string
	 */
	public static function number($number, int $decimals = 0, ?string $decPoint = NULL, ?string $sepThousands = NULL): string {
		return number_format(
			$number, $decimals,
			$decPoint !== NULL ? $decPoint : self::$decPoint,
			$sepThousands !== NULL ? $sepThousands : self::$sepThousands
		);
	}

	/**
	 * @param string $subject
	 * @return string
	 */
	public static function detectEncoding(string $subject): string {
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $subject))
			return 'UTF-8';

		if (preg_match('#[\x7F-\x9F\xBC]#', $subject))
			return 'WINDOWS-1250';

		return 'ISO-8859-2';
	}

	/**
	 * @param string $subject
	 * @return string
	 */
	public static function toUTF8(string $subject): string {
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $subject))
			return $subject;

		if (preg_match('#[\x7F-\x9F\xBC]#', $subject))
			return iconv('WINDOWS-1250', 'UTF-8', $subject);

		return iconv('ISO-8859-2', 'UTF-8', $subject);
	}

}
