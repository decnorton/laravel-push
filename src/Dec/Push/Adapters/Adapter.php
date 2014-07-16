<?php namespace Dec\Push\Adapters;

use Dec\Push\Collection\DeviceCollection;
use Dec\Push\Models\Message;
use Dec\Push\Models\PushNotification;

/**
 * AdapterInterface.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface Adapter {

    /**
     * @param $environment
     * @return string
     */
    public function setEnvironment($environment);

    /**
     * @return string
     */
    public function getEnvironment();

    /**
     * Send the push
     *
     * @param PushNotification $push Push
     */
    public function push(PushNotification $push);

    /**
     * Check if valid token
     *
     * @return boolean
     */
    public function isValidToken($token);


    /**
     * @param $content
     * @param $parameters
     * @return Message
     */
    public function createMessage($content, $parameters);

    /**
     * @param DeviceCollection $devices
     * @param Message $message
     * @return PushNotification
     */
    public static function createPush(DeviceCollection $devices, Message $message);

    /**
     * Get default parameters.
     *
     * @return array
     */
    public function getDefaultConfig();

    /**
     * Get required parameters.
     *
     * @return array
     */
    public function getRequiredConfig();

}
