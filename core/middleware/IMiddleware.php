<?php

namespace core\middleware;

interface IMiddleware
{
    public function next();
}