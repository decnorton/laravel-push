<?php namespace Dec\Push\Models;


use Dec\Push\Collection\DeviceCollection;
use Illuminate\Support\Contracts\ArrayableInterface;

abstract class BasePushResponse implements PushResponse, ArrayableInterface {

    /**
     * @var Message
     */
    protected $message;

    /**
     * @var DeviceCollection
     */
    protected $devices;

    public function __construct(DeviceCollection $devices, Message $message)
    {
        $this->devices = $devices;
        $this->message = $message;
    }

    /**
     * @param DeviceCollection $devices
     * @return self
     */
    public function setDevices(DeviceCollection $devices)
    {
        $this->devices = $devices;
    }

    /**
     * @return DeviceCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param Message $message
     * @return self
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'message' => $this->message->getBody()
        ];
    }

}