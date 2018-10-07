<?php

namespace request\account;

use core\Redirect;
use \core\request\Request;
use core\Validator;

class EditRequest extends Request
{
    public function __construct()
    {
        parent::__construct();

        Validator::instance('first_name', $this->first_name)->isRequired();
        Validator::instance('last_name', $this->last_name)->isRequired();
        Validator::instance('password', $this->password)->isRequired()
            ->isEqualTo('repeat_password', $this->repeat_password);
        Validator::instance('email', $this->email)->isRequired();

        if (Validator::hasErrors()) {
            Redirect::route('/account/edit');
        }
    }
}