<?php

/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

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