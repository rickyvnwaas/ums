<?php

namespace core\request;

class Request implements IRequest
{
    private $hasProperties = false;

    /**
     * Request constructor.
     * Dynamic request class
     */
    public function __construct()
    {
        foreach ($_POST as $key => $value) {
            $this->{$key} = $value;

            $this->hasProperties = true;
        }

        foreach ($_GET as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function hasProperties()
    {
        return $this->hasProperties;
    }
}