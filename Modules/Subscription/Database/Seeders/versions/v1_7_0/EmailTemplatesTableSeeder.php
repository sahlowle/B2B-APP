<?php

namespace Modules\Subscription\Database\Seeders\versions\v1_7_0;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;

class EmailTemplatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        $subscriptionInvoice = EmailTemplate::where(['slug' => 'subscription-invoice'])->first();

        if (!$subscriptionInvoice) {
            EmailTemplate::insert([
                'parent_id' => NULL,
                'name' => 'Subscription Invoice',
                'slug' => 'subscription-invoice',
                'subject' => 'Your Invoice from {company_name} has been created.',
                'body' => '<!DOCTYPE html>
                <html>

                <head>
                <meta charset="utf-8" />
                <meta http-equiv="x-ua-compatible" content="ie=edge" />
                <title>3.Invoice</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <style type="text/css">
                @media screen {
                @font-face {
                font-family: "DM Sans";
                font-weight: 700;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
                }

                @font-face {
                font-family: "DM Sans";
                font-weight: 500;
                font-style: normal;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
                }

                @font-face {
                font-family: \'Roboto\';
                font-style: normal;
                font-weight: 500;
                src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format(\'woff2\');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }
                }

                .bodys,
                .tables,
                td,
                .anchor-tag a {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                }

                .tables,
                td {
                mso-table-rspace: 0pt;
                mso-table-lspace: 0pt;
                }

                .anchor-tag a {
                padding: 1px;
                margin: 1px;
                }

                .anchor-tag a[x-apple-data-detectors] {
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                color: inherit !important;
                text-decoration: none !important;
                }

                .bodys {
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                }

                .tables {
                border-collapse: collapse !important;
                }

                .logo-img {
                margin: 26px 0px 19px 0px;
                padding: 0px;
                width: 207.98px;
                height: 56px;
                }

                .actives {
                box-sizing: border-box;
                text-decoration: none;
                -webkit-text-size-adjust: none;
                text-align: center;
                border-radius: 2px;
                -webkit-border-radius: 2px;
                -moz-border-radius: 2px;
                -khtml-border-radius: 2px;
                -o-border-radius: 2px;
                -ms-border-radius: 2px;
                padding: 10px 31px;
                cursor: pointer;
                background: #fcca19;
                }

                .anchor-tag a:focus,
                .anchor-tag a:hover {
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }

                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }

                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: none;
                text-decoration-color: #fcca19;
                }
                </style>
                </head>

                <body class="bodys" style="background-color: #e9ecef">
                <div class="preheader"
                style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
                </div>
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
                <tr>
                <td align="center" valign="top" style="padding: 36px 24px"></td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; margin-top: 100px">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <img class="logo-img" src="{logo}" alt="logo" />
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td bgcolor="#fff">
                <p
                style="font-family: \'DM Sans\', sans-serif; margin: 28px 32px 20px 32px; line-height: 16px; font-size:26px !important; color: #3c3c3c; font-weight: 600 !important; cursor: default !important;">
                Your subscription invoice has been generated</p>
                
                <p style="margin-top: 22px; padding:0px 30px 0px 32px; font-family: \'DM Sans\', sans-serif; text-align: left; font-style: normal; font-weight: 500; font-size: 16px; line-height: 28px; color: #898989;
                "><span style="color: #2C2C2C;">Hello {user_name},</span>
                <br> We’ve issued invoice #{subscription_code} for your account.
                <br>
                <div style="margin-left: 32px; margin-bottom: 14px;">
                <span style="line-height: 28px; font-weight: 700; color: #2C2C2C;">Payment amount:</span> <span style="font-weight: 400; color: #424141;">{amount}</span>
                <br>
                <span style="line-height: 28px; font-weight: 700; color: #2C2C2C;">Subscription plan:</span> <span style="font-weight: 400; color: #424141;">{plan}</span>
                <br>
                <span style="line-height: 28px; font-weight: 700; color: #2C2C2C;">Subscription period end date:</span> <span style="font-weight: 400; color: #424141;">{next_billing_date}</span>
                <br>

                <p style="color: #2C2C2C; margin-top: 16px;">You can view or download your invoice using the link below:</p>

                <p style="text-align: center; margin-right: 32px; margin-top: 32px; margin-bottom: 22px;">
                <a href="{invoice_link}" style="border: 1px solid #e0dede; padding: 10px 20px; border-radius: 5px; text-decoration: none; background-color: #fcfcfc; color: #2e2e2e;">View Invoice</a>
                </p>

                <p style="margin-top: 40px; margin-bottom: 8px; font-size: 16px;">Need assistance?</p>
                <div style="margin-top: 2px; font-size: 16px; display: flex; align-items: center;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-2" height="16" width="16" style="margin-top: 2px; margin-right: 4px; color: #898989">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                </svg>
                <p style="font-weight: 600; margin: 4px;">{contact_number}</p></div>
                <div style="margin-top: 2px; font-size: 16px; display: flex; align-items: center; margin-bottom: 20px;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6" height="16" width="16" style="margin-top: 2px; margin-right: 4px; color: #898989">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>
                    <p style="font-weight: 600; margin: 4px;">{support_mail}</p>
                </div>
                </div>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#ffffff">

                <div style="clear: both;"></div>

                
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <p
                style="text-align: center; line-height: 16px; color: #898989; font-size: 14px; margin: 13px 0px;">
                &copy; 2025, {company_name}. All rights reserved.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </body>

                </html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'subscription_code, amount, invoice_link, plan, next_billing_date, user_name, contact_number, support_mail, company_name, logo',
            ]);
        }

        $subscriptionExpire = EmailTemplate::where(['slug' => 'subscription-expire'])->first();

        if (!$subscriptionExpire) {
            EmailTemplate::insert([
                'parent_id' => NULL,
                'name' => 'Subscription Expire',
                'slug' => 'subscription-expire',
                'subject' => 'Your Subscription has been Expired',
                'body' => '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8" />
                <meta http-equiv="x-ua-compatible" content="ie=edge" />
                <title>3.Invoice</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <style type="text/css">
                @media screen {
                @font-face {
                font-family: "DM Sans";
                font-weight: 700;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
                }
                @font-face {
                font-family: "DM Sans";
                font-weight: 500;
                font-style: normal;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
                }
                @font-face {
                font-family: \'Roboto\';
                font-style: normal;
                font-weight: 500;
                src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format(\'woff2\');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }
                }
                .bodys,
                .tables,
                td,
                .anchor-tag a {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                }
                .tables,
                td {
                mso-table-rspace: 0pt;
                mso-table-lspace: 0pt;
                }
                .anchor-tag a {
                padding: 1px;
                margin: 1px;
                }
                .anchor-tag a[x-apple-data-detectors] {
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                color: inherit !important;
                text-decoration: none !important;
                }
                .bodys {
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                }
                .tables {
                border-collapse: collapse !important;
                }
                .logo-img {
                margin: 26px 0px 19px 0px;
                padding: 0px;
                width: 207.98px;
                height: 56px;
                }
                .actives {
                box-sizing: border-box;
                text-decoration: none;
                -webkit-text-size-adjust: none;
                text-align: center;
                border-radius: 2px;
                -webkit-border-radius: 2px;
                -moz-border-radius: 2px;
                -khtml-border-radius: 2px;
                -o-border-radius: 2px;
                -ms-border-radius: 2px;
                padding: 10px 31px;
                cursor: pointer;
                background: #fcca19;
                }
                .anchor-tag a:focus,
                .anchor-tag a:hover {
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: none;
                text-decoration-color: #fcca19;
                }
                </style>
                </head>
                <body class="bodys" style="background-color: #e9ecef">
                <div class="preheader"
                style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
                </div>
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
                <tr>
                <td align="center" valign="top" style="padding: 36px 24px"></td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; margin-top: 100px">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <img class="logo-img" src="{logo}" alt="logo" />
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#fff">
                <p
                style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 28px 0px 20px 0px; line-height: 25px; font-size:14px !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
                Subscription Expire</p>
                <p
                style="margin: 0px; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 28px; text-align: center; color: #2C2C2C;">
                SUBSCRIPTION CODE</p>
                <p style="margin-top: 5px;font-family: \'DM Sans\', sans-serif;  font-style: normal; font-weight: 700;
                font-size: 32px; line-height: 28px; text-align: center; color: #2C2C2C;">{subscription_code}
                </p>
                <p style="margin-top: 32px; padding:0px 30px 0px 37px; font-family: \'DM Sans\', sans-serif; text-align: left; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; color: #898989;
                "><span style="color: #2C2C2C;">Dear {user_name},</span>
                <br> We hope you\'re enjoying our services! We want to remind you that your subscription has been expired on <b>{expire_date}</b>. Please renew your subscription in order to continue enjoying our services without interruption.
                <br>
                For further information, login to
                your account.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <div style="clear: both;"></div>
                <div>
                <br>
                <p
                style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px;line-height: 21px; margin-top:1px ;text-align:center; text-transform: uppercase; color: #2C2C2C;">
                Keep in touch</p>
                </div>
                <div
                style="margin-top: 1px; font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
                <p style="margin-top:14px"> If you have any queries, concerns or suggestions,</p>
                <p style="margin:0px; margin-top:1px"> please email us: <span
                style="cursor: pointer; color: #0060A9; text-decoration: underline;">{support_mail}</span>
                </p>
                </div>
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <p
                style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
                &copy; 2023, {company_name}. All rights reserved.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </body>
                </html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'subscription_code, expire_date, user_name, support_mail, company_name, logo'
            ]);
        }

        $subscriptionRemaining = EmailTemplate::where(['slug' => 'subscription-remaining'])->first();

        if (!$subscriptionRemaining) {
            EmailTemplate::insert([
                'parent_id' => NULL,
                'name' => 'Subscription Remaining',
                'slug' => 'subscription-remaining',
                'subject' => 'Your Subscription will expired soon',
                'body' => '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8" />
                <meta http-equiv="x-ua-compatible" content="ie=edge" />
                <title>3.Invoice</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <style type="text/css">
                @media screen {
                @font-face {
                font-family: "DM Sans";
                font-weight: 700;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
                }
                @font-face {
                font-family: "DM Sans";
                font-weight: 500;
                font-style: normal;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
                }
                @font-face {
                font-family: \'Roboto\';
                font-style: normal;
                font-weight: 500;
                src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format(\'woff2\');
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
                }
                }
                .bodys,
                .tables,
                td,
                .anchor-tag a {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                }
                .tables,
                td {
                mso-table-rspace: 0pt;
                mso-table-lspace: 0pt;
                }
                .anchor-tag a {
                padding: 1px;
                margin: 1px;
                }
                .anchor-tag a[x-apple-data-detectors] {
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                color: inherit !important;
                text-decoration: none !important;
                }
                .bodys {
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                }
                .tables {
                border-collapse: collapse !important;
                }
                .logo-img {
                margin: 26px 0px 19px 0px;
                padding: 0px;
                width: 207.98px;
                height: 56px;
                }
                .actives {
                box-sizing: border-box;
                text-decoration: none;
                -webkit-text-size-adjust: none;
                text-align: center;
                border-radius: 2px;
                -webkit-border-radius: 2px;
                -moz-border-radius: 2px;
                -khtml-border-radius: 2px;
                -o-border-radius: 2px;
                -ms-border-radius: 2px;
                padding: 10px 31px;
                cursor: pointer;
                background: #fcca19;
                }
                .anchor-tag a:focus,
                .anchor-tag a:hover {
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: none;
                text-decoration-color: #fcca19;
                }
                </style>
                </head>
                <body class="bodys" style="background-color: #e9ecef">
                <div class="preheader"
                style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
                </div>
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
                <tr>
                <td align="center" valign="top" style="padding: 36px 24px"></td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; margin-top: 100px">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <img class="logo-img" src="{logo}" alt="logo" />
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#fff">
                <p
                style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 28px 0px 20px 0px; line-height: 25px; font-size:14px !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
                Subscription Remaining</p>
                <p
                style="margin: 0px; font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 500; font-size: 14px; line-height: 28px; text-align: center; color: #2C2C2C;">
                SUBSCRIPTION CODE</p>
                <p style="margin-top: 5px;font-family: \'DM Sans\', sans-serif;  font-style: normal; font-weight: 700;
                font-size: 32px; line-height: 28px; text-align: center; color: #2C2C2C;">{subscription_code}
                </p>
                <p style="margin-top: 32px; padding:0px 30px 0px 37px; font-family: \'DM Sans\', sans-serif; text-align: left; font-style: normal; font-weight: 500; font-size: 14px; line-height: 24px; color: #898989;
                "><span style="color: #2C2C2C;">Dear {customer_name},</span>
                <br> We hope you\'re enjoying our services! We want to remind you that your subscription will expired on <b>{expire_date}</b>. Please keep your recurring fee on your card if your subscription is recurring-based,  otherwise please renew your subscription within {expire_date} in order to continue enjoying our services without interruption.
                <br>
                For further information, login to
                your account.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <div style="clear: both;"></div>
                <div>
                <br>
                <p
                style="font-family:\'DM Sans\', sans-serif; font-style: normal; font-weight: 700; font-size: 18px;line-height: 21px; margin-top:1px ;text-align:center; text-transform: uppercase; color: #2C2C2C;">
                Keep in touch</p>
                </div>
                <div
                style="margin-top: 1px; font-size: 14px; text-align: center; color: #898989; line-height: 22px; margin: 1px;">
                <p style="margin-top:14px"> If you have any queries, concerns or suggestions,</p>
                <p style="margin:0px; margin-top:1px"> please email us: <span
                style="cursor: pointer; color: #0060A9; text-decoration: underline;">{support_mail}</span>
                </p>
                </div>
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <p
                style="text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px;">
                &copy; 2023, {company_name}. All rights reserved.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </body>
                </html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'subscription_code, customer_name, support_mail, company_name, logo'
            ]);
        }

        $privatePlan = EmailTemplate::where(['slug' => 'private-plan'])->first();

        if (!$privatePlan) {
            EmailTemplate::insert([
                'parent_id' => NULL,
                'name' => 'Private Plan',
                'slug' => 'private-plan',
                'subject' => 'Welcome to {company_name}',
                'body' => '<!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8" />
                <meta http-equiv="x-ua-compatible" content="ie=edge" />
                <title>10.NEW COUPON ADDED</title>
                <meta name="viewport" content="width=device-width, initial-scale=1" />
                <style type="text/css">
                @media screen {
                @font-face {
                font-family: "DM Sans";
                font-weight: 700;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriASitCBimCw.woff2) format("woff2");
                }
                @font-face {
                font-family: "DM Sans";
                font-weight: 500;
                font-style: normal;
                src: url(https://fonts.gstatic.com/s/dmsans/v11/rP2Cp2ywxg089UriAWCrCBimCw.woff2) format("woff2");
                }
                }
                .bodys,
                .tables,
                td,
                .anchor-tag a {
                -ms-text-size-adjust: 100%;
                -webkit-text-size-adjust: 100%;
                }
                .tables,
                td {
                mso-table-rspace: 0pt;
                mso-table-lspace: 0pt;
                }
                .anchor-tag a {
                padding: 1px;
                margin: 1px;
                }
                .anchor-tag a[x-apple-data-detectors] {
                font-family: inherit !important;
                font-size: inherit !important;
                font-weight: inherit !important;
                line-height: inherit !important;
                color: inherit !important;
                text-decoration: none !important;
                }
                .bodys {
                width: 100% !important;
                height: 100% !important;
                padding: 0 !important;
                margin: 0 !important;
                }
                .tables {
                border-collapse: collapse !important;
                }
                .logo-img {
                margin: 26px 0px 19px 0px;
                padding: 0px;
                width: 207.98px;
                height: 56px;
                }
                .anchor-tag a:focus,
                .anchor-tag a:hover {
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: underline;
                text-decoration-color: #fcca19;
                }
                .anchor-tag a:-webkit-any-link {
                color: -webkit-link;
                cursor: pointer;
                text-decoration: none;
                text-decoration-color: #fcca19;
                }
                </style>
                </head>
                <body class="bodys" style="background-color: #e9ecef">
                <div class="preheader"
                style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;"></div>
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
                <tr>
                <td align="center" valign="top" style="padding: 36px 24px"></td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; margin-top: 100px">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <img class="logo-img" src="{logo}" alt="logo" />
                <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#fff">
                <p style="font-family: \'DM Sans\', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px;
                line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important;
                cursor: default !important;"></p>
                <p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
                color: #2c2c2c;"> Dear {user_email} </p>
                <p style="margin: 0px; color: #898989; font-size: 14px; margin: 3px 50px 31px;
                text-align: center; line-height: 24px;">A warm welcome to {company_name} family, here is your private plan <a
                href="{plan_link}" style="text-decoration: underline; cursor: pointer; color: #0060a9;">link</a>
                </p>
                <p style="margin: 0px;text-align: center; line-height: 24px; font-size: 16px;
                color: #2c2c2c;">
                Please note that this link is for one-time use only; it will no longer be functional after your initial use.
                </p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500;">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <div>
                <p style="font-family: \'DM Sans\', sans-serif; font-style: normal; font-weight: 700;
                font-size: 18px; line-height: 21px; margin-top: 37px; text-align: center;
                text-transform: uppercase; color: #2c2c2c;"> Keep in touch</p>
                </div>
                <div style="font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
                <div style="font-size: 14px; text-align: center; color: #898989;line-height: 22px; margin: 1px;">
                <p style="margin-top: 14px">If you have any queries, concerns or suggestions,
                </p>
                <p style="margin: 0px; margin-top: 1px">please email us:
                <span style="text-decoration: underline; cursor: pointer; color: #0060a9;">{support_mail}</span>
                </p>
                </div>
                </div>
                <p style="border-top: 1px solid #dfdfdf;margin: 1px 20px 0px 20px; "></p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                <tr>
                <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%"
                style="max-width: 640px; font-family: \'DM Sans\', sans-serif; font-weight: 500; margin-bottom: 200px; ">
                <tr>
                <td align="center" bgcolor="#ffffff">
                <p style=" text-align: center; line-height: 16px; color: #898989; font-size: 12px; margin: 13px 0px; ">
                &copy; 2023, {company_name}. All rights reserved.</p>
                </td>
                </tr>
                </table>
                </td>
                </tr>
                </table>
                </body>
                </html>',
                'language_id' => 1,
                'status' => 'Active',
                'variables' => 'logo,user_email, plan_link, company_name,support_mail'
            ]);
        }
    }
}
