<?php
/**
 * User: ennosteppat
 * Date: 28.03.17
 * Time: 16:36
 */

namespace Inwendo\LatexClientBundle\Helper;


class Base64Decoder
{
    /**
     * @param string $data
     * @return bool|string
     */
    public static function decode(string $data){
        $tBase64 = explode(',', $data);
        if (count($tBase64) == 2){
            $base64Data = $tBase64[1];
        }else{
            $base64Data = $data;
        }

        return base64_decode($base64Data);
    }
}