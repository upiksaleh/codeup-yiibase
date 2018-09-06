<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */
namespace codeup\helpers;
class DateTimeHelper
{
    /**
     * ex:
     * ` DateTimeHelper::monthName(date('n'))
     * @param $month nomor untuk bulan
     * @return string|null
     */
    public static function monthName($month){
        $bulan=array(
            "1" => "Januari",
            "2" => "Februari",
            "3" => "Maret",
            "4" => "April",
            "5" => "Mei",
            "6" => "Juni",
            "7" => "Juli",
            "8" => "Agustus",
            "9" => "September",
            "10" => "Oktober",
            "11" => "November",
            "12" => "Desember"
        );
        if(isset($bulan[$nbulan])) return $bulan[$nbulan];
        return null;
    }
}