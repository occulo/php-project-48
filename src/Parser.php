<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

class Parser
{
    public static function parse(string $path): array
    {
        $parsers = [
            'json' => fn($data) => json_decode($data, true),
            'yaml' => fn($data) => Yaml::parse($data),
            'yml' => fn($data) => Yaml::parse($data)
        ];
        $extension = self::getExtension($path);
        if (!array_key_exists($extension, $parsers)) {
            throw new \Exception("Unsupported file format: {$extension}");
        }
        return $parsers[$extension](self::readFile($path));
    }

    private static function readFile(string $path): string
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

    private static function getExtension(string $path): string
    {
        return strtolower(pathinfo($path, PATHINFO_EXTENSION));
    }
}
