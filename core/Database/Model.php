<?php
declare(strict_types=1);

namespace Core\Database;

use Core\Exceptions\ConnectionException;
use Core\Exceptions\DatabaseException;
use Core\Exceptions\QueryException;
use Exception;
use RuntimeException;
use mysqli;
use mysqli_sql_exception;
use Throwable;

abstract class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected  ?mysqli $connection = null;
    
    public function __construct() {
        try {
            $db = Connection::getInstance();
            $this->connection = $db->getConnection();
        } catch (Throwable $e) {
            throw new ConnectionException("Falha ao conectar ao banco de dados.", [], $e);
        }
    }

    /**
     * Retorna uma instância de QueryBuilder para construir consultas SQL
     * 
     * @return QueryBuilder
     * @throws ConnectionException
     */
    
    public function query(): QueryBuilder {
        if ($this->connection === null) {
            throw new ConnectionException('Conexão com o banco de dados não disponível Model.php');
        }
        return new QueryBuilder($this->connection, $this->table);
    }

    /**
     * Retorna resultado através da query com ID como referência
     *
     * @param $id
     * @return array|null
     */
    public function find($id): ?array {
        return $this->query()
            ->select()
            ->where($this->primaryKey, '=', $id)
            ->first();
    }

    /**
     * Retorna uma lista de registro com base em condições, ordenação e paginação.
     *
     * Este método permite monta consultas dinâmicas, aplicando filtros (`where`),
     * ordenação(`orderBy`) e controle de paginação (`limit` e `offset`),
     * retornando todos os registros que atendem aos critérios informados.
     *
     * @param array $conditions
     * @param array $order
     * @param int|null $limit
     * @param int|null $offset
     * @return array
     */

    public function findAll(array $conditions = [], array $order = [], ?int $limit = null, ?int $offset = null): array {
        $query = $this->query()->select();
        
        foreach ($conditions as $condition) {
            [$column, $operator, $value] = $condition;
            $query->where($column, $operator, $value);
        }
        
        foreach ($order as $column => $direction) {
            $query->orderBy($column, $direction);
        }
        
        if ($limit !== null) {
            $query->limit($limit, $offset);
        }
        
        return $query->get();
    }

    /**
     * Insere um novo registro na tabela associada ao repositório.
     *
     * Este método cria dinamicamente uma instrução INSERT com base
     * nos dados fornecidos, utilizando prepared statements para
     * evitar SQL Injection. A operação é executada dentro de uma
     * transação, garantindo integridade dos dados.
     *
     * @param array $data
     * @return int
     * @throws Throwable
     */
    public function create(array $data): int {
        $this->beginTransaction();
        
        try {
            $columns = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));
            
            $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new RuntimeException("Erro ao preparar query: " . $this->connection->error);
            }
            
            $types = $this->determineBindTypes(array_values($data));
            $stmt->bind_param($types, ...array_values($data));
            $stmt->execute();
            
            $insertId = $this->connection->insert_id;
            $this->commit();
            
            return $insertId;
        } catch (Exception $e) {
            $this->rollBack();
            $this->handleException($e);
            return 0;
        }
    }

    /**
     * Atualiza o registro associado a um ID de identificação
     *
     * Este método atualiza de forma dinâmica com a instrução UPDATE
     * os dados fornecidos com base num ID, o registro retorna true.
     *
     * @param $id
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function update($id, array $data): bool {
        $this->beginTransaction();
        
        try {
            $setClause = implode(', ', array_map(fn($col) => "{$col} = ?", array_keys($data)));
            
            $sql = "UPDATE {$this->table} SET {$setClause} WHERE {$this->primaryKey} = ?";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new RuntimeException("Erro ao preparar query: " . $this->connection->error);
            }
            
            $values = array_values($data);
            $values[] = $id;
            $types = $this->determineBindTypes($values);
            
            $stmt->bind_param($types, ...$values);
            $result = $stmt->execute();
            
            $this->commit();
            return $result;
        } catch (Exception $e) {
            $this->rollBack();
            $this->handleException($e);
            return false;
        }
    }

    /**
     * Remove o registro associado a um ID de identificação
     *
     * Este método remove todos os dados do banco com base no ID fornecido.
     *
     * @param $id
     * @return bool
     * @throws Throwable
     */
    public function delete($id): bool {
        $this->beginTransaction();
        
        try {
            $sql = "DELETE FROM {$this->table} WHERE {$this->primaryKey} = ?";
            $stmt = $this->connection->prepare($sql);
            
            if (!$stmt) {
                throw new RuntimeException("Erro ao preparar query: " . $this->connection->error);
            }
            
            $stmt->bind_param($this->determineBindTypes([$id]), $id);
            $result = $stmt->execute();
            
            $this->commit();
            return $result;
        } catch (Exception $e) {
            $this->rollBack();
            $this->handleException($e);
            return false;
        }
    }

    // TRANSAÇÕES
    public function beginTransaction(): void {
        $this->connection->begin_transaction();
    }

    public function commit(): void {
        $this->connection->commit();
    }

    public function rollBack(): void {
        $this->connection->rollback();
    }

    // HELPERS - AUXILIARES
    protected function determineBindTypes(array $values): string {
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

    protected function handleException(Throwable $e): void {

        if ($e instanceof mysqli_sql_exception) {
            $e = new QueryException($e->getMessage(), '', [
                'errno' => $e->getCode(),
                'sqlstate' => $e->getSqlState() ?? 'UNKNOWN'
            ], $e);
        }

        error_log(json_encode([
            'timestamp' => date('Y-m-d H:i:s'),
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'code' => $e->getCode(),
            'trace' => $e->getTraceAsString(),
            'context' => $e instanceof DatabaseException ? $e->getContext() : []
        ]));

        throw $e;

    }
}