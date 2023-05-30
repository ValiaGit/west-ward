<?php

namespace App\Integrations\Helpers;

class UIDSecurity
{

    /**
     * @param $input
     * @return mixed|string
     */
    static function encrypt($input)
    {
        ///
        $out = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, hash('sha256', env('TOKEN_GENERATION_SECRET'), TRUE), $input, MCRYPT_MODE_ECB));

        $out = str_replace("/","{s1}",$out);
        $out = str_replace("+","{s2}",$out);

        return $out;
    }

    /**
     * @param $input
     * @return string
     */
    static function decrypt($input)
    {
        $input = str_replace(" ","+",$input);
        $input = str_replace("{s1}","/",$input);
        $input = str_replace("{s2}","+",$input);
        return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, hash('sha256', env('TOKEN_GENERATION_SECRET'), TRUE), base64_decode($input), MCRYPT_MODE_ECB));
    }


}