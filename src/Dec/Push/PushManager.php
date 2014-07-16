<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 15/07/2014
 * Time: 22:23
 */

namespace Dec;

use Dec\Push\Models\PushInterface;
use Illuminate\Support\Collection;

class PushManager extends Collection {

    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION = 'production';

    private $environment;

    private $validEnvironments = [
        self::ENV_DEVELOPMENT,
        self::ENV_PRODUCTION
    ];

    function __construct($environment = self::ENV_PRODUCTION)
    {
        if ( ! in_array($environment, $this->validEnvironments))
            throw new \InvalidArgumentException('Not a valid environment');

        $this->environment = $environment;
    }

    /**
     * Alias for add()
     * @param PushInterface $push
     */
    public function queue(PushInterface $push)
    {
        $this->add($push);
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * @param string $environment
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    public function add(PushInterface $push)
    {
        $this->items[] = $push;
    }

    public function send()
    {
        $results = [];

        foreach ($this as $push)
        {
            $adapter = $push->getAdapter();
            $adapter->setEnvironment($this->getEnvironment());

            if ($result = $adapter->push($push))
            {
                $results[] = $result;
            }
        }

        return $results;
    }

} 