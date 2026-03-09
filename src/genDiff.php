<?php

namespace Differ\Differ;

use Hexlet\Code\Differ;
use Hexlet\Code\Parser;
use Hexlet\Code\FormatterFactory;

function genDiff(string $firstPath, string $secondPath, string $format = 'stylish'): string
{
    $parser = new Parser();
    $factory = new FormatterFactory();
    $differ = new Differ();

    $firstFile = $parser->parse($firstPath);
    $secondFile = $parser->parse($secondPath);
    $diff = $differ->buildDiff($firstFile, $secondFile);

    return $factory->build($format)->format($diff);
}
