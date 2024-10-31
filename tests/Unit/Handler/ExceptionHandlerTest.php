<?php declare(strict_types=1);

namespace Tests\Unit\Handler;

use bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;
use YoutubeVideoSearch\Handler\ExceptionHandler;
use YoutubeVideoSearch\Service\ConfigServiceInterface;

class ExceptionHandlerTest extends TestCase
{
    public function testReport(): void
    {
        $this->expectOutputString(
            sprintf('Exception occurred! Please check errors log file.%s', PHP_EOL)
        );

        $structure = [
            'logs' => [
            ]
        ];
        $root = vfsStream::setup(sys_get_temp_dir(), null, $structure);

        $configService = $this
            ->getMockBuilder(ConfigServiceInterface::class)
            ->getMock();
        $configService->method('getErrorLogFile')->willReturn(
            $root->url() . '/logs/errors.log'
        );

        $message = 'Exception message to write in log file.';

        (new ExceptionHandler($configService))->report(new \Exception($message));

        $this->assertTrue($root->hasChild('logs/errors.log'));
        $this->assertStringContainsString(
            $message,
            $root->getChild('logs/errors.log')->getContent()
        );
    }
}
