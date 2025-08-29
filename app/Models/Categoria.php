<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: Categoria.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;

class Categoria extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Construtor model
        parent::__construct();
    }

    public function storeCategory(array $data): array
    {
        return $this->query()
            ->create($data)
            ->into($this->table)
            ->execute();
    }

    public static function contarCategorias(): int
    {
        return (new static())->query()->select()->count('*');
    }

    public static function getCategorias($items = 10): array
    {
        $qb = (new static())
            ->query()
            ->select([
                'categories.id',
                'categories.name',
                'categories.descricao',
                'COUNT(artigos.id) AS total_artigos'
            ])
            ->join('artigos', 'categories.id', 'artigos.categoria_id', 'LEFT')
            ->groupBy('categories.id')
            ->orderBy('categories.id', 'ASC');

        return $qb->paginate($items);
    }

    public static function addCategoria(array $data): int
    {
        $qb = (new static())
            ->create($data);
        return $qb;
    }

    /**
     * Gera um slug a partir de um texto
     * @param string $text Texto para converter em slug
     * @return string Slug gerado
     */
    public static function generateSlug(string $text): string
    {
        if (empty($text)) {
            return '';
        }

        // Converter para minúsculas
        $slug = mb_strtolower($text, 'UTF-8');

        // Remover acentos e caracteres especiais
        $slug = self::removeAccents($slug);

        // Substituir caracteres especiais
        $specialChars = [
            'æ' => 'ae', 'œ' => 'oe', 'ß' => 'ss',
            '&' => 'e', '+' => 'e', '@' => 'a',
            'á' => 'a', 'à' => 'a', 'ã' => 'a', 'â' => 'a', 'ä' => 'a',
            'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
            'í' => 'i', 'ì' => 'i', 'î' => 'i', 'ï' => 'i',
            'ó' => 'o', 'ò' => 'o', 'õ' => 'o', 'ô' => 'o', 'ö' => 'o',
            'ú' => 'u', 'ù' => 'u', 'û' => 'u', 'ü' => 'u',
            'ç' => 'c', 'ñ' => 'n', 'ý' => 'y', 'ÿ' => 'y'
        ];

        foreach ($specialChars as $char => $replacement) {
            $slug = str_replace($char, $replacement, $slug);
        }

        // Remover caracteres não alfanuméricos (exceto hífens e espaços)
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);

        // Substituir espaços por hífens
        $slug = preg_replace('/\s+/', '-', $slug);

        // Remover hífens múltiplos consecutivos
        $slug = preg_replace('/-+/', '-', $slug);

        // Remover hífens no início e no final
        $slug = trim($slug, '-');

        // Limitar o tamanho do slug (máximo 100 caracteres)
        if (mb_strlen($slug) > 100) {
            $slug = mb_substr($slug, 0, 100);
            // Garantir que não termina com hífen
            $slug = rtrim($slug, '-');
        }

        return $slug;
    }

    /**
     * Remove acentos de uma string
     * @param string $string String com acentos
     * @return string String sem acentos
     */
    private static function removeAccents(string $string): string
    {
        $string = htmlentities($string, ENT_NOQUOTES, 'UTF-8');
        $string = preg_replace('#&([A-za-z])(?:acute|cedil|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $string);
        $string = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $string);
        $string = preg_replace('#&[^;]+;#', '', $string);

        return $string;
    }

    /**
     * Gera um slug único incrementando números se necessário
     * @param string $baseSlug Slug base
     * @param int|null $currentId ID atual (para edição)
     * @return string Slug único
     */
    public static function generateUniqueSlug(string $baseSlug, ?int $currentId = null): string
    {
        $slug = $baseSlug;
        $counter = 1;
        $originalSlug = $slug;

        while (self::slugExists($slug, $currentId)) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;

            // Limitar para evitar loop infinito
            if ($counter > 100) {
                // Gerar slug com timestamp como fallback
                $slug = $originalSlug . '-' . time();
                break;
            }
        }

        return $slug;
    }

    /**
     * Verifica se um slug já existe
     * @param string $slug Slug para verificar
     * @param int|null $currentId ID atual (para evitar conflito na edição)
     * @return bool True se o slug já existe
     */
    public static function slugExists(string $slug, ?int $currentId = null): bool
    {
        $db = self::getDb();

        if ($currentId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM categorias WHERE short_link = :slug AND id != :id");
            $stmt->execute([':slug' => $slug, ':id' => $currentId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM categorias WHERE short_link = :slug");
            $stmt->execute([':slug' => $slug]);
        }

        return $stmt->fetchColumn() > 0;
    }

    /**
     * Adiciona uma categoria com slug automático
     * @param array $dados Dados da categoria
     * @return int ID da categoria inserida
     */
    public static function addCategoriaComSlug(array $dados): int
    {
        // Gerar slug a partir do nome
        if (!empty($dados['name'])) {
            $baseSlug = self::generateSlug($dados['name']);
            $dados['short_link'] = self::generateUniqueSlug($baseSlug);
        }

        return self::addCategoria($dados);
    }

    /**
     * Atualiza uma categoria com slug automático se o nome foi alterado
     * @param int $id ID da categoria
     * @param array $dados Dados atualizados
     * @return bool True se atualizado com sucesso
     */
    public static function updateCategoriaComSlug(int $id, array $dados): bool
    {
        // Se o nome foi alterado, gerar novo slug
        if (!empty($dados['name'])) {
            $categoriaAtual = self::find($id);

            if ($categoriaAtual && $categoriaAtual['name'] !== $dados['name']) {
                $baseSlug = self::generateSlug($dados['name']);
                $dados['short_link'] = self::generateUniqueSlug($baseSlug, $id);
            }
        }

        return self::updateCategoria($id, $dados);
    }
}
