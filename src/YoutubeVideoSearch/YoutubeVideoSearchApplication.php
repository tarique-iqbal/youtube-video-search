<?php declare(strict_types = 1);

namespace YoutubeVideoSearch;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use YoutubeVideoSearch\Service\CliArgsServiceInterface;
use YoutubeVideoSearch\Service\ConfigServiceInterface;
use YoutubeVideoSearch\Service\FileWriterServiceInterface;
use YoutubeVideoSearch\Service\YoutubeVideoServiceInterface;
use YoutubeVideoSearch\Validator\ArraySizeValidator;
use YoutubeVideoSearch\Validator\SearchKeywordValidator;

/**
 * Class YoutubeVideoApplication
 * @package YoutubeVideoSearch
 */
class YoutubeVideoSearchApplication
{
    const INPUT_SIZE = 1;

    /**
     * @var CliArgsServiceInterface
     */
    private $cliArgsService;

    /**
     * @var ConfigServiceInterface
     */
    private $configService;

    /**
     * @var YoutubeVideoServiceInterface
     */
    private $youtubeVideoService;

    /**
     * @var FileWriterServiceInterface
     */
    private $excelFileWriterService;

    /**
     * YoutubeVideoApplication constructor.
     * @param CliArgsServiceInterface $cliArgsService
     * @param ConfigServiceInterface $configService
     * @param YoutubeVideoServiceInterface $youtubeVideoService
     * @param FileWriterServiceInterface $excelFileWriterService
     */
    public function __construct(
        CliArgsServiceInterface $cliArgsService,
        ConfigServiceInterface $configService,
        YoutubeVideoServiceInterface $youtubeVideoService,
        FileWriterServiceInterface $excelFileWriterService
    ) {
        $this->cliArgsService = $cliArgsService;
        $this->configService = $configService;
        $this->youtubeVideoService = $youtubeVideoService;
        $this->excelFileWriterService = $excelFileWriterService;
    }

    /**
     * @throws Exception
     * @throws WriterException
     */
    public function search(): void
    {
        $keyword = $this->cliArgsService->getArgs();

        if ($this->validateInput($keyword) === true) {
            $youtubeVideos = $this->youtubeVideoService->searchAndSortByViewCountDescending(urlencode($keyword[0]));

            if (count($youtubeVideos) > 0) {
                $fileName = $this->configService->getExcelFile();

                $this->excelFileWriterService->write($fileName, $youtubeVideos);

                echo 'YouTube videos search and excel file has been written successfully.' . PHP_EOL;
            } else {
                echo 'YouTube video search result is empty.' . PHP_EOL;
            }
        }
    }

    /**
     * @param array $keyword
     * @return bool
     */
    private function validateInput(array $keyword): bool
    {
        $arraySizeValidator = new ArraySizeValidator();

        if ($arraySizeValidator->isValid($keyword, self::INPUT_SIZE) === false) {
            echo $arraySizeValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        $searchKeywordValidator = new SearchKeywordValidator();

        if ($searchKeywordValidator->isValid($keyword[0]) === false) {
            echo $searchKeywordValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        return true;
    }
}
