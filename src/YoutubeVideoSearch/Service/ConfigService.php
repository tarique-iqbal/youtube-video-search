<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Class ConfigService
 * @package YoutubeVideoSearch\Service
 */
final readonly class ConfigService implements ConfigServiceInterface
{
    /**
     * ConfigService constructor.
     * @param array $config
     */
    public function __construct(private array $config)
    {
    }

    /**
     * @param string $keyword
     * @param string|null $nextPageToken
     * @return string
     */
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

    /**
     * @param string $videoIds
     * @return string
     */
    public function getYouTubeVideoStatisticsApiUrl(string $videoIds): string
    {
        $key = $this->config['google_api']['youtube_data_api_key'];
        $apiUrl = $this->config['google_api']['youtube_video_statistics_api_url'];

        return str_replace(['{id}', '{key}'], [$videoIds, $key], $apiUrl);
    }

    /**
     * @param string $videoId
     * @return string
     */
    public function getYouTubeVideoUrl(string $videoId): string
    {
        $url = $this->config['google_api']['youtube_video_url'];

        return str_replace('{videoId}', $videoId, $url);
    }

    /**
     * @return string
     */
    public function getExcelFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['excel_file']['directory']
            . '/' . $this->config['excel_file']['name'];
    }

    /**
     * @return string
     */
    public function getErrorLogFile(): string
    {
        return BASE_DIR
            . '/' . $this->config['error_log']['directory']
            . '/' . $this->config['error_log']['file_name'];
    }
}
