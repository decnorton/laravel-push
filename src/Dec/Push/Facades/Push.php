<?php namespace Dec\Push\Facades;

class Push extends \Illuminate\Support\Facades\Facade {

    /**
    * Get the registered name of the component.
    *
    * @return string
    */
    protected static function getFacadeAccessor()
    {
        return 'push';
    }

}