<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

use YoutubeVideoSearch\Entity\YoutubeVideo;

final readonly class YoutubeVideoService implements YoutubeVideoServiceInterface
{
    public function __construct(
        private ConfigServiceInterface $configService,
        private YoutubeDataServiceInterface $youtubeDataService
    ) {
    }

    public function searchAndSortByViewCountDescending(string $keyword): array
    {
        $youtubeVideos = [];
        $snippet = $this->youtubeDataService->searchVideoSnippet($keyword, null);

        while (property_exists($snippet, 'items') && count($snippet->items) > 0) {
            $snippets = [];

            foreach ($snippet->items as $item) {
                $snippets[$item->id->videoId] = [
                    'title' => $item->snippet->title,
                    'channelTitle' => $item->snippet->channelTitle
                ];
            }

            $statistics = $this->youtubeDataService->searchVideoStatistics(
                implode(',', array_keys($snippets))
            );

            foreach ($statistics->items as $item) {
                $youTubeVideo = new YoutubeVideo();
                $youTubeVideo->setTitle($snippets[$item->id]['title']);
                $youTubeVideo->setChannelTitle($snippets[$item->id]['channelTitle']);
                $youTubeVideo->setViewCount($item->statistics->viewCount);
                $youTubeVideo->setLikeCount($item->statistics->likeCount);
                $youTubeVideo->setUrl(
                    $this->configService->getYouTubeVideoUrl($item->id)
                );

                $youtubeVideos[] = $youTubeVideo;
            }

            if (property_exists($snippet, 'nextPageToken')) {
                $snippet = $this->youtubeDataService->searchVideoSnippet($keyword, $snippet->nextPageToken);
            } else {
                $snippet->items = [];
            }
        }

        usort($youtubeVideos, function ($youTubeVideo, $youTubeVideoToCompare) {
            return $youTubeVideo->getViewCount() < $youTubeVideoToCompare->getViewCount() ? 1 : 0;
        });

        return $youtubeVideos;
    }
}
