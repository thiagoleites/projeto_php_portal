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

    public function store(): void
    {
        View::setArea('admin');
//        $regras = [
//            'categoria_pai' => FILTER_VALIDATE_INT,
//            'name'          => FILTER_SANITIZE_SPECIAL_CHARS,
//            'descricao'     => FILTER_SANITIZE_SPECIAL_CHARS,
//        ];
//        $dados = filter_input_array(INPUT_POST, $regras);
//
//        if (!$dados || empty($dados['name'])) {
//            Helpers::session('erro', 'O nome da categoria é obrigatório');
//            header('Location: ' . Helpers::URL_BASE["admin"] . '/categorias/criar');
//            exit;
//        }
//
//        try {
//            Categoria::addCategoria($dados);
//            Helpers::session('sucesso', 'Categoria cadastrada com sucesso');
//            header('Location: ' . Helpers::URL_BASE["admin"] . '/categorias');
//        } catch (Exception $e) {
//            Helpers::session('erro', 'Erro ao adicionar categoria '. $e->getMessage());
//            header('Location: ' . Helpers::URL_BASE["admin"] . '/categorias/criar');
//            exit();
//        }

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

    private function handleStoreAjax(): void
    {
        try {
            $dados = $this->getRequestData();

            // Validação
            $regras = [
                'name' => 'required|min:3|max:255',
                'descricao' => 'max:500',
                'categoria_pai' => 'numeric'
            ];

            $errors = $this->validateAjaxData($dados, $regras);

            if (!empty($errors)) {
                $this->ajaxValidationError($errors);
                return;
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
}
