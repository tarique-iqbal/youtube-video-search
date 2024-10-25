<?php declare(strict_types = 1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Service\CurlServiceInterface;

class YoutubeDataServiceTest extends TestCase
{
    protected CurlServiceInterface $curlService;

    protected $youtubeDataService;

    protected function setUp(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = (new ContainerFactory($config))->create();
        $container['CurlService'] = $this
            ->getMockBuilder(CurlServiceInterface::class)
            ->getMock();

        $this->curlService = $container['CurlService'];
        $this->youtubeDataService = $container['YoutubeDataService'];
    }

    public function testSearchVideoSnippet(): void
    {
        $jsonString = '{"kind": "youtube#searchListResponse","nextPageToken":"CAIQAA","regionCode":"DE","pageInfo":'
            . '{"totalResults":100,"resultsPerPage":2},"items":[{"kind": "youtube#searchResult","id":'
            . '{"kind": "youtube#video","videoId": "sru9dtw9q08"},"snippet":{"title": "Spring Breakdown Part 3: '
            . '“Tropical Depression” MLP: Equestria Girls Season 2","channelTitle": "My Little Pony Official",'
            . '"liveBroadcastContent": "none"}},{"kind": "youtube#searchResult","id":{"kind":"youtube#video","videoId":'
            . ' "ROtTk71qN7Y"},"snippet":{"title": "MLP: Friendship is Magic","channelTitle":"My Little Pony Official",'
            . '"liveBroadcastContent": "none"}}]}';

        $this->curlService
            ->method('get')
            ->willReturn($jsonString);

        $keyword = 'MLP';
        $snippet = $this->youtubeDataService->searchVideoSnippet($keyword, null);

        $this->assertInstanceOf(\stdClass::class, $snippet);
        $this->assertContainsOnlyInstancesOf(\stdClass::class, $snippet->items);
    }

    public static function addUnexpectedResponseProvider(): array
    {
        return [
            [
                '{"error": {"errors": [{"domain": "usageLimits","reason": "keyInvalid","message": "Bad Request"}],'
                . '"code": 400,"message": "Bad Request"}}'
            ],
        ];
    }

    #[DataProvider('addUnexpectedResponseProvider')]
    public function testSearchVideoSnippetInvalidResponseFromCurlService(string $response): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->curlService
            ->method('get')
            ->willReturn($response);

        $keyword = 'MLP';
        $this->youtubeDataService->searchVideoSnippet($keyword, null);
    }

    public function testSearchVideoStatistics(): void
    {
        $jsonString = '{"kind": "youtube#videoListResponse","pageInfo": {"totalResults": 2,"resultsPerPage": 2},'
            . '"items": [{"kind": "youtube#video","id": "sru9dtw9q08","statistics": {"viewCount": "173178","likeCount":'
            . ' "2336","dislikeCount": "70","favoriteCount": "0"}},{"kind": "youtube#video","id": "ROtTk71qN7Y",'
            . '"statistics": {"viewCount": "4570165","likeCount": "28426","dislikeCount": "2096","favoriteCount":'
            . ' "0","commentCount": "3552"}}]}';

        $this->curlService
            ->method('get')
            ->willReturn($jsonString);

        $videoIds = 'sru9dtw9q08,ROtTk71qN7Y';
        $statistics = $this->youtubeDataService->searchVideoStatistics($videoIds);

        $this->assertInstanceOf(\stdClass::class, $statistics);
        $this->assertContainsOnlyInstancesOf(\stdClass::class, $statistics->items);
    }

    #[DataProvider('addUnexpectedResponseProvider')]
    public function testSearchVideoStatisticsInvalidResponseFromCurlService(string $response): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $this->curlService
            ->method('get')
            ->willReturn($response);

        $videoIds = 'sru9dtw9q08,ROtTk71qN7Y';
        $this->youtubeDataService->searchVideoStatistics($videoIds);
    }
}
