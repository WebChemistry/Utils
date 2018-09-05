<?php

declare(strict_types=1);

namespace WebChemistry\Utils\Latte;

use Nette\SmartObject;

class Filters {

	use SmartObject;

	public function load(string $name): ?string {
		$name = strtolower($name);
		if (method_exists($this, $name)) {
			return call_user_func_array([$this, $name], array_slice(func_get_args(), 1));
		}

		return NULL;
	}

}
