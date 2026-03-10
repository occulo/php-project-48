<?php

namespace Differ\Differ;

use Hexlet\Code\Application;

function genDiff(string $firstPath, string $secondPath, string $format = 'stylish'): string
{
    $app = new Application();
    return $app->run($firstPath, $secondPath, $format);
}
