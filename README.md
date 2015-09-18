# nette-request-id
Extension for Nette Framework which assigns a unique identifier to each HTTP request.

[![Build Status](https://travis-ci.org/klimesf/nette-request-id.svg)](https://travis-ci.org/klimesf/nette-request-id)
[![Latest stable](https://img.shields.io/packagist/v/klimesf/nette-request-id.svg)](https://packagist.org/packages/klimesf/nette-request-id)

Requirements
------------

Klimesf/NetteRequestId requires PHP 5.5 or higher.

- [Nette Framework](https://github.com/nette/nette)
- [Rhumsaa\UUID for PHP](https://github.com/ramsey/uuid)


Installation
------------

The best way to install Klimesf\NetteRequestId is using  [Composer](http://getcomposer.org/):

```sh
$ composer require klimesf/nette-request-id
```


Configuration
-------------

Register the extension in your `config.neon`:

```yml
extensions:
	requestId: Klimesf\NetteRequestId\DI\NetteRequestIdExtension
```

You can provide your own Request ID generator in the config file:

```yml
requestId:
	generator: My\Own\Generator
```


Monolog Integration
-------------------

The typical use-case for request ids is logging. If you use [Kdyby\Monolog](https://github.com/kdyby/monolog), you
can write your own processor.

```php
namespace My\Own;

use Klimesf\NetteRequestId\Provider;

class MonologProcessor
{

	/** @var Provider */
	private $requestIdProvider;

	public function __constructor(Provider $requestIdProvider)
	{
		$this->requestIdProvider = $requestIdProvider;
	}

	public function __invoke(array $record)
	{
		$record['extra']['request_id'] = $this->provider->getRequestId();
		return $record;
	}

}
```

Then register the processor in Kdyby\Monolog configuration:

```yml
monolog:
	processors:
		- My\Own\MonologProcessor
```
