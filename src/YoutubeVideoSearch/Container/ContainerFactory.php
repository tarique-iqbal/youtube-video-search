<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Container;

use Pimple\Container;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\CurlService;
use YoutubeVideoSearch\Service\YoutubeDataService;
use YoutubeVideoSearch\Service\YoutubeVideoService;

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

        return $container;
    }
}
