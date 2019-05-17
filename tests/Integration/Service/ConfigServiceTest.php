<?php declare(strict_types = 1);

namespace Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Service\ConfigService;

class ConfigServiceTest extends TestCase
{
    protected $config;

    protected $configService;

    protected function setUp()
    {
        $this->config = include BASE_DIR . '/config/parameters.php';
        $this->configService = new ConfigService($this->config);
    }

    public function testGetYouTubeVideoSnippetApiUrl(): void
    {
        $keyword = 'MLP';
        $apiUrl = $this->configService->getYouTubeVideoSnippetApiUrl($keyword, null);

        $key = $this->config['google_api']['youtube_data_api_key'];
        $maxResults = $this->config['google_api']['youtube_max_results'];
        $url = $this->config['google_api']['youtube_video_snippet_api_url'];

        $expectedApiUrl = str_replace(
            ['{maxResults}', '{keyword}', '{key}'],
            [$maxResults, $keyword, $key],
            $url
        );

        $this->assertSame($expectedApiUrl, $apiUrl);

        $nextPageToken = 'CAoQAA';
        $apiUrl = $this->configService->getYouTubeVideoSnippetApiUrl($keyword, $nextPageToken);

        $url = $this->config['google_api']['youtube_video_snippet_pagination_api_url'];

        $expectedApiUrl = str_replace(
            ['{maxResults}', '{keyword}', '{pageToken}', '{key}'],
            [$maxResults, $keyword, $nextPageToken, $key],
            $url
        );

        $this->assertSame($expectedApiUrl, $apiUrl);
    }

    public function testGetYouTubeVideoStatisticsApiUrl(): void
    {
        $videoIds = 'sru9dtw9q08,ROtTk71qN7Y';
        $apiUrl = $this->configService->getYouTubeVideoStatisticsApiUrl($videoIds);

        $key = $this->config['google_api']['youtube_data_api_key'];
        $url = $this->config['google_api']['youtube_video_statistics_api_url'];

        $expectedApiUrl = str_replace(['{id}', '{key}'], [$videoIds, $key], $url);

        $this->assertSame($expectedApiUrl, $apiUrl);
    }
}
