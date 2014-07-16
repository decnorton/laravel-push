<?php namespace Dec\Push\Models;

use Dec\Push\Collection\DeviceCollection;

interface PushResponse {

    /**
     * @param Message $message
     * @return self
     */
    public function setMessage(Message $message);

    /**
     * @return Message
     */
    public function getMessage();

    /**
     * @param DeviceCollection $devices
     * @return self
     */
    public function setDevices(DeviceCollection $devices);

    /**
     * @return DeviceCollection
     */
    public function getDevices();

    /**
     * @return bool
     */
    public function success();

    /**
     * @return bool
     */
    public function failed();


} 