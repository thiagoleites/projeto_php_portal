<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use Core\View;

class ComentarioController
{
    public function index()
    {
        View::setArea('admin');
        View::render('pages/comentarios/index', [
            'titulo' => 'Moderação de Comentários',
            'subtitulo' => 'Gerencie os comentários enviados pelos usuários.'
        ]);
    }
}
