<?php declare(strict_types = 1);

namespace Tests\Unit\Validator;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Validator\SearchKeywordValidator;

class SearchKeywordValidatorTest extends TestCase
{
    public static function addSearchKeywordDataProvider(): array
    {
        return [
            [
                '', false
            ],
            [
                '@;6*3', false
            ],
            [
                'MLP', true
            ],
            [
                'Long search Keyword', true
            ],
        ];
    }

    #[DataProvider('addSearchKeywordDataProvider')]
    public function testIsValid(string $keyword, bool $expectedStatus): void
    {
        $searchKeywordValidator = new SearchKeywordValidator();
        $status = $searchKeywordValidator->isValid($keyword);

        $this->assertSame($expectedStatus, $status);
    }
}
