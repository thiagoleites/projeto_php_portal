<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        View.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core;

// class View
// {
//     private $view;
//     private $data = [];

//     public function __construct($view)
//     {
//         $this->view = $view;
//     }

//     public function assign($key, $value)
//     {
//         $this->data[$key] = $value;
//     }

//     public function render()
//     {
//         extract($this->data);
//         ob_start();
//         include "../app/Views/{$this->view}.php";
//         return ob_get_clean();
//     }
// }

class View
{
    public static function render(string $viewPath, array $data = [])
    {
        extract($data);
        include "../app/Views/$viewPath.php";
    }
}