<?php

namespace middleware;

use core\Abort;
use core\Auth;
use core\middleware\IMiddleware;

class IsAdminMiddleware implements IMiddleware
{
    public function next()
    {
        if (Auth::isAdmin()) {
            return true;
        }

        Abort::notAuthorized();
    }
}