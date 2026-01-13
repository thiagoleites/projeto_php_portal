<?php

/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 *
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

namespace App\Models;

use Core\Database\Model;

class Artigo extends Model
{
    protected $table = 'artigos';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }


    public static function contarArtigos(): int
    {
        return (new static())->query()->select()->count('*');
    }

    public static function getArtigos(int $limit = 10, int $offset = 0): array
    {
        return (new static())
            ->query()
            ->select()
            ->orderBy('id', 'DESC')
            ->limit($limit, $offset)
            ->get();
    }
}