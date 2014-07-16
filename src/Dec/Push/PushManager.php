<?php namespace Dec\Push;

use Dec\Push\Adapters\Adapter;
use Dec\Push\Models\PushNotification;
use Illuminate\Support\Collection;

class PushManager extends Collection {

    const ENV_DEVELOPMENT = 'development';
    const ENV_PRODUCTION = 'production';

    private $environment;

    private $validEnvironments = [
        self::ENV_DEVELOPMENT,
        self::ENV_PRODUCTION
    ];
    /**
     * @var Adapter
     */
    private $adapter;

    function __construct(Adapter $adapter, $environment = self::ENV_PRODUCTION)
    {
        if ( ! in_array($environment, $this->validEnvironments))
            throw new \InvalidArgumentException('Not a valid environment');

        $this->adapter = $adapter;
        $this->environment = $environment;

        $this->adapter->setEnvironment($this->getEnvironment());
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
     * @param PushNotification $push
     */
    public function add(PushNotification $push)
    {
        if ( ! empty($push))
            $this->items[] = $push;
    }

    /**
     * Alias for add()
     * @param PushNotification $push
     */
    public function queue(PushNotification $push)
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
            if ($push instanceof PushNotification)
            {
                if ($result = $this->adapter->push($push))
                    $results[(string) $push] = $result;
            }
        }

        return $results;
    }

} 