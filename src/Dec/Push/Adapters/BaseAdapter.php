<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 14/07/2014
 * Time: 23:54
 */

namespace Dec\Adapters;


use Dec\Push\Adapters\AdapterInterface;

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