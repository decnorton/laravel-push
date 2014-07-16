<?php namespace Dec\Push\Models;

use DateTime;
use Dec\Push\Collection\DeviceCollection;

interface PushNotification {

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
     * @return Message
     */
    public function getMessage();

    /**
     * @param Message $message
     * @return PushNotification
     */
    public function setMessage(Message $message);

    /**
     * @return DeviceCollection
     */
    public function getDevices();

    /**
     * @param \Dec\Push\Collection\DeviceCollection $devices
     * @return PushNotification
     */
    public function setDevices(DeviceCollection $devices);

    /**
     * @return DateTime
     */
    public function getSentAt();

    /**
     * @param DateTime $timestamp
     * @return PushNotification
     */
    public function setSentAt(DateTime $timestamp);

    public function __toString();

}