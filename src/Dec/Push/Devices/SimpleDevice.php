<?php namespace Dec\Push\Devices;

class SimpleDevice implements Device {

    /**
     * @var string
     */
    private $token;

    function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @param $token
     * @return Device
     */
    public static function withToken($token)
    {
        return new SimpleDevice($token);
    }

}