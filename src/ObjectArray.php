<?php

namespace WebChemistry\Utils;

class ObjectArray implements \ArrayAccess {

	/** @var array */
	protected $data = [];

	/**
	 * Whether a offset exists
	 *
	 * @param mixed $offset
	 * @return bool
	 */
	public function offsetExists($offset) {
		return isset($this->data[$offset]);
	}

	/**
	 * Offset to retrieve
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet($offset) {
		return $this->data[$offset];
	}

	/**
	 * Offset to set
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value) {
		$this->data[$offset] = $value;
	}

	/**
	 * Offset to unset
	 *
	 * @param mixed $offset
	 */
	public function offsetUnset($offset) {
		unset($this->data[$offset]);
	}

	/**
	 * @param mixed $name
	 * @return mixed
	 */
	public function __get($name) {
		return $this->offsetGet($name);
	}

	/**
	 * @param mixed $name
	 * @param mixed $value
	 */
	public function __set($name, $value) {
		$this->offsetSet($name, $value);
	}

	/**
	 * @param mixed $name
	 * @return bool
	 */
	public function __isset($name) {
		return $this->offsetExists($name);
	}

	/**
	 * @param mixed $name
	 */
	public function __unset($name) {
		$this->offsetUnset($name);
	}

}
