<?php declare(strict_types=1);

namespace YoutubeVideoSearch;

use Assert\Assert;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use YoutubeVideoSearch\Service\CliArgsServiceInterface;
use YoutubeVideoSearch\Service\ConfigServiceInterface;
use YoutubeVideoSearch\Service\FileWriterServiceInterface;
use YoutubeVideoSearch\Service\YoutubeVideoServiceInterface;

final readonly class YoutubeVideoSearchApplication
{
    private const INPUT_SIZE = 1;

    public function __construct(
        private CliArgsServiceInterface $cliArgsService,
        private ConfigServiceInterface $configService,
        private YoutubeVideoServiceInterface $youtubeVideoService,
        private FileWriterServiceInterface $excelFileWriterService
    ) {
    }

    /**
     * @throws Exception
     * @throws WriterException
     */
    public function search(): void
    {
        $inputArgs = $this->cliArgsService->getArgs();
        $keyword = current($inputArgs);

        Assert::lazy()
            ->that($inputArgs, 'inputArgs')->isArray()->count(self::INPUT_SIZE)
            ->that($keyword, 'keyword')->regex('/^[a-z]{1}[a-z0-9.\-\'\s]+$/i')
            ->verifyNow();

        $keyword = urlencode($keyword);
        $youtubeVideos = $this->youtubeVideoService->searchAndSortByViewCountDescending($keyword);

        if (count($youtubeVideos) > 0) {
            $fileName = $this->configService->getExcelFile();

            $this->excelFileWriterService->write($fileName, $youtubeVideos);

            echo 'YouTube videos search and excel file has been written successfully.' . PHP_EOL;
        } else {
            echo 'YouTube video search result is empty.' . PHP_EOL;
        }
    }
}
