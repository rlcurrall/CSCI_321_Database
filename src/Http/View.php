<?php

namespace ScrollLock\Http;

class View
{
    private string $layout = 'layouts/main';

    private string $contents = '';

    private array $parameters = [];

    private string $view;

    public function layout(string $layout): self
    {
        $this->layout = $layout;

        return $this;
    }

    public function view(string $name): self
    {
        $this->view = $name;

        return $this;
    }

    public function with(array $parameters): self
    {
        $this->parameters = $parameters;

        return $this;
    }

    public function render(): string
    {
        $this->contents = $this->renderFile($this->view, $this->parameters);

        return $this->renderFile($this->layout, $this->parameters);
    }

    private function renderFile(string $name, array $parameters = []): string
    {
        $filePath = dirname(__DIR__, 2) . "/views/{$name}.phtml";

        if (!file_exists($filePath)) {
            throw new \Exception("View not found: {$filePath}");
        }

        extract($parameters);
        ob_start();
        include($filePath);
        $output = ob_get_clean();

        return $output;
    }

    private function yield()
    {
        echo $this->contents;
    }

    private function partial(string $name, array $data): void
    {
        echo $this->renderFile("partials/{$name}", $data);
    }

    private function component(string $name, array $data): void
    {
        echo $this->renderFile("components/{$name}", $data);
    }
}
