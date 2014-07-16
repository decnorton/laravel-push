<?php namespace Dec\Push\Models;


use Illuminate\Support\Contracts\ArrayableInterface;

abstract class BaseMessage implements Message, ArrayableInterface {

    /**
     * @var array
     */
    private $content;

    /**
     * @var array
     */
    private $parameters = [];

    function __construct(array $content, $parameters)
    {
        $this->content = $content;
        $this->parameters = $parameters;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters = [])
    {
        $this->parameters = $parameters;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get the message content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }

    public function getParameter($key)
    {
        return $this->parameters[$key];
    }

    /**
     * Set content
     * @param $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getBody();
    }

} 