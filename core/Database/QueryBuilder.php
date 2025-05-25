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
use InvalidArgumentException;
use RuntimeException;
use mysqli_sql_exception;
use mysqli_stmt;

class QueryBuilder
{
    protected $connection;
    private $query;
    private $bindings = [];
    private $table;

    public function __construct(mysqli $connection, string $table) {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function select(array $columns = ['*']): self {
        $this->query = 'SELECT ' . implode(', ', $columns) . ' FROM ' . $this->table;
        return $this;
    }

    public function where(string $column, string $operator, $value): self {
        if (!in_array(strtoupper($operator), ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN'])) {
            throw new InvalidArgumentException("Operador inválido: {$operator}");
        }

        $this->addCondition('WHERE', $column, $operator, $value);
        return $this;
    }

    public function andWhere(string $column, string $operator, $value): self {
        $this->addCondition('AND', $column, $operator, $value);
        return $this;
    }

    public function orWhere(string $column, string $operator, $value): self {
        $this->addCondition('OR', $column, $operator, $value);
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->query .= " ORDER BY {$column} {$direction}";
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): self {
        $this->query .= " LIMIT {$limit}";
        if ($offset !== null) {
            $this->query .= " OFFSET {$offset}";
        }
        return $this;
    }

    private function addCondition(string $type, string $column, string $operator, $value): void {
        $placeholder = '?';
        
        if (is_array($value) && in_array($operator, ['IN', 'NOT IN'])) {
            $placeholders = implode(', ', array_fill(0, count($value), '?'));
            $this->query .= " {$type} {$column} {$operator} ({$placeholders})";
            $this->bindings = array_merge($this->bindings, $value);
        } else {
            $this->query .= " {$type} {$column} {$operator} {$placeholder}";
            $this->bindings[] = $value;
        }
    }

    public function get(): array {
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

    public function first(): ?array {
        $results = $this->limit(1)->get();
        return $results[0] ?? null;
    }

    private function prepareStatement(): mysqli_stmt {
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

    private function determineBindTypes(array $values): string {
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

    private function handleException(mysqli_sql_exception $e): void {
        // Log do erro (implemente seu sistema de log)
        error_log("Database error: " . $e->getMessage());
        
        // Você pode lançar uma exceção personalizada aqui se desejar
        throw new RuntimeException("Erro ao executar consulta no banco de dados");
    }
}