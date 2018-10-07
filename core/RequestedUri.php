<?php

namespace core;


use config\Constants;

class RequestedUri extends Uri
{
    /**
     * RequestedUri constructor.
     *
     * Get uri
     * Remove arguments
     */
    public function __construct()
    {
        if (isset($_SERVER['REDIRECT_QUERY_STRING'])) {
            $uri = str_replace(
                'path=',
                '/',
                $_SERVER['REDIRECT_QUERY_STRING']
            );

            $withoutArguments = substr($uri, 0, strpos($uri, "&"));

            if ($withoutArguments) {
                $uri = $withoutArguments;
            }

            $this->setString($uri);
        }
    }

    /**
     * @param Uri $uri
     * Get arguments of request and the given route
     * @return array
     */
    public function getArguments($uri)
    {
        $arguments = [];

        $argumentPositions = preg_grep ('/\{([^}]+)\}/', $uri->getUriParts());

        foreach ($argumentPositions as $index => $variable) {
            $arguments[] = $this->getUriParts()[$index];
        }

        return $arguments;
    }

    /**
     * @param Uri $uri
     * Check requested uri and the given uri is equal to each other
     * If 1 part is incorrect break loop
     * Check given pattern is equal
     * Or the part is a variable
     * @return bool
     */
    public function isGivenUriPattern($uri)
    {
        $isGivenPattern = false;

        if (count($uri->getUriParts()) == count($this->getUriParts())) {

            foreach ($uri->getUriParts() as $index => $uriPart) {
                $requestedUriPart = $this->getUriParts()[$index];

                if (isset($requestedUriPart) && $uriPart == $requestedUriPart or
                    !empty($uriPart) && preg_match( Constants::ROUTE_VARIABLE, $uriPart)
                ){
                    $isGivenPattern = true;
                } else {
                    $isGivenPattern = false;
                    break;
                }
            }
        }

        return $isGivenPattern;
    }
}