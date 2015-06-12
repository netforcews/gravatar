<?php namespace NetForce\Gravatar\Facades;

class Gravatar extends \Illuminate\Support\Facades\Facade
{
    protected static function getFacadeAccessor()
    {
        return 'gravatar';
    }
}