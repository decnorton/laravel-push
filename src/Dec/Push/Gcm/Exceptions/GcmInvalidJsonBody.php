<?php namespace Dec\Push\Gcm\Exceptions;


class GcmInvalidJsonBody extends GcmException {

    /**
     * @var array
     */
    private $body;

    /**
     * @param int $statusCode
     * @param array $body
     */
    function __construct($statusCode, array $body)
    {
        parent::__construct($statusCode, "InvalidJson");

        $this->body = $body;
    }

    /**
     * @return array
     */
    public function getBody()
    {
        return $this->body;
    }

}