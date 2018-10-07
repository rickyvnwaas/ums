<?php

namespace middleware;


use core\middleware\IMiddleware;

class MiddlewareGroup
{
    /**
     * @var IMiddleware[]
     */
    private $middlewares = [];

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
    public function handle()
    {
        foreach ($this->getMiddlewares() as $middleware) {
            if (!$middleware->next()) {
                return false;
            }
        }
        return true;
    }
}