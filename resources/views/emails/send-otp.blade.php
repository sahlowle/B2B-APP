<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>OTP Verification</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    @php
    if (!isset($page->layout)) {
          $page = \Modules\CMS\Entities\Page::firstWhere('default', '1');
      }

      $layout = $page->layout;
      $primaryColor = option($layout . '_template_primary_color', '#FCCA19');
      
   @endphp

    <style type="text/css">
        :root {
            --primary-color: {{ $primaryColor }};
        }

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
                font-family: 'Roboto';
                font-style: normal;
                font-weight: 500;
                src: url(https://fonts.gstatic.com/s/roboto/v30/KFOlCnqEu92Fr1MmEU9fBBc4.woff2) format('woff2');
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

        .otp-code {
            background: var(--primary-color);
            color: white;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 8px;
            padding: 20px 30px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
            font-family: 'DM Sans', sans-serif;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .security-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
            font-size: 14px;
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
    <div class="preheader" style="display: none; max-width: 0; max-height: 0; margin: 0px; overflow: hidden; color: #fff; opacity: 0;">
        Your OTP verification code is {{ $otp ?? '123456' }}
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
        
        <!-- Logo Section -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; margin-top: 20px">
                    <tr>
                        <td align="center" bgcolor="#ffffff">
                            
                            @php
                                $logo = App\Models\Preference::getLogo('company_logo');
                            @endphp

                            @php
                                $companyName = preference('company_name');
                            @endphp

                            @if(isset($logo) && $logo)
                                <img class="logo-img" src="{{ $logo }}" alt="Exports Valley" />
                            @else
                                <div style="margin: 26px 0px 19px 0px; padding: 0px; width: 207.98px; height: 56px; background-color: #f8f9fa; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #6c757d; font-family: 'DM Sans', sans-serif; font-weight: 500;">
                                    {{ $companyName }}
                                </div>
                            @endif
                            <p style="border-top: 1px solid #dfdfdf; margin: 1px 20px 0px 20px;"></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Main Content -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px; font-family: 'DM Sans', sans-serif; font-weight: 500;">
                    <tr>
                        <td align="center" bgcolor="#fff">
                            <!-- Header -->
                            <p style="font-family: 'DM Sans', sans-serif; letter-spacing: 0.255em; text-transform: uppercase; margin: 26px 0px; line-height: 25px; font-size: 0.8em !important; color: rgb(44, 44, 44); font-weight: 500 !important; cursor: default !important;">
                                OTP Verification
                            </p>
                            
                            <!-- Greeting -->
                            <p style="margin: 0px; text-align: center; line-height: 24px; font-size: 16px; color: #2c2c2c;">
                                Hello {{ $user->name ?? 'User' }}
                            </p>
                            
                            <!-- Description -->
                            <p style="margin: 0px; color: #898989; font-size: 14px; margin: 7px 54px 0px; text-align: center; line-height: 24px;">
                                You have requested a One-Time Password (OTP) for verification. Please use the code below to complete your verification process.
                            </p>
                            
                            <!-- OTP Code -->
                            <div style="margin: 30px 78px;">
                                <div class="otp-code">
                                    {{ $otp ?? '1234'}}
                                </div>
                            </div>
                            
                            <!-- Security Notice -->
                            <div class="security-notice" style="margin: 20px 78px;">
                                <p style="margin: 0; font-family: 'DM Sans', sans-serif; font-size: 13px; line-height: 18px;">
                                    <strong>Security Notice:</strong> This OTP is valid for {{ $expiryMinutes ?? '10' }} minutes only. Do not share this code with anyone. Our team will never ask for your OTP.
                                </p>
                            </div>
                            
                            <!-- Additional Info -->
                            <p style="margin: 0px; color: #898989; font-size: 14px; margin: 20px 54px 0px; text-align: center; line-height: 24px;">
                                If you didn't request this OTP, please ignore this email or contact our support team immediately.
                            </p>
                            
                            <!-- Footer -->
                            <p style="margin: 30px 0px 0px; color: #898989; font-size: 12px; text-align: center; line-height: 20px;">
                                This is an automated message. Please do not reply to this email.
                            </p>
                            
                            <!-- Company Info -->
                            <p style="margin: 20px 0px 40px; color: #898989; font-size: 12px; text-align: center; line-height: 20px;">
                                © {{ date('Y') }} {{ $companyName ?? 'Your Company' }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <!-- Bottom Spacing -->
        <tr>
            <td align="center" bgcolor="#e9ecef">
                <table class="tables" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 640px">
                    <tr>
                        <td align="center" valign="top" style="padding: 36px 24px"></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
