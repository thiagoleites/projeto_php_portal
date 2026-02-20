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

    public static function checkLogin(string $email, string $password): ?array
    {
        $user = (new static())
            ->query()
            ->select()
            ->where('email', '=', $email)
            ->where('is_active', '=', 1)
            ->first();

        return $user ?: null;
    }

}
