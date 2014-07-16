<?php namespace Dec\Push\Models;

interface Message {

    /**
     * Get the message content
     * @return string
     */
    public function getContent();

    /**
     * Set content
     * @param $content
     */
    public function setContent(array $content);

    /**
     * @return array
     */
    public function getParameters();

    /**
     * @param array $parameters
     * @return mixed
     */
    public function setParameters(array $parameters);

    /**
     * Returns the request body
     * @return array
     */
    public function getBody();

} 