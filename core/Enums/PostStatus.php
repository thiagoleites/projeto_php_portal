<?php
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