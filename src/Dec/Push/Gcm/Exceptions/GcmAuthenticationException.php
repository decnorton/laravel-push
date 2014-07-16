<?php namespace Dec\Push\Gcm\Exceptions;

class GcmAuthenticationException extends GcmException {

    public function __construct()
    {
        parent::__construct("Possible causes:\n"
            . "- Authorization header missing or with invalid syntax\n"
            . "-Invalid project number sent as key\n"
            . "- Key valid but with GCM service disabled\n"
            . "- Request originated from a server not whitelisted in the Server Key IPs", 401);
    }

}