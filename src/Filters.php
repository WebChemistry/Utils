<?php

declare(strict_types=1);

namespace WebChemistry\Utils;

use Nette\SmartObject;

class Filters {

	use SmartObject;

	/** @var array */
	public static $booleans = ['no', 'yes'];

	public function load(string $name): ?string {
		$name = strtolower($name);
		if (method_exists($this, $name)) {
			return call_user_func_array([$this, $name], array_slice(func_get_args(), 1));
		}

		return NULL;
	}

	/**
	 * @param int $month
	 * @return string
	 */
	public function month(int $month): string {
		return DateTime::translateMonth($month);
	}

	/**
	 * @param int $day
	 * @return string
	 */
	public function day(int $day): string {
		return DateTime::translateDay($day);
	}

	/**
	 * @param \DateTime|int $time
	 * @return string
	 */
	public function timeAgo($time): string {
		return DateTime::timeAgo($time);
	}

	/**
	 * @param \DateTime|int $time
	 * @return string
	 */
	public function datetime($time): string {
		return DateTime::toDateTime($time);
	}

	/**
	 * @param \DateTime|int $time
	 * @return string
	 */
	public function date($time, $format = NULL): string {
		return DateTime::toDate($time, $format);
	}

	/**
	 * @param \DateTime|int $time
	 * @return string
	 */
	public function time($time): string {
		return DateTime::toTime($time);
	}

	/**
	 * @param float|int $num
	 * @param int $decimals
	 * @param string|null $decPoint
	 * @param string|null $sepThousands
	 * @return string
	 */
	public function number($num, int $decimals = 0, string $decPoint = NULL, string $sepThousands = NULL): string {
		return Strings::number($num, $decimals, $decPoint, $sepThousands);
	}

}
