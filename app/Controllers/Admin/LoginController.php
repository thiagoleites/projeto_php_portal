<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        LoginController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Controllers\Admin;


use Core\View;

class LoginController
{
    public function index()
    {
        $backgroundImages = [
            'https://images.unsplash.com/photo-1726137569962-456daf4ec02f?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1735825764478-674bb8df9d4a?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDF8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1735825764445-af30f44dc49f?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1749731630653-d9b3f00573ed?q=80&w=2664&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1749303025584-0b4e15e4146b?q=80&w=2644&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1749794680236-86626308ebb7?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
            'https://images.unsplash.com/photo-1746311372686-e164b0bcb333?q=80&w=2670&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
        ];

        $msgTitulos = [
            'Sua Central de Comando.',
            'Simplifique seu Trabalho.',
            'Otimize seu Tempo.',
            'Dados que Falam.',
            'Clareza em Cada Métrica.',
            'Sua Performance, Descomplicada.',
            'Onde as Ideias Ganham Vida.',
            'Desbloqueie seu Potencial Criativo.',
        ];

        $msgDescricoes = [
            'Gerencie seus projetos, tarefas e resultados em um só lugar.',
            'Ferramentas poderosas para você focar no que realmente importa.',
            'Transforme números complexos em decisões inteligentes.',
            'Clareza em Cada Métrica.',
            'Insights poderosos para impulsionar o crescimento do seu negócio.',
            'Acompanhe seus indicadores-chave com precisão e agilidade.',
            'Colabore, crie e organize seu próximo grande projeto.',
            'A plataforma ideal para mentes inovadoras.',
        ];

        $selectImages = $backgroundImages[array_rand($backgroundImages)];
        $selectTitulo = $msgTitulos[array_rand($msgTitulos)];
        $selectDescricao = $msgDescricoes[array_rand($msgDescricoes)];

        View::setArea('admin');


        $this->render('pages/login', [
            'titulo' => 'Login - Acesso ao Painel',
            'backgroundImage' => $selectImages,
            'msgTitulo' => $selectTitulo,
            'msgDescricao' => $selectDescricao,
        ]);
    }
}
