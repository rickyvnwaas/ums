<?php

namespace core;


class Response
{
    public static function json($args, $statusCode = 200)
    {
        http_response_code($statusCode);

        return json_encode($args);
    }
}