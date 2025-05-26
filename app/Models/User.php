<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        User.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function __construct()
    {
        // Construtor model
    }

    public function getActiveUsers()
    {
        return $this->query()
            ->select()
            ->where('is_active', '=', 1)
            ->orderBy('name', 'ASC')
            ->get();

    }
}
