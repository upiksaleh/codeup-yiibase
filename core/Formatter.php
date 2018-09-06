<?php
/**
 * CodeUP Framework using Yii Framework
 * @author Upik Saleh <upxsal@gmail.com>
 * @license MIT
 */

namespace codeup\core;


class Formatter extends \yii\i18n\Formatter
{
    /**
     * @param string $time1        waktu dari
     * @param string $time2        waktu ke
     * @param bool $hitungsekarang
     * @return float|int
     */
    public function asCountDay($time1, $time2, $hitungsekarang = true)
    {
        $time1 = $this->asTimestamp($time1);
        $time2 = $this->asTimestamp($time2);
        $datediff = $time2 - $time1;
        $day = round($datediff / (60 * 60 * 24));
        if($hitungsekarang) $day = $day+1;
        return $day;

    }
    function asPenyebut($nilai) {
        $nilai = abs($nilai);
        $huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " ". $huruf[$nilai];
        } else if ($nilai <20) {
            $temp = $this->asPenyebut($nilai - 10). " belas";
        } else if ($nilai < 100) {
            $temp = $this->asPenyebut($nilai/10)." puluh". $this->asPenyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->asPenyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->asPenyebut($nilai/100) . " ratus" . $this->asPenyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->asPenyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->asPenyebut($nilai/1000) . " ribu" . $this->asPenyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->asPenyebut($nilai/1000000) . " juta" . $this->asPenyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->asPenyebut($nilai/1000000000) . " milyar" . $this->asPenyebut(fmod($nilai,1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->asPenyebut($nilai/1000000000000) . " trilyun" . $this->asPenyebut(fmod($nilai,1000000000000));
        }
        return $temp;
    }

    function asTerbilang($nilai) {
        if($nilai<0) {
            $hasil = "minus ". trim($this->asPenyebut($nilai));
        } else {
            $hasil = trim($this->asPenyebut($nilai));
        }
        return strtoupper($hasil);
    }
}