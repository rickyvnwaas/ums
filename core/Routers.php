<?php

namespace core;


use config\Constants;
use core\request\Request;

class Routers
{
    /**
     * @var Route[]
     */
    private $routes = [];

    /**
     * @var Route
     */
    private $activeRoute;

    /**
     * @var RequestedUri
     */
    private $requestedUri;

    public function __construct()
    {
        $this->setRequestedUri(new RequestedUri());
    }

    /**
     * @param RequestedUri $uri
     */
    private function setRequestedUri($uri)
    {
        $this->requestedUri = $uri;
    }

    /**
     * @return RequestedUri
     */
    private function getRequestedUri()
    {
        return $this->requestedUri;
    }


    /**
     * Add to route list
     * @param $route
     */
    public function add($route)
    {
        if ($route) {
            $this->routes[] = $route;
        }
    }

    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return Route
     */
    public function getActiveRoute()
    {
        return $this->activeRoute;
    }

    /**
     * @param Route $activeRoute
     */
    public function setActiveRoute($activeRoute)
    {
        $this->activeRoute = $activeRoute;
    }

    /**
     * split the action into a class reference and method.
     * Check requested uri is equal to the gives parameter.
     * If the given values are equal create instance of the given action.
     * Echo the return information to the screen
     */
    public function resolve()
    {
        $lastElementRouteIndex = count($this->getRoutes());

        foreach ($this->getRoutes() as $index => $route) {

            $this->setActiveRoute($route);

            if ($this->getRequestedUri()->isGivenUriPattern($route->getUri())) {

                $classReference = Constants::CONTROLLER_DIR . '\\' . $this->getActiveRoute()->getClass();
                $controller = new $classReference();

                echo call_user_func_array([$controller, $this->getActiveRoute()->getMethod()],
                    $this->getRequestedUri()->getArguments($route->getUri())
                );
                break;
            } elseif ($lastElementRouteIndex == $index + 1) {
                Abort::notFound();
            }
        }
    }
}