<?php

namespace Modules\Subscription\Services\Mail;

use App\Services\Mail\TechVillageMail;

class SubscriptionInvoiceMailService extends TechVillageMail
{
    /**
     * Send mail to user
     *
     * @param object $request
     * @return array|object $response
     */
    public function send($subscription)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'subscription-invoice');

        if (!$email['status']) {
            return $email;
        }

        // Send pdf with mail
        createDirectory("public/uploads/invoices");
        $invoiceName = 'Invoice-' . $subscription->code . '-' . uniqid() . '.pdf';
        subscription('invoicePdfEmail', $subscription, $invoiceName);

        $user = $subscription->user()->first();

        // Replacing template variable
        $subject = str_replace(['{company_name}'], [preference('company_name')], $email->subject);

        $plan = $subscription?->package?->name ?? __('Unknown');

        $data = [
            '{logo}' => $this->logo,
            '{subscription_code}' => $subscription->code,
            '{plan}' => $plan,
            '{next_billing_date}' => formatDate($subscription->next_billing_date),
            '{user_name}' => $subscription?->user?->name,
            '{contact_number}' => preference('company_phone'),
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email'),
            '{amount}' => formatNumber($subscription->amount_billed),
            '{invoice_link}' => route('vendor.subscription.invoice', ['id' => $subscription->id]),
        ];

        $message = str_replace(array_keys($data), $data, $email->body);
        if (!empty($user->email)) {
            return $this->email->sendEmailWithAttachment($user->email, $subject, $message, $invoiceName, preference('company_name'));
        }

        return ['status' => false, 'message' => __('User email not found.')];
    }
}
