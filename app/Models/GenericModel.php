<?php
namespace App\Models;

use Core\Database\Model;

class GenericModel extends Model
{
    protected $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        parent::__construct();
    }

    public function setTable(string $table): self
    {
        $this->table = $table;
        return $this;
    }
}