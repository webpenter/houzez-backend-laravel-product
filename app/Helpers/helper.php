<?php

if (!function_exists('formatTextWithNumber')) {
    function formatTextWithNumber($number, $text) {
        return $number > 1 ? "$number {$text}s" : "$number $text";
    }
}

if (!function_exists('currencySymbol')) {
    function currencySymbol($currencyCode)
    {
        $currencySymbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'JPY' => '¥',
            'INR' => '₹',
            'CAD' => 'C$',
            'AUD' => 'A$',
            'CHF' => 'CHF',
            'CNY' => '¥',
            'SEK' => 'kr',
            'NZD' => 'NZ$',
            'PKR' => 'RS',
        ];

        return $currencySymbols[strtoupper($currencyCode)] ?? $currencyCode;
    }
}

if (!function_exists('formatPrice')) {
    function formatPrice($price)
    {
        return number_format((float)$price, 2, '.', ',');
    }
}
