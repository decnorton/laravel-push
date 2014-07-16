<?php namespace Dec\Push;

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

    /**
     * Adds a Push to the queue
     * @param PushInterface $push
     */
    public function add(PushInterface $push)
    {
        if ( ! empty($push))
            $this->items[] = $push;
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
     * @return array
     */
    public function send()
    {
        $results = [];

        foreach ($this as $push)
        {
            if ($push instanceof PushInterface)
            {
                $adapter = $push->getAdapter();
                $adapter->setEnvironment($this->getEnvironment());

                if ($result = $adapter->push($push))
                    $results[] = $result;
            }
        }

        return $results;
    }

} 