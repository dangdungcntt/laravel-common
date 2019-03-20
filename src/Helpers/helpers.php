<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 05/03/2019
 * Time: 10:46
 */

use Pushtimze\Common\Helpers\AesCBCHelper;

if (! function_exists('gravatar_url')) {
    function gravatar_url($email)
    {
        return "https://www.gravatar.com/avatar/" . md5( strtolower( trim($email) ) );
    }
}

/*
 * AesCBCHelper function
 */

if (! function_exists('aes_encrypt')) {
    function aes_encrypt($msg)
    {
        return AesCBCHelper::encrypt($msg);
    }
}

if (! function_exists('aes_decrypt')) {
    function aes_decrypt($msg)
    {
        return AesCBCHelper::decrypt($msg);
    }
}
