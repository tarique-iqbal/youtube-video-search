<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

final readonly class ConfigService implements ConfigServiceInterface
{
    public function __construct(private array $config)
    {
    }

    public function getYouTubeVideoSnippetApiUrl(string $keyword, ?string $nextPageToken): string
    {
        $key = $this->config['google_api']['youtube_data_api_key'];
        $maxResults = $this->config['google_api']['youtube_max_results'];

        if (isset($nextPageToken)) {
            $apiUrl = $this->config['google_api']['youtube_video_snippet_pagination_api_url'];

            return str_replace(
                ['{maxResults}', '{keyword}', '{pageToken}', '{key}'],
                [$maxResults, $keyword, $nextPageToken, $key],
                $apiUrl
            );
        }

        $apiUrl = $this->config['google_api']['youtube_video_snippet_api_url'];

        return str_replace(
            ['{maxResults}', '{keyword}', '{key}'],
            [$maxResults, $keyword, $key],
            $apiUrl
        );
    }

    public function getYouTubeVideoStatisticsApiUrl(string $videoIds): string
    {
        $key = $this->config['google_api']['youtube_data_api_key'];
        $apiUrl = $this->config['google_api']['youtube_video_statistics_api_url'];

        return str_replace(['{id}', '{key}'], [$videoIds, $key], $apiUrl);
    }

    public function getYouTubeVideoUrl(string $videoId): string
    {
        $url = $this->config['google_api']['youtube_video_url'];

        return str_replace('{videoId}', $videoId, $url);
    }

    public function getExcelFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['excel_file']['directory']
            . '/' . $this->config['excel_file']['name'];
    }

    public function getErrorLogFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['error_log']['directory']
            . '/' . $this->config['error_log']['file_name'];
    }
}
