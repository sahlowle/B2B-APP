<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\MultiCurrencyRequest;
use App\Models\Currency;
use App\Models\MultiCurrency;
use App\Models\Preference;
use App\Services\Currency\ExchangeApiService;
use Illuminate\Http\Request;

class CurrencySettingsController extends Controller
{
    /**
     * multi-currency data
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        if ($request->isMethod('get')) {
            $data['multiCurrencies'] = MultiCurrency::getAll();
            $data['currencies'] = Currency::getAll();

            return view('admin.multi_currency.index', $data);
        }

        foreach ($request->except('_token', 'type') as $key => $value) {

            (new Preference())->storeOrUpdate([
                'category' => 'multi_currency', 'field' => $key, 'value' => $value ?? '',
            ]);

            session()->flash('sub_menu', $request->type ?? null);
        }

        return redirect()->back()->withSuccess(__('The :x has been successfully saved.', ['x' => __('Data')]));
    }

    /**
     * store data in multi-currency table
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MultiCurrencyRequest $request)
    {
        if (MultiCurrency::store($request->all())) {
            return redirect()->back()->with('sub_menu', 'currency')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Currency')]));
        }

        return redirect()->back()->with('sub_menu', 'currency')->withErrors(__('The :x can not be saved. Please try again.', ['x' => __('Currency')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = MultiCurrency::getAll()->where('id', $id)->first();

        return response()->json([
            'status' => 1,
            'records' =>  $data,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function update(MultiCurrencyRequest $request, $id)
    {
        $response = MultiCurrency::currencyUpdate($request->except('_token', '_method'), $id);

        if ($response) {

            return redirect()->back()->with('sub_menu', 'currency')->withSuccess(__('The :x has been successfully saved.', ['x' => __('Currency')]));
        }

        return redirect()->back()->with('sub_menu', 'currency')->withErrors(__('The :x can not be saved. Please try again.', ['x' => __('Currency')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $status = MultiCurrency::remove($id);

        if ($status['status']) {
            return redirect()->back()->with('sub_menu', 'currency')->withSuccess($status['msg']);
        }

        return redirect()->back()->with('sub_menu', 'currency')->withErrors($status['msg']);
    }

    /**
     * update exchange rate from api
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function exchangeUpdate(Request $request)
    {
        $exchangeService = new ExchangeApiService(true);

        if ($request->update_type == 'all') {
            $response = $exchangeService->exchangeRateUpdate();
            if ($response) {
                session()->flash('success', __('Exchange rate has been successfully updated.'));

                return response()->json([
                    'status' => 1,
                ]);
            }
        }

        $response = $exchangeService->exchangeRateUpdateSingle($request->multi_currency_id);
        if ($response) {

            return response()->json([
                'status' => 1,
                'exchange_rate' => $response,
            ]);
        }

        return response()->json([
            'status' => 0,
        ]);
    }
}
