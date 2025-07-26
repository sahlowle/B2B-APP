"use strict";

function getDecimalNumberFormat(num = 0)
{
    if (thousand_separator != null && decimal_digits != null && num != null) {
        num = roundLikePHP(num, decimal_digits);
        num = parseFloat(num).toFixed(decimal_digits);
        if (thousand_separator == '.') {
            num = numberWithDot(num);
        } else if (thousand_separator == ',') {
            num = numberWithCommas(num);
        }
    }
    return num;
}

function numberWithCommas(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return parts.join(".");
}

function decimalNumberFormatWithCurrency(number = 0) {
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return currencySymbol + num;
    } else {
        return num + currencySymbol;
    }
}

function decimalNumberFormatWithMultiCurrency(number = 0) {
    number = (number * exchangeRate);
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return currencySymbol + num;
    } else {
        return num + currencySymbol;
    }
}

function decimalNumberFormatWithEquiCurrency(number = 0) {
    number = (number * equivalentExchangeRate);
    var num = getDecimalNumberFormat(number);
    if (symbol_position == 'before') {
        return equivalentSymbol + num;
    } else {
        return num + equivalentSymbol;
    }
}

function getDecimalNumberFormatMultiCurrency(num = 0)
{
    num = (num * exchangeRate);
    if (thousand_separator != null && decimal_digits != null && num != null) {
        num = roundLikePHP(num, decimal_digits);
        num = parseFloat(num).toFixed(decimal_digits);
        if (thousand_separator == '.') {
            num = numberWithDot(num);
        } else if (thousand_separator == ',') {
            num = numberWithCommas(num);
        }
    }
    return num;
}

function roundLikePHP(num, dec){
    var num_sign = num >= 0 ? 1 : -1;
    return parseFloat((Math.round((num * Math.pow(10, dec)) + (num_sign * 0.0001)) / Math.pow(10, dec)).toFixed(dec));
}

function numberWithDot(x)
{
    var parts = x.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    return parts.join(",");
}
