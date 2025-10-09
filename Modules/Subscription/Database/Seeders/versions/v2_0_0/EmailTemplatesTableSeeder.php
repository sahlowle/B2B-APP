<?php

namespace Modules\Subscription\Database\Seeders\versions\v2_0_0;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{
    /**
     * Update the SMS body of an email template with the given slug.
     *
     * @param  string  $slug
     * @param  string  $data
     */
    private function updateTemplate($slug, $data): void
    {
        $template = EmailTemplate::where('slug', $slug);

        if ($template->exists() && empty($template->first()->sms_body)) {
            $template->update(['sms_body' => $data]);
        }
    }

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $data = 'Hi {user_name}, your invoice ({subscription_code}) for the {plan} plan is due on {next_billing_date}. For help, contact us at {contact_number} or email {support_mail}. – {company_name}';

        $this->updateTemplate('subscription-invoice', $data);

        $data = 'Hi {user_name}, your subscription expired on {expire_date}. Renew now to avoid service interruption. Need help? Contact us at {support_mail}.';

        $this->updateTemplate('subscription-expire', $data);

        $data = 'Hi {customer_name}, your subscription will expire on {expire_date}. Please renew to avoid service interruption. Contact us: {support_mail}.';

        $this->updateTemplate('subscription-remaining', $data);

        $data = 'Hi {user_email}, welcome to {company_name}! 
Your private plan is ready: {plan_link}
(Note: Link is one-time use only.)
Need help? Contact us at {support_mail}';

        $this->updateTemplate('private-plan', $data);
    }
}
