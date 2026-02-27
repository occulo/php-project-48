<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Hexlet\Code\ParserFactory;
use Hexlet\Code\FormatterFactory;
use Hexlet\Code\Differ;

class FormatterTest extends TestCase
{
    public function testStylishFormatting(): void
    {
        $firstPath = __DIR__ . '/fixtures/json/file1.json';
        $secondPath = __DIR__ . '/fixtures/json/file2.json';
        $firstFile = ParserFactory::build($firstPath)->parse($firstPath);
        $secondFile = ParserFactory::build($secondPath)->parse($secondPath);
        $differ = new Differ();
        $diff = $differ->genDiff($firstFile, $secondFile);
        $actual = FormatterFactory::build('stylish')->format($diff);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_stylish.txt');
        $this->assertSame(trim($expected), trim($actual));
    }

    public function testPlainFormatting(): void
    {
        $firstPath = __DIR__ . '/fixtures/json/file1.json';
        $secondPath = __DIR__ . '/fixtures/json/file2.json';
        $firstFile = ParserFactory::build($firstPath)->parse($firstPath);
        $secondFile = ParserFactory::build($secondPath)->parse($secondPath);
        $differ = new Differ();
        $diff = $differ->genDiff($firstFile, $secondFile);
        $actual = FormatterFactory::build('plain')->format($diff);
        $expected = file_get_contents(__DIR__ . '/fixtures/expected_plain.txt');
        $this->assertSame(trim($expected), trim($actual));
    }
}
