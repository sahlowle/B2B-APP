<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 22-11-2021
 */

namespace App\Http\Controllers\Site;

use Auth;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{
    /**
     * Edit
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function edit()
    {
        return view('site.myaccount.profile');
    }

    /**
     * Update
     *
     * @param  int  $id
     * @return \Illuminate\Routing\Redirector
     */
    public function update(Request $request)
    {
        $response = ['status' => 'fail', 'message' => __('Invalid Request')];
        if ($request->isMethod('post')) {
            $result = $this->checkExistence(Auth::user()->id, 'users');
            if ($result['status'] === true) {
                $request['phone'] = $request['dial_code'] . $request['phone'];
                $validator = User::siteUpdateValidation($request->all(), Auth::user()->id);

                if ($validator->fails()) {
                    return back()->withErrors($validator)->withInput();
                }

                if ((new user())->updateUser($request->only('name', 'phone', 'birthday', 'address', 'gender'), Auth::user()->id)) {
                    $response = ['status' => 'success', 'message' => __('Your information has been successfully saved.')];
                }

            } else {
                $response['message'] = $result['message'];
            }
        }

        $this->setSessionValue($response);

        return redirect()->back();
    }

    /**
     * Setting
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function setting()
    {
        return view('site.myaccount.settings');
    }

    /**
     * Update password
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function updatePassword(Request $request)
    {
        $data = ['status' => 'fail', 'message' => __('Invalid Request')];
        $response = $this->checkExistence(Auth::user()->id, 'users', ['getData' => true]);
        if ($response['status'] === true) {
            $validator = User::siteUpdatePasswordValidation($request->all());
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }
            if (! Hash::check($request->old_password, $response['data']->password)) {
                $data['message'] = __('Old password is wrong.');
                $this->setSessionValue($data);

                return back();
            }
            $request['password'] = \Hash::make(trim($request->new_password));

            if ((new User())->siteUpdatePassword($request->only('password'), Auth::user()->id)) {
                $data = ['status' => 'success', 'message' => __('The :x has been successfully saved.', ['x' => __('Password')])];
            } else {
                $data['message'] = __('Nothing is updated.');
            }
        } else {
            $data['message'] = $response['message'];
        }

        $this->setSessionValue($data);

        return back();
    }

    /**
     * Delete
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {

        if (auth()->user()->role()->type == 'admin') {
            return back()->withFail(__("Admin account can't be deleted."));
        }

        if (User::where('id', \Auth::user()->id)->update(['status' => 'Deleted'])) {
            Auth::guard('user')->logout();

            return redirect()->route('site.index')->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Account')]));
        }

        return back()->withFail(__('Something went wrong, please try again.'));
    }

    /**
     * Delete Image
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage()
    {
        if ((new User())->removeProfileImage()) {
            return back()->withSuccess(__('Profile image remove successfully.'));
        }

        return back()->withFail(__('Profile image remove fail.'));
    }

    /**
     * Distinct User Activity
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function activity()
    {
        return view('site.myaccount.activities');
    }
}
