<?php

namespace middleware;

use core\Auth;
use core\middleware\IMiddleware;
use core\Redirect;

class IsAuthenticatedMiddleware implements IMiddleware
{
    public function next()
    {
        if (Auth::isAuthenticated()) {
            return true;
        }

        Redirect::route('');
    }
}