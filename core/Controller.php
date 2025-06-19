<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        Controller.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types = 1);

namespace Core;

use Core\View;
use Core\Auth;

abstract class Controller
{
    /**
     * Dados compartilhados com a view
     * @var array
     */
    protected array $data = [];

    /**
     * Redireciona para outra URL
     * @param string $url URL para redirecionamento
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit();
    }

    /**
     * Renderiza uma view
     * @param string $view Nome da view (caminho relativo)
     * @param array $data Dados adicionais para a view
     */
    protected function render(string $view, array $data = []): void
    {
        // Combina dados do controller com dados específicos
        $viewData = array_merge($this->data, $data);
        
        View::render($view, $viewData);
    }

    /**
     * Verifica se o usuário está autenticado
     * @throws \RuntimeException Se não estiver autenticado
     */
    protected function requireAuth(): void
    {
        if (!Auth::check()) {
            $this->redirect('/projeto/login');
        }
    }

    /**
     * Verifica se o usuário é admin
     * @throws \RuntimeException Se não for admin
     */
    protected function requireAdmin(): void
    {
        $this->requireAuth();
        
        if (!Auth::isAdmin()) {
            $this->redirect('/projeto/acesso-negado');
        }
    }

    /**
     * Retorna o usuário logado
     * @return array|null
     */
    protected function user(): ?array
    {
        return Auth::user();
    }

    /**
     * Adiciona um script para ser carregado no layout
     * @param string $script
     */
    protected function addScript(string $script): void
    {
        View::script($script);
    }
}