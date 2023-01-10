<?php

class cli
{
    static $args = [];

    static function run ()
    {
        // debug: get args
        cli::$args = $_SERVER['argv'] ?? [];
        print_r(cli::$args);

        $arg1 = cli::$args[1] ?? "";
        $command = "cli::$arg1";
        if (is_callable($command)) {
            $command();
        }
    }

    /**
     * php framework.php code myclass
     */
    static function code ()
    {
        $logs = [];
        $args2 = cli::$args[2] ?? "";
        if ($args2) {
            $logs[] = "code $args2";
            
            // target file
            $target = __DIR__ . "/$args2.php";
            if (!file_exists($target)) {
                $logs[] = "create class file: $target";
                // check if sample file exists
                // then get the code from it
                // replace =CREATED= with date
                // replace sample with $args2
                // then save the code to $target
                $sample = __DIR__ . "/sample.php";
                if (file_exists($sample)) {
                    $code = file_get_contents($sample);
                    $code = str_replace("=CREATED=", date("Y-m-d H:i:s"), $code);
                    $code = str_replace("sample", $args2, $code);
                    file_put_contents($target, $code);
                } else {
                    $logs[] = "sample file not found: $sample";
                }
            } else {
                $logs[] = "file exists: $target";
            }
        }
        print_r($logs);
    }
}