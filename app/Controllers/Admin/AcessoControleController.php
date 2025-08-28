<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: AcessoControleController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
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
