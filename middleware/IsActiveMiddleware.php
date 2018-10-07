<?php

namespace middleware;

use core\Auth;
use core\middleware\IMiddleware;
use core\Redirect;

class IsActiveMiddleware implements IMiddleware
{
    public function next()
    {
        if (Auth::isAuthenticated() && Auth::isActive()) {
            return true;
        }

        Auth::logout();

        Redirect::route('');
    }
}