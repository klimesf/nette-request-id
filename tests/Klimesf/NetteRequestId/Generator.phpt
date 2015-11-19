<?php

use Klimesf\NetteRequestId\Generator;
use Ramsey\Uuid\Uuid;
use Tester\Assert;

require __DIR__ . '/../../bootstrap.php';

$generator = new Generator();

Assert::true(Uuid::isValid($generator->generate()));
