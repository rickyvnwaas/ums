<?php

namespace request\user;

use core\Redirect;
use core\request\ApiRequest;
use core\request\Request;
use core\Validator;
use model\Question;
use model\Role;
use model\User;

class ActiveToggleRequest extends Request
{
    public $id;

    public $is_active;

    public function __construct()
    {
        parent::__construct();

        Validator::instance('id', $this->id)->isRequired()->exists(new User());
        Validator::instance('is_active', $this->is_active)->isBoolean();
    }
}