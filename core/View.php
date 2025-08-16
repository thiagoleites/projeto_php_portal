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

use Core\Exceptions\FilesExcepition;

class View
{
    /** @var array Dados compartilhados com as views */
    private static array $data = [];
    
    /** @var array<string, string> Seções de conteúdo */
    private static array $sections = [];
    
    /** @var string|null Seção atual sendo capturada */
    private static ?string $currentSection = null;
    
    /** @var array<string> Scripts a serem injetados */
    private static array $scripts = [];
    
    /** @var string|null Layout base a ser estendido */
    private static ?string $layout = null;

    /** @var string Área atual (admin ou site) */
    private static string $currentArea = 'site';
    
    /**
     * Define a área atual (admin ou site)
     */
    public static function setArea(string $area): void
    {
        if (!in_array($area, ['admin', 'site'])) {
            throw new \InvalidArgumentException("Área de view inválida: {$area}");
        }
        self::$currentArea = $area;
    }

    /**
     * Renderiza uma view
     * @param string $viewPath Caminho para o arquivo de view (sem extensão)
     * @param array $data Dados a serem passados para a view
     */
    public static function render(string $viewPath, array $data = []): void
    {
        self::$data = array_merge(self::$data, $data);
        extract(self::$data);
        
        ob_start();
//        require self::resolvePath($viewPath);
//        $content = ob_get_clean();
        $file = self::resolvePath($viewPath);
        $content = file_get_contents($file);

        $content = str_replace(['@php', '@endphp'], ['<?php', '?>'], $content); //teste
        $content = preg_replace('/\{\{\s*(.+?)\s*\}\}/', '<?=  htmlspecialchars($1, ENT_QUOTES, "UTF-8") ?>', $content); //teste

        eval('?>' . $content); //teste

        $content = ob_get_clean();

        if (self::$layout) {
            ob_start();
            extract(self::$data);
            require self::resolvePath(self::$layout);
            $content = ob_get_clean();
        }
        
        echo $content;
    }

    /**
     * Resolve o caminho completo para a view
     * 
     * @param string $path Caminho relativo da view (sem extensão)
     * @return string Caminho completo para o arquivo de view
     */
    private static function resolvePath(string $path): string
    {
        // Se o path já começar com admin/ ou site/, usa como está
        if (str_starts_with($path, 'admin/') || str_starts_with($path, 'site/')) {
            return "../app/Views/{$path}.php";
        }
        
        // Caso contrário, usa a área atual
        return "../app/Views/" . self::$currentArea . "/{$path}.php";
    }
    
    /**
     * Define o layout base para a view atual
     * @param string $layout Caminho para o arquivo de layout (sem extensão)
     */
    public static function extend(string $layout): void
    {
        self::$layout = $layout;
    }
    
    /**
     * Exibe o conteúdo de uma seção
     * @param string $name Nome da seção
     * @param string $default Conteúdo padrão caso a seção não exista
     */
    public static function section(string $name, string $default = ''): void
    {
        echo self::$sections[$name] ?? $default;
    }
    
    /**
     * Inicia a captura de uma seção
     * @param string $name Nome da seção
     */
    public static function start(string $name): void
    {
        self::$currentSection = $name;
        ob_start();
    }
    
    /**
     * Finaliza a captura de uma seção
     */
    public static function end(): void
    {
        if (self::$currentSection) {
            self::$sections[self::$currentSection] = ob_get_clean();
            self::$currentSection = null;
        }
    }
    
    /**
     * Adiciona um script para ser injetado no final do layout
     * @param string $script Código ou tag de script completo
     */
    public static function script(string $script): void
    {
        self::$scripts[] = $script;
    }
    
    /**
     * Renderiza todos os scripts acumulados
     */
    public static function scripts(): void
    {
        foreach (self::$scripts as $script) {
            echo $script . "\n";
        }
        self::$scripts = []; // Limpa os scripts após renderizar
    }
    
    /**
     * Inclui um partial view
     * @param string $partialPath Caminho para o partial (sem extensão)
     * @param array $data Dados adicionais para o partial
     */
    public static function partial(string $partialPath, array $data = []): void
    {
        extract(array_merge(self::$data, $data));
        require "../app/Views/$partialPath.php";
    }

    /**
     * Verifica se uma seção está definida
     * 
     * @param string $name Nome da seção
     * @return bool Verdadeiro se a seção estiver definida, falso caso contrário
     */
    public function renderShared(string $viewPath, array $data = []): void
    {
        //Método para renderizar views compartilhadas
        $oldArea = self::$currentArea;
        self::render($viewPath, $data);
        self::$currentArea = $oldArea;
    }

    public static function adminView(string $viewPath, array $data = []): void
    {
        self::setArea('admin');
        self::render($viewPath, $data);
    }

    public static function siteView(string $viewPath, array $data = []): void
    {
        self::setArea('site');
        self::render($viewPath, $data);
    }

    /**
     * Retorna o caminho completo do asset com versionamento
     * @param string $path Caminho relativo do asset (ex: 'css/style.css')
     * @return string Caminho completo com versão
     */

    public static function asset(string $path): string
    {
        $path = ltrim($path, '/');
        return "/base/public/{$path}?v=" . time(); // Usa timestamp atual
    }
}