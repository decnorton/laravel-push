<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 17/07/2014
 * Time: 00:13
 */

namespace Dec\Push\Gcm\Exceptions;


class GcmServerException extends GcmException {

    public function __construct($statusCode)
    {
        parent::__construct("Internal server error. You should try again.", $statusCode);
    }

}