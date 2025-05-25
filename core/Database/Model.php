<?php

declare(strict_types=1);

namespace Core\Database;

use mysqli;

abstract class Model
{

    protected ?string $tabela;
    protected ?string $primaryKey = 'id';
    protected mysqli $conexao;

    public function __construct()
    {
        $db = Connection::getInstance();
        $this->conexao = $db->getConnection();
    }

    // Métodos Genericos para manipulação de dados
    // Aqui você pode adicionar métodos genéricos para manipulação de dados, como:
    // - all(): Retorna todos os registros da tabela
    // - find($id): Retorna um registro específico pelo ID
    // - save($data): Salva um novo registro na tabela
    // - update($id, $data): Atualiza um registro específico pelo ID
    // - delete($id): Deleta um registro específico pelo ID
    // - etc.


    /**
     * Retorna todos os registros da tabela
     * Método find()
     * 
     * @return array
     */
    public function find(int $id): ?array
    {
        $query = "SELECT * FROM {$this->tabela} WHERE {$this->primaryKey} = ?";
        $stmt = $this->conexao->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc() ?: null;
    }

    /**
     * Retorna todos os registros da tabela
     * Método all()
     * 
     * @return array
     */
    public function all($columns = ['*'], $conditions = '', $params = [], $limit = null, $offset = null): array

    {
        $cols   = implode(', ', $columns);
        $sql    = "SELECT {$cols} FROM {$this->tabela}";

        if (!empty($conditions)) {
            $sql .= " WHERE {$conditions}";
        }

        if ($limit !== null) {
            $sql .= " LIMIT {$limit}";
            $params[] = $limit;

            if ($offset !== null) {
                $sql .= " OFFSET {$offset}";
                $params[] = $offset;
            }
        }

        $stmt = $this->conexao->prepare($sql);
        if (!empty($params)) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}