<?php
/**
 * class: os
 * created: 2023-01-11 15:06:12
 * license: MIT
 * author: appLH
 */

/**
 * os
 */
class os 
{
    //_class_start_

    static $vars = [];

    /**
     * getter/setter
     */
    static function v ($key, $val=null)
    {
        if ($val !== null) {
            // set value
            os::$vars[$key] = $val;
        }
        // get value
        return os::$vars[$key] ?? null;
    }

    static function md5 ($src=null)
    {
        // if src is not null then return md5 of src
        // else generate a random md5
        return $src ? md5($src) : md5(password_hash(uniqid(rand(), true), PASSWORD_DEFAULT));
    }

    //_class_end_
}

//_file_end_
