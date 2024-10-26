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
final readonly class YoutubeVideoSearchApplication
{
    private const INPUT_SIZE = 1;

    /**
     * YoutubeVideoApplication constructor.
     * @param CliArgsServiceInterface $cliArgsService
     * @param ConfigServiceInterface $configService
     * @param YoutubeVideoServiceInterface $youtubeVideoService
     * @param FileWriterServiceInterface $excelFileWriterService
     */
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

        if ($this->validateInput($inputArgs) === true) {
            $keyword = urlencode(current($inputArgs));
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

    /**
     * @param array $inputArgs
     * @return bool
     */
    private function validateInput(array $inputArgs): bool
    {
        $arraySizeValidator = new ArraySizeValidator();

        if ($arraySizeValidator->isValid($inputArgs, self::INPUT_SIZE) === false) {
            echo $arraySizeValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        $searchKeywordValidator = new SearchKeywordValidator();

        if ($searchKeywordValidator->isValid($inputArgs[0]) === false) {
            echo $searchKeywordValidator->getErrorMessage() . PHP_EOL;

            return false;
        }

        return true;
    }
}
