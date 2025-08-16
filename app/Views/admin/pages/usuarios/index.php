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
                    <h1 class="text-3xl font-semibold text-slate-800"><?= $titulo ?></h1>
                    <p class="text-slate-600 mt-1"><?= $subtitulo ?></p>
                </div>
                <a href="usuario-form.html" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2.5 px-5 rounded-lg text-sm flex items-center space-x-2 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                        <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                    </svg>
                    <span>Novo Usuário</span>
                </a>
            </header>

            <!-- Grid de Usuários -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <!-- Exemplo de Card de Usuário 1 -->

                <?php
                foreach ($allUsers as $user) { ?>
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80 text-center flex flex-col">
                        <img class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-2 border-slate-200" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Avatar Rafael Martins">
                        <h3 class="text-lg font-semibold text-slate-800"><?= $user['first_name'] ?> <?= $user['last_name']?></h3>
                        <p class="text-sm text-slate-500 mb-2"><?= $user['email']?></p>
                        <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1.5 rounded-full mb-4"><?= $user['role']?></span>
                        <div class="mt-auto flex justify-center space-x-2">
                            <a href="usuario-form.html?id=1" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 border rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                            <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 rounded-md border hover:bg-red-50 transition-colors">Excluir</button>
                        </div>
                    </div>
                <?php
                }
                ?>
                <!--
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 text-center flex flex-col">
                    <img class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-2 border-slate-200" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Avatar Rafael Martins">
                    <h3 class="text-lg font-semibold text-slate-800">Rafael Martins</h3>
                    <p class="text-sm text-slate-500 mb-2">rafa.martins@example.com</p>
                    <span class="inline-block bg-indigo-100 text-indigo-700 text-xs font-semibold px-2.5 py-1.5 rounded-full mb-4">Administrador</span>
                    <div class="mt-auto flex justify-center space-x-2">
                        <a href="usuario-form.html?id=1" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 border rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                        <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 rounded-md border hover:bg-red-50 transition-colors">Excluir</button>
                    </div>
                </div>


                <div class="bg-white p-6 rounded-xl border border-slate-200/80 text-center flex flex-col">
                    <img class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-2 border-slate-200" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Avatar Juliana Alves">
                    <h3 class="text-lg font-semibold text-slate-800">Juliana Alves</h3>
                    <p class="text-sm text-slate-500 mb-2">ju.alves@example.com</p>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1.5 rounded-full mb-4">Editor</span>
                     <div class="mt-auto flex justify-center space-x-2">
                        <a href="usuario-form.html?id=2" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 border rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                        <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 border rounded-md hover:bg-red-50 transition-colors">Excluir</button>
                    </div>
                </div>


                <div class="bg-white p-6 rounded-xl border border-slate-200/80 text-center flex flex-col">
                    <img class="w-24 h-24 rounded-full mx-auto mb-4 object-cover border-2 border-slate-200" src="https://randomuser.me/api/portraits/men/36.jpg" alt="Avatar Fernando Gomes">
                    <h3 class="text-lg font-semibold text-slate-800">Fernando Gomes</h3>
                    <p class="text-sm text-slate-500 mb-2">fer.gomes@example.com</p>
                    <span class="inline-block bg-sky-100 text-sky-700 text-xs font-semibold px-2.5 py-1.5 rounded-full mb-4">Autor</span>
                     <div class="mt-auto flex justify-center space-x-2">
                        <a href="usuario-form.html?id=3" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium py-1 px-3 border rounded-md hover:bg-indigo-50 transition-colors">Editar</a>
                        <button class="text-sm text-red-600 hover:text-red-800 font-medium py-1 px-3 border rounded-md hover:bg-red-50 transition-colors">Excluir</button>
                    </div>
                </div>
                -->

                <!-- Adicione mais cards aqui -->
            </div>

            <!-- Paginação (similar à de artigos) -->
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
