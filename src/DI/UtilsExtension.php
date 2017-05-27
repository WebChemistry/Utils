<?php

declare(strict_types=1);

namespace WebChemistry\Utils;

use Nette\DI\CompilerExtension;

class UtilsExtension extends CompilerExtension {

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();

		$builder->addDefinition($this->prefix('filters'))
			->setClass(Filters::class);
	}

	public function beforeCompile() {
		$builder = $this->getContainerBuilder();

		$builder->getDefinition('latte.latteFactory')
			->addSetup('addFilter', ['date', [$this->prefix('@filters'), 'date']])
			->addSetup('addFilter', ['number', [$this->prefix('@filters'), 'number']])
			->addSetup('addFilter', [NULL, [$this->prefix('@filters'), 'load']]);
	}

}
