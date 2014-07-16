<?php namespace Dec\Push\Adapters;

use Dec\Collection\DeviceCollection;
use Dec\Push\Models\MessageInterface;
use Dec\Push\Models\PushInterface;

/**
 * AdapterInterface.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface AdapterInterface {

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
     * @param PushInterface $push Push
     */
    public function push(PushInterface $push);

    /**
     * Check if valid token
     *
     * @return boolean
     */
    public function isValidToken($token);


    /**
     * @param $content
     * @param $parameters
     * @return MessageInterface
     */
    public function createMessage($content, $parameters);

    /**
     * @param DeviceCollection $devices
     * @param MessageInterface $message
     * @return PushInterface
     */
    public function createPush(DeviceCollection $devices, MessageInterface $message);

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
