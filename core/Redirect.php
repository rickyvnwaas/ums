<?php

namespace core;

use config\Constants;

class Redirect
{
    public static function route($route)
    {
        $subDir = Constants::APP_SUB_DIR;

        $route = (!empty($subDir)) ? "/$subDir/$route" : "/$route";

        header("Location: $route");
        exit();
    }

    public static function back()
    {
        var_dump($_SERVER);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}