<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        QueryBuilder.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core\Database;

use mysqli;

class QueryBuilder
{
    protected mysqli $conexao;
    protected ?string $tabela;
    protected ?array $bindings = [];
    protected ?string $query;

    public function __construct(mysqli $conexao, string $tabela)
    {
        $this->conexao = $conexao;
        $this->tabela = $tabela;
    }
}