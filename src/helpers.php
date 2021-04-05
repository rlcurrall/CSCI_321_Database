<?php

if (!function_exists('dd')) {
    function dd(...$args): void
    {
        foreach ($args as $arg) {
            echo "<pre>" . var_export($arg, true) . "</pre>\n";
        }
        die();
    }
}
