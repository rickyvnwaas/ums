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
}