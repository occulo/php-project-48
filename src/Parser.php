<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

class Parser
{
    private array $parsers;

    public function __construct(array $parsers = [])
    {
        $this->parsers = [
            'json' => fn($data) => json_decode($data, true),
            'yaml' => fn($data) => Yaml::parse($data),
            'yml' => fn($data) => Yaml::parse($data),
        ];
        if ($parsers !== []) {
            $this->parsers = $parsers;
        }
    }

    public function parse(string $path): array
    {
        $extension = $this->getExtension($path);
        if (!isset($this->parsers[$extension])) {
            throw new \Exception("Unsupported file format: {$extension}");
        }
        return $this->parsers[$extension]($this->readFile($path));
    }

    private function readFile(string $path): string
    {
        if (!file_exists($path)) {
            throw new \Exception("File not found: {$path}");
        }
        $content = file_get_contents($path);
        if ($content === false) {
            throw new \Exception("Failed to read file: {$path}");
        }
        return $content;
    }

    private function getExtension(string $path): string
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
