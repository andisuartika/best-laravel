<?php

if (!function_exists('currency')) {
    function currency($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }
}
