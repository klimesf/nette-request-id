<?php


namespace Klimesf\NetteRequestId;

use Rhumsaa\Uuid\Uuid;

/**
 * Generates uuid1 Request ID.
 * @package   Klimesf\NetteRequestId
 * @author    Filip Klimes <filip@filipklimes.cz>
 */
class Generator implements IGenerator
{

	/**
	 * Generates unique Request ID.
	 * @return string
	 */
	public function generate()
	{
		return Uuid::uuid1()->toString();
	}

}
