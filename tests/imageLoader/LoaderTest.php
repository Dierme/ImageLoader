<?php

use PHPUnit\Framework\TestCase;
use dierme\loader\Loader;


class LoaderTest extends TestCase
{
    public function testNameIsUniqueReturnsFalseIfNameExists()
    {
        $path = __DIR__;
        $loader = new Loader();
        $this->assertFalse($loader->nameIsUnique($path, 'LoaderTest', 'php'));
    }
}