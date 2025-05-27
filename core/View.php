<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        View.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core;

class View
{
    private static array $data = [];
    private static array $sections = [];
    private static ?string $currentSection = null;
    private static array $scripts = [];
    private static ?string $layout = null;

    /**
     * Renderiza uma view
     * 
     * @param string $viewPath Caminho da view a ser renderizada
     * @param array $data Dados a serem passados para a view
     */
    public static function render(string $viewPath, array $data = []): void
    {
        self::$data = array_merge(self::$data, $data);
        extract(self::$data);

        ob_start();
        require "../app/Views/$viewPath.php";
        $content = ob_get_clean();

        if (self::$layout) {
            ob_start();
            extract(self::$data);
            require "../app/Views/" . self::$layout;
            $content = ob_get_clean();
        }

        echo $content;
    }
    /**
     * Adiciona uma seção de conteúdo
     * 
     * @param string $name Nome da seção
     * @param string $content Conteúdo da seção
     */
    public static function extend(string $layout): void
    {
        self::$layout = $layout;
    }

    /**
     * Exibir o conteúdo de uma seção
     * 
     * @param string $name Nome da seção
     * @return string|null Conteúdo da seção ou null se não existir
     */
    public static function section(string $name, string $default = ''): void
    {
        echo self::$section[$name] ?? $default;
    }

    /**
     * Inicia a captura de uma seção
     * 
     * @param string $name Nome da seção
     * @return void
     */
    public static function start(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }

    /**
     * Adiciona um script para ser injetado no final do layout
     * 
     * @param string $script Código JavaScript a ser adicionado
     * @return void
     */
    public static function script(string $script): void
    {
        self::$scripts[] = $script;
    }

    /**
     * Renderiza todos os script acumulados
     * 
     * @return void
     */
    public static function scripts(): void
    {
        foreach (self::$scripts as $script) {
            echo $script . "\n";
        }

        // Limpa os scripts após renderizar
        // Isso garante que os scripts sejam renderizados apenas uma vez
        // e não sejam acumulados em chamadas subsequentes
        self::$scripts = [];
    }

    /**
     * Inclui um partial na view
     * Adiciona dados adicionais ao escopo da view
     * 
     * @param string $partialPath Caminho do partial a ser incluído
     * @return void
     */
    public static function partial(string $partialPath, array $data = []): void
    {
        extract(array_merge(self::$data, $data));
        require "../app/Views/$partialPath.php";
    }
}