<?php
namespace App\Tests\Util;

use PHPUnit\Framework\TestCase;

class TestTest extends TestCase
{
    public function testAdd()
    {
        $result = 42;
        $this->assertEquals(42, $result);
    }
}