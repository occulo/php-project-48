<?php

namespace Hexlet\Code\parsers;

use Hexlet\Code\ParserInterface;

class JsonParser implements ParserInterface
{
    public function parse(string $path): array
    {
        $content = file_get_contents($path);
        if ($content === false) {
            throw new \Exception('Failed to read file: ' . $path);
        }
        try {
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new \Exception('Failed to decode JSON data: ' . $e->getMessage(), 0, $e);
        }
    }
}
