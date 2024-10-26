<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;

interface FileWriterServiceInterface
{
    /**
     * @throws Exception
     * @throws WriterException
     */
    public function write(string $fileName, array $youtubeVideos): void;
}
