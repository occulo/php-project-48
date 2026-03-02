<?php

namespace Hexlet\Code\parsers;

use Symfony\Component\Yaml\Yaml;
use Symfony\Component\Yaml\Exception\ParseException;
use Hexlet\Code\ParserInterface;

class YamlParser implements ParserInterface
{
    public function parse(string $path): array
    {
        $content = file_get_contents($path);
        if ($content === false) {
            throw new \Exception('Failed to read file: ' . $path);
        }
        try {
            return Yaml::parse($content);
        } catch (ParseException $e) {
            throw new \Exception('Failed to decode YAML data: ' . $e->getMessage(), 0, $e);
        }
    }
}
