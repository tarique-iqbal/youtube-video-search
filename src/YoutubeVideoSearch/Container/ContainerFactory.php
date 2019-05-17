<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Container;

use Pimple\Container;
use YoutubeVideoSearch\Service\ConfigService;
use YoutubeVideoSearch\Service\CurlService;

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

        return $container;
    }
}
