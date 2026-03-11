<?php

namespace Occulo\Gendiff;

use Occulo\Gendiff\Parser;
use Occulo\Gendiff\Differ;
use Occulo\Gendiff\Formatter\FormatterFactory;

class Gendiff
{
    private Parser $parser;
    private Differ $differ;
    private FormatterFactory $factory;

    public function __construct()
    {
        $this->parser = new Parser();
        $this->differ = new Differ();
        $this->factory = new FormatterFactory();
    }

    public function build(string $firstPath, string $secondPath, string $format = 'stylish'): string
    {
        $first = $this->parser->parse($firstPath);
        $second = $this->parser->parse($secondPath);
        $diff = $this->differ->buildDiff($first, $second);
        return $this->factory->build($format)->format($diff);
    }
}
