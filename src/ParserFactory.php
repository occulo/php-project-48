<?php

namespace Hexlet\Code;

class ParserFactory
{
    private const ALLOWED_EXTENSIONS = [
        'json' => \Hexlet\Code\parsers\JsonParser::class,
    ];

    public static function build(string $path): ParserInterface
    {
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        if (!isset(self::ALLOWED_EXTENSIONS[$extension])) {
            throw new \Exception('Unsupported file format');
        }
        $parserClass = self::ALLOWED_EXTENSIONS[$extension];
        return new $parserClass();
    }
}
