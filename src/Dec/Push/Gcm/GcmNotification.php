<?php namespace Dec\Push\Gcm;

use Dec\Push\Collection\DeviceCollection;
use Dec\Push\Gcm\GcmMessage;
use Dec\Push\Models\BasePushNotification;
use Dec\Push\Models\PushNotification;

class GcmNotification extends BasePushNotification implements PushNotification {

    /**
     * Helper method for creating a Push
     * @param $devices
     * @param $message
     * @param array $parameters
     * @return BasePushNotification
     */
    public static function create($devices, $message, $parameters = [])
    {
        if ( ! is_a($devices, 'DeviceCollection'))
        {
            if (! is_array($devices))
                throw new \InvalidArgumentException('First parameter must be a DeviceCollection or array of DeviceInterfaces');

            $devices = new DeviceCollection($devices);
        }

        if ( ! is_a($message, 'MessageInterface'))
        {
            if ( ! is_array($message))
                throw new \InvalidArgumentException('Second parameter must be an instance of MessageInterface or an array');

            $message = new GcmMessage($message, $parameters);
        }

        return new GcmNotification($devices, $message);
    }

    public function __toString()
    {
        return spl_object_hash($this);
    }


} 