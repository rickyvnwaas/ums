<?php

namespace core;


class Abort
{
    public static function notFound()
    {
        echo 'ABORT';
        exit();
    }

    public static function notAuthorized()
    {
        echo 'NOT AUTHORIZED';
        exit();
    }
}