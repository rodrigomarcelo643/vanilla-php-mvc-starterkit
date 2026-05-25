<?php

class Route
{
    private array|string $method;
    private string $uri;

    public function __construct(array|string $method, string $uri)
    {
        $this->method = $method;
        $this->uri = $uri;
    }

    /**
     * Apply one or more middlewares to the route.
     *
     * @param string|array $middleware
     * @return $this
     */
    public function middleware(string|array $middleware): self
    {
        Router::addMiddlewareToRoute($this->method, $this->uri, $middleware);
        return $this;
    }
}
