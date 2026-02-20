<?php

/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

use Core\Helpers;
use Core\View;

View::extend('layouts/main');
View::start('content');

/**
 * @var array{
 *     id: int,
 *     name: string,
 *     descricao: string,
 *     short_link: string,
 *     categoria_pai: int|null
 * } $categoria
 */
/** @var int $artigosCount */
/** @var int $subcategoriasCount */
?>

    <!-- Conteúdo Principal -->
    <main class="flex-1 md:ml-64 p-6 md:p-8">
        <div class="md:hidden mb-4">
            <button id="mobileMenuButton" class="p-2 rounded-md text-slate-600 hover:bg-slate-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>

        <header class="mb-8">
            <h1 class="text-3xl font-semibold text-slate-800">Confirmar Exclusão</h1>
            <p class="text-slate-600 mt-1">Tem certeza que deseja excluir esta categoria?</p>
        </header>

        <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200/80 w-full max-w-2xl mx-auto">
            <!-- Alertas de restrições -->
            <?php if ($artigosCount > 0): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Não é possível excluir esta categoria!</strong><br>
                                Existem <?= $artigosCount ?> artigo(s) associado(s) a ela.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($subcategoriasCount > 0): ?>
                <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                <strong>Não é possível excluir esta categoria!</strong><br>
                                Existem <?= $subcategoriasCount ?> subcategoria(s) associada(s) a ela.
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Informações da categoria -->
            <div class="bg-slate-50 p-4 rounded-lg mb-6">
                <h3 class="font-semibold text-slate-800 mb-2">Informações da Categoria</h3>
                <p><strong>Nome:</strong> <?= htmlspecialchars($categoria['name']) ?></p>
                <p><strong>Slug:</strong> <?= htmlspecialchars($categoria['short_link']) ?></p>
                <?php if (!empty($categoria['descricao'])): ?>
                    <p><strong>Descrição:</strong> <?= htmlspecialchars($categoria['descricao']) ?></p>
                <?php endif; ?>
            </div>

            <!-- Aviso permanente -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-yellow-700">
                            <strong>Atenção:</strong> Esta ação não pode ser desfeita. Todos os dados da categoria serão permanentemente excluídos.
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="<?= Helpers::URL_BASE['admin'] ?>/categorias"
                   class="bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold py-2 px-4 rounded-lg text-sm transition-colors">
                    Cancelar
                </a>

                <?php if ($artigosCount == 0 && $subcategoriasCount == 0): ?>
                    <form action="<?= Helpers::URL_BASE['admin'] ?>/categorias/excluir/<?= $categoria['id'] ?>" method="POST" class="inline">
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit"
                                class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg text-sm transition-colors">
                            Confirmar Exclusão
                        </button>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </main>

<?php
View::end();
?>