<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 25-01-2024
 */

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Notification List
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('site.myaccount.notification');
    }

    /**
     * Delete Notification
     *
     * @param  string  $id
     */
    public function destroy($id)
    {
        $notification = DatabaseNotification::where('id', $id);

        if ($notification->exists()) {
            $notification->delete();

            return back()->withSuccess(__('The :x has been successfully deleted.', ['x' => __('Notification')]));
        }

        return back()->withErrors(__('Failed to delete :x', ['x' => __('Notification')]));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  int  $id  The ID of the notification.
     * @return int The number of affected rows (0 or 1).
     */
    public function markAsRead($id)
    {
        return DatabaseNotification::where('id', $id)->update(['read_at' => now()]);
    }

    /**
     * Mark a specific notification as unread.
     *
     * @param  int  $id  The ID of the notification.
     * @return int The number of affected rows (0 or 1).
     */
    public function markAsUnread($id)
    {
        return DatabaseNotification::where('id', $id)->update(['read_at' => null]);
    }

    /**
     * View Notification
     */
    public function view($id)
    {
        DatabaseNotification::where('id', $id)->update(['read_at' => now()]);

        if (! isset(request()->url)) {
            return back();
        }

        return redirect()->intended(request()->url);
    }
}
