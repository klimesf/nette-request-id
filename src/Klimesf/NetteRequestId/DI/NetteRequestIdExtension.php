<?php


namespace Klimesf\NetteRequestId\DI;

use Klimesf\NetteRequestId\Generator;
use Klimesf\NetteRequestId\Provider;
use Nette;
use Nette\DI\CompilerExtension;

/**
 * @package   Klimesf\NetteRequestId\DI
 * @author    Filip Klimes <filip@filipklimes.cz>
 */
class NetteRequestIdExtension extends CompilerExtension
{

	protected $defaults = [
		"generator" => Generator::class,
	];

	public function loadConfiguration()
	{
		$config = $this->validateConfig($this->defaults);
		$container = $this->getContainerBuilder();

		$container->addDefinition($this->prefix('generator'))
			->setClass($config['generator']);

		$container->addDefinition($this->prefix('provider'))
			->setClass(Provider::class, ['@' . $this->prefix('generator')]);
	}

	public function afterCompile(Nette\PhpGenerator\ClassType $class)
	{
		$initialize = $class->methods['initialize'];
		$initialize->addBody('$this->getService(?)->onRequest[] = function() {
			$this->getService(?)->generateId();
		};', ['nette.application.application', $this->prefix('provider')]);
	}

}
