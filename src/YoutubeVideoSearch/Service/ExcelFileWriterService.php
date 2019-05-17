<?php declare(strict_types = 1);

namespace YoutubeVideoSearch\Service;

use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Exception as WriterException;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * Class ExcelFileWriterService
 * @package YoutubeVideoSearch\Service
 */
class ExcelFileWriterService implements FileWriterServiceInterface
{
    const EXCEL_HEADER = [
        'Video title',
        'Number of views',
        'Number of likes',
        'Uploader name',
        'Video link'
    ];

    /**
     * @var Spreadsheet
     */
    private $spreadsheet;

    /**
     * @var Xlsx
     */
    private $xlsx;

    /**
     * ExcelFileWriterService constructor.
     * @param Spreadsheet $spreadsheet
     * @param Xlsx $xlsx
     */
    public function __construct(Spreadsheet $spreadsheet, Xlsx $xlsx)
    {
        $this->spreadsheet = $spreadsheet;
        $this->xlsx = $xlsx;
    }

    /**
     * @param string $fileName
     * @param array $youtubeVideos
     * @throws Exception
     * @throws WriterException
     */
    public function write(string $fileName, array $youtubeVideos): void
    {
        $activeSheet = $this->spreadsheet->getActiveSheet();

        $activeSheet->fromArray(self::EXCEL_HEADER, null, 'A1');
        $activeSheet->getStyle('A1:E1')->applyFromArray(
            [
                'fill' => [
                    'type' => Fill::FILL_SOLID,
                    'color' => ['rgb' => 'E5E4E2']
                ],
                'font'  => [
                    'bold' => true
                ]
            ]
        );

        foreach ($youtubeVideos as $key => $video) {
            $row = $key + 2;

            $activeSheet->setCellValue('A' . $row, $video->getTitle());
            $activeSheet->setCellValue('B' . $row, $video->getViewCount());
            $activeSheet->setCellValue('C' . $row, $video->getLikeCount());
            $activeSheet->setCellValue('D' . $row, $video->getChannelTitle());
            $activeSheet->setCellValue('E' . $row, $video->getUrl());
            $activeSheet->getCell('E' . $row)
                ->getHyperlink()
                ->setUrl($video->getUrl());
        }

        foreach (range('A', 'E') as $col) {
            $activeSheet->getColumnDimension($col)->setAutoSize(true);
        }

        $this->xlsx->save($fileName);
    }
}
