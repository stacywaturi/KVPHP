<?php
/**
 * Created by PhpStorm.
 * User: stacy
 * Date: 2018/11/20
 * Time: 09:23
 */

namespace hash;


class Base64url
{

    public function encode($data)
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }

    public function decode($data)
    {

        return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
    }
}