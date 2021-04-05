<?php

namespace ScrollLock\Http;

use ScrollLock\Entity\User;

class Request
{
    private string $method;

    private string $path;

    private array $params = [];

    private ?User $user = null;

    public function __construct()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        if ($method === 'POST' && isset($_POST['_method'])) {
            $method = $_POST['_method'];
        }

        $this->setMethod($method)
            ->setPath(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
            ->setParams(array_merge($_GET, $_POST));
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setMethod(string $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = trim($path, '/');

        return $this;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function get(string $key, $default = null)
    {
        return $this->params[$key] ?? $default;
    }

    public function setParams(array $params): self
    {
        $this->params = $params;

        return $this;
    }

    public function setParam(string $key, $value): self
    {
        $this->params[$key] = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $_SESSION['auth_user_id'] = $user->getId();
        $this->user = $user;

        return $this;
    }

    public function parsePathParams(string $pathTemplate): self
    {
        $pathTemplate = trim($pathTemplate, '/');
        $templateFragments = explode('/', $pathTemplate);
        $templateFragments = array_filter($templateFragments, fn ($f) => str_contains($f, '{'));

        $pathFragments = explode('/', $this->path);

        foreach ($templateFragments as $index => $key) {
            $key = str_replace(['{', '}'], '', $key);
            $value = $pathFragments[$index];
            $this->setParam($key, $value);
        }

        return $this;
    }
}
