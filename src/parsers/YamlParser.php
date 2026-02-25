<?php

namespace Hexlet\Code\parsers;

use Symfony\Component\Yaml\Yaml;
use Hexlet\Code\ParserInterface;

class YamlParser implements ParserInterface
{
    public function parse(string $path): array
    {
        $content = file_get_contents($path);
        return Yaml::parse($content);
    }
}
