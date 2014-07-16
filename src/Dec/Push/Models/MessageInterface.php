<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 14/07/2014
 * Time: 23:46
 */

namespace Dec\Models;

interface MessageInterface {

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

} 