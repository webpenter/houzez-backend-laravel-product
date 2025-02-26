<?php

use Carbon\Carbon;

if (!function_exists('formatDate')) {
    function formatDate($date, $format = 'F j, Y') {
        return $date ? \Carbon\Carbon::parse($date)->format($format) : null;
    }
}


if (!function_exists('formatTextWithNumber')) {
    function formatTextWithNumber($number, $text) {
        return $number > 1 ? "$number {$text}s" : "$number $text";
    }
}

if (!function_exists('currencySymbol')) {
    function currencySymbol($currencyCode)
    {
        $currencySymbols = [
            'USD' => '$',    // US Dollar
            'EUR' => '€',    // Euro
            'GBP' => '£',    // British Pound
            'JPY' => '¥',    // Japanese Yen
            'INR' => '₹',    // Indian Rupee
            'CAD' => 'C$',   // Canadian Dollar
            'AUD' => 'A$',   // Australian Dollar
            'CHF' => 'CHF',  // Swiss Franc
            'CNY' => '¥',    // Chinese Yuan
            'SEK' => 'kr',   // Swedish Krona
            'NZD' => 'NZ$',  // New Zealand Dollar
            'PKR' => 'Rs',   // Pakistani Rupee
            'SGD' => 'S$',   // Singapore Dollar
            'HKD' => 'HK$',  // Hong Kong Dollar
            'NOK' => 'kr',   // Norwegian Krone
            'MXN' => 'Mex$', // Mexican Peso
            'BRL' => 'R$',   // Brazilian Real
            'ZAR' => 'R',    // South African Rand
            'RUB' => '₽',    // Russian Ruble
            'KRW' => '₩',    // South Korean Won
            'TRY' => '₺',    // Turkish Lira
            'THB' => '฿',    // Thai Baht
            'AED' => 'د.إ',  // UAE Dirham
            'SAR' => '﷼',    // Saudi Riyal
            'EGP' => 'E£',   // Egyptian Pound
            'IDR' => 'Rp',   // Indonesian Rupiah
            'MYR' => 'RM',   // Malaysian Ringgit
            'PHP' => '₱',    // Philippine Peso
            'PLN' => 'zł',   // Polish Zloty
            'CZK' => 'Kč',   // Czech Koruna
            'HUF' => 'Ft',   // Hungarian Forint
            'DKK' => 'kr',   // Danish Krone
            'ILS' => '₪',    // Israeli Shekel
            'KWD' => 'KD',   // Kuwaiti Dinar
            'QAR' => '﷼',    // Qatari Riyal
            'OMR' => '﷼',    // Omani Rial
            'BHD' => 'BD',   // Bahraini Dinar
            'VND' => '₫',    // Vietnamese Dong
            'UAH' => '₴',    // Ukrainian Hryvnia
            'BGN' => 'лв',   // Bulgarian Lev
            'LKR' => 'Rs',   // Sri Lankan Rupee
            'BDT' => '৳',    // Bangladeshi Taka
            'MAD' => 'DH',   // Moroccan Dirham
            'TWD' => 'NT$',  // New Taiwan Dollar
            'ARS' => 'ARS$', // Argentine Peso
            'CLP' => 'CLP$', // Chilean Peso
            'COP' => 'COP$', // Colombian Peso
            'PEN' => 'S/',   // Peruvian Sol
            'ISK' => 'kr',   // Icelandic Krona
            'JMD' => 'J$',   // Jamaican Dollar
            'TTD' => 'TT$',  // Trinidad and Tobago Dollar
            'GHS' => 'GH₵',  // Ghanaian Cedi
            'NPR' => 'Rs',   // Nepalese Rupee
            'MVR' => 'Rf',   // Maldivian Rufiyaa
            'XAF' => 'CFA',  // Central African CFA Franc
            'XOF' => 'CFA',  // West African CFA Franc
            'UGX' => 'USh',  // Ugandan Shilling
            'TZS' => 'TSh',  // Tanzanian Shilling
            'KES' => 'KSh',  // Kenyan Shilling
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
