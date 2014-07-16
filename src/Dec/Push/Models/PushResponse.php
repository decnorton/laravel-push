<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 15/07/2014
 * Time: 21:33
 */

namespace Dec\Models;


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