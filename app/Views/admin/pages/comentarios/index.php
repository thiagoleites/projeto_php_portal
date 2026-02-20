<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

use Core\View;

View::extend('layouts/main');
View::start('content');
?>

 <!-- Conteúdo Principal -->
        <main class="flex-1 md:ml-64 p-6 md:p-8">
            <div class="md:hidden mb-4">
                <button id="mobileMenuButton" class="p-2 rounded-md text-slate-600 hover:bg-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <header class="mb-8 bg-white py-5 px-6 rounded-lg shadow-sm">
                <h1 class="text-3xl font-semibold text-slate-800">Moderação de Comentários</h1>
                <p class="text-slate-600 mt-1">Gerencie os comentários enviados pelos usuários.</p>
            </header>

            <!-- Filtros (Opcional) -->
            <div class="mb-6 flex flex-wrap gap-4 items-center">
                <select class="px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm bg-white">
                    <option value="todos">Todos os Status</option>
                    <option value="pendente">Pendentes</option>
                    <option value="aprovado">Aprovados</option>
                    <option value="reprovado">Reprovados</option>
                    <option value="spam">Spam</option>
                </select>
                <input type="text" placeholder="Buscar por autor ou conteúdo..." class="flex-grow px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder:text-slate-400 bg-white">
                <button class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-5 rounded-lg text-sm transition-colors">Filtrar</button>
            </div>

            <!-- Lista de Comentários -->
            <div class="space-y-6">
                <!-- Exemplo de Comentário 1 (Pendente) -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80">
                    <div class="flex items-start space-x-4">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/75.jpg" alt="Avatar">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-slate-800">Laura Mendes</span>
                                    <span class="text-xs text-slate-500">laura.m@example.com</span>
                                    <span class="text-xs py-0.5 px-2 rounded-full bg-amber-100 text-amber-700 font-medium">Pendente</span>
                                </div>
                                <span class="text-xs text-slate-500">10 minutos atrás</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-2 line-clamp-3">
                                Ótimo artigo! Tenho uma dúvida sobre o ponto X, poderia elaborar um pouco mais? Agradeço desde já a atenção e parabéns pelo conteúdo de qualidade que vocês sempre trazem. Realmente ajuda muito no dia a dia.
                            </p>
                            <p class="text-xs text-slate-500 mb-3">
                                Em resposta a: <a href="#" class="text-indigo-600 hover:underline">O Futuro do Desenvolvimento Web com IA</a>
                            </p>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Aprovar</button>
                                <button class="bg-red-500 hover:bg-red-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Reprovar</button>
                                <button class="bg-slate-600 hover:bg-slate-700 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Editar</button>
                                <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Spam</button>
                                <button class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-1.5 px-3 rounded-md transition-colors">Lixeira</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Comentário 2 (Aprovado) -->
                <div class="bg-white p-5 rounded-xl border border-slate-200/80">
                    <div class="flex items-start space-x-4">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/62.jpg" alt="Avatar">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-slate-800">Bruno Costa</span>
                                    <span class="text-xs text-slate-500">bruno.costa@example.com</span>
                                    <span class="text-xs py-0.5 px-2 rounded-full bg-green-100 text-green-700 font-medium">Aprovado</span>
                                </div>
                                <span class="text-xs text-slate-500">2 horas atrás</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-2 line-clamp-3">
                                Excelente ponto sobre minimalismo! Aplicar isso em projetos reais tem sido um desafio, mas os resultados são incríveis.
                            </p>
                             <p class="text-xs text-slate-500 mb-3">
                                Em resposta a: <a href="#" class="text-indigo-600 hover:underline">Design Minimalista: Menos é Mais</a>
                            </p>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <button class="bg-red-500 hover:bg-red-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Reprovar</button>
                                <button class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-1.5 px-3 rounded-md transition-colors">Lixeira</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Comentário 3 (Spam) -->
                <div class="bg-white p-5 rounded-xl border border-rose-300 opacity-70">
                    <div class="flex items-start space-x-4">
                        <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/44.jpg" alt="Avatar">
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-semibold text-slate-800">Marketing Digital PRO</span>
                                    <span class="text-xs text-slate-500">contato@fakespam.com</span>
                                    <span class="text-xs py-0.5 px-2 rounded-full bg-rose-100 text-rose-700 font-medium">Spam</span>
                                </div>
                                <span class="text-xs text-slate-500">1 dia atrás</span>
                            </div>
                            <p class="text-sm text-slate-600 mb-2 line-clamp-3">
                                Compre agora nosso curso e fique rico!!! Link na bio. OFERTA IMPERDÍVEL!!!
                            </p>
                             <p class="text-xs text-slate-500 mb-3">
                                Em resposta a: <a href="#" class="text-indigo-600 hover:underline">Marketing de Conteúdo para Pequenas Empresas</a>
                            </p>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <button class="bg-green-500 hover:bg-green-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors">Não é Spam</button>
                                <button class="bg-slate-200 hover:bg-slate-300 text-slate-700 font-medium py-1.5 px-3 rounded-md transition-colors">Excluir Permanentemente</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Adicione mais cards de comentários aqui -->

            </div>

            <!-- Paginação (similar às outras listas) -->
            <div class="mt-8 flex justify-center">
                <nav aria-label="Page navigation">
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <a href="#" class="py-2 px-3 ml-0 leading-tight text-slate-500 bg-white rounded-l-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700">Anterior</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="py-2 px-3 text-indigo-600 bg-indigo-50 border border-slate-300 hover:bg-indigo-100 hover:text-indigo-700">1</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700">2</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-slate-500 bg-white rounded-r-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700">Próximo</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </main>

            <!-- Paginação (similar à de artigos) 
             <div class="mt-8 flex justify-center">
                <nav aria-label="Page navigation">
                    <ul class="inline-flex items-center -space-x-px">
                        <li>
                            <a href="#" class="py-2 px-3 ml-0 leading-tight text-slate-500 bg-white rounded-l-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700">Anterior</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="py-2 px-3 text-indigo-600 bg-indigo-50 border border-slate-300 hover:bg-indigo-100 hover:text-indigo-700">1</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-slate-500 bg-white border border-slate-300 hover:bg-slate-100 hover:text-slate-700">2</a>
                        </li>
                        <li>
                            <a href="#" class="py-2 px-3 leading-tight text-slate-500 bg-white rounded-r-lg border border-slate-300 hover:bg-slate-100 hover:text-slate-700">Próximo</a>
                        </li>
                    </ul>
                </nav>
            </div>
         </main> -->

<?php
View::end();
?>
