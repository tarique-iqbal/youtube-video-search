<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

/**
 * Class CliArgsService
 * @package YoutubeVideoSearch\Service
 */
class CliArgsService implements CliArgsServiceInterface
{
    /**
     * @return array
     */
    public function getArgs(): array
    {
        $argv = $_SERVER['argv'];
        array_shift($argv);

        return $argv;
    }
}
