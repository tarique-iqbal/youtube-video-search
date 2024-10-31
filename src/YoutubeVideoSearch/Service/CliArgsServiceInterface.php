<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Service;

interface CliArgsServiceInterface
{
    public function getArgs(): array;
}
