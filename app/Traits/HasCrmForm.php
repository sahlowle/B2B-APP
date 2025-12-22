<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait HasCrmForm
{
    public function sendToForm($name,array $data) : void
    {

        $url = match($name){
            'buyer_register' => 'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/ec61530e-df58-472b-b57a-ec5fb657d917',
            'factory_register' => 'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/50f47fb6-bede-4bd1-8b20-b4ac49078bbe',
            'rfq' => 'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/8edc7c6c-2139-4676-a50a-40f462686dba',
            'rfq_with_factories' =>'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/ac9e3255-cf52-4a84-be4c-442cedc714dc',
            'rfq_distributed' =>'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/bf3c8239-70f6-4efe-a32e-2c97b02b36f8',
            'rfq_replied' =>'https://services.leadconnectorhq.com/hooks/apUOfc4StICa0y0nNP3T/webhook-trigger/691ebc65-9be3-466f-b06c-2db21153f751',
            default => throw new \Exception('Invalid form name'),
        };

        $response = Http::timeout(40)->post($url, $data);

        Log::info("{$name} Form Response", [
            'name' => $name,
            'url' => $url,
            'status' => $response->status(),
            'response' => $response->body(),
        ]);

        if ($response->failed()) {
            Log::error("{$name} Form Error", [
                'url' => $url,
                'response' => $response->body(),
            ]);
        }
    }
}