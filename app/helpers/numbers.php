<?php

use App\Models\Currency;

if (! function_exists('formatCurrencyAmount')) {
    function formatCurrencyAmount($value, $decimalDigit = null)
    {
        if (is_string($value)) {
            $value = (float) $value;
        }

        if (! is_int($value)) {

            if (is_null($decimalDigit)) {
                $decimalDigit = preference('decimal_digits');
            }

            $value = round($value, $decimalDigit);
        }

        $decimal_digits = $decimalDigit;
        if (preference('hide_decimal') == 1 && count(explode('.', $value)) == 1) {
            $decimal_digits = 0;
        }

        if (preference('thousand_separator') == '.') {
            return number_format((float) $value, $decimal_digits, ',', '.');
        }

        return number_format((float) $value, $decimal_digits, '.', ',');
    }
}

if (! function_exists('formatNumber')) {
    function formatNumber($value, $symbol = null)
    {
        $amount = formatCurrencyAmount($value);
        if (empty($symbol)) {
            $symbol = Currency::defaultSymbol();
        }
        if (preference('symbol_position') == 'before') {
            return $symbol . $amount;
        }

        return $amount . $symbol;
    }
}

if (! function_exists('validateNumbers')) {
    function validateNumbers($number)
    {
        if (preference('thousand_separator') == '.') {
            $number = str_replace('.', '', $number);
        } else {
            $number = str_replace(',', '', $number);
        }
        $number = floatval(str_replace(',', '.', $number));

        return $number;
    }
}

if (! function_exists('formatDecimal')) {
    function formatDecimal($value)
    {
        $decimal_digits = preference('decimal_digits');
        if (preference('hide_decimal') == 1 && count(explode('.', $value)) == 1) {
            $decimal_digits = 0;
        }

        return round($value, $decimal_digits);
    }
}

if (! function_exists('multiCurrencyFormatNumber')) {
    /**
     * same as formatNumber(), here only apply exchange rate, decimal digit frontend purposes
     */
    function multiCurrencyFormatNumber($value, $symbol = null)
    {
        $multicurrencyData = defaultMulticurrencyData();
        $value = ($value * $multicurrencyData['exchange_rate']);
        $amount = formatCurrencyAmount($value, $multicurrencyData['allow_decimal']);

        if (empty($symbol)) {
            $symbol = $multicurrencyData['symbol'];
        }

        if (preference('symbol_position') == 'before') {
            return $symbol . $amount;
        }

        return $amount . $symbol;
    }
}

if (! function_exists('formatMultiCurrencyAmount')) {
    /**
     * same as formatCurrencyAmount(), here only apply exchange rate frontend purposes
     */
    function formatMultiCurrencyAmount($value)
    {
        if (is_string($value)) {
            $value = (float) $value;
        }

        $multicurrencyData = defaultMulticurrencyData();
        $value = ($value * $multicurrencyData['exchange_rate']);
        $decimalDigit = $multicurrencyData['allow_decimal'];

        if (! is_int($value)) {
            $value = round($value, $decimalDigit);
        }

        $decimal_digits = $decimalDigit;
        if (preference('hide_decimal') == 1 && count(explode('.', $value)) == 1) {
            $decimal_digits = 0;
        }

        if (preference('thousand_separator') == '.') {
            return number_format((float) $value, $decimal_digits, ',', '.');
        }

        return number_format((float) $value, $decimal_digits, '.', ',');
    }
}
