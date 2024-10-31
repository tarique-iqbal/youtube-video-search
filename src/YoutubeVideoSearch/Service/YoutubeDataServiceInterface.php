<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

interface YoutubeDataServiceInterface
{
    /**
     * @throws \UnexpectedValueException
     */
    public function searchVideoSnippet(string $keyword, ?string $nextPageToken): \stdClass;

    /**
     * @throws \UnexpectedValueException
     */
    public function searchVideoStatistics(string $videoIds): \stdClass;
}
