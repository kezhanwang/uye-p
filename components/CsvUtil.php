<?php
/**
 * Created by PhpStorm.
 * User: wangyi
 * Date: 2017/10/24
 * Time: 下午1:55
 */

namespace components;


class CsvUtil
{
    public static function exportCsv($data = [], $headerData = [], $fileName = '')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename=' . $fileName);
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        if (!empty($headerData)) {
            foreach ($headerData as $key => $value) {
                $headerData[$key] = iconv('utf-8', 'gbk', $value);
            }
            fputcsv($fp, $headerData);
        }
        $num = 0;
        //每隔$limit行，刷新一下输出buffer，不要太大，也不要太小
        $limit = 100000;
        //逐行取出数据，不浪费内存
        $count = count($data);
        if ($count > 0) {
            for ($i = 0; $i < $count; $i++) {
                $num++;
                //刷新一下输出buffer，防止由于数据过多造成问题
                if ($limit == $num) {
                    ob_flush();
                    flush();
                    $num = 0;
                }
                $row = $data[$i];
                foreach ($row as $key => $value) {
                    $row[$key] = iconv('utf-8', 'gbk', $value);
                }
                fputcsv($fp, $row);
            }
        }
        fclose($fp);
    }
}