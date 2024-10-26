<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Interface ConfigServiceInterface
 * @package YoutubeVideoSearch\Service
 */
interface ConfigServiceInterface
{
    /**
     * @param string $keyword
     * @param string|null $nextPageToken
     * @return string
     */
    public function getYouTubeVideoSnippetApiUrl(string $keyword, ?string $nextPageToken): string;

    /**
     * @param string $videoIds
     * @return string
     */
    public function getYouTubeVideoStatisticsApiUrl(string $videoIds): string;

    /**
     * @param string $videoId
     * @return string
     */
    public function getYouTubeVideoUrl(string $videoId): string;

    /**
     * @return string
     */
    public function getExcelFile(): string;

    /**
     * @return string
     */
    public function getErrorLogFile(): string;
}
