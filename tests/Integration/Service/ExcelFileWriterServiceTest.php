<?php declare(strict_types = 1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Entity\YoutubeVideo;

class ExcelFileWriterServiceTest extends TestCase
{
    protected $fileName;

    protected $excelFileWriterService;

    protected function setUp()
    {
        $this->fileName = BASE_DIR . '/var/data/test.xlsx';

        $config = include BASE_DIR . '/config/parameters_test.php';
        $container = (new ContainerFactory($config))->create();

        $this->excelFileWriterService = $container['ExcelFileWriterService'];
    }

    protected function tearDown()
    {
        if (file_exists($this->fileName)) {
            unlink($this->fileName);
        }
    }

    public function testWrite()
    {
        $youTubeVideo = new YoutubeVideo();
        $youTubeVideo->setTitle('MLP: Equestria Girls Season 2');
        $youTubeVideo->setChannelTitle('My Little Pony Official');
        $youTubeVideo->setViewCount('282652');
        $youTubeVideo->setLikeCount('2896');
        $youTubeVideo->setUrl('https://www.youtube.com/watch?v=sru9dtw9q08');

        $this->excelFileWriterService->write($this->fileName, [$youTubeVideo]);

        $this->assertTrue(file_exists($this->fileName));
    }
}
