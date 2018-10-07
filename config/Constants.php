<?php

namespace config;

class Constants
{
    const APP_URL = 'http://localhost:8888';
    const APP_SUB_DIR = 'ums';
    const APP_FULL_URL = self::APP_URL . '/' . self::APP_SUB_DIR;
    const CONTROLLER_DIR = 'controllers';
    const VIEW_PATH = 'resources/views';
    const ROUTE_VARIABLE = '/\{([^}]+)\}/';
    const DEBUG = false;
}