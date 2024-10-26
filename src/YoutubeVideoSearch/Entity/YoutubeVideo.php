<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Entity;

/**
 * Class YoutubeVideo
 * @package YoutubeVideoSearch\Entity
 */
class YoutubeVideo
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $channelTitle;

    /**
     * @var string|null
     */
    private ?string $viewCount;

    /**
     * @var string|null
     */
    private ?string $likeCount;

    /**
     * @var string
     */
    private string $url;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getChannelTitle(): string
    {
        return $this->channelTitle;
    }

    /**
     * @param string $channelTitle
     */
    public function setChannelTitle(string $channelTitle): void
    {
        $this->channelTitle = $channelTitle;
    }

    /**
     * @return string|null
     */
    public function getViewCount(): ?string
    {
        return $this->viewCount;
    }

    /**
     * @param string|null $viewCount
     */
    public function setViewCount(?string $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    /**
     * @return string|null
     */
    public function getLikeCount(): ?string
    {
        return $this->likeCount;
    }

    /**
     * @param string|null $likeCount
     */
    public function setLikeCount(?string $likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
