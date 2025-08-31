<?php

use Core\View;
use Core\Helpers;

View::extend('layouts/main');
View::start('content');


/** @var array<int, array{
 *     id: int,
 *     name: string,
 *     descricao: string,
 *     total_artigos: int
 * }> $categorias
 */

?>
<!-- notificações -->
<!--<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2 hidden"></div>-->

<!-- Sistema de Notificações para mensagens de sessão -->
<?php if (Helpers::session('sucesso')): ?>
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 rounded-lg shadow-lg animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"/>
                </svg>
                <span><?= Helpers::session('sucesso') ?></span>
                <button class="ml-auto text-green-700 hover:opacity-75"
                        onclick="this.parentElement.parentElement.style.display='none'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php
    Helpers::session('sucesso', null);
endif; ?>

<?php if (Helpers::session('erro')): ?>
    <div class="fixed top-4 right-4 z-50">
        <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 rounded-lg shadow-lg animate-fade-in">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"/>
                </svg>
                <span><?= Helpers::session('erro') ?></span>
                <button class="ml-auto text-red-700 hover:opacity-75"
                        onclick="this.parentElement.parentElement.style.display='none'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <?php
    Helpers::session('erro', null);
endif; ?>

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

    <header class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-semibold text-slate-800">Categorias</h1>
            <p class="text-slate-600 mt-1">Gerencie as categorias de seus artigos.</p>
        </div>
        <a href="/base/admin/categorias/criar"
           class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2.5 px-5 rounded-lg text-sm flex items-center space-x-2 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z"/>
            </svg>
            <span>Nova Categoria</span>
        </a>
    </header>

    <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200/80">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-sm text-left text-slate-600">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50/50">
                <tr>
                    <th scope="col" class="px-6 py-3 font-medium">Nome da Categoria</th>
                    <th scope="col" class="px-6 py-3 font-medium">Descrição</th>
                    <th scope="col" class="px-6 py-3 font-medium text-center">Artigos</th>
                    <th scope="col" class="px-6 py-3 font-medium text-center">Ações</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/80">
                <?php foreach ($categorias['data'] as $categoria) : ?>
                    <tr class="hover:bg-slate-50/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-slate-800"><?= $categoria['name'] ?></td>
                        <td class="px-6 py-4"><code><?= $categoria['descricao'] ?></code></td>
                        <td class="px-6 py-4 text-center">
                            <a href="#" class="text-indigo-600 hover:underline"><?= $categoria['total_artigos'] ?></a>
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="<?= Helpers::URL_BASE['admin'] ?>/categorias/editar/<?= $categoria['id'] ?>"
                               class="text-indigo-600 hover:text-indigo-900">Editar</a>
                            <!--                            <a href="-->
                            <?php //= Helpers::URL_BASE['admin'] ?><!--/categorias/confirmar-exclusao/-->
                            <?php //= $categoria['id'] ?><!--"-->
                            <!--                               class="text-red-600 hover:text-red-800 font-medium cursor pointer"-->
                            <!--                               data-id="-->
                            <?php //= $categoria['id'] ?><!--">Excluir</a>-->
                            <?php if ($categoria['total_artigos'] == 0): ?>
                                <a href="<?= Helpers::URL_BASE['admin'] ?>/categorias/confirmar-exclusao/<?= $categoria['id'] ?>"
                                   class="text-red-600 hover:text-red-900">Excluir</a>
                            <?php else: ?>
                                <span class="text-slate-400 cursor-not-allowed"
                                      title="Não pode ser excluída (possui artigos)">Excluir</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!--    </div>-->
        <!-- Paginação -->
        <div class="mt-6 flex justify-end bottom-5 right-8">
            <nav aria-label="Page navigation">
                <ul class="inline-flex items-center -space-x-px">

                    <!-- Link Anterior -->
                    <?php if ($categorias['current_page'] > 1): ?>
                        <li>
                            <a href="?pagina=<?= $categorias['current_page'] - 1 ?>"
                               class="py-2 px-3 ml-0 leading-tight text-slate-500 bg-white rounded-l-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700 text-sm">
                                Anterior
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Números de páginas -->
                    <?php for ($i = 1; $i <= $categorias['last_page']; $i++): ?>
                        <li>
                            <a href="?pagina=<?= $i ?>"
                               class="py-2 px-3 leading-tight border border-slate-300 text-sm
                              <?= $i == $categorias['current_page']
                                       ? 'text-indigo-600 bg-indigo-50 hover:bg-indigo-100 hover:text-indigo-700'
                                       : 'text-slate-500 bg-white hover:bg-slate-100 hover:text-slate-700' ?>">
                                <?= $i ?>
                            </a>
                        </li>
                    <?php endfor; ?>

                    <!-- Link Próximo -->
                    <?php if ($categorias['current_page'] < $categorias['last_page']): ?>
                        <li>
                            <a href="?pagina=<?= $categorias['current_page'] + 1 ?>"
                               class="py-2 px-3 leading-tight text-slate-500 bg-white rounded-r-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700 text-sm">
                                Próximo
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </nav>
        </div>
    </div>
</main>

<?php
View::script(<<<SCRIPT
<script>
// Auto-remover notificações após 5 segundos
setTimeout(() => {
    document.querySelectorAll('[class*="bg-green-50"], [class*="bg-red-50"]').forEach(notification => {
        notification.style.display = 'none';
    });
}, 5000);
</script>
SCRIPT
);
View::end();
?>
