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
class CannotFindUserException extends AbstractCommonsException
{

    /**
     * @var string
     */
    protected $defaultMessage = 'Cannot find the user. I looked at session and token and object, but no luck :(';

    /**
     * @param \Illuminate\Http\Request
     *
     * @return mixed
     */
    public function render($request) {
        $message = $this->getMessage();

        $message = $this->defaultMessage . ' Here is an additional message, that may solve your problem: ' . $message;

        return response()->api()->errorUnprocessable( $message ?: $this->defaultMessage );
    }

}