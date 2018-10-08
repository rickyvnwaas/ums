<?php

namespace middleware;


use core\Auth;
use core\middleware\IMiddleware;
use core\Redirect;

class IsNotAuthenticatedMiddleware implements IMiddleware
{
    public function next()
    {
        if (!Auth::isAuthenticated()) {
            return true;
        }

        if (Auth::isAdmin()) {
            Redirect::route('admin/users/overzicht');
        }

        Redirect::route('account');
    }
}