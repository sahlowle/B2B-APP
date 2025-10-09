<?php

namespace Modules\Subscription\Notifications;

use App\Notifications\Channel\AdminDatabaseChannel;
use App\Notifications\Channel\SmsChannel;
use App\Notifications\Notification;
use App\Traits\NotificationTrait;
use Illuminate\Bus\Queueable;
use Modules\Subscription\Services\Mail\SubscriptionInvoiceMailService;

class SubscriptionInvoiceNotification extends Notification
{
    use NotificationTrait;
    use Queueable;

    private $request;

    /**
     * Notification Label
     */
    public static $label = 'Subscription Invoice';

    /**
     * Image
     *
     * @var string
     */
    public static $image = 'public/frontend/img/order.png';

    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function setVia($notifiable)
    {
        return ['mail', 'database', SmsChannel::class, AdminDatabaseChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable)
    {
        return (new SubscriptionInvoiceMailService())->send($this->request);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => '',
            'message' => 'Subscription Invoice has been sent.',
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toAdmin(object $notifiable): array
    {
        return [
            'id' => $notifiable->id,
            'label' => static::$label,
            'url' => route('users.edit', ['id' => $notifiable->id]),
            'message' => "Subscription Invoice has been sent to $notifiable->name",
        ];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms(object $notifiable): array
    {
        return [
            'to' => $notifiable->phone,
            'message' => $this->getSmsData('subscription-invoice'),
        ];
    }

    /**
     * Replace SMS variables in the given SMS body.
     *
     * @param  string  $body
     * @return string
     */
    public function replaceSmsVariables($body)
    {
        $data = [
            '{user_name}' => $this->request?->user?->name,
            '{subscription_code}' => $this->request->code,
            '{plan}' => $this->request?->package?->name ?? __('Unknown'),
            '{next_billing_date}' => formatDate($this->request->next_billing_date),
            '{contact_number}' => preference('company_phone'),
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),

        ];

        return str_replace(array_keys($data), $data, $body);
    }
}
