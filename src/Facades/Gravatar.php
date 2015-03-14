<?php namespace NetForce\Common\Gravatar\Facades;

class Gravatar extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }
}