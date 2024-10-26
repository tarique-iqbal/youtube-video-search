<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

interface YoutubeVideoServiceInterface
{
    public function searchAndSortByViewCountDescending(string $keyword): array;
}
