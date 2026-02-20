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

class Artigo extends Model
{
    protected $table = 'artigos';
    protected $primaryKey = 'id';

    public function __construct()
    {
        parent::__construct();
    }


    public static function contarArtigos(): int
    {
        return (new static())->query()->select()->count('*');
    }

    public static function getArtigos(int $limit = 10, int $offset = 0): array
    {
        return (new static())
            ->query()
            ->select()
            ->orderBy('id', 'DESC')
            ->limit($limit, $offset)
            ->get();
    }
}