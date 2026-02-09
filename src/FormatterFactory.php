<?php

namespace Hexlet\Code;

class FormatterFactory
{
    const ALLOWED_FORMATS = [
        'stylish' => \Hexlet\Code\formatters\StylishFormatter::class,
    ];

    public static function build(string $format = 'stylish'): FormatterInterface
    {
        if (!isset(self::ALLOWED_FORMATS[$format])) {
            throw new \Exception('Unsupported report format');
        }
        $formatterClass = self::ALLOWED_FORMATS[$format];
        $formatter = new $formatterClass();
        return $formatter;
    }
}
