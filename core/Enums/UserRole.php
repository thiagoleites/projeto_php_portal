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

namespace Core\Enums;

enum UserRole: int
{
    case ADMINISTRADOR = 1;
    case USUARIO = 2;
    case EDITOR = 3;

    /**
     * Retorna uma descrição amigável
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::ADMINISTRADOR => 'Administrador',
            self::USUARIO => 'Usuário',
            self::EDITOR => 'Editor',
        };
    }

    public static function options(): array
    {
        $result = [];
        foreach (self::cases() as $role) {
            $result[$role->value] = $role->label();
        }

        return $result;
    }
}