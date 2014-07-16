<?php namespace Dec\Push;

use Config;
use Dec\Push\Models\Configuration;
use Dec\Push\Gcm\GcmNotification;

class Push {

    function __construct()
    {
        $deviceModel = Config::get('push::device_model', 'SimpleDevice');

        if ( ! in_array('Dec\Push\Devices\Device', class_implements($deviceModel)))
            throw new \InvalidArgumentException("{$deviceModel} doesn't implement Dec\\Push\\Devices\\Device");
    }

    /**
     * @param $name
     * @return \Dec\Push\Models\Configuration
     */
    public function app($name)
    {
        return new Configuration($name);
    }

    /**
     * @return \Dec\Push\Gcm\GcmNotification
     */
    public function createGcmNotification()
    {
        return call_user_func_array(['\Dec\Push\Gcm\GcmNotification', 'create'], func_get_args());
    }

}