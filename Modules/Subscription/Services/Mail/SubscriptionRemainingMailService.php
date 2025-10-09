<?php

namespace Modules\Subscription\Services\Mail;

use App\Services\Mail\TechVillageMail;
use Modules\Subscription\Entities\PackageSubscriptionMeta;

class SubscriptionRemainingMailService extends TechVillageMail
{
    /**
     * Send mail to user
     * @param int $id
     * @return array $response
     */
    public function send($id)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'subscription-remaining');

        if (!$email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);

        $subscription = subscription('getSubscription', $id);

        $data = [
            '{customer_name}' => $subscription?->user?->name,
            '{subscription_code}' => $subscription->code,
            '{expire_date}' => formatDate($subscription->next_billing_date),
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{logo}' => $this->logo,
        ];

        $message = str_replace(array_keys($data), $data, $email->body);

        $mailResponse = $this->email->sendEmail($subscription?->user?->email, $subject, $message, null, preference('company_name'));

        if ($mailResponse['status']) {
            PackageSubscriptionMeta::updateOrInsert([
                'package_subscription_id' => $subscription->id,
                'key' => 'last_mail_sent'
            ], [
                'value' => date("Y-m-d")
            ]);
        }

        return $mailResponse;
    }
}
