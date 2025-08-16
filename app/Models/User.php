<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: User.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */
declare(strict_types=1);

namespace App\Models;

use Core\Database\Model;
use Core\Database\QueryBuilder;
use Core\Enums\UserRole;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function __construct(

    )
    {
        parent::__construct();
    }

    public function getRoleLabel(): string
    {
        $roleValue = $this->role;

        try {
            $roleEnum = UserRole::from((int)$roleValue);
            return $roleEnum->label();
        } catch (\ValueError $e) {
            return 'Desconhecido.';
        }
    }

    public function getActiveUsers(): array
    {
        return $this->query()
            ->select()
            ->where('is_active', '=', 1)
            ->orderBy('name', 'ASC')
            ->get();
    }

    public static function getAllUsers(int $limit = 10, int $offset = 0): array
    {
//        return (new static)->findAll();
        return (new static())
            ->query()
            ->select()
            ->orderBy('id', 'DESC')
            ->limit($limit, $offset)
            ->get();
    }

    public static function contarUsuarios(): int
    {
        $instance = new static();
        return $instance->query()->select()->count('*');
    }

}
