<?php

namespace Hexlet\Code;


interface FormatterInterface
{
    public function format(array $data): string;
}
