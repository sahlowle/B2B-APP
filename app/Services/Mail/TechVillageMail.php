<?php

namespace App\Services\Mail;

use App\Http\Controllers\EmailController;
use App\Models\{
    EmailTemplate, Language, Preference
};

abstract class TechVillageMail
{
    protected $email;

    protected $logo;

    protected $response;

    abstract protected function send($request);

    /**
     * Constructor
     *
     * return void
     */
    public function __construct()
    {
        $this->email = new EmailController();
        $this->logo = Preference::where('field', 'company_logo')->first()->fileUrl();
        $this->response = ['status' => false, 'message' => __('Email can not be sent, please contact with admin.')];
    }

    /**
     * Mail setting
     *
     * @param  string  $langName,  $slug
     * @return object
     */
    protected function getTemplate($langName = null, $slug = null)
    {
        if (empty($slug)) {
            return $this->response;
        }

        $languageId = Language::getAll()->where('short_name', $langName)->first()->id;
        $emailTemplate = EmailTemplate::where(['status' => 'Active', 'slug' => $slug, 'language_id' => 1])->first();


        if ($languageId != 1) {
            $template = EmailTemplate::where(['parent_id' => $emailTemplate->id, 'language_id' => $languageId])->first();
        } else {
            $template = $emailTemplate;
        }


        if (empty($template)) {
            return $this->response;
        }
        $template->status = 'Active';

        return $template;
    }
}
