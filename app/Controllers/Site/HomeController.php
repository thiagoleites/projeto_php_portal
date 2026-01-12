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
        View::render('pages/home', [
            'titulo' => 'Página Inicial - Projeto Frontend',
        ]);
    }
}