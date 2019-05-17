<?php declare(strict_types=1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Entity\YoutubeVideo;
use YoutubeVideoSearch\Service\CurlServiceInterface;

class YoutubeVideoServiceTest extends TestCase
{
    protected $curlService;

    protected $youtubeVideoService;

    protected function setUp()
    {
        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = (new ContainerFactory($config))->create();
        $container['CurlService'] = $this
            ->getMockBuilder(CurlServiceInterface::class)
            ->getMock();

        $this->curlService = $container['CurlService'];
        $this->youtubeVideoService = $container['YoutubeVideoService'];
    }

    public function testSearchAndSortByViewCountDescending(): void
    {
        $this->curlService
            ->expects($this->any())
            ->method('get')
            ->will($this->onConsecutiveCalls(
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
            ));

        $keyword = 'MLP:';
        $youtubeVideos = $this->youtubeVideoService->searchAndSortByViewCountDescending($keyword);

        $this->assertContainsOnlyInstancesOf(YoutubeVideo::class, $youtubeVideos);
    }

    public function testSearchAndSortByViewCountDescendingMultiplePage(): void
    {
        $this->curlService
            ->expects($this->any())
            ->method('get')
            ->will($this->onConsecutiveCalls(
                '{"nextPageToken": "CAIQAA","regionCode": "DE","pageInfo": {"totalResults": 1000000,'
                . '"resultsPerPage": 2},"items": [{"id": {"kind": "youtube#video","videoId": "sYilwmF8JSA"},'
                . '"snippet": {"title": "Spring Breakdown Part 4: “Friend Overboard” MLP: Equestria Girls Season 2",'
                . '"channelTitle": "My Little Pony Official","liveBroadcastContent": "none"}},{"id": {"kind":'
                . ' "youtube#video","videoId": "ROtTk71qN7Y"},"snippet": {"title": "MLP: Friendship is Magic - &#39;'
                . 'Ail-icorn&#39; 🌡️ Official Short","channelTitle": "My Little Pony Official","liveBroadcastContent":'
                . ' "none"}}]}',

                '{ "pageInfo": {"totalResults": 2,"resultsPerPage": 2},"items": [{"id": "sYilwmF8JSA","statistics": {'
                . '"viewCount": "239942","likeCount": "2625","dislikeCount": "117","favoriteCount": "0"}},{"id":'
                . ' "ROtTk71qN7Y", "statistics": { "viewCount": "5040649", "likeCount": "29912", "dislikeCount":'
                . ' "2292", "favoriteCount": "0", "commentCount": "3712" }}]}',

                '{"prevPageToken": "CAIQAQ","regionCode": "DE","pageInfo": {"totalResults": 1000000,"resultsPerPage":'
                . ' 2},"items": [{"id": {"kind": "youtube#video","videoId": "fFuDAor3mLc"},"snippet": {"title":'
                . ' "Spring Breakdown Part 1: “Bon Voyage” MLP: Equestria Girls Season 2","channelTitle":'
                . ' "My Little Pony Official","liveBroadcastContent": "none"}},{"id": {"kind": "youtube#video",'
                . '"videoId": "sru9dtw9q08"},"snippet": {"title": "Spring Breakdown Part 3: “Tropical Depression” MLP:'
                . ' Equestria Girls Season 2","channelTitle": "My Little Pony Official","liveBroadcastContent":'
                . ' "none"}}]}',

                '{"pageInfo": {"totalResults": 2,"resultsPerPage": 2},"items": [{"id": "fFuDAor3mLc","statistics":'
                . ' {"viewCount": "664825","likeCount": "4902","dislikeCount": "339","favoriteCount": "0"}},{"id":'
                . ' "sru9dtw9q08","statistics": {"viewCount": "282652","likeCount": "2896","dislikeCount": "115",'
                . '"favoriteCount": "0"}}]}'
            ));

        $keyword = 'MLP';
        $youtubeVideos = $this->youtubeVideoService->searchAndSortByViewCountDescending($keyword);

        $this->assertContainsOnlyInstancesOf(YoutubeVideo::class, $youtubeVideos);
    }
}
