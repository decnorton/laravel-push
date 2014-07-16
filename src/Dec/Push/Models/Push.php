<?php namespace Dec\Push\Models;

use DateTime;
use Dec\Collection\DeviceCollection;
use Dec\Push\Adapters\AdapterInterface;
use Dec\Push\Models\PushInterface;

class Push implements PushInterface {

    protected $validStatuses = [
        PushInterface::STATUS_PENDING,
        PushInterface::STATUS_SENDING,
        PushInterface::STATUS_SENT
    ];

    /**
     * @var string
     */
    private $status;

    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var DateTime
     */
    private $timestamp;

    /**
     * @var DeviceCollection
     */
    private $devices;

    /**
     * @param DeviceCollection $devices
     * @param MessageInterface $message
     */
    function __construct(DeviceCollection $devices, MessageInterface $message)
    {
        $this->devices = $devices;
        $this->message = $message;
    }

    /**
     * Helper method for creating a Push
     * @param $devices
     * @param $message
     * @param array $parameters
     * @return Push
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

            $message = new Message($message, $parameters);
        }

        return new Push($devices, $message);
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
        return $this->status === PushInterface::STATUS_PENDING;
    }

    /**
     * Has the push been sent?
     * @return bool
     */
    public function sent()
    {
        return $this->status === PushInterface::STATUS_SENT;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param MessageInterface $message
     * @return PushInterface
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * @return DeviceCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * @param DeviceCollection $devices
     * @return PushInterface
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
     * @return PushInterface
     */
    public function setSentAt(DateTime $timestamp)
    {
        $this->timestamp = $timestamp;
    }

} 