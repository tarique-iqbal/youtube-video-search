<?php declare(strict_types = 1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\ConfigServiceInterface;

class ConfigServiceTest extends TestCase
{
    protected array $config;

    protected ConfigServiceInterface $configService;

    protected function setUp(): void
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

    public function testGetYouTubeVideoUrl(): void
    {
        $videoId = 'ROtTk71qN7Y';
        $videoUrl = $this->configService->getYouTubeVideoUrl($videoId);

        $url = $this->config['google_api']['youtube_video_url'];

        $expectedApiUrl = str_replace('{videoId}', $videoId, $url);

        $this->assertSame($expectedApiUrl, $videoUrl);
    }

    public function testGetExcelFile(): void
    {
        $excelFile = $this->configService->getExcelFile();
        $expectedExcelFile = BASE_DIR
            . '/' . $this->config['excel_file']['directory']
            . '/' . $this->config['excel_file']['name'];

        $this->assertSame($expectedExcelFile, $excelFile);
    }

    public function testGetErrorLogFile(): void
    {
        $logFile = $this->configService->getErrorLogFile();
        $expectedLogFile = BASE_DIR
            . '/' . $this->config['error_log']['directory']
            . '/' . $this->config['error_log']['file_name'];

        $this->assertSame($expectedLogFile, $logFile);
    }
}
