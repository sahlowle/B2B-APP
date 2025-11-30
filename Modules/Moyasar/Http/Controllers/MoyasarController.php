<?php

namespace Modules\Moyasar\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Http;
use Modules\Addons\Entities\Addon;
use Modules\Moyasar\Entities\Moyasar;
use Modules\Stripe\Entities\StripeBody;
use Modules\Stripe\Http\Requests\StripeRequest;

class MoyasarController extends Controller
{
    public function store(StripeRequest $request)
    {
        $moyasarBody = new StripeBody($request);

        Moyasar::updateOrCreate(
            ['alias' => 'moyasar'],
            [
                'name' => 'Moyasar',
                'instruction' => $request->instruction,
                'status' => $request->status,
                'sandbox' => $request->sandbox,
                'image' => 'thumbnail.png',
                'data' => json_encode($moyasarBody),
            ]
        );

        return back()->with(['AddonStatus' => 'success', 'AddonMessage' => __('Moyasar settings updated.')]);
    }

    /**
     * Returns form for the edit modal
     *
     * @param \Illuminate\Http\Request
     * @return JsonResponse
     */
    public function edit(Request $request)
    {
            $module = Moyasar::first()->data;
       
        $addon = Addon::findOrFail('moyasar');

        return response()->json(
            [
                'html' => view('gateway::partial.form', compact('module', 'addon'))->render(),
                'status' => true,
            ],
            200
        );
    }


     public function addCard($holderName, $cardNumber, $month, $year, $cvv) :bool
     {

         $moyasar = Moyasar::firstWhere('alias', 'moyasar')->data;
         $publicKey = $moyasar->publishableKey;
         
         $response = Http::withBasicAuth($publicKey, '')
        ->asForm()
        ->post('https://api.moyasar.com/v1/tokens', [
            'name' => $holderName,
            'number' => $cardNumber,
            'month' => $month,
            'year' => $year,
            'cvc' => $cvv,
            'callback_url' => route('moyasar.save-card-webhook', auth()->id()),
        ]);

        if (filled($response->json('id'))) {

            $token = $response->json('id');

            auth()->user()->cards()->create([
                'token' => $token,
            ]);

            return true;
        }

        return false;
     }

     public function saveCardWebHook(Request $request, User $user)
     {
        abort_if($request->isNotFilled(['id']), 400, 'User not found');

        $user->cards()->create([
            'token' => $request->id,
        ]);

        return true;
     }
}
