<?php

namespace middleware;

use core\Auth;
use core\middleware\IMiddleware;

class IsUserMiddleware implements IMiddleware
{
    public function next()
    {
        if (Auth::isAdmin() || Auth::isUser()) {
            return true;
        }
        return false;
    }
}