<?php

namespace Hexlet\Code;

interface ParserInterface
{
    public function parse(string $path): array;
}
