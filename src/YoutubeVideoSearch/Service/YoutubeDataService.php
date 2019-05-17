<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Class YoutubeDataService
 * @package YoutubeVideoSearch\Service
 */
class YoutubeDataService implements YoutubeDataServiceInterface
{
    /**
     * @var array
     */
    private $headers;

    /**
     * @var ConfigServiceInterface
     */
    private $configService;

    /**
     * @var CurlServiceInterface
     */
    private $curlService;

    /**
     * RestCountriesService constructor.
     * @param ConfigServiceInterface $configService
     * @param CurlServiceInterface $curlService
     */
    public function __construct(ConfigServiceInterface $configService, CurlServiceInterface $curlService)
    {
        $this->headers = [
            'Content-Type: application/json; charset=utf-8'
        ];

        $this->configService = $configService;
        $this->curlService = $curlService;
    }

    /**
     * @param string $keyword
     * @param string|null $nextPageToken
     * @return \stdClass
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
     * @param string $videoIds
     * @return \stdClass
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
