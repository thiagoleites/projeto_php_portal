<?php

declare(strict_types=1);

namespace App\Controllers\Admin;


use Core\Controller;

class AcessoControleController extends Controller
{
    public function erro()
    {
        echo "Erro, 404";
    }

    public function negado()
    {
        echo "Erro, Acesso negado!";
    }
}
