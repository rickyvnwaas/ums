<?php

namespace core;

class Route
{
    /**
     * @var Uri
     */
    private $uri;

    /**
     * @var string
     */
    private $action;

    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $method;

    /**
     * @return Uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param Uri $uri
     */
    private function setUri($uri)
    {
        $this->uri = $uri;
    }

    /**
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    public function getClass()
    {
        return $this->class;
    }

    private function setClass($class)
    {
        $this->class = $class;
    }

    public function getMethod()
    {
        return $this->method;
    }

    private function setMethod($method)
    {
        $this->method = $method;
    }

    /**
     * @param string $action
     */
    private function setAction($action)
    {
        $classReferenceMethod = explode('@', $action);

        if (count($classReferenceMethod) == 2) {
            $this->setClass($classReferenceMethod[0]);
            $this->setMethod($classReferenceMethod[1]);
        }

        $this->action = $action;
    }

    /**
     * Get variable positions of the uri
     * Check position exists in requested uri
     * Place value into a array
     * @param @requestedUri
     * @return array
     */
    public function getUriArguments($requestedUri)
    {
        $arguments = [];

        $argumentPositions = preg_grep ('/\{([^}]+)\}/', $this->getUriParts());

        foreach ($argumentPositions as $index => $variable) {
           $arguments[] = $requestedUri[$index];
        }

        return $arguments;
    }

    /**
     * @param $uri
     * @param $action
     * All get requests
     * @return Route
     */
    public static function get($uri, $action)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $route = self::handle($uri, $action);

            return $route;
        }
    }


    /**
     * @param $uri
     * @param $action
     * All post requests
     * @return Route
     */
    public static function post($uri, $action)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $route = self::handle($uri, $action);

            return $route;
        }
    }

    /**
     * @param $uri
     * @param $action
     * @return Route
     */
    private static function handle($uri, $action)
    {
        $uriObj = new Uri();
        $uriObj->setString($uri);

        $route = new Route();
        $route->setAction($action);
        $route->setUri($uriObj);

        return $route;
    }
}