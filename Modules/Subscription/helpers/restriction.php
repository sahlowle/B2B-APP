<?php

if (!function_exists('_d_f_e')) {
    function _d_f_e()
    {
        return false;
        if(empty(d_f_c())) {
            return true;
        }

        if (!dfc_()) {
            try {
                $_c = _d_f_c();
                $c_ = d_f_c();
                $e_ = explode('.', $c_);

                $_e_ = md5($_c . $e_[1]);

                if ($e_[0] == $_e_) {
                    dfc();

                    return false;
                }

                return true;
            } catch (\Exception $e) {
                return true;
            }
        }

        return false;
    }
}

if (!function_exists('_d_f_c')) {
    function _d_f_c()
    {
        return str_replace(['https://www.', 'http://www.', 'https://', 'http://', 'www.'], '', request()->getHttpHost());
    }
}

if (!function_exists('d_f_c')) {
    function d_f_c()
    {
        return moduleConfig('subscription.key');
    }
}

if (!function_exists('dfc')) {
    function dfc()
    {
        return cache(['a_s_k_subscription' => d_f_c()], 2629746);
    }
}
if (!function_exists('dfc_')) {
    function dfc_()
    {
        return cache('a_s_k_subscription');
    }
}
