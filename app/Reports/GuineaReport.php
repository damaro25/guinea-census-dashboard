<?php

namespace App\Reports;

use Illuminate\Support\Facades\Storage;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\CellAlignment;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Common\Entity\Style\Border;
use OpenSpout\Common\Entity\Style\BorderPart;
use Spatie\SimpleExcel\SimpleExcelWriter;
use Uneca\Chimera\Report\ReportBaseClass;

abstract class GuineaReport extends ReportBaseClass
{
    public $fileType = 'xlsx';
    protected $headersToSkip = 4;
    protected function writeFile(array $data, string $filename)
    {
        $border = new Border(
            new BorderPart(Border::BOTTOM, "#fff", Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::LEFT,  "#fff", Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::RIGHT,  "#fff", Border::WIDTH_THIN, Border::STYLE_SOLID),
            new BorderPart(Border::TOP,  "#fff", Border::WIDTH_THIN, Border::STYLE_SOLID)
        );

    $style = (new Style())
       ->setBorder($border)
       ->setCellAlignment(CellAlignment::RIGHT);

    $headerStyle = (new Style())
        ->setFontBold()
        ->setFontSize(13)
        ->setShouldWrapText()
        ->setBorder($border);
    $header = array_keys(reset($data)); // Actual headers (get from the first row)

    SimpleExcelWriter::create(Storage::disk('reports')
            ->path($filename),
            configureWriter: function ($writer) {
                $options = $writer->getOptions();
                $options->DEFAULT_COLUMN_WIDTH = 15;

            }
            )
            ->noHeaderRow()
            ->addRow([$this->report->title])
            ->addRow([__("As of "),now()->toDayDateTimeString()])
            ->setHeaderStyle($headerStyle)
            ->addHeader($header)
            ->addRows($data, $style);
    }


    public function getExcelReference($row, $column)
    {
        $row = $row + $this->headersToSkip;
        $column = $this->excelColumn($column);
        return "{$column}{$row}";

    }
    public function excelColumn($column){
        $column = $column;
        $alphabet = range('A', 'Z');
        $alphabet = array_merge($alphabet, array_map(function ($letter) {
            return 'A' . $letter;
        }, $alphabet));
        return $alphabet[$column];

    }

}
