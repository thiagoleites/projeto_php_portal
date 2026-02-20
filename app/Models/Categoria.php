<?php

/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

declare(strict_types=1);

namespace App\Models;

use Core\Database\Connection;
use Core\Database\Model;
use Exception;

class Categoria extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Construtor model
        parent::__construct();
    }

    public function __toString(): string
    {
        return (string)($this->name ?? '');
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

    /**
     * Busca uma categoria pelo ID
     *
     * @param int $id ID da categoria
     * @return array{id: int, name: string, descricao: string, short_link: string, categoria_pai: int|null, created_at: string, updated_at: string}|null
     */
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
        if (isset($data['categoria_pai']) && empty($data['categoria_pai'])) {
            $data['categoria_pai'] = null;
        }

        try {
            return (new static())->create($data);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao inserir categoria: " . $e->getMessage());
        }
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
        try {
            $query = (new static())
                ->query()
                ->select(['COUNT(*) as total'])
                ->where('short_link', '=', $slug);

            if ($currentId) {
                $query->where('id', '!=', $currentId);
            }

            $result = $query->first();
            return ($result['total'] ?? 0) > 0;

        } catch (\Exception $e) {
            error_log("Erro ao verificar slug: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Adiciona uma categoria com slug automático
     * @param array $dados Dados da categoria
     * @return int ID da categoria inserida
     * @throws Exception
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
     * @throws \Exception
     */
    public static function updateCategoriaComSlug(int $id, array $dados): bool
    {
        // Se o nome foi alterado, gerar novo slug
        if (!empty($dados['name'])) {
//            $categoriaAtual = self::find($id);
            $categoriaAtual = (new static())->find($id);

            if ($categoriaAtual && $categoriaAtual['name'] !== $dados['name']) {
                $baseSlug = self::generateSlug($dados['name']);
                $dados['short_link'] = self::generateUniqueSlug($baseSlug, $id);
            }
        }

        return self::updateCategoria($id, $dados);
    }

    public static function getCategoriaById(int $id): ?array
    {
        return (new static())->find($id);
    }

    /**
     * Função para atualizar uma categoria
     * @param int $id
     * @param array $data
     * @return bool
     * @throws \Exception
     */
    public static function updateCategoria(int $id, array &$data): bool
    {
        if (isset($data['categoria_pai']) && empty($data['categoria_pai'])) {
            $data['categoria_pai'] = null;
        }
        $data['updated_at'] = date('Y-m-d H:i:s'); // atualizar data de modificação

        try {
            return (new static())->update($id, $data);
        } catch (\Exception $e) {
            throw new \Exception("Erro ao atualizar categoria: " . $e->getMessage());
        }
    }

    /**
     * Função para deletar uma nova categoria
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public static function deleteCategoria(int $id): bool
    {
        try {
            // Verificar se a categoria tem artigos associados
            $artigosCount = (new Artigo())
                ->query()
                ->select()
                ->where('categoria_id', '=', $id)
                ->count();

            if ($artigosCount > 0) {
                throw new \Exception("Não é possível excluir a categoria pois existem artigos associados a ela.");
            }

            // Verificar se a categoria tem subcategorias
            $subcategoriasCount = (new static())
                ->query()
                ->select()
                ->where('categoria_pai', '=', $id)
                ->count();

            if ($subcategoriasCount > 0) {
                throw new \Exception("Não é possível excluir a categoria pois existem subcategorias associadas a ela.");
            }

            // Deletar a categoria
            return (new static())->delete($id);

        } catch (\Exception $e) {
            throw new \Exception("Erro ao excluir categoria: " . $e->getMessage());
        }
    }
}
