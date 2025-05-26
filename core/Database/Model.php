<?php
/**
 * ---------------------------------------------------------------------
 * Project:     Sistema personalizado em PHP
 * Author:      Thiago Leite - Devt Digital
 * License:     Proprietary - Todos os direitos reservados
 * File:        Model.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright (c) 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

declare(strict_types=1);

namespace Core\Database;

use Exception;
use RuntimeException;
use mysqli;

abstract class Model {
    protected $table;
    protected $primaryKey = 'id';
    protected  ?mysqli $connection = null;
    
    public function __construct() {
        // $db = Connection::getInstance();
        // $this->connection = $db->getConnection();
        $this->initializeConnection();
    }

    protected function initializeConnection()
    {
        if ($this->connection === null) {
            try {
                $db = Connection::getInstance();
                $this->connection = $db->getConnection();

                if ($this->connection->connect_errno) {
                    throw new RuntimeException(
                        "Falha na conexão: " . $this->connection->connect_error
                    );
                }
            } catch (Exception $e) {
                $this->handleException($e);
                throw new RuntimeException("Falha ao inicializar conexão com o banco de dados.");
            }
        }
    }
    
    public function query(): QueryBuilder {
        if ($this->connection === null) {
            throw new Exception('Conexão não iniciada.');
        }
        return new QueryBuilder($this->connection, $this->table);
    }

    // SELECT
    public function find($id): ?array {
        return $this->query()
            ->select()
            ->where($this->primaryKey, '=', $id)
            ->first();
    }

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

    // INSERIR
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

    // ATUALIZAR
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

    // DELETAR
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

    protected function handleException(Exception $e): void {
        // Log do erro
        error_log("Model error: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        
        // Lança exceção personalizada ou trata conforme sua necessidade
        throw new RuntimeException("Erro na operação do modelo: " . $e->getMessage(), 0, $e);
    }
}