<?php

namespace request\auth;

use core\Redirect;
use core\request\Request;
use core\Validator;

class LoginRequest extends  Request
{
    public function __construct()
    {
        parent::__construct();

        Validator::instance('email', $this->email)->isRequired();
        Validator::instance('password', $this->password)->isRequired();

        if (Validator::hasErrors()) {
            Redirect::route('');
        }
    }
}