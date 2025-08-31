<?php
/**
 * ---------------------------------------------------------------------
 * Project: Sistema personalizado em PHP
 * Author: Thiago Leite - Devt Digital
 * License: Proprietary - Todos os direitos reservados
 * File: CategoriaController.php
 * Description: Classe responsável pela construção de queries SQL
 * ---------------------------------------------------------------------
 * Copyright © 2025 Devt Digital
 * Thiago Leite <tls@devt.emp.br>
 * ---------------------------------------------------------------------
 */

namespace App\Controllers\Admin;

use App\Models\Categoria;
use Core\Controller;
use Core\Helpers;
use Core\View;
use Exception;

class CategoriaController extends Controller
{
    public function index(): void
    {
        $categorias = Categoria::getCategorias(15);

        View::setArea('admin');
        View::render('pages/categorias/index', [
            'titulo' => 'Listagem de categorias',
            'subtitulo' => 'Gerencie as categorias listadas',
            'categorias' => $categorias,
        ]);
    }

    public function create(): void
    {
        $categorias = Categoria::getCategorias(100);
        View::setArea('admin');

        View::render('pages/categorias/criar', [
            'titulo' => 'Criar nova Categoria',
            'subtitulo' => 'Preencha os campos abaixo para publicar ou salvar um rascunho.',
            'categorias' => $categorias
        ]);
    }

    public function edit(Categoria $id): void
    {
        try {
            $categoria = Categoria::getCategoriaById($id);
            if (!$categoria) {
                Helpers::session('erro', 'Categoria não encontrada');
                $this->redirect(Helpers::URL_BASE['admin'] . '/categorias');
                return;
            }
            $categorias = Categoria::getCategorias(100);
            View::setArea('admin');
            View::render('pages/categorias/editar', [
                'titulo' => 'Editar Categoria',
                'subtitulo' => 'Altere os dados da Categoria',
                'categoria' => $categoria,
                'categorias' => $categorias
            ]);

        } catch (Exception $e) {
            Helpers::session('erro', 'Erro ao carregar categoria: ' . $e->getMessage());
            $this->redirect(Helpers::URL_BASE['admin'] . '/categorias');
        }


    }

    public function store(): void
    {
        View::setArea('admin');

        $this->setCorsHeaders();

        if ($this->isPreflightRequest()) {
            exit;
        }

        if ($this->isAjaxRequest()) {
            $this->handleStoreAjax();
            return;
        }

        $this->handleStoreNormal();

    }

    public function update(int $id): void
    {
        $this->setCorsHeaders();

        if ($this->isPreflightRequest()) {
            exit;
        }

        if ($this->isAjaxRequest()) {
            $this->handUpdateAjax($id);
            return;
        }

        $this->handleUpdateNormal();
    }

    private function handleStoreAjax(): void
    {
        try {
            $dados = $this->getRequestData();

            // Validação
            $regras = [
                'name' => 'required|min:3|max:255',
                'descricao' => 'max:500',
                'categoria_pai' => 'nullable|numeric|exists:categorias,id'
            ];

            $errors = $this->validateAjaxData($dados, $regras);

            if (!empty($errors)) {
                $this->ajaxValidationError($errors);
                return;
            }

            if (empty($dados['categoria_pai'])) {
                $dados['categoria_pai'] = null;
            }

            // Insere no banco
            $categoriaId = Categoria::addCategoria($dados);

            $this->ajaxSuccess([
                'id' => $categoriaId,
                'name' => $dados['name'],
                'redirect' => Helpers::URL_BASE["admin"] . '/categorias'
            ], 'Categoria criada com sucesso!', 201);

        } catch (Exception $e) {
            $this->ajaxError('Erro ao criar categoria: ' . $e->getMessage());
        }
    }

    public function handleUpdateAjax(int $id): void
    {
        try {
            $dados = $this->getRequestData();

            // Validaçãoi (adicionar unique excluindo o registro atual)
            $regras = [
                'name' => 'required|min:3|max:255',
                'short_link' => 'required|min:3|max:255|unique:categorias,short_link,' . $id,
                'descricao' => 'max:500',
                'categoria_pai' => 'nullable|numeric|exists:categorias,id'
            ];

            $errors = $this->validateAjaxData($dados, $regras);

            if (!empty($errors)) {
                $this->ajaxValidationError($errors);
                return;
            }

            if (empty($dados['categoria_pai'])) {
                $dados['categoria_pai'] = null;
            }
            $sucesso = Categoria::addCategoriaComSlug($id, $dados);

            if ($sucesso) {
                $this->ajaxSuccess([
                    'id' => $id,
                    'name' => $dados['name'],
                    'redirect' => Helpers::URL_BASE["admin"] . '/categorias'
                ], 'Categoria criada com sucesso!', 200);
            } else {
                $this->ajaxError('Erro ao atualizar categoria');
            }

        } catch (Exception $e) {
            $this->ajaxError('Erro ao carregar categoria: ' . $e->getMessage());
        }
    }

    private function handleUpdateNormal(int $id): void
    {
        View::setArea('admin');
        $regras = [
            'categoria_pai' => FILTER_VALIDATE_INT,
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'short_link' => FILTER_SANITIZE_SPECIAL_CHARS,
            'descricao' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $dados = filter_input_array(INPUT_POST, $regras);

        if (!$dados || empty($dados['name'])) {
            Helpers::session('erro', 'O nome da categoria é obrigatório');
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias/editar/' . $id);
        }

        try {
            $sucesso = Categoria::updateCategoriaComSlug($id, $dados);

            if ($sucesso) {
                Helpers::session('sucesso', 'Categoria atualizada com sucesso');
                $this->redirect(Helpers::URL_BASE["admin"] . '/categorias');
            } else {
                Helpers::session('erro', 'Erro ao atualizar categoria');
                $this->redirect(Helpers::URL_BASE["admin"] . '/categorias/editar/' . $id);
            }
        } catch (Exception $e) {
            Helpers::session('erro', 'Erro ao atualizar categoria: ' . $e->getMessage());
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias/editar/' . $id);
        }
    }

    // Adicione este método para validação
    protected function validateAjaxData(array $data, array $rules): array
    {
        $errors = [];

        foreach ($rules as $field => $ruleString) {
            $rulesArray = explode('|', $ruleString);

            foreach ($rulesArray as $rule) {
                if ($rule === 'required') {
                    if (!isset($data[$field]) || empty(trim($data[$field] ?? ''))) {
                        $errors[$field][] = "O campo {$field} é obrigatório";
                    }
                }

                if (strpos($rule, 'min:') === 0) {
                    $min = (int)str_replace('min:', '', $rule);
                    if (isset($data[$field]) && strlen(trim($data[$field])) < $min) {
                        $errors[$field][] = "O campo {$field} deve ter pelo menos {$min} caracteres";
                    }
                }

                if (strpos($rule, 'max:') === 0) {
                    $max = (int)str_replace('max:', '', $rule);
                    if (isset($data[$field]) && strlen(trim($data[$field])) > $max) {
                        $errors[$field][] = "O campo {$field} não pode ter mais que {$max} caracteres";
                    }
                }

                if ($rule === 'numeric') {
                    if (isset($data[$field]) && !empty($data[$field]) && !is_numeric($data[$field])) {
                        $errors[$field][] = "O campo {$field} deve ser um número";
                    }
                }

                if (strpos($rule, 'unique:') === 0) {
                    $parts = explode(',', str_replace('unique:', '', $rule));
                    $table = $parts[0];
                    $column = $parts[1];

                    if (isset($data[$field]) && !empty($data[$field])) {
                        $exists = $this->checkUnique($table, $column, $data[$field]);
                        if ($exists) {
                            $errors[$field][] = "Este {$field} já está em uso";
                        }
                    }
                }

                if (strpos($rule, 'exists:') === 0) {
                    $parts = explode(',', str_replace('exists:', '', $rule));
                    $table = $parts[0];
                    $column = $parts[1];

                    if (isset($data[$field]) && !empty($data[$field])) {
                        $exists = $this->checkExists($table, $column, $data[$field]);
                        if (!$exists) {
                            $errors[$field][] = "O valor selecionado para {$field} é inválido";
                        }
                    }
                }
            }
        }

        return $errors;
    }

    private function checkUnique(string $table, string $column, $value): bool
    {
        // Implemente a verificação de unicidade no banco
        $db = \Core\Database\DB::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = :value");
        $stmt->execute([':value' => $value]);
        return $stmt->fetchColumn() > 0;
    }

    private function checkExists(string $table, string $column, $value): bool
    {
        // Implemente a verificação de existência no banco
        $db = \Core\Database\DB::getInstance();
        $stmt = $db->prepare("SELECT COUNT(*) FROM {$table} WHERE {$column} = :value");
        $stmt->execute([':value' => $value]);
        return $stmt->fetchColumn() > 0;
    }

    private function handleStoreNormal(): void
    {
        View::setArea('admin');
        $regras = [
            'categoria_pai' => FILTER_VALIDATE_INT,
            'name' => FILTER_SANITIZE_SPECIAL_CHARS,
            'descricao' => FILTER_SANITIZE_SPECIAL_CHARS,
        ];

        $dados = filter_input_array(INPUT_POST, $regras);

        if (!$dados || empty($dados['name'])) {
            Helpers::session('erro', 'O nome da categoria é obrigatório');
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias/criar');
        }

        try {
            Categoria::addCategoria($dados);
            Helpers::session('sucesso', 'Categoria cadastrada com sucesso');
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias');
        } catch (Exception $e) {
            Helpers::session('erro', 'Erro ao adicionar categoria ' . $e->getMessage());
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias/criar');
        }
    }

    // No controller CategoriaController.php
    public function delete(int $id): void
    {
        $this->setCorsHeaders();

        if ($this->isPreflightRequest()) {
            exit;
        }

        if ($this->isAjaxRequest()) {
            $this->handleDeleteAjax($id);
            return;
        }

        $this->handleDeleteNormal($id);
    }

    private function handleDeleteAjax(int $id): void
    {
        try {
            $sucesso = Categoria::deleteCategoria($id);

            if ($sucesso) {
                $this->ajaxSuccess([
                    'id' => $id,
                    'redirect' => Helpers::URL_BASE["admin"] . '/categorias'
                ], 'Categoria excluída com sucesso!', 200);
            } else {
                $this->ajaxError('Erro ao excluir categoria');
            }

        } catch (Exception $e) {
            $this->ajaxError($e->getMessage());
        }
    }

    private function handleDeleteNormal(int $id): void
    {
        try {
            $sucesso = Categoria::deleteCategoria($id);

            if ($sucesso) {
                Helpers::session('sucesso', 'Categoria excluída com sucesso');
            } else {
                Helpers::session('erro', 'Erro ao excluir categoria');
            }
        } catch (Exception $e) {
            Helpers::session('erro', $e->getMessage());
        }

        $this->redirect(Helpers::URL_BASE["admin"] . '/categorias');
    }

// Adicione também um método para confirmar a exclusão
    public function confirmDelete(int $id): void
    {
        try {
            $categoria = Categoria::getCategoriaById($id);

            if (!$categoria) {
                Helpers::session('erro', 'Categoria não encontrada');
                $this->redirect(Helpers::URL_BASE["admin"] . '/categorias');
                return;
            }

            // Verificar se existem artigos ou subcategorias
            $artigosCount = (new Categoria())
                ->query()
                ->select()
                ->where('categoria_id', '=', $id)
                ->count();

            $subcategoriasCount = (new Categoria())
                ->query()
                ->select()
                ->where('categoria_pai', '=', $id)
                ->count();

            View::setArea('admin');
            View::render('pages/categorias/confirmar-exclusao', [
                'titulo' => 'Confirmar Exclusão',
                'subtitulo' => 'Tem certeza que deseja excluir esta categoria?',
                'categoria' => $categoria,
                'artigosCount' => $artigosCount,
                'subcategoriasCount' => $subcategoriasCount
            ]);

        } catch (Exception $e) {
            Helpers::session('erro', 'Erro ao carregar categoria: ' . $e->getMessage());
            $this->redirect(Helpers::URL_BASE["admin"] . '/categorias');
        }
    }
}
