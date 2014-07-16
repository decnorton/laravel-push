<?php namespace Dec\Push\Models;

interface DeviceInterface {

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

}