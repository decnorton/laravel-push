<?php namespace Dec\Push\Models;

use Config;
use Dec\Collection\DeviceCollection;
use Dec\Push\Adapters\AdapterInterface;
use Dec\Push\Exceptions\InvalidAppException;
use Dec\Push\Exceptions\InvalidPushServiceException;
use Dec\Push\PushManager;

class App {

    /**
     * @var array
     */
    protected $config;

    /**
     * @var PushManager
     */
    protected $pushManager;

    /**
     * @var AdapterInterface
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

        $this->pushManager = new PushManager($environment);

        $adapterName = isset($this->config['adapter'])
            ? $this->config['adapter']
            : $this->getAdapterClass($this->config['service']);

        $this->validateAdapter($adapterName);

        $this->adapter = $this->createAdapter($adapterName, $this->config);
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
     * @param PushInterface $push
     * @return $this
     */
    public function queue(PushInterface $push)
    {
        $this->pushManager->add($push);

        return $this;
    }

    /**
     * Queue Push if present and process queue
     * @param PushInterface $push
     * @return array
     */
    public function send(PushInterface $push = null)
    {
        if ($push)
            $this->queue($push);

        return $this->pushManager->send();
    }

    /**
     * Alias for send()
     * @param PushInterface $push
     * @return array
     */
    public function push(PushInterface $push = null)
    {
        return $this->send($push);
    }

}