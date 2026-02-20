<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code;

class ParserTest extends TestCase
{
    public function testJsonParsing(): void
    {
        $filePath = __DIR__ . '/fixtures/file1.json';
        $actual = \Hexlet\Code\ParserFactory::build($filePath)->parse($filePath);
        $this->assertEquals([
            'host' => 'hexlet.io',
            'timeout' => 50,
            'proxy' => '123.234.53.22',
            'follow' => false,
            'ports' => [80, 443, 8080],
            'settings' => [
                'mode' => 'development',
                'retry' => 3,
                'features' => [
                    'auth' => true,
                    'cache' => false,
                    'beta' => true
                ]
            ]
        ], $actual);
    }
}
