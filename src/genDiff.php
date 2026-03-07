<?php

namespace Differ\Differ;

use Hexlet\Code\Differ as DiffService;
use Hexlet\Code\Parser;
use Hexlet\Code\FormatterFactory;

function genDiff(string $firstPath, string $secondPath, string $format = 'stylish'): string
{
    $firstFile = Parser::parse($firstPath);
    $secondFile = Parser::parse($secondPath);
    $diff = (new DiffService())->buildDiff($firstFile, $secondFile);
    return FormatterFactory::build($format)->format($diff);
}
