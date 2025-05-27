<?php
/**
 * Autoloader para carregar classes automaticamente
 * 
 * @package Core
 * @author Thiago Leite <tls@devt.emp.br>
 */
//  * @license Proprietary - Todos os direitos reservados
//  * @version 1.0
/*
spl_autoload_register(function ($class) {
    // Remove o namespace base do início
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../app/';
    
    if (str_starts_with($class, 'App\\')) {
        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    } else {
        // Autoload do sistema (Core)
        $prefix = 'Core\\';
        $base_dir = __DIR__ . '/';
        $relative_class = substr($class, strlen($prefix));
        $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    }

    if (file_exists($file)) {
        require_once $file;
    }
});
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