<?php

namespace Mpyw\PHPUnitPatchSerializableComparison\Tests;

use PHPUnit\Framework\TestCase;

class DataProviderTest extends TestCase
{
    public function provideAdditionTestParams()
    {
        return [
            'say hello' => [
                function ($mr) {
                    return "Hello, $mr!";
                }
            ],
            'hello arrow' => [fn($ms) => "Hello, $ms!"]
        ];
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     * @dataProvider provideAdditionTestParams
     */
    public function testUseClosureDataProviderTest($data)
    {
        self::assertSame('Hello, aaa!', $data('aaa'));
    }
}
