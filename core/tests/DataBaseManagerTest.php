<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

class URLTest extends TestCase
{
    //     Search magic card     //
    /** @test */
    public function testGetInstance()
    {
        $numArgs = func_num_args();
        $expectedArguments = 0;
        $this->assertEquals($expectedArguments, $numArgs);

        $url = new URL();
        $result = $url->sluggify($originalString);
        $this->assertEquals($expectedResult, $result);
    }
}