<?php


namespace Klimesf\NetteRequestId;

/**
 * Generates unique Request ID.
 * @package   Klimesf\NetteRequestId
 * @author    Filip Klimes <filip@filipklimes.cz>
 */
interface IGenerator
{

	/**
	 * Generates unique Request ID.
	 * @return string
	 */
	public function generate();

}
