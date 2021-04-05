<?php

namespace ScrollLock\Http;

class Response
{
    private int $code = 200;

    private array $headers = [];

    private string $body = '';

    public function error(\Throwable $e): self
    {
        $this->body = '<pre>' . var_export($e, true) . '</pre>';

        return $this;
    }

    public function header(string $name, string $value): self
    {
        array_map(function ($key) use ($name) {
            if (strtoupper($key) === strtoupper($name)) {
                unset($this->headers[$key]);
            }
        }, array_keys($this->headers));

        $this->headers[$name] = $value;

        return $this;
    }

    public function redirect(string $url): self
    {
        $this->header('Location', $url);

        return $this;
    }

    public function send(): void
    {
        http_response_code($this->code);

        foreach ($this->headers as $header => $value) {
            header("{$header}: {$value}");
        }

        echo $this->body;
    }

    public function status(int $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function view(string $name, array $data = []): self
    {
        $view = (new View())->view($name)->with($data);
        $this->body = $view->render();

        return $this;
    }
}
