<?php

namespace Request;

class Request
{
    protected string $uri;
    protected string $method;

    protected array $data;

    public function __construct(string $uri, string $method, array $data = [])
    {
        $this->uri = $uri;
        $this->method = $method;
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

}