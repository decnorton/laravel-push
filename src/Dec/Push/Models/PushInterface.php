<?php namespace Dec\Push\Models;

use DateTime;
use Dec\Collection\DeviceCollection;
use Dec\Models\MessageInterface;
use Dec\Push\Adapters\AdapterInterface;

interface PushInterface {

    const STATUS_PENDING = 'pending';
    const STATUS_SENDING = 'sending';
    const STATUS_SENT = 'sent';

    /**
     * @return string
     */
    public function getStatus();

    /**
     * @param string $status
     */
    public function setStatus($status);

    /**
     * Is the push waiting to be sent?
     * @return bool
     */
    public function pending();

    /**
     * Has the push been sent?
     * @return bool
     */
    public function sent();

    /**
     * @return AdapterInterface
     */
    public function getAdapter();

    /**
     * @param AdapterInterface $adapter
     * @return PushInterface
     */
    public function setAdapter(AdapterInterface $adapter);

    /**
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * @param MessageInterface $message
     * @return PushInterface
     */
    public function setMessage(MessageInterface $message);

    /**
     * @return DeviceCollection
     */
    public function getDevices();

    /**
     * @param DeviceCollection $devices
     * @return PushInterface
     */
    public function setDevices(DeviceCollection $devices);

    /**
     * @return DateTime
     */
    public function getSentAt();

    /**
     * @param DateTime $timestamp
     * @return PushInterface
     */
    public function setSentAt(DateTime $timestamp);

}