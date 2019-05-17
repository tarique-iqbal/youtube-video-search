<?php declare(strict_types = 1);

namespace Tests\Integration\Container;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PHPUnit\Framework\TestCase;
use Pimple\Container;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Exception\ExceptionHandler;
use YoutubeVideoSearch\Service\CliArgsService;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\CurlService;
use YoutubeVideoSearch\Service\ExcelFileWriterService;
use YoutubeVideoSearch\Service\YoutubeDataService;
use YoutubeVideoSearch\Service\YoutubeVideoService;
use YoutubeVideoSearch\YoutubeVideoSearchApplication;

class ContainerFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $config = include BASE_DIR . '/config/parameters_test.php';

        $container = (new ContainerFactory($config))->create();

        $this->assertInstanceOf(Container::class, $container);
        $this->assertInstanceOf(ConfigService::class, $container['ConfigService']);
        $this->assertInstanceOf(CurlService::class, $container['CurlService']);
        $this->assertInstanceOf(YoutubeDataService::class, $container['YoutubeDataService']);
        $this->assertInstanceOf(YoutubeVideoService::class, $container['YoutubeVideoService']);
        $this->assertInstanceOf(Spreadsheet::class, $container['Spreadsheet']);
        $this->assertInstanceOf(Xlsx::class, $container['Xlsx']);
        $this->assertInstanceOf(ExcelFileWriterService::class, $container['ExcelFileWriterService']);
        $this->assertInstanceOf(CliArgsService::class, $container['CliArgsService']);
        $this->assertInstanceOf(YoutubeVideoSearchApplication::class, $container['YoutubeVideoSearchApplication']);
        $this->assertInstanceOf(ExceptionHandler::class, $container['ExceptionHandler']);
    }
}
