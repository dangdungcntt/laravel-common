<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 07/03/2019
 * Time: 12:29
 */

namespace Pushtimze\Common\Helpers;

class AesCBCHelper
{
    public static function encrypt($msg) {
        $key = config('common.aes_key');
        $iv = config('common.aes_iv');
        $encryptedMessage = openssl_encrypt($msg, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($encryptedMessage);
    }

    public static function decrypt($payload) {
        $key = config('common.aes_key');
        $iv = config('common.aes_iv');
        $raw = base64_decode($payload);
        return openssl_decrypt($raw, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }
}
