<?php

/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 *
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

spl_autoload_register(function ($class) {
    $namespaces = [
        'App\\' => __DIR__ . '/../app/',
        'Core\\' => __DIR__ . '/',
    ];

    foreach ($namespaces as $prefix => $base_dir) {
        if (str_starts_with($class, $prefix)) {
            $relative_class = substr($class, strlen($prefix));
            $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

            if (file_exists($file)) {
                require_once $file;
                return;
            }
        }
    }
});

//Versão 2

// spl_autoload_register(function ($class) {
//     $namespaces = [
//         'App\\' => __DIR__ . '/../app/',
//         'Core\\' => __DIR__ . '/../core/', // Ajuste conforme sua estrutura real
//     ];

//     foreach ($namespaces as $prefix => $base_dir) {
//         $len = strlen($prefix);
//         if (strncmp($prefix, $class, $len) === 0) {
//             $relative_class = substr($class, $len);
//             $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

//             if (file_exists($file)) {
//                 require $file;
//                 return;
//             }
//         }
//     }
    
//     // Opcional: Log para debug
//     error_log("Class {$class} not found in autoloader");
// });