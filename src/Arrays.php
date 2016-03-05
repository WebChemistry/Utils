<?php

namespace WebChemistry\Utils;

use Nette;

class Arrays extends Nette\Utils\Arrays {

	/**
	 * @param array|\Traversable $array
	 * @param bool $check
	 * @return array
	 */
	public static function toArray($array, $check = FALSE) {
		if ($check && (!is_array($array) && !$array instanceof \Traversable)) {
			throw new Nette\InvalidArgumentException(sprintf('Parameter must be an array or class implements Traversable, %s given.', gettype($array)));
		}

		return $array instanceof \Traversable ? iterator_to_array($array) : (array) $array;
	}

	/**
	 * @param array|\Traversable $array
	 * @return int
	 */
	public static function count($array) {
		if (!is_array($array) && !$array instanceof \Traversable) {
			throw new Nette\InvalidArgumentException(sprintf('Parameter must be an array or class implements Traversable, %s given.', gettype($array)));
		}

		return $array instanceof \Traversable ? iterator_count($array) : count($array);
	}

}
