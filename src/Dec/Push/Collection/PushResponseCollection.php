<?php namespace Dec\Push\Collection;

use Dec\Push\Models\PushNotification;
use Illuminate\Support\Collection;

class PushResponseCollection extends Collection {

    /**
     * The original Notification
     * @var PushNotification
     */
    private $push;

    function __construct(PushNotification $push, array $responses)
    {
        parent::__construct($responses);

        $this->push = $push;
    }

    /**
     * @return array
     */
    public function getSuccessful()
    {
        $out = [];

        foreach ($this as $response)
        {
            $out = array_merge($out, $response->getSuccessful());
        }

        return $out;
    }

    /**
     * @return array
     */
    public function getFailed()
    {
        $out = [];

        foreach ($this as $response)
        {
            $out = array_merge($out, $response->getFailed());
        }

        return $out;
    }

} 