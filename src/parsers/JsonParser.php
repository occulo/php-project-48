<?php

namespace Hexlet\Code\parsers;

use Hexlet\Code\ParserInterface;

class JsonParser implements ParserInterface
{
    public function parse(string $path): array
    {
        $content = file_get_contents($path);
        return json_decode($content, true);
    }
}
