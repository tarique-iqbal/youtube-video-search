<?php declare(strict_types=1);

namespace YoutubeVideoSearch\Handler;

use YoutubeVideoSearch\Service\ConfigServiceInterface;

final readonly class ExceptionHandler
{
    public function __construct(private ConfigServiceInterface $configService)
    {
    }

    /**
     * @param \Throwable $e
     */
    public function report(\Throwable $e): void
    {
        $message = $e->getMessage()
            . ' File: ' . $e->getFile()
            . ' Line: ' . $e->getLine();
        $logFile = $this->configService->getErrorLogFile();

        error_log($message . PHP_EOL, 3, $logFile);

        echo sprintf('Exception occurred! Please check errors log file.%s', PHP_EOL);
    }
}
