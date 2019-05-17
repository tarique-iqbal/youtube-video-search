<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Class ConfigService
 * @package YoutubeVideoSearch\Service
 */
class ConfigService implements ConfigServiceInterface
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * ConfigService constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
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
}
