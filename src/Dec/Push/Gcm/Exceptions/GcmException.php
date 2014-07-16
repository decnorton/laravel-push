<?php namespace Dec\Push\Gcm\Exceptions;


class GcmException extends \Exception {

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $errorMessage;

    /**
     * @param int $statusCode
     * @param string $errorMessage
     */
    function __construct($message, $statusCode, $errorMessage = null)
    {
        parent::__construct($message, $statusCode);

        $this->statusCode = (int) $statusCode;
        $this->errorMessage = $errorMessage;
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

}