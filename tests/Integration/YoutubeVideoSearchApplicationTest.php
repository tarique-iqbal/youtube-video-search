<?php declare(strict_types = 1);

namespace Tests\Integration;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Service\CliArgsServiceInterface;
use YoutubeVideoSearch\Service\CurlServiceInterface;
use YoutubeVideoSearch\YoutubeVideoSearchApplication;

class YoutubeVideoSearchApplicationTest extends TestCase
{
    protected string $fileName;

    protected CurlServiceInterface $curlService;

    protected CliArgsServiceInterface $cliArgsService;

    protected YoutubeVideoSearchApplication $youtubeVideoSearchApplication;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = (new ContainerFactory($config))->create();
        $container['CurlService'] = $this
            ->getMockBuilder(CurlServiceInterface::class)
            ->getMock();
        $container['CliArgsService'] = $this
            ->getMockBuilder(CliArgsServiceInterface::class)
            ->getMock();

        $this->fileName = $container['ConfigService']->getExcelFile();

        $this->curlService = $container['CurlService'];
        $this->cliArgsService = $container['CliArgsService'];
        $this->youtubeVideoSearchApplication = $container['YoutubeVideoSearchApplication'];
    }

    protected function tearDown(): void
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }

    public function testSearch(): void
    {
        $this->expectOutputString(
            sprintf('YouTube videos search and excel file has been written successfully.%s', PHP_EOL)
        );

        $this->cliArgsService
            ->method('getArgs')
            ->willReturn(['Italy']);
        $this->curlService
            ->expects($this->any())
            ->method('get')
            ->willReturn(
                '{"kind": "youtube#searchListResponse","regionCode":"DE","pageInfo":{"totalResults":100,'
                . '"resultsPerPage":2},"items":[{"kind": "youtube#searchResult","id":{"kind": "youtube#video",'
                . '"videoId": "sru9dtw9q08"},"snippet":{"title": "Spring Breakdown Part 3: “Tropical Depression”'
                . ' MLP: Equestria Girls Season 2","channelTitle": "My Little Pony Official","liveBroadcastContent":'
                . ' "none"}},{"kind": "youtube#searchResult","id":{"kind":"youtube#video","videoId":"ROtTk71qN7Y"},'
                . '"snippet":{"title": "MLP: Friendship is Magic","channelTitle":"My Little Pony Official",'
                . '"liveBroadcastContent": "none"}}]}',

                '{"kind": "youtube#videoListResponse","pageInfo": {"totalResults": 2,"resultsPerPage": 2},"items":'
                . ' [{"kind": "youtube#video","id": "sru9dtw9q08","statistics": {"viewCount": "173178","likeCount":'
                . ' "2336","dislikeCount": "70","favoriteCount": "0"}},{"kind": "youtube#video","id": "ROtTk71qN7Y",'
                . '"statistics": {"viewCount": "4570165","likeCount": "28426","dislikeCount": "2096","favoriteCount":'
                . ' "0","commentCount": "3552"}}]}'
            );

        $this->youtubeVideoSearchApplication->search();

        $this->assertTrue(file_exists($this->fileName));
    }

    public static function addInvalidInputProvider(): array
    {
        return [
            [
                [],
                'Invalid input length.' . PHP_EOL
            ],
            [
                ['Search', 'Keyword'],
                'Invalid input length.' . PHP_EOL
            ],
            [
                [''],
                'Search keyword can not be empty.' . PHP_EOL
            ],
            [
                ['@#56%*'],
                'Search keyword should contain alphabets.' . PHP_EOL
            ],
        ];
    }

    #[DataProvider('addInvalidInputProvider')]
    public function testSearchWithInvalidInput(array $invalidInputArgs, string $expectOutputString): void
    {
        $this->cliArgsService
            ->method('getArgs')
            ->willReturn($invalidInputArgs);

        $this->expectOutputString($expectOutputString);

        $this->youtubeVideoSearchApplication->search();
    }
}
