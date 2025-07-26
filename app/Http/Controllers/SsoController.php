<?php
/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 *
 * @created 11-11-2021
 */

namespace App\Http\Controllers;

use App\Lib\Env;
use Illuminate\Http\Request;
use Validator;
use App\Models\Preference;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Http\Rules\RedirectRule;
use Laravel\Passport\Passport;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Laravel\Passport\Client;

use function GuzzleHttp\json_encode;

class SsoController extends Controller
{
    /**
     * The client repository instance.
     *
     * @var \Laravel\Passport\ClientRepository
     */
    protected $clients;

    /**
     * The validation factory implementation.
     *
     * @var \Illuminate\Contracts\Validation\Factory
     */
    protected $validation;

    /**
     * The redirect validation rule.
     *
     * @var \Laravel\Passport\Http\Rules\RedirectRule
     */
    protected $redirectRule;

    public function __construct(
        Request $req,
        ClientRepository $clients,
        ValidationFactory $validation,
        RedirectRule $redirectRule
    ) {
        //this middleware should be for POST request only
        if ($req->isMethod('post')) {
            $this->middleware('checkForDemoMode')->only('index');
        }

        $this->clients = $clients;
        $this->validation = $validation;
        $this->redirectRule = $redirectRule;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function index(Request $request)
    {
        $response = $this->messageArray(__('Invalid Request'), 'fail');

        $data['list_menu'] = 'sso';
        if ($request->isMethod('get')) {
            $data['preference'] = preference('sso_service');

            return view('admin.sso_service.index', $data);
        } elseif ($request->isMethod('post')) {

            $validator = Validator::make($request->all(), [
                'data' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            foreach ($request->data as $key => $dt) {

                if ($key == 'facebook') {

                    Env::set('FACEBOOK_CLIENT_ID', $dt['client_id'] ?? '');
                    Env::set('FACEBOOK_CLIENT_SECRET', $dt['client_secret'] ?? '');
                    Env::set('FACEBOOK_REDIRECT_URL', route('facebook'));
                } elseif ($key == 'google') {
                    Env::set('GOOGLE_CLIENT_ID', $dt['client_id'] ?? '');
                    Env::set('GOOGLE_CLIENT_SECRET', $dt['client_secret'] ?? '');
                    Env::set('GOOGLE_REDIRECT_URL', route('google'));
                }
            }

            $sso = ['category' => 'preference', 'field' => 'sso_service'];
            $sso['value'] = empty($request->sso_service) ? '' : json_encode($request->sso_service);
            (new Preference())->storeOrUpdate($sso);
            $response = $this->messageArray(__('The :x has been successfully saved.', ['x' => __('SSO Service')]), 'success');
            $this->setSessionValue($response);

            return redirect()->route('sso.index');
        }
    }

    /**
     * SSO Client
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function client(Request $request)
    {
        $data['list_menu'] = 'sso_client';

        if ($request->isMethod('post')) {

            $this->validation->make($request->all(), [
                'name' => 'required|max:191',
                'redirect' => ['required', $this->redirectRule],
                'confidential' => 'boolean',
            ])->validate();

            $client = $this->clients->create(
                $request->user()->getAuthIdentifier(),
                $request->name,
                $request->redirect,
                null,
                false,
                false,
                (bool) $request->input('confidential', true)
            );

            if (Passport::$hashesClientSecrets) {
                return ['plainSecret' => $client->plainSecret] + $client->toArray();
            }
        }

        $data['clients'] = $request->user()->clients->sortByDesc('id');

        return view('admin.sso_service.client', $data);
    }

    /**
     * Delete SSO Client
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteClient(Request $request, $id)
    {
        $client = Client::where('id', $id);

        if (! $client->exists()) {
            return redirect()->back()->with('error', __('The :x does not exist.', ['x' => __('SSO Client')]));
        }

        $client->delete();

        return redirect()->back()->with('success', __('The :x has been successfully deleted.', ['x' => __('SSO Client')]));
    }
}
