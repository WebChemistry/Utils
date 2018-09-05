<?php

declare(strict_types=1);

namespace WebChemistry\Utils;

use Nette\DI\CompilerExtension;
use WebChemistry\Utils\Latte\Filters;

class UtilsExtension extends CompilerExtension {

	/** @var array */
	public $defaults = [
		'latte' => false,
	];

	public function loadConfiguration() {
		$builder = $this->getContainerBuilder();
		$config = $this->validateConfig($this->defaults);

		if ($config['latte']) {
			$builder->addDefinition($this->prefix('filters'))
				->setClass(Filters::class);
		}
	}

	public function beforeCompile() {
		$builder = $this->getContainerBuilder();
		$config = $this->getConfig();

		// latte
		if ($config['latte']) {
			$builder->getDefinition('latte.latteFactory')
				->addSetup('addFilter', ['date', [$this->prefix('@filters'), 'date']])
				->addSetup('addFilter', ['number', [$this->prefix('@filters'), 'number']])
				->addSetup('addFilter', [null, [$this->prefix('@filters'), 'load']]);
		}
	}

}
