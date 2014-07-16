<?php namespace Dec\Push\Models;


class Message implements MessageInterface {

    /**
     * @var array
     */
    private $parameters = [];

    /**
     * @var array
     */
    private $content;

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

    /**
     * Set content
     * @param $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

} 