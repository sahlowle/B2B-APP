<?php

namespace Modules\Subscription\Services\Mail;

use App\Services\Mail\TechVillageMail;

class PrivatePlanMailService extends TechVillageMail
{
    /**
     * Send mail to user
     * @param object $request
     * @return array $response
     */
    public function send($request)
    {
        $email = $this->getTemplate(preference('dflt_lang'), 'private-plan');

        if (!$email['status']) {
            return $email;
        }

        // Replacing template variable
        $subject = str_replace('{company_name}', preference('company_name'), $email->subject);
        $data = [
            '{logo}' => $this->logo,
            '{company_name}' => preference('company_name'),
            '{support_mail}' => preference('company_email')
        ];

        $data['{user_email}'] = $request->email;
        $data['{plan_link}'] = route('vendor.private-plan', $request->link);
        $message = str_replace(array_keys($data), $data, $email->body);

        return $this->email->sendEmail($request->email, $subject, $message, null, preference('company_name'));
    }
}
