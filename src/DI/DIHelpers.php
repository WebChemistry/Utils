<?php declare(strict_types = 1);

namespace WebChemistry\Utils\DI;

use Nette\DI\ContainerBuilder;
use Nette\DI\Definitions\FactoryDefinition;

class DIHelpers {

	/** @var ContainerBuilder */
	private $builder;

	public function __construct(ContainerBuilder $builder) {
		$this->builder = $builder;
	}

	public function registerLatteFilterLoader(string $class, string $method = 'load') {
		$def = $this->builder->getDefinition('latte.latteFactory');
		if ($def instanceof FactoryDefinition) {
			$def = $def->getResultDefinition();
		}

		$def->addSetup('?->addFilter(null, [?, ?])', ['@self', $class, $method]);

		return $this;
	}

	public function registerLatteMacroLoader(string $class, string $method = 'install') {
		$factory = $this->builder->getDefinition('latte.latteFactory');
		if ($factory instanceof FactoryDefinition) {
			$factory = $factory->getResultDefinition();
		}
		
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
