<?php namespace Dec\Push\Models;

use Config;
use Dec\Collection\DeviceCollection;
use Dec\Push\Exceptions\InvalidAppException;
use Dec\Push\Exceptions\InvalidPushServiceException;
use Dec\Push\Models\DeviceInterface;
use Dec\PushManager;

class App {

    protected $config;
    protected $pushManager;
    protected $adapter;
    protected $devices;

    public function __construct($name)
    {
        dd('boobs');

        if ( ! Config::has("push::{$name}"))
            throw new InvalidAppException("Configuration '{$name}' doesn't exist");

        $this->config = Config::get("push::{$name}");

        $environment = (bool) $this->config['development']
                ? PushManager::ENV_DEVELOPMENT
                : PushManager::ENV_PRODUCTION;

        $this->pushManager = new PushManager($environment);

        $adapterName = $this->getAdapterClass($this->config['service']);

        $this->validateAdapter($adapterName);

        $this->adapter = $this->createAdapter($adapterName);
    }

    private function getAdapterClass($name)
    {
        return 'Sly\\NotificationPusher\\Adapter\\' . ucfirst($name);
    }

    private function validateAdapter($name)
    {
        if ( ! class_exists($name))
            throw new InvalidPushServiceException("'{$name}' is not a valid adapter");
    }

    private function createAdapter($name)
    {
        return new $name();
    }

    public function to($devices)
    {
        if ($devices instanceof DeviceInterface)
        {
            $this->devices = new DeviceCollection([$devices]);
        }
        else if ($devices instanceof DeviceCollection)
        {
            $this->devices = $devices;
        }

        return $this;
    }

    public function queue($content, $parameters = [])
    {
        if ( ! is_a($content, 'Message'))
            $content = new Message($content, $parameters);


        $push = new Push(
            $this->adapter,
            $this->devices,
            $content
        );

        $this->pushManager->add($push);

        return $this;
    }

    /**
     * @param mixed $message
     * @param array $options
     * @return array
     */
    public function send($message = null, $options = [])
    {
        if ($message)
            $this->queue($message, $options);

        return $this->pushManager->send();
    }

}