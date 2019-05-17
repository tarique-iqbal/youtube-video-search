<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

/**
 * Interface YoutubeVideoServiceInterface
 * @package YoutubeVideoSearch\Service
 */
interface YoutubeVideoServiceInterface
{
    /**
     * @param string $keyword
     * @return array
     */
    public function searchAndSortByViewCountDescending(string $keyword): array;
}
