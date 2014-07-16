<?php namespace Dec\Push\Models;

interface PushResponse {

    /**
     * @return bool
     */
    public function success();

    /**
     * @return bool
     */
    public function failed();


} 