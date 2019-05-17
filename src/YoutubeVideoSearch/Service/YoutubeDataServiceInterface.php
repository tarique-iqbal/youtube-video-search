<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Interface YoutubeDataServiceInterface
 * @package YoutubeVideoSearch\Service
 */
interface YoutubeDataServiceInterface
{
    /**
     * @param string $keyword
     * @param string|null $nextPageToken
     * @return \stdClass
     * @throws \UnexpectedValueException
     */
    public function searchVideoSnippet(string $keyword, ?string $nextPageToken): \stdClass;

    /**
     * @param string $videoIds
     * @return \stdClass
     * @throws \UnexpectedValueException
     */
    public function searchVideoStatistics(string $videoIds): \stdClass;
}
