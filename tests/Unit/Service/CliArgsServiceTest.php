<?php declare(strict_types = 1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\Attributes\DataProvider;
use YoutubeVideoSearch\Service\CliArgsService;
use PHPUnit\Framework\TestCase;

class CliArgsServiceTest extends TestCase
{
    const FILE = 'index.php';

    public static function addCliArgsDataProvider(): array
    {
        return [
            [
                [self::FILE], 0, []
            ],
            [
                [self::FILE, 'Search keyword'], 1, ['Search keyword']
            ],
            [
                [self::FILE, 'Keyword', 'Search keyword'], 2, ['Keyword', 'Search keyword']
            ],
        ];
    }

    #[DataProvider('addCliArgsDataProvider')]
    public function testGetArgs(array $arguments, int $countExpected, array $resultExpected): void
    {
        $_SERVER['argv'] = $arguments;

        $cliArgsService = new CliArgsService();
        $result = $cliArgsService->getArgs();

        $this->assertSame($resultExpected, $result);
        $this->assertEquals($countExpected, count($result));
    }
}
