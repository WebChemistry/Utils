<?php declare(strict_types = 1);

namespace WebChemistry\Utils\Traits;

trait TMagicGetter {

	public function __get($name) {
		$getter = 'get' . ucfirst($name);
		if (method_exists($this, $getter)) {
			return $this->$getter();
		}

		$getter = 'is' . ucfirst($name);
		if (method_exists($this, $getter)) {
			return $this->$getter();
		}
		if (property_exists($this, $name)) {
			return $this->$name;
		}

		ObjectHelpers::strictGet(get_class($this), $name);
	}

}
