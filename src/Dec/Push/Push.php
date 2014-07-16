<?php namespace Dec\Push;

use Dec\Models\App;

class Push {

    public function app($name)
    {
        return new App($name);
    }

    public function newMessage()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Message'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newDevice()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Device'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newDeviceCollection()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Collection\DeviceCollection'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newPushManager()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\PushManager'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newApnsAdapter()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Adapter\ApnsAdapter'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newGcmAdapter()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Model\GcmAdapter'));
        return $instance->newInstanceArgs(func_get_args());
    }

    public function newPush()
    {
        $instance = (new \ReflectionClass('Sly\NotificationPusher\Model\Push'));
        return $instance->newInstanceArgs(func_get_args());
    }

}