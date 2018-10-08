<?php

namespace middleware;


use core\middleware\IMiddleware;
use core\RequestedUri;
use core\Uri;

class MiddlewareGroup
{
    /**
     * @var IMiddleware[]
     */
    private $middlewares = [];

    /**
     * @var bool
     */
    private $except = false;

    /**
     * Set admin middlewares
     */
    public function admin()
    {
        $this->setMiddlewares([
            new IsAuthenticatedMiddleware(),
            new IsActiveMiddleware(),
            new IsAdminMiddleware()
        ]);
    }

    public function user()
    {
        $this->setMiddlewares([
            new IsAuthenticatedMiddleware(),
            new IsActiveMiddleware()
        ]);
    }

    public function guest()
    {
        $this->setMiddlewares([
            new IsNotAuthenticatedMiddleware()
        ]);
    }

    /**
     * @param IMiddleware[] $middlewares
     */
    public function setMiddlewares($middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @return IMiddleware[]
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @return bool
     */
    public function getExcept()
    {
        return $this->except;
    }

    public function except($except = [])
    {
        $requestedUri = new RequestedUri();

        foreach ($except as $item) {
            if ($requestedUri->getString() == $item->getString()) {
                $this->except = true;
            }
        }
    }

    /**
     * Check excepts
     * @param Uri[] $except
     * @return bool
     */
    public function handle()
    {
        if (!$this->getExcept()) {
            foreach ($this->getMiddlewares() as $middleware) {
                if (!$middleware->next()) {
                    return false;
                }
            }
        }

        return true;
    }
}