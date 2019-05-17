<?php declare(strict_types = 1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Validator\SearchKeywordValidator;

class SearchKeywordValidatorTest extends TestCase
{
    public function addSearchKeywordDataProvider()
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

    /**
     * @dataProvider addSearchKeywordDataProvider
     */
    public function testIsValid(string $keyword, bool $expectedStatus): void
    {
        $searchKeywordValidator = new SearchKeywordValidator();
        $status = $searchKeywordValidator->isValid($keyword);

        $this->assertSame($expectedStatus, $status);
    }
}
