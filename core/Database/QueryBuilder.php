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

namespace Core\Database;

use Core\Exceptions\DatabaseException;
use mysqli;
use mysqli_stmt;
use mysqli_sql_exception;
use RuntimeException;
use InvalidArgumentException;

class QueryBuilder
{
    protected mysqli $connection;
    private ?string $query = null;
    private array $bindings = [];
    private string $table;
    private array $joins = [];
    private ?string $groupBy = null;
    private ?string $orderBy = null;
    private ?int $limit = null;
    private ?int $offset = null;

    public function __construct(mysqli $connection, string $table)
    {
        $this->connection = $connection;
        $this->table = $table;
    }

    public function select(array $columns = ['*']): self
    {
        $columnsList = implode(', ', $columns);
        $this->query = "SELECT {$columnsList} FROM {$this->table}";
        return $this;
    }

    public function where(string $column, string $operator, $value): self
    {
        return $this->addCondition('WHERE', $column, $operator, $value);
    }

    public function andWhere(string $column, string $operator, $value): self
    {
        return $this->addCondition('AND', $column, $operator, $value);
    }

    public function orWhere(string $column, string $operator, $value): self
    {
        return $this->addCondition('OR', $column, $operator, $value);
    }

    private function addCondition(string $type, string $column, string $operator, $value): self
    {
        $operator = strtoupper($operator);
        $allowedOperators = ['=', '!=', '<', '>', '<=', '>=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN'];
        if (!in_array($operator, $allowedOperators)) {
            throw new InvalidArgumentException("Operador inválido: {$operator}");
        }

        $prefix = '';
        if (stripos($this->query, 'WHERE') === false && $type !== 'OR') {
            $prefix = 'WHERE';
        } elseif ($type === 'WHERE') {
            $prefix = 'AND';
        } else {
            $prefix = $type;
        }

        if (is_array($value) && in_array($operator, ['IN', 'NOT IN'])) {
            $placeholders = implode(', ', array_fill(0, count($value), '?'));
            $this->query .= " {$prefix} {$column} {$operator} ({$placeholders})";
            $this->bindings = array_merge($this->bindings, $value);
        } else {
            $this->query .= " {$prefix} {$column} {$operator} ?";
            $this->bindings[] = $value;
        }

        return $this;
    }

    public function join(string $table, string $localColumn, string $foreignColumn, string $type = 'INNER'): self
    {
        $type = strtoupper($type);
        if (!in_array($type, ['INNER', 'LEFT', 'RIGHT'])) {
            throw new InvalidArgumentException("Tipo de JOIN inválido: {$type}");
        }

        $this->joins[] = "{$type} JOIN {$table} ON {$localColumn} = {$foreignColumn}";
        return $this;
    }

    public function groupBy(string $column): self
    {
        $this->groupBy = $column;
        return $this;
    }

    public function orderBy(string $column, string $direction = 'ASC'): self
    {
        $direction = strtoupper($direction) === 'DESC' ? 'DESC' : 'ASC';
        $this->orderBy = "{$column} {$direction}";
        return $this;
    }

    public function limit(int $limit, ?int $offset = null): self
    {
        $this->limit = $limit;
        $this->offset = $offset;
        return $this;
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

    public function count(): int
    {
        // Cria um clone para não modificar a query principal
        $countQuery = clone $this;

        // Remove o limite e offset da query de contagem
        $countQuery->limit = null;
        $countQuery->offset = null;
        $countQuery->orderBy = null;

        // Constrói a query de contagem a partir da query original
        // Apenas substituímos a parte SELECT
        $sql = $countQuery->buildCountQuery();

        try {
            $stmt = $this->connection->prepare($sql);
            if (!$stmt) {
                throw new RuntimeException("Erro ao preparar query de contagem: " . $this->connection->error);
            }

            // Binda os parâmetros da query original
            if (!empty($this->bindings)) {
                $types = $this->determineBindTypes($this->bindings);
                $stmt->bind_param($types, ...$this->bindings);
            }

            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return (int)($row['total'] ?? 0);
        } catch (mysqli_sql_exception $e) {
            $this->handleException($e);
            return 0;
        }
    }

    public function paginate(int $perPage = 10, ?int $page = null): array
    {
        $page = $page ?? (isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1);
        if ($page < 1) $page = 1;

        $offset = ($page - 1) * $perPage;
        $total = $this->count(); // Chama o método count() corrigido primeiro

        $dataQuery = clone $this;
        $dataQuery->limit($perPage, $offset);

        return [
            "data" => $dataQuery->get(),
            "total" => $total,
            "per_page" => $perPage,
            "current_page" => $page,
            "last_page" => (int)ceil($total / $perPage),
        ];
    }

    private function prepareStatement(): mysqli_stmt
    {
        $sql = $this->buildQuery();

        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new RuntimeException("Erro ao preparar query: " . $this->connection->error);
        }

        if (!empty($this->bindings)) {
            $types = $this->determineBindTypes($this->bindings);
            $stmt->bind_param($types, ...$this->bindings);
        }

        return $stmt;
    }

    private function buildQuery(): string
    {
        $sql = $this->query;

        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        if (!empty($this->groupBy)) {
            $sql .= " GROUP BY {$this->groupBy}";
        }

        if (!empty($this->orderBy)) {
            $sql .= " ORDER BY {$this->orderBy}";
        }

        if (!empty($this->limit)) {
            $sql .= " LIMIT {$this->limit}";
            if (!empty($this->offset)) {
                $sql .= " OFFSET {$this->offset}";
            }
        }

        return $sql;
    }

    private function buildCountQuery(): string
    {
        $sql = "SELECT COUNT(DISTINCT {$this->table}.id) AS total FROM {$this->table}";

        // Adiciona os JOINs existentes
        if (!empty($this->joins)) {
            $sql .= ' ' . implode(' ', $this->joins);
        }

        // Extrai a parte WHERE da query original
        $wherePart = $this->extractWherePart();
        if (!empty($wherePart)) {
            $sql .= $wherePart;
        }

        return $sql;
    }

    private function determineBindTypes(array $values): string
    {
        $types = '';
        foreach ($values as $value) {
            if (is_int($value)) $types .= 'i';
            elseif (is_float($value)) $types .= 'd';
            else $types .= 's';
        }
        return $types;
    }

    private function handleException(mysqli_sql_exception $e): void
    {
        error_log("Database error: " . $e->getMessage());
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