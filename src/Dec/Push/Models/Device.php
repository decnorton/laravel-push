<?php namespace Dec\Push\Models;


class Device extends \Eloquent implements DeviceInterface {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'devices';


    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

}