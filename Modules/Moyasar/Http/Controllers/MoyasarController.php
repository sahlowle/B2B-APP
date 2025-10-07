<?php

namespace Modules\Moyasar\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
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
}
