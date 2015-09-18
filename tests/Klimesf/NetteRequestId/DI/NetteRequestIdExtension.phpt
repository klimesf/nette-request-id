<?php

use Klimesf\NetteRequestId\DI\NetteRequestIdExtension;
use Klimesf\NetteRequestId\IGenerator;
use Klimesf\NetteRequestId\Provider;
use Nette\DI;
use Tester\Assert;

require __DIR__ . '/../../../bootstrap.php';

$compiler = new DI\Compiler;
$compiler->addExtension('requestId', new NetteRequestIdExtension());

eval($compiler->compile([], 'Container'));
$container = new Container();

Assert::type(IGenerator::class, $container->getService('requestId.generator'));
Assert::type(Provider::class, $container->getService('requestId.provider'));
