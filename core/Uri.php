<?php

namespace core;

class Uri
{
    private $string;

    /**
     * @return string
     */
    public function getString()
    {
        if (!empty($this->string)) {
            return rtrim($this->string,'/');
        }
        return '';
    }

    /**
     * @param string $string
     */
    public function setString($string)
    {
        $this->string = $string;
    }

    public function getUriParts()
    {
        return explode("/", $this->getString());
    }

    public function get()
    {
        if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            $uri = $_SERVER['REDIRECT_QUERY_STRING'];
            $uriBeforeParameters = strstr($uri, '&', true);

            return str_replace('path=', '/',
                ($uriBeforeParameters) ? $uriBeforeParameters : $uri
            );
        }
        return null;
    }

}