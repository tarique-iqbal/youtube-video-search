<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Interface CliArgsServiceInterface
 * @package YoutubeVideoSearch\Service
 */
interface CliArgsServiceInterface
{
    /**
     * @return array
     */
    public function getArgs(): array;
}
