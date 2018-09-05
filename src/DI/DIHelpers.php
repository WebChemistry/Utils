<?php declare(strict_types = 1);

namespace WebChemistry\Utils;

use Nette\DI\ContainerBuilder;

class DIHelpers {

	/** @var ContainerBuilder */
	private $builder;

	public function __construct(ContainerBuilder $builder) {
		$this->builder = $builder;
	}

	public function registerLatteFilterLoader(string $class, string $method = 'load') {
		$this->builder->getDefinition('latte.latteFactory')
			->addSetup('?->addFilter(null, [?, ?])', ['@self', $class, $method]);

		return $this;
	}

	public function registerLatteMacroLoader(string $class, string $method = 'install') {
		$factory = $this->builder->getDefinition('latte.latteFactory');
		if (($class[0] ?? null) === '@') {
			$factory->addSetup('?->onCompile[] = function ($engine) { ?->' . $method . '($engine->getCompiler()); }', ['@self', $class]);
		} else {
			$class .= '::' . $method;
			$factory->addSetup('?->onCompile[] = function ($engine) { ' . $class . '($engine->getCompiler()); }', ['@self']);
		}

		return $this;
	}

	public function registerLatteProvider(string $name, $value) {
		$this->builder->getDefinition('latte.latteFactory')
			->addSetup('addProvider', [$name, $value]);

		return $this;
	}

}
