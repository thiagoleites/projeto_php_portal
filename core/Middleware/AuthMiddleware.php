<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        AuthMiddleware.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types = 1);

namespace Core\Middleware; 

use Core\Auth;
use Core\Helpers;
use Core\View;

class AuthMiddleware
{
    public function handle(): void
    {
        View::setArea('admin');
        $backgroundImage = 'https://cribl.io/_next/image/?url=https%3A%2F%2Fimages.ctfassets.net%2Fxnqwd8kotbaj%2F4ugRnmEYq0h8aZp75ztwWW%2F9b13e683e88c0b729c3a933b3f9cfbba%2FAdobeStock_622335155.jpeg&w=3840&q=75';
        $titulo = "Login - Acesso ao Painel";
        $msgTitulo = 'Você não está logado';
        $msgDescricao = 'Por favor, faça login para continuar';
        if (!Auth::check()) {
            View::render('pages/login', [
                'titulo' => $titulo,
                'msgTitulo' => $msgTitulo,
                'msgDescricao' => $msgDescricao,
                'backgroundImage' => $backgroundImage,
            ]);
            // header('Location: /'. Helpers::BASE_PATH.'/admin');
            exit;
        }
    }
}