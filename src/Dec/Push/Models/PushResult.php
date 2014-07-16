<?php namespace Dec\Push\Models;

class PushResult {

    /**
     * @var array
     */
    private $responses;

    /**
     * @var array
     */
    private $successful;

    /**
     * @var array
     */
    private $failed;

    function __construct($responses, $successful, $failed)
    {
        $this->responses = $responses;
        $this->successful = $successful;
        $this->failed = $failed;
    }

    /**
     * @return array
     */
    public function getResponses()
    {
        return $this->responses;
    }

    /**
     * @return array
     */
    public function getSuccessful()
    {
        return $this->successful;
    }

    /**
     * @return array
     */
    public function getFailed()
    {
        return $this->failed;
    }

} 