<?php
/**
 * class: control
 * created: 2023-01-11 17:50:42
 * license: MIT
 * author: appLH
 */

/**
 * control
 */
class control 
{
    //_class_start_

    static function public ()
    {
        return true;
    }

    static function admin ()
    {
        $res = false;

        // check admin/api_key with request k
        $api_key = os::v("admin/api/key") ?? "";
        $request_key = $_REQUEST['k'] ?? "";
        if ($api_key && ($api_key === $request_key)) {
            $res = true;
        }
        else {
            // debug
            web::extra("feedback", "control::admin() failed");
        }

        return $res;
    }

    //_class_end_
}

//_file_end_
