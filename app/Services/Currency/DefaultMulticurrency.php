<?php

namespace App\Services\Currency;

use Auth;
use Cache;

class DefaultMulticurrency
{
    private static $instance;

    private $data = null;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DefaultMulticurrency();
        }

        return self::$instance;
    }

    /**
     * set currency data
     *
     * @return array
     */
    public function setCurrencyData($multiCurrencies = null)
    {
        if (preference('enable_multicurrency') == '1') {

            if (is_null($multiCurrencies)) {
                $multiCurrencies  = \App\Models\MultiCurrency::getAll();
            }

            $userId = optional(Auth::guard('user')->user())->id;
            $userCacheKey = config('cache.prefix') . '-user-multi_currency-' . $userId;
            $guestUserCacheKey = config('cache.prefix') . '-guest-multi_currency-' . request()->server('HTTP_USER_AGENT');

            $currencyData = Cache::get($userCacheKey);

            if (! is_null($userId) && ! empty($currencyData) && empty(Cache::get($guestUserCacheKey))) {
                $currencyData = Cache::put($guestUserCacheKey, $currencyData, 5 * 365 * 86400);
            }

            if (is_null($userId)) {
                $currencyData = Cache::get($guestUserCacheKey);
            }

            if (empty($currencyData) && preference('auto_detect_currency') == 1 && ! request()->session()->has('auto_req')) {
                $currencyCode = \App\Services\Currency\ExchangeApiService::getCurrencyCodeFromServerIp();
                $currencyDetails = \App\Models\Currency::getAll()->where('name', $currencyCode)->first();

                if (! empty($currencyDetails) && isset($currencyDetails->multicurrency)) {
                    $currencyData = $currencyDetails->id;
                    Cache::put($guestUserCacheKey, $currencyData, 5 * 365 * 86400);

                    if (! is_null($userId)) {
                        Cache::put($userCacheKey, $currencyData, 5 * 365 * 86400);
                    }
                }
            }

            if (empty($currencyData) && ! is_null($userId) && ! empty(Cache::get($guestUserCacheKey))) {
                $currencyData = Cache::get($guestUserCacheKey);

                if (! empty($currencyData)) {
                    Cache::put($userCacheKey, $currencyData, 5 * 365 * 86400);
                }
            }

            if (empty($currencyData)) {
                $currencyData = preference('dflt_currency_id');
            }

            $defaultCurrency = $multiCurrencies->where('currency_id', $currencyData)->first();

            if (! empty($defaultCurrency)) {
                $this->data = [
                    'symbol' => ! empty($defaultCurrency->custom_symbol) ? $defaultCurrency->custom_symbol : $defaultCurrency->currency->symbol,
                    'name' => $defaultCurrency->currency->name,
                    'currency_id' => $defaultCurrency->currency_id,
                    'exchange_rate' => $defaultCurrency->exchange_rate,
                    'exchange_fee' => $defaultCurrency->exchange_fee,
                    'allow_decimal' => ! empty($defaultCurrency->allow_decimal_number) ? $defaultCurrency->allow_decimal_number : preference('decimal_digits'),
                ];

                return $this->data;
            }
        }

        $currency = currency();

        $this->data = [
            'symbol' => $currency->symbol,
            'name' => $currency->name,
            'currency_id' => $currency->id,
            'exchange_rate' => 1,
            'exchange_fee' => 0,
            'allow_decimal' => preference('decimal_digits'),
        ];

        return $this->data;
    }

    /**
     * get currency data
     *
     * @return null
     */
    public function getData()
    {
        return $this->data;
    }
}
