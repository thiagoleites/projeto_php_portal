<?php

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