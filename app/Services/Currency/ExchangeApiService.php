<?php

namespace App\Services\Currency;

use App\Models\MultiCurrency;

//use GeoIP;

class ExchangeApiService extends ExchangeResource
{
    private $decimal;

    private $multiCurrencies;

    private $conversionRates;

    public function __construct($setup = false)
    {
        $this->decimal = ! empty(preference('exchange_rate_decimal')) ? preference('exchange_rate_decimal') : 2;

        if ($setup) {
            $this->multiCurrencies = MultiCurrency::getAll();
            $this->conversionRates = $this->setup();
        }
    }

    /**
     * update all multicurrency exchange rates
     *
     * @return bool
     */
    public function exchangeRateUpdate()
    {
        if (! empty($this->conversionRates)) {
            foreach ($this->multiCurrencies as $currency) {
                if (isset($this->conversionRates[$currency->currency->name])) {
                    $exchangeRate = round($this->conversionRates[$currency->currency->name], $this->decimal);
                    MultiCurrency::currencyUpdate(['exchange_rate' => $exchangeRate], $currency->id);
                }
            }

            return true;
        }

        return false;
    }

    /**
     * update exchange rate for specific currency
     *
     * @return false|float
     */
    public function exchangeRateUpdateSingle($multicurrencyId = null)
    {
        $this->multiCurrencies = MultiCurrency::getAll()->where('id', $multicurrencyId)->first();

        if (! empty($this->conversionRates) && ! empty($this->multiCurrencies)) {

            if (isset($this->conversionRates[$this->multiCurrencies->currency->name])) {
                $exchangeRate = round($this->conversionRates[$this->multiCurrencies->currency->name], $this->decimal);
                MultiCurrency::currencyUpdate(['exchange_rate' => $exchangeRate], $this->multiCurrencies->id);
            }

            return $exchangeRate;
        }

        return false;
    }

    /**
     * get currency code from server ip
     *
     * @return array|string|null
     */
    public static function getCurrencyCodeFromServerIp($ip = null, $purpose = 'currency', $deep_detect = true)
    {
        $output = null;
        request()->session()->put('auto_req', true);
        if (filter_var($ip, FILTER_VALIDATE_IP) === false) {
            $ip = $_SERVER['REMOTE_ADDR'];

            if ($deep_detect) {
                if (filter_var(@$_SERVER['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                }

                if (filter_var(@$_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP)) {
                    $ip = $_SERVER['HTTP_CLIENT_IP'];
                }
            }
        }

        $purpose    = str_replace(['name', "\n", "\t", ' ', '-', '_'], null, strtolower(trim($purpose)));
        $support    = ['country', 'countrycode', 'state', 'region', 'city', 'location', 'address', 'currency'];
        $continents = [
            'AF' => 'Africa',
            'AN' => 'Antarctica',
            'AS' => 'Asia',
            'EU' => 'Europe',
            'OC' => 'Australia (Oceania)',
            'NA' => 'North America',
            'SA' => 'South America',
        ];

        if (filter_var($ip, FILTER_VALIDATE_IP) && in_array($purpose, $support)) {
            $ipdat = @json_decode(file_get_contents('http://www.geoplugin.net/json.gp?ip=' . $ip));
            if (@strlen(trim($ipdat->geoplugin_countryCode)) == 2) {
                switch ($purpose) {
                    case 'location':
                        $output = [
                            'city'           => @$ipdat->geoplugin_city,
                            'state'          => @$ipdat->geoplugin_regionName,
                            'country'        => @$ipdat->geoplugin_countryName,
                            'country_code'   => @$ipdat->geoplugin_countryCode,
                            'continent'      => @$continents[strtoupper($ipdat->geoplugin_continentCode)],
                            'continent_code' => @$ipdat->geoplugin_continentCode,
                            'currency_code' => @$ipdat->geoplugin_currencyCode,
                        ];

                        break;
                    case 'address':
                        $address = [$ipdat->geoplugin_countryName];
                        if (@strlen($ipdat->geoplugin_regionName) >= 1) {
                            $address[] = $ipdat->geoplugin_regionName;
                        }
                        if (@strlen($ipdat->geoplugin_city) >= 1) {
                            $address[] = $ipdat->geoplugin_city;
                        }
                        $output = implode(', ', array_reverse($address));

                        break;
                    case 'city':
                        $output = @$ipdat->geoplugin_city;

                        break;
                    case 'region':
                    case 'state':
                        $output = @$ipdat->geoplugin_regionName;

                        break;
                    case 'country':
                        $output = @$ipdat->geoplugin_countryName;

                        break;
                    case 'countrycode':
                        $output = @$ipdat->geoplugin_countryCode;

                        break;

                    case 'currency':
                        $output = @$ipdat->geoplugin_currencyCode;

                        break;
                }
            }
        }

        return $output;
    }
}
