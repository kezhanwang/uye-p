<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/12/11
 * Time: 下午2:43
 */

namespace components;

use Mpdf\Mpdf;

require_once PATH_VENDOR . '/autoload.php';

class MpdfUtil
{
    /**
     * 输出结果文件
     */
    const DEST_OUTPUT = 'D';

    /**
     * 保存成文件
     */
    const DEST_FILE = "F";

    /**
     * 创建PDF文件
     * @param $title
     * @param $content
     * @param $fileName
     * @param string $outputDest
     * @param int $margin_top
     * @return string
     * @throws \Mpdf\MpdfException
     */
    public static function createPDF($title, $content, $fileName, $outputDest = self::DEST_OUTPUT, $margin_top = 27)
    {
        $pdf = new Mpdf([
            'mode' => 'zh-CN',
            'format' => 'A4',
        ]);
        $pdf->pdf_version = '1.5';
        $pdf->SetCreator(DOMAIN_BASE);
        $pdf->SetAuthor(DOMAIN_BASE);
        $pdf->SetTitle($title);
        $pdf->SetSubject(DOMAIN_BASE);
        $pdf->SetKeywords(DOMAIN_BASE);
        // 设置页脚
        $pdf->SetFooter('{PAGENO}');
        // 设置边距
        $pdf->SetMargins(15, 15, $margin_top);
        $pdf->SetAutoPageBreak(true, 20);
        // 设置字体
        $pdf->useFixedNormalLineHeight = false;
        $pdf->useFixedTextBaseline = false;
        $pdf->adjustFontDescLineheight = 1;
        $pdf->AddPage();
        $pdf->WriteHTML($content);
        return $pdf->Output($fileName, $outputDest);
    }
}