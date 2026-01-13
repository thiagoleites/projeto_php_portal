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

class GenericModel extends Model
{
    protected $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        parent::__construct();
    }

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }
}