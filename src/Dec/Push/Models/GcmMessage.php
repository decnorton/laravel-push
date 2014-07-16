<?php namespace Dec\Push\Models;


class GcmMessage implements MessageInterface {

    /**
     * @var array
     */
    private $content;

    /**
     * @var array
     */
    private $parameters;

    function __construct($content, $parameters)
    {
        $this->content = $content;
        $this->parameters = $parameters;
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
     * @param array $content
     */
    public function setContent(array $content)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getCollapseKey()
    {
        return $this->parameters['collapse_key'];
    }

    /**
     * @param string $collapseKey
     */
    public function setCollapseKey($collapseKey)
    {
        $this->parameters['collapse_key'] = $collapseKey;
    }

    /**
     * @return bool
     */
    public function getDelayWhileIdle()
    {
        return $this->parameters['delay_while_idle'];
    }

    /**
     * @param bool $delayWhileIdle
     */
    public function setDelayWhileIdle($delayWhileIdle)
    {
        $this->parameters['delay_while_idle'] = $delayWhileIdle;
    }

    /**
     * @return int
     */
    public function getTtl()
    {
        return $this->parameters['ttl'];
    }

    /**
     * @param int $ttl
     */
    public function setTtl($ttl)
    {
        $this->parameters['ttl'] = $ttl;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;
    }


} 