<?php
/**
 * Format Helper
 * Functions for formatting data like dates, prices, and text
 */

function formatPrice($price): string
{
    return number_format((float) $price, 0, ',', '.') . ' VND';
}

function formatDate($date): string
{
    if (empty($date)) {
        return '';
    }

    $timestamp = strtotime((string) $date);

    if ($timestamp === false) {
        return (string) $date;
    }

    return date('d/m/Y', $timestamp);
}
?>
