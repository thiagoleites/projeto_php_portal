<?php

namespace Core\Enums;

enum UserRole: string
{
    case ADMINISTRADOR = 'administrador';
    case USUARIO = 'usuario';
    case EDITOR = 'editor';

    /**
     * Retorna uma descrição amigável
     *
     * @return string
     */
    public function label(): string
    {
        return match($this) {
            self::ADMINISTRADOR => 'Administrador do sistema',
            self::USUARIO => 'Usuario padrão',
            self::EDITOR => 'Editor de conteúdo',
        };
    }

    /**
     * Lista todos os valores em array (util para selects e exibição em formularios para cadastros e etc...)
     *
     * @return array
     */
    public static function values(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}