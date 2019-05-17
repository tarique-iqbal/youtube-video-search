<?php declare(strict_types = 1);

namespace Tests\Unit\Container;

use PHPUnit\Framework\TestCase;
use Pimple\Container;
use YoutubeVideoSearch\Container\ContainerFactory;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\CurlService;
use YoutubeVideoSearch\Service\YoutubeDataService;

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
    }
}
