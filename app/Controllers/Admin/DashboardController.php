<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Models\Artigo;
use App\Models\Categoria;
use App\Models\User;
use Core\Controller;
use Core\View;

class DashboardController extends Controller
{
    public function index(): void
    {
        $totalUsers         = User::contarUsuarios();
        $totalCategorias    = Categoria::contarCategorias();
        $totalArtigos       = Artigo::contarArtigos();
        $allArtigos         = Artigo::getArtigos(5);
        $allUsers           = User::getAllUsers(5);


        View::setArea('admin');
        View::render('pages/dashboard', [
            'titulo'            => 'Dashboard - Painel de controle',
            'totalUsuarios'     => $totalUsers,
            'totalCategorias'   => $totalCategorias,
            'totalArtigos'      => $totalArtigos,
            'allArtigos'        => $allArtigos,
            'allUsers'          => $allUsers,
        ]);
    }
}