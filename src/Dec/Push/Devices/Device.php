<?php namespace Dec\Push\Devices;

interface Device {

    /**
     * Get device token
     * @return string
     */
    public function getToken();

    /**
     * Set device token
     * @param string $token
     */
    public function setToken($token);

    /**
     * @param $token
     * @return Device
     */
    public static function withToken($token);

}