<?php

namespace App\Services\Currency;

use App\Models\Currency;

class ExchangeResource
{
    private $exchangeUrl;

    /**
     * use this function for each exchange data
     *
     * @return array[]
     */
    protected function exchangeResource()
    {
        return [
            'exchangerate-api' => [
                'url' => 'https://v6.exchangerate-api.com/v6/{api_key}/latest/{base_currency}',
                'method' => 'exchangeRate_Api',
            ],
        ];
    }

    /**
     * api setup & get data
     *
     * @return false
     */
    public function setup()
    {
        $exchangeResource = preference('exchange_resource');
        $apiData = $this->exchangeResource();

        if (! empty($exchangeResource)) {
            $apiData = $apiData[preference('exchange_resource')];
            $this->exchangeUrl = $apiData['url'];

            return $this->{$apiData['method']}();
        }

        return false;
    }

    /**
     * api call & get data
     *
     * @return false|mixed
     */
    protected function exchangeRate_Api()
    {
        $conversionRates = null;

        $currency = Currency::getAll()->where('id', preference('dflt_currency_id'))->first();

        if (empty($currency)) {
            return false;
        }

        $baseCurrency = $currency->name;
        $this->exchangeUrl = str_replace('{api_key}', preference('exchange_api_key'), $this->exchangeUrl);
        $this->exchangeUrl = str_replace('{base_currency}', $baseCurrency, $this->exchangeUrl);

        try {
            $response_json = file_get_contents($this->exchangeUrl);

            // Continuing if we got a result
            if ($response_json !== false) {

                // Try/catch for json_decode operation

                // Decoding
                $response = json_decode($response_json, true);

                // Check for success
                if (isset($response['result']) && $response['result'] === 'success') {
                    $conversionRates = $response['conversion_rates'];

                }

                return ! is_null($conversionRates) ? $conversionRates : false;

            }
        } catch (\Exception $e) {
            logger($e->getMessage());
        }

        return false;
    }
}
