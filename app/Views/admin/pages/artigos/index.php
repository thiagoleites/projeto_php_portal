<?php
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

            <header class="mb-8 bg-white py-6 px-5 rounded-lg shadow-sm flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-800">Listagem de Artigos</h1>
                    <p class="text-slate-600 mt-1">Gerencie todos os seus artigos publicados e rascunhos.</p>
                </div>
                <a href="/base/admin/artigos/criar" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2.5 px-5 rounded-lg text-sm flex items-center space-x-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span>Novo Artigo</span>
                </a>
            </header>

            <!-- Filtros (Opcional) -->
            <div class="mb-6 flex space-x-4">
                <select class="px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                    <option>Todas as Categorias</option>
                    <option>Tecnologia</option>
                    <option>Design</option>
                </select>
                <input type="text" placeholder="Buscar artigo..." class="flex-grow px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-sm placeholder:text-slate-400">
            </div>

            <!-- Grid de Artigos -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Exemplo de Card de Artigo 1 -->
                <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden flex flex-col">
                    <a href="artigo-form.html?id=1">
                        <img src="https://plus.unsplash.com/premium_photo-1681426687411-21986b0626a8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Imagem do Artigo" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-2">
                            <span class="text-xs font-semibold inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline bg-indigo-100 text-indigo-700 rounded-full">Tecnologia</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2 hover:text-indigo-600 transition-colors">
                            <a href="artigo-form.html?id=1">O Futuro do Desenvolvimento Web com IA</a>
                        </h3>
                        <p class="text-slate-600 text-sm line-clamp-3 mb-3 flex-grow">
                            Uma exploração profunda de como a Inteligência Artificial está moldando as ferramentas e práticas do desenvolvimento web moderno, desde a geração de código até testes automatizados.
                        </p>
                        <div class="text-xs text-slate-500 mb-4">
                            Por <span class="font-medium text-slate-700">Ana Silva</span> em <span class="font-medium text-slate-700">15 Jul, 2023</span>
                        </div>
                        <div class="mt-auto flex space-x-2">
                            <a href="artigo-form.html?id=1" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                            <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 rounded-md hover:bg-red-50 transition-colors">Excluir</button>
                            <span class="ml-auto text-xs py-1 px-3 rounded-full bg-green-100 text-green-700 font-medium">Publicado</span>
                        </div>
                    </div>
                </div>

                <!-- Exemplo de Card de Artigo 2 -->
                <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden flex flex-col">
                    <a href="artigo-form.html?id=2">
                        <img src="https://images.unsplash.com/photo-1587440871875-191322ee64b0?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Imagem do Artigo" class="w-full h-48 object-cover">
                    </a>
                    <div class="p-5 flex flex-col flex-grow">
                        <div class="mb-2">
                            <span class="text-xs font-semibold inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline bg-amber-100 text-amber-700 rounded-full">Design</span>
                        </div>
                        <h3 class="text-lg font-semibold text-slate-800 mb-2 hover:text-indigo-600 transition-colors">
                            <a href="artigo-form.html?id=2">Design Minimalista: Menos é Mais na Experiência do Usuário</a>
                        </h3>
                        <p class="text-slate-600 text-sm line-clamp-3 mb-3 flex-grow">
                            Princípios do design minimalista aplicados à interfaces digitais para criar experiências de usuário mais focadas, intuitivas e esteticamente agradáveis.
                        </p>
                        <div class="text-xs text-slate-500 mb-4">
                            Por <span class="font-medium text-slate-700">Carlos Lima</span> em <span class="font-medium text-slate-700">12 Jul, 2023</span>
                        </div>
                        <div class="mt-auto flex space-x-2">
                            <a href="artigo-form.html?id=2" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                            <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 rounded-md hover:bg-red-50 transition-colors">Excluir</button>
                            <span class="ml-auto text-xs py-1 px-3 rounded-full bg-slate-200 text-slate-600 font-medium">Rascunho</span>
                        </div>
                    </div>
                </div>

                <!-- Adicione mais cards aqui -->

            </div>

            <!-- Paginação -->
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

<?php
View::end();
?>
