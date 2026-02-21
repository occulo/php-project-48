<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;

class ParserTest extends TestCase
{
    public function testJsonParsing(): void
    {
        $filePath = __DIR__ . '/fixtures/file1.json';
        $actual = ParserFactory::build($filePath)->parse($filePath);
        $expected = [
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
        ];
        $this->assertEquals($expected, $actual);
    }
}
