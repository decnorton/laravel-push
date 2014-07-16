<?php
/**
 * Created by PhpStorm.
 * User: decnorton
 * Date: 15/07/2014
 * Time: 00:26
 */

namespace Dec\Models;


interface ResponseInterface {

    public function success();
    public function error();

} 