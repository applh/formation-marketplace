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

    static function run ($checkpoint)
    {
        $cmds = os::v($checkpoint) ?? [];
        foreach ($cmds as $cmd) {
            $cmd = !is_string($cmd) ?: trim($cmd);
            if (is_callable($cmd)) {
                $cmd();
            }
        }
    }

    static function filename_cleanup ($name)
    {
        // and replace non alphanumeric characters with "-"
        $filename = pathinfo($name, PATHINFO_FILENAME) ?? "";
        $filename = preg_replace("/[^a-zA-Z0-9]/", "-", $filename);
        $filename = trim($filename, "-");
        // remove double "-"
        $filename = preg_replace("/-+/", "-", $filename);
        // lowercase
        $filename = strtolower($filename);

        return $filename;
    }

    static function extension_cleanup ($name)
    {
        $ext = pathinfo($name, PATHINFO_EXTENSION) ?? "";
        $ext = strtolower($ext);
        $ext = trim($ext);
        return $ext;
    }
    
    //_class_end_
}

//_file_end_
