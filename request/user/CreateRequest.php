<?php

namespace request\user;

use core\Redirect;
use core\request\Request;
use core\Validator;
use model\Question;
use model\Role;
use model\User;

class CreateRequest extends Request
{
    public function __construct()
    {
        parent::__construct();

        Validator::instance('first_name', $this->first_name)->isRequired();
        Validator::instance('last_name', $this->last_name)->isRequired();
        Validator::instance('password', $this->password)->isRequired()
            ->isEqualTo('repeat_password', $this->repeat_password);

        Validator::instance('email', $this->email)->doesNotExist(new User(), 'email')->isRequired();

        Validator::instance('role_id', $this->role_id)->isRequired()->exists(new Role());
        Validator::instance('question_id', $this->question_id)->isRequired()->exists(new Question());
        Validator::instance('secret', $this->secret)->isRequired();

        if (Validator::hasErrors()) {
            Redirect::route('/admin/users/create');
        }
    }
}