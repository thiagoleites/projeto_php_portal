<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: QueryBuilder.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core\Database;

use Core\Exceptions\DatabaseException;
use mysqli;
use InvalidArgumentException;
use RuntimeException;
use mysqli_sql_exception;
use mysqli_stmt;

class QueryBuilder
{
    protected mysqli $connection; // verificar tipagem se houver erros
    private ?string $query = null;
    private array $bindings = [];
    private string $table;
    private $joins = [];


    public function __construct(mysqli $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function select(array $columns = ['*']): self
    {
        $this->query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->table;
        return $this;
    }

    public function count(string $column = '*'): int
    {
        // Se não tiver query, cria a base
        if ($this->query === null) {
            $this->query = "SELECT COUNT({$column}) as total FROM {$this->table}";
        } else {
            $this->query = "SELECT COUNT({$column}) as total FROM {$this->table}" . $this->extractWherePart();
        }

        try {
            $stmt = $this->prepareStatement();
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return (int)($row['total'] ?? 0);
        } catch (mysqli_sql_exception $e) {
            $this->handleException($e);
            return 0;
        }
    }

    public function where(string $column, string $operator, $value): self
    {
        if (!in_array(strtoupper($operator), ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN'])) {
            throw new InvalidArgumentException("Operador inválido: {$operator}");
        }

        $this->addCondition('WHERE', $column, $operator, $value);
        return $this;
    }

    public function andWhere(string $column, string $operator, $value): self
    {
        $this->addCondition('AND', $column, $operator, $value);
        return $this;
    }

    public function orWhere(string $column, string $operator, $value): self
    {
        $this->addCondition('OR', $column, $operator, $value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->query .= " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): self
    {
        $this->query .= " LIMIT {$limit}";
        if ($offset !== null) {
            $this->query .= " OFFSET {$offset}";
        }
        return $this;
    }

    private function addCondition(string $type, string $column, string $operator, $value): void
    {
        $placeholder = '?';

        // Se a query ainda não tem WHERE, sempre força WHERE
        if (stripos($this->query, 'WHERE') === false && $type !== 'OR') {
            $type = 'WHERE';
        } elseif ($type === 'WHERE') {
            // se já existe WHERE e chamaram where(), vira AND
            $type = 'AND';
        }

        if (is_array($value) && in_array($operator, ['IN', 'NOT IN'])) {
            $placeholders = implode(', ', array_fill(0, count($value), '?'));
            $this->query .= " {$type} {$column} {$operator} ({$placeholders})";
            $this->bindings = array_merge($this->bindings, $value);
        } else {
            $this->query .= " {$type} {$column} {$operator} {$placeholder}";
            $this->bindings[] = $value;
        }
    }

    public function get(): array
    {
        try {
            $stmt = $this->prepareStatement();
            $stmt->execute();
            $result = $stmt->get_result();
            return $result->fetch_all(MYSQLI_ASSOC);
        } catch (mysqli_sql_exception $e) {
            $this->handleException($e);
            return [];
        }
    }

    public function first(): ?array
    {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }

    /**
     * Determina a paginação na Query
     *
     * @param int $perPage
     * @param int|null $page
     * @return array
     */
    public function paginate(int $perPage = 10, ?int $page = null): array
    {
        $page = $page ?? (isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1);
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $perPage;

        // Clona a query para não perder os WHERE já definidos
        $dataQuery = clone $this;
        $dataQuery->limit($perPage, $offset);

        // Dados
        $data = $dataQuery->get();

        // Total
        $total = $this->count();
        $lastPage = (int)ceil($total / $perPage);

        return [
            "data" => $data,
            "total" => $total,
            "per_page" => $perPage,
            "current_page" => $page,
            "last_page" => $lastPage,
        ];
    }

    /**
     * Adiciona um JOIN à query.
     *
     * @param string $table         Tabela que será unida
     * @param string $localColumn   Coluna da tabela base para o JOIN
     * @param string $foreignColumn Coluna da tabela unida para o JOIN
     * @param string $type          Tipo de JOIN: 'INNER', 'LEFT' ou 'RIGHT' (default: 'INNER')
     * @return self
     *
     * @throws  InvalidArgumentException Se o tipo de JOIN for inválido
     *
     * Exemplo:
     * $query->join('artigos',  'artigos.categoria_id', 'categorias.id', 'LEFT');
     */
    public function join(string $table, string $localColumn, string $foreignColumn, string $type = 'INNER'): self
    {
        $type = strtoupper($type);
        if (!in_array($type, ['INNER', 'LEFT', 'RIGHT'])) {
            throw  new \http\Exception\InvalidArgumentException("Tipo de JOIN inválido: {$type}}");
        }

        $this->joins[] = "{$type} JOIN {$table} ON {$foreignColumn} = {$localColumn}";
        return $this;
    }

    // Monta a query no método get(), ou prepareStatement()
    // Pode-se inserir joins na query.
    private function applyJoins(): void
    {
        if (!empty($this->joins)) {
            $this->query .= ' ' . implode(' ', $this->joins);
        }
    }

    /**
     * Prepare statements para segurança
     *
     * @return mysqli_stmt
     */
    private function prepareStatement(): mysqli_stmt
    {
        $this->applyJoins(); // Aplica os JOINS antes do prepare.

        $stmt = $this->connection->prepare($this->query);
        if (!$stmt) {
            throw new RuntimeException("Erro ao preparar query: " . $this->connection->error);
        }

        if (!empty($this->bindings)) {
            $types = $this->determineBindTypes($this->bindings);
            $stmt->bind_param($types, ...$this->bindings);
        }

        return $stmt;
    }

    private function determineBindTypes(array $values): string
    {
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) {
                $types .= 'i';
            } elseif (is_float($value)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }
        }
        return $types;
    }

    private function handleException(mysqli_sql_exception $e): void
    {
        // Log do erro (implemente seu sistema de log)
        error_log("Database error: " . $e->getMessage());

        // Você pode lançar uma exceção personalizada aqui se desejar
        throw new DatabaseException("Erro ao executar consulta no banco de dados");
    }

    private function extractWherePart(): string
    {
        if (stripos($this->query, 'WHERE') !== false) {
            return ' ' . substr($this->query, stripos($this->query, 'WHERE'));
        }

        return '';
    }

}