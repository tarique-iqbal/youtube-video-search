<?php declare(strict_types = 1);

namespace Tests\Integration\Service;

use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Service\CurlService;

class CurlServiceTest extends TestCase
{
    protected $headers = [];

    protected function setUp()
    {
        $this->headers = [
            'Content-Type: text/html; charset=utf-8'
        ];
    }

    public function testGet(): void
    {
        $testUrl = $_SERVER['REQUEST_SCHEME']
            . '://' . $_SERVER['HTTP_HOST']
            . '/' . $_SERVER['REQUEST_URI'];

        $curlService = new CurlService();
        $response = $curlService->get($testUrl, $this->headers);

        $this->assertTrue(strlen($response) > 0);
    }

    public function testGetByInvalidUrl(): void
    {
        $this->expectException(\UnexpectedValueException::class);

        $invalidUrl = 'invalidDummyUrl';
        $curlService = new CurlService();

        $curlService->get($invalidUrl, $this->headers);
    }
}
