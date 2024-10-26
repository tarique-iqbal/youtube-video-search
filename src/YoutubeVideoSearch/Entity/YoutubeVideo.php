<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Entity;

class YoutubeVideo
{
    private string $title;

    private string $channelTitle;

    private ?string $viewCount;

    private ?string $likeCount;

    private string $url;

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getChannelTitle(): string
    {
        return $this->channelTitle;
    }

    public function setChannelTitle(string $channelTitle): void
    {
        $this->channelTitle = $channelTitle;
    }

    public function getViewCount(): ?string
    {
        return $this->viewCount;
    }

    public function setViewCount(?string $viewCount): void
    {
        $this->viewCount = $viewCount;
    }

    public function getLikeCount(): ?string
    {
        return $this->likeCount;
    }

    public function setLikeCount(?string $likeCount): void
    {
        $this->likeCount = $likeCount;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
}
