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
}
