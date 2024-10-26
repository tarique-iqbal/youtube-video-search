<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

interface ConfigServiceInterface
{
    public function getYouTubeVideoSnippetApiUrl(string $keyword, ?string $nextPageToken): string;

    public function getYouTubeVideoStatisticsApiUrl(string $videoIds): string;

    public function getYouTubeVideoUrl(string $videoId): string;

    public function getExcelFile(): string;

    public function getErrorLogFile(): string;
}
