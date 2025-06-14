<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        Categoria.php
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
    protected string $table = 'categorias';
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Construtor model
        parent::__construct();
    }

    public function storeCategory(array $data)
    {
        return $this->query()
            ->create($data)
            ->into($this->table)
            ->execute();
    }
}
