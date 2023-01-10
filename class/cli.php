<?php

class cli
{
    static function run ()
    {
        // debug: get args
        $args = $_SERVER['argv'];
        print_r($args);
    }
}