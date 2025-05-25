<?php

namespace Core;

class Router
{
    public static function dispatch()
    {
        // $uri = trim($_SERVER['REQUEST_URI'], '/');

        // if (str_starts_with($uri, 'admin')) {
        //     require_once '../routes/admin.php';
        // } else {
        //     require_once '../routes/web.php';
        // }

        $uri = str_replace('/projeto', '', $_SERVER['REQUEST_URI']);
        $uri = trim($uri, '/');

        if (str_starts_with($uri, 'admin')) {
            require_once '../routes/admin.php';
        } else {
            require_once '../routes/web.php';
        }
    }
}