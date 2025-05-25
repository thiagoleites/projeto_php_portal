<?php

declare(strict_types=1);

namespace App\Controllers\Site;
use Core\View;

class HomeController
{
    /**
     * Método para exibir a página inicial do projeto Frontend.
     */
    public function index()
    {
        // Aqui você pode adicionar a lógica para a página inicial
        // echo "Bem-vindo à página inicial!";
        View::render('site/home', [
            'titulo' => 'Página Inicial - Projeto Frontend',
            // 'content' => 'Bem-vindo à página inicial!'
        ]);
    }
}