<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

final class YoutubeDataService implements YoutubeDataServiceInterface
{
    private array $headers;

    public function __construct(
        private readonly ConfigServiceInterface $configService,
        private readonly CurlServiceInterface $curlService
    ) {
        $this->headers = [
            'Content-Type: application/json; charset=utf-8'
        ];
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function searchVideoSnippet(string $keyword, ?string $nextPageToken): \stdClass
    {
        $apiUrl = $this->configService->getYouTubeVideoSnippetApiUrl($keyword, $nextPageToken);

        $response = $this->curlService->get($apiUrl, $this->headers);
        $snippet = json_decode($response);

        if (property_exists($snippet, 'error')) {
            throw new \UnexpectedValueException(
                'Unexpected video snippet search result found in Youtube data service.'
                . ' Error code: ' . $snippet->error->code
                . ' Error message: ' . $snippet->error->message
            );
        }

        return $snippet;
    }

    /**
     * @throws \UnexpectedValueException
     */
    public function searchVideoStatistics(string $videoIds): \stdClass
    {
        $apiUrl = $this->configService->getYouTubeVideoStatisticsApiUrl($videoIds);

        $response = $this->curlService->get($apiUrl, $this->headers);
        $statistics = json_decode($response);

        if (property_exists($statistics, 'error')) {
            throw new \UnexpectedValueException(
                'Unexpected statistics search list result found in Youtube data service.'
                . ' Error code: ' . $statistics->error->code
                . ' Error message: ' . $statistics->error->message
            );
        }

        return $statistics;
    }
}
