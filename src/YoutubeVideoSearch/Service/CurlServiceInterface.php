<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

interface CurlServiceInterface
{
    public function get(string $url, array $headers): string;
}
