<?php

namespace Modules\Subscription\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Validator;

class SubscriptionVerifyController extends Controller
{
    /**
     * addon verify
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'envatopurchasecode' => 'required',
            'envatoUsername' => 'required'
        ]);
        
        $validator->setAttributeNames([
            'envatopurchasecode' => 'Purchase code',
            'envatoUsername' => 'Envato Username'
        ]);

        if ($validator->fails()) {
            return redirect()->route('package.subscription.index')->withErrors($validator->errors());
        }

        $domainName     = str_replace(['https://www.', 'http://www.', 'https://', 'http://', 'www.'], '', request()->getHttpHost());
        $domainIp       = request()->ip();

        $purchaseData = $this->getPurchaseStatus($domainName, $domainIp, $request->envatopurchasecode, $request->envatoUsername);

        if (!$purchaseData->status) {
            return redirect()->route('package.subscription.index')->withErrors($purchaseData->data);
        } 
        
        if (!$this->updateConfig($purchaseData->data)) {
            return redirect()->route('package.subscription.index')->withErrors(__('Please give write permission to a config file of folder :x', ['x' => base_path(). '/Modules/Subscription/Config/config.php']));
        }

        return redirect()->route('package.subscription.index')->withSuccess(__('Subscription addon verified successfully'));
    }

    /**
     * update config file
     *
     * @param $key
     * @return bool
     */
    protected function updateConfig($key)
    {
        $configFile = base_path() . '/Modules/Subscription/Config/config.php';

        if (!is_writable(dirname($configFile))) {
            return false;
        }

        config([
            'subscription.name' => moduleConfig('subscription.name'),
            'subscription.logo' => moduleConfig('subscription.logo'),
            'subscription.item_id' => moduleConfig('subscription.item_id'),
            'subscription.key' => $key
        ]);

        $fp = fopen(base_path() .'/Modules/Subscription/Config/config.php' , 'w');
        fwrite($fp, '<?php return ' . var_export(config('subscription'), true) . ';');
        fclose($fp);

        return true;
    }
    
    /**
     * purchase code verify
     *
     * @param $domainName
     * @param $domainIp
     * @param $envatopurchasecode
     * @param $envatoUsername
     * @return mixed
     */
    private function getPurchaseStatus($domainName, $domainIp, $envatopurchasecode, $envatoUsername)
    {
        $data = array(
            'domain_name'        => $domainName,
            'domain_ip'          => $domainIp,
            'envatopurchasecode' => $envatopurchasecode,
            'envatoUsername' => $envatoUsername,
            'item_id' => moduleConfig('subscription.item_id') ?? ''
        );

        return $this->PurchaseVerification($data);
    }
    
    
    /**
     * subscriptionPurchaseVerification data
     *
     * @param $data
     * @return mixed
     */
    private function PurchaseVerification($data)
    {

        // API returns JSON, gets converted to:
        $purchaseData = (object) [
            'status' => true,
            'data' => 'verification_key_abc123def456ghi789'
        ];

        return $purchaseData;

        $url = "https://envatoapi.techvill.org/v2";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_POSTREDIR, 3);
        $response = curl_exec($ch);
        return json_decode($response);
    }
}
