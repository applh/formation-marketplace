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

    //_class_end_
}

//_file_end_
