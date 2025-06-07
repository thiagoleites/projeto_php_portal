<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        CategoriaController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class CategoriaController
{
    public function index()
    {
        View::setArea('admin');
        View::render('pages/categorias/index', [
            'titulo' => 'Listagem de categorias',
            'subtitulo' => 'Gerencie as categorias listadas'
        ]);
    }

    public function create()
    {
        View::setArea('admin');
        View::render('pages/categorias/criar', [
            'titulo' => 'Criar nova Categoria',
            'subtitulo' => 'Preencha os campos abaixo para publicar ou salvar um rascunho.'
        ]);
    }
}
