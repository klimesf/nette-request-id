<?php

use Klimesf\NetteRequestId\DI\NetteRequestIdExtension;
use Tester\Assert;
use Nette\DI;

require __DIR__ . '/../../bootstrap.php';

define('ID', 'my-request-id');




class MyGenerator implements \Klimesf\NetteRequestId\IGenerator
{
	public function generate()
	{
		return ID;
	}
}

class MyRouter implements \Nette\Application\IRouter
{
	function match(Nette\Http\IRequest $httpRequest)
	{
		throw new \LogicException("Method match() not implemented.");
	}

	function constructUrl(\Nette\Application\Request $appRequest, Nette\Http\Url $refUrl)
	{
		throw new \LogicException("Method constructUrl() not implemented.");
	}
}

class MyRequest implements \Nette\Http\IRequest
{
	function getUrl()
	{
		throw new \LogicException("Method getUrl() not implemented.");
	}

	function getQuery($key = null, $default = null)
	{
		throw new \LogicException("Method getQuery() not implemented.");
	}

	function getPost($key = null, $default = null)
	{
		throw new \LogicException("Method getPost() not implemented.");
	}

	function getFile($key)
	{
		throw new \LogicException("Method getFile() not implemented.");
	}

	function getFiles()
	{
		throw new \LogicException("Method getFiles() not implemented.");
	}

	function getCookie($key, $default = null)
	{
		throw new \LogicException("Method getCookie() not implemented.");
	}

	function getCookies()
	{
		throw new \LogicException("Method getCookies() not implemented.");
	}

	function getMethod()
	{
		throw new \LogicException("Method getMethod() not implemented.");
	}

	function isMethod($method)
	{
		throw new \LogicException("Method isMethod() not implemented.");
	}

	function getHeader($header, $default = null)
	{
		throw new \LogicException("Method getHeader() not implemented.");
	}

	function getHeaders()
	{
		throw new \LogicException("Method getHeaders() not implemented.");
	}

	function isSecured()
	{
		throw new \LogicException("Method isSecured() not implemented.");
	}

	function isAjax()
	{
		throw new \LogicException("Method isAjax() not implemented.");
	}

	function getRemoteAddress()
	{
		throw new \LogicException("Method getRemoteAddress() not implemented.");
	}

	function getRemoteHost()
	{
		throw new \LogicException("Method getRemoteHost() not implemented.");
	}

	function getRawBody()
	{
		throw new \LogicException("Method getRawBody() not implemented.");
	}
}

class MyResponse implements \Nette\Http\IResponse
{
	function setCode($code)
	{
		throw new \LogicException("Method setCode() not implemented.");
	}

	function getCode()
	{
		throw new \LogicException("Method getCode() not implemented.");
	}

	function setHeader($name, $value)
	{
		throw new \LogicException("Method setHeader() not implemented.");
	}

	function addHeader($name, $value)
	{
		throw new \LogicException("Method addHeader() not implemented.");
	}

	function setContentType($type, $charset = null)
	{
		throw new \LogicException("Method setContentType() not implemented.");
	}

	function redirect($url, $code = self::S302_FOUND)
	{
		throw new \LogicException("Method redirect() not implemented.");
	}

	function setExpiration($seconds)
	{
		throw new \LogicException("Method setExpiration() not implemented.");
	}

	function isSent()
	{
		throw new \LogicException("Method isSent() not implemented.");
	}

	function getHeader($header, $default = null)
	{
		throw new \LogicException("Method getHeader() not implemented.");
	}

	function getHeaders()
	{
		throw new \LogicException("Method getHeaders() not implemented.");
	}

	function setCookie($name, $value, $expire, $path = null, $domain = null, $secure = null, $httpOnly = null)
	{
		throw new \LogicException("Method setCookie() not implemented.");
	}

	function deleteCookie($name, $path = null, $domain = null, $secure = null)
	{
		throw new \LogicException("Method deleteCookie() not implemented.");
	}
}



$compiler = new DI\Compiler;
$compiler->addExtension('requestId', new NetteRequestIdExtension());
$compiler->addExtension('nette.application', new \Nette\Bridges\ApplicationDI\ApplicationExtension());
$compiler->addConfig([
	"services" => [
		MyRouter::class,
		MyRequest::class,
		MyResponse::class,
	],
	"requestId" => [
		"generator" => MyGenerator::class, // Custom generator
	]
]);

//file_put_contents('container.php', $compiler->compile([], 'Container'));
eval($compiler->compile([], 'Container'));
$container = new Container();
$container->initialize();

$provider = $container->getService('requestId.provider');
Assert::null($provider->getRequestId());

// Generate id via Application::onRequest event
$application = $container->getService('nette.application.application');
$application->onRequest($application, $request = new \Nette\Http\Request(new \Nette\Http\UrlScript()));

Assert::same(ID, $provider->getRequestId());
