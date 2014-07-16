<?php namespace Dec\Push\Adapters;

abstract class BaseAdapter implements AdapterInterface {

    /**
     * @var string
     */
    private $environment;


    /**
     * @param $environment
     * @return string
     */
    public function setEnvironment($environment)
    {
        $this->environment = $environment;
    }

    /**
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }


}