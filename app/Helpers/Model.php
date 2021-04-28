<?php
namespace App\Helpers;

class Rupiah {
    public static function getRupiah($value) {
        $format = "Rp " . number_format($value,2,',','.');
        return $format;
    }
}