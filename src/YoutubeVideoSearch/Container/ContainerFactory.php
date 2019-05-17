<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Container;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Pimple\Container;
use YoutubeVideoSearch\Exception\ExceptionHandler;
use YoutubeVideoSearch\Service\CliArgsService;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\CurlService;
use YoutubeVideoSearch\Service\ExcelFileWriterService;
use YoutubeVideoSearch\Service\YoutubeDataService;
use YoutubeVideoSearch\Service\YoutubeVideoService;
use YoutubeVideoSearch\YoutubeVideoSearchApplication;

/**
 * Class ContainerFactory
 * @package YoutubeVideoSearch\Container
 */
class ContainerFactory
{
    /**
     * @var array
     */
    private $config;

    /**
     * ContainerFactory constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @return Container
     */
    public function create(): Container
    {
        $container = new Container();

        $container['ConfigService'] = function () {
            return new ConfigService($this->config);
        };

        $container['ExceptionHandler'] = function ($c) {
            return new ExceptionHandler(
                $c['ConfigService']
            );
        };

        $container['CurlService'] = function () {
            return new CurlService();
        };

        $container['YoutubeDataService'] = function ($c) {
            return new YoutubeDataService(
                $c['ConfigService'],
                $c['CurlService']
            );
        };

        $container['YoutubeVideoService'] = function ($c) {
            return new YoutubeVideoService(
                $c['ConfigService'],
                $c['YoutubeDataService']
            );
        };

        $container['Spreadsheet'] = function () {
            return new Spreadsheet();
        };

        $container['Xlsx'] = function ($c) {
            return new Xlsx(
                $c['Spreadsheet']
            );
        };

        $container['ExcelFileWriterService'] = function ($c) {
            return new ExcelFileWriterService(
                $c['Spreadsheet'],
                $c['Xlsx']
            );
        };

        $container['CliArgsService'] = function () {
            return new CliArgsService();
        };

        $container['YoutubeVideoSearchApplication'] = function ($c) {
            return new YoutubeVideoSearchApplication(
                $c['CliArgsService'],
                $c['ConfigService'],
                $c['YoutubeVideoService'],
                $c['ExcelFileWriterService']
            );
        };

        return $container;
    }
}
