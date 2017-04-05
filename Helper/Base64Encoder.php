<?php
/**
 * User: ennosteppat
 * Date: 30.03.17
 * Time: 17:29
 */

namespace Inwendo\LatexClientBundle\Helper;

class Base64Encoder
{
    /**
     * @param string $data
     * @param null|string $mimetype
     * @return null|string
     */
    static function encode(string $data, ?string $mimetype=null): ?string{
        if(empty($mimetype)){
            return base64_encode($data);
        }else{
            return 'data:' . $mimetype . ';base64,' . base64_encode($data);
        }
    }

    /**
     * @param string $filepath
     * @return null|string
     */
    static function encodeFile(string $filepath): ?string{
        if(file_exists($filepath)){
            $data = file_get_contents($filepath);
            $mime = mime_content_type($filepath);
            return self::encode($data, $mime);
        }
        return null;
    }
}