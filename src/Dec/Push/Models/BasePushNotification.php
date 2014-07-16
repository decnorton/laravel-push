<?php namespace Dec\Push\Models;

use DateTime;
use Dec\Push\Collection\DeviceCollection;

abstract class BasePushNotification implements PushNotification {

    protected $validStatuses = [
        PushNotification::STATUS_PENDING,
        PushNotification::STATUS_SENDING,
        PushNotification::STATUS_SENT
    ];

    /**
     * @var string
     */
    private $status;

    /**
     * @var Message
     */
    private $message;

    /**
     * @var DateTime
     */
    private $timestamp;

    /**
     * @var \Dec\Push\Collection\DeviceCollection
     */
    private $devices;

    /**
     * @param \Dec\Push\Collection\DeviceCollection $devices
     * @param Message $message
     */
    function __construct(DeviceCollection $devices, Message $message)
    {
        $this->devices = $devices;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        if ( ! in_array($status, $this->validStatuses))
            throw new \InvalidArgumentException('Not a valid status');

        $this->status = $status;
    }

    /**
     * Is the push waiting to be sent?
     * @return bool
     */
    public function pending()
    {
        return $this->status === PushNotification::STATUS_PENDING;
    }

    /**
     * Has the push been sent?
     * @return bool
     */
    public function sent()
    {
        return $this->status === PushNotification::STATUS_SENT;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param Message $message
     * @return PushNotification
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
    }

    /**
     * @return \Dec\Push\Collection\DeviceCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param \Dec\Push\Collection\DeviceCollection $devices
     * @return PushNotification
     */
    public function setDevices(DeviceCollection $devices)
    {
        $this->devices = $devices;
    }

    /**
     * @return DateTime
     */
    public function getSentAt()
    {
        return $this->timestamp;
    }

    /**
     * @param DateTime $timestamp
     * @return PushNotification
     */
    public function setSentAt(DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }

} 