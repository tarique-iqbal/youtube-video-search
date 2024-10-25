<?php declare(strict_types = 1);

namespace Tests\Unit\Validator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Validator\ArraySizeValidator;

class ArraySizeValidatorTest extends TestCase
{
    public static function addArraySizeDataProvider(): array
    {
        return [
            [
                [], 1, false
            ],
            [
                ['', ''], 1, false
            ],
            [
                ['Key', 'Search key', 'word'], 1, false
            ],
            [
                ['MLP'], 1, true
            ],
            [
                ['Long search keyword'], 1, true
            ],
        ];
    }

    #[DataProvider('addArraySizeDataProvider')]
    public function testIsValid(array $array, int $expectedInputSize, bool $expectedStatus): void
    {
        $arraySizeValidator = new ArraySizeValidator();
        $status = $arraySizeValidator->isValid($array, $expectedInputSize);

        $this->assertSame($expectedStatus, $status);
    }
}
