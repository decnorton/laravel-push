<?php namespace Dec\Push\Adapters;

use Dec\Push\Models\PushInterface;

/**
 * AdapterInterface.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface AdapterInterface
{

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
