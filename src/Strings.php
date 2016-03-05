<?php

namespace WebChemistry\Utils;

use Nette;
use Urodoz\Truncate\TruncateService;

class Strings extends Nette\Utils\Strings {

	/** @var string */
	public static $decPoint = ',';

	/** @var string */
	public static $sepThousands = ' ';

	/** @var TruncateService */
	private static $htmlService;

	/**
	 * @return TruncateService
	 */
	private static function getHtmlService() {
		if (!self::$htmlService) {
			self::$htmlService = new TruncateService();
		}

		return self::$htmlService;
	}

	/**
	 * Format number
	 *
	 * @param float|int $num
	 * @param int       $decimals
	 * @param null      $decPoint
	 * @param null      $sepThousands
	 * @return string
	 */
	public static function number($num, $decimals = 0, $decPoint = NULL, $sepThousands = NULL) {
		return number_format($num, $decimals, $decPoint !== NULL ? $decPoint : self::$decPoint, $sepThousands !== NULL ? $sepThousands : self::$sepThousands);
	}

	/**
	 * @param int $num
	 * @param string $first
	 * @param string $second
	 * @param string $third
	 * @return string
	 */
	public static function plural($num, $first, $second, $third) {
		return $num . ' ' . ($num === 1 ? $first : ($num > 1 && $num < 5 ? $second : $third));
	}

	/**
	 * @param string $s
	 * @return string
	 */
	public static function detectEncoding($s) {
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
	public static function toUTF8($s) {
		if (preg_match('#[\x80-\x{1FF}\x{2000}-\x{3FFF}]#u', $s))
			return $s;

		if (preg_match('#[\x7F-\x9F\xBC]#', $s))
			return iconv('WINDOWS-1250', 'UTF-8', $s);

		return iconv('ISO-8859-2', 'UTF-8', $s);
	}

	/**
	 * @param string $text
	 * @param int $length
	 * @param string $replace
	 * @param bool $exact
	 * @return string
	 */
	public static function htmlTruncate($text, $length, $replace = '...', $exact = TRUE) {
		return self::getHtmlService()->truncate($text, $length, $replace, $exact);
	}

}
