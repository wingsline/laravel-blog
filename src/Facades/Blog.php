<?php

namespace Wingsline\Blog\Facades;

use Illuminate\Support\Facades\Facade;

class Blog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'blog';
    }
}
