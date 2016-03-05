<?php

namespace WebChemistry\Utils;

use Nette;

class DateTime extends Nette\Utils\DateTime {

	/** @var string */
	public static $datetime = 'd.m.Y H:i';

	/** @var string */
	public static $date = 'd.m.Y';

	/** @var string */
	public static $time = 'H:i';

	/** @var array */
	public static $translatedMonths = [
		1 => 'january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october',
		'november', 'december'
	];

	/** @var array */
	public static $translatedDays = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];

	/** @var callable */
	public static $timeAgoCallback;

	/** @var array */
	private static $startEndIndexes = [
		'year' => 'Y', 'month' => 'm', 'day' => 'd', 'hours' => 'H', 'minutes' => 'i', 'seconds' => 's'
	];

	/**
	 * @param int|\DateTime $time
	 * @return string
	 */
	public static function translateMonth($time) {
		if (is_numeric($time) && $time > 13) {
			$time = date('n', $time);
		}
		if ($time instanceof \DateTime) {
			$time = $time->format('n');
		}

		return isset(self::$translatedMonths[$time]) ? self::$translatedMonths[$time] : $time;
	}

	/**
	 * @param int|\DateTime $time
	 * @return string
	 */
	public static function translateDay($time) {
		if (is_numeric($time) && $time > 6) {
			$time = date('w', $time);
		}
		if ($time instanceof \DateTime) {
			$time = $time->format('w');
		}

		return isset(self::$translatedDays[$time]) ? self::$translatedDays[$time] : $time;
	}

	/**
	 * @param int      $time
	 * @param int|null $from
	 * @return null|string
	 */
	public static function timeAgo($time, $from = NULL) {
		$from = DateTime::from($from);
		$time = DateTime::from($time);
		if ($from === NULL) {
			$from = time();
		}

		$diff = $from->getTimestamp() - $time->getTimestamp();

		if ($diff < 0) {
			return NULL;
		}
		$callback = self::$timeAgoCallback;

		if ($diff < 60) {
			return $callback('now', 0);
		} else if ($diff < 3601) {
			return $callback('minutes', floor($diff / 60));
		} else if ($diff < 86401) {
			return $callback('hours', floor($diff / 3600));
		} else if ($diff < 2629801) {
			return $callback('days', floor($diff / 86400));
		} else if ($diff < 31536001) {
			return $callback('months', floor($diff / 2629800));
		} else {
			return $callback('years', floor($diff / 31536000));
		}
	}

	/**
	 * @param mixed $time
	 * @param null  $format
	 * @return string
	 */
	public static function flush($time, $format = NULL) {
		if ($format === NULL) {
			$format = self::$datetime;
		}

		$datetime = self::from($time);

		return $datetime->format($format);
	}
	/**
	 * @return string
	 */
	public function __toString() {
		return $this->format(self::$datetime);
	}

	/**
	 * @return string
	 */
	public function baseFormat() {
		return $this->format('Y-m-d H:i:s');
	}

	/**
	 * @param int|\DateTime $time
	 * @return DateTime
	 */
	public static function toDateTime($time) {
		return self::flush($time);
	}

	/**
	 * @param int|\DateTime $time
	 * @param string|null $format
	 * @return DateTime
	 */
	public static function toDate($time, $format = NULL) {
		return self::flush($time, $format ? : self::$date);
	}

	/**
	 * @param int $time
	 * @return DateTime
	 */
	public static function toTime($time) {
		return self::flush($time, self::$time);
	}

	/**
	 * @param string $type year, day, month, day, hours, minutes, seconds
	 * @param string $value
	 * @return DateTime
	 */
	public static function start($type, $value = NULL) {
		$index = self::$startEndIndexes[$type];
		$v = [
			'Y' => date('Y'), 'm' => '01', 'd' => '01', 'H' => '00', 'i' => '00', 's' => '00'
		];
		$start = TRUE;
		while (current($v)) {
			$key = key($v);
			if ($key === $index) {
				$v[$key] = $value ? : date($key);
				$start = FALSE;
			} else if ($start === TRUE) {
				$v[$key] = date($key);
			}
			next($v);
		}

		return new self("$v[Y]-$v[m]-$v[d] $v[H]:$v[i]:$v[s]");
	}

	/**
	 * @param string $type year, day, month, day, hours, minutes, seconds
	 * @param string $value
	 * @return DateTime
	 */
	public static function end($type, $value = NULL) {
		$index = self::$startEndIndexes[$type];
		$v = [
			'Y' => date('Y'), 'm' => '12', 'd' => '31', 'H' => '23', 'i' => '59', 's' => '59'
		];
		$start = TRUE;
		while (current($v)) {
			$key = key($v);
			if ($key === $index) {
				$v[$key] = $value ? : date($key);
				$start = FALSE;
			} else if ($start === TRUE) {
				$v[$key] = date($key);
			}
			next($v);
		}

		return new self("$v[Y]-$v[m]-$v[d] $v[H]:$v[i]:$v[s]");
	}

}
