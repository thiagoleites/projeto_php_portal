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

enum PostStatus: string
{
    case RASCUNHO = 'rascunho';
    case PUBLICADO = 'publicado';
    case INATIVO = 'inativo';

    public function label(): string
    {
        return match ($this) {
            self::RASCUNHO => 'Rascunho',
            self::PUBLICADO => 'Publicado',
            self::INATIVO => 'Inativo',
        };
    }
}