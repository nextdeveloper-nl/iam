<?php
/**
 * This file is part of the PlusClouds.Core library.
 *
 * (c) Semih Turna <semih.turna@plusclouds.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace  NextDeveloper\IAM\Exceptions;

use NextDeveloper\Commons\Exceptions\AbstractCommonsException;

/**
 * Class ModelNotFoundException
 * @package  NextDeveloper\Commons\Exceptions
 */
class CannotFindAccountException extends AbstractCommonsException
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
