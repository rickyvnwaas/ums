<?php

namespace request\auth;

use core\Redirect;
use core\request\Request;
use core\Validator;
use model\Question;

class PasswordResetRequest extends  Request
{
    public function __construct()
    {
        parent::__construct();

        Validator::instance('email', $this->email)->isRequired();
        Validator::instance('password', $this->password)->isRequired()
            ->isEqualTo('repeat_password', $this->repeat_password);
        Validator::instance('question_id', $this->question_id)->isRequired()
            ->exists(new Question());
        Validator::instance('secret', $this->secret)->isRequired();

        if (Validator::hasErrors()) {
            Redirect::route('/password-reset');
        }
    }
}