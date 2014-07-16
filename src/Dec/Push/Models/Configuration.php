<?php namespace Dec\Push\Models;

use Config;
use Dec\Push\Collection\DeviceCollection;
use Dec\Push\Adapters\Adapter;
use Dec\Push\Exceptions\InvalidAppException;
use Dec\Push\Exceptions\InvalidPushServiceException;
use Dec\Push\PushManager;

class Configuration {

    /**
     * @var array
     */
    protected $config;

    /**
     * @var PushManager
     */
    protected $pushManager;

    /**
     * @var Adapter
     */
    protected $adapter;

    public function __construct($name)
    {
        if ( ! Config::has("push::{$name}"))
            throw new InvalidAppException("Configuration '{$name}' doesn't exist");

        $this->config = Config::get("push::{$name}");

        $environment = (bool) $this->config['development']
                ? PushManager::ENV_DEVELOPMENT
                : PushManager::ENV_PRODUCTION;

        $adapterName = isset($this->config['adapter'])
            ? $this->config['adapter']
            : $this->getAdapterClass($this->config['service']);

        // Check if it's a valid adapter
        $this->validateAdapter($adapterName);

        // Create the adapter
        $this->adapter = $this->createAdapter($adapterName, $this->config);

        // Create the PushManager
        $this->pushManager = new PushManager($this->adapter, $environment);
    }

    private function getAdapterClass($name)
    {
        return 'Dec\\Push\\Adapters\\' . ucfirst($name) . 'Adapter';
    }

    private function validateAdapter($name)
    {
        if ( ! class_exists($name))
            throw new InvalidPushServiceException("'{$name}' is not a valid adapter");
    }

    private function createAdapter($name, $config)
    {
        return new $name($config);
    }

    /**
     * @param PushNotification $push
     * @return $this
     */
    public function queue(PushNotification $push)
    {
        $this->pushManager->add($push);

        return $this;
    }

    /**
     * Queue Push if present and process queue
     * @param PushNotification $push
     * @return array
     */
    public function send(PushNotification $push = null)
    {
        if ($push)
            $this->queue($push);

        return $this->pushManager->send();
    }

    /**
     * Alias for send()
     * @param PushNotification $push
     * @return array
     */
    public function push(PushNotification $push = null)
    {
        return $this->send($push);
    }

}