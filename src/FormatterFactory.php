<?php

namespace Hexlet\Code;

use Hexlet\Code\Formatters\StylishFormatter;
use Hexlet\Code\Formatters\PlainFormatter;
use Hexlet\Code\Formatters\JsonFormatter;

class FormatterFactory
{
    private array $formats;

    public function __construct(array $formats = [])
    {
        $this->formats = [
            'stylish' => StylishFormatter::class,
            'plain' => PlainFormatter::class,
            'json' => JsonFormatter::class,
        ];
        if ($formats) {
            $this->formats = $formats;
        }
    }

    public function build(string $format = 'stylish'): FormatterInterface
    {
        if (!isset($this->formats[$format])) {
            throw new \Exception("Unsupported format");
        }
        return new $this->formats[$format]();
    }
}
