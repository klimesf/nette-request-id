<?php


namespace Klimesf\NetteRequestId;

/**
 * Provides unique HTTP request ID.
 * @package   Klimesf\NetteRequestId
 * @author    Filip Klimes <filip@filipklimes.cz>
 */
class Provider
{

	/** @var string */
	private $requestId;

	/** @var IGenerator */
	private $idGenerator;

	/**
	 * Provider constructor.
	 * @param IGenerator $idGenerator
	 */
	public function __construct(IGenerator $idGenerator)
	{
		$this->idGenerator = $idGenerator;
	}

	/**
	 * Generates the Request ID via IGenerator.
	 * @internal
	 */
	public function generateId()
	{
		$this->requestId = $this->idGenerator->generate();
	}

	/**
	 * Returns the Request ID.
	 * @return string
	 */
	public function getRequestId()
	{
		return $this->requestId;
	}

}
