<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Elegante</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/heroicons/2.0.18/24/outline/heroicons.min.css" rel="stylesheet">
    <style>
        /* Para customizações que o Tailwind não cobre facilmente ou para organização */
        body {
            font-family: 'Inter', sans-serif; /* Exemplo de fonte, adicione ao seu <head> se desejar */
        }
        /* Estilo para o scrollbar (opcional, mas adiciona elegância) */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* slate-300 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* slate-400 */
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-100 text-slate-800">

    <div class="flex min-h-screen">
        <!-- Sidebar (Barra Lateral) -->
        <aside class="w-64 bg-slate-800 text-slate-100 p-6 space-y-6 fixed top-0 left-0 h-full shadow-lg z-20 transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
            <div class="text-center">
                <a href="#" class="text-2xl font-semibold text-white hover:text-indigo-400 transition-colors">
                    <img src="./logo.png" alt="">
                </a>
            </div>
            <nav class="space-y-2">
                <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors bg-slate-700 text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="artigos.html" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    <span>Artigos</span>
                </a>
                <a href="usuarios.html" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    <span>Usuários</span>
                </a>
                <a href="categorias.html" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                    <span>Categorias</span>
                </a>
                <a href="comentarios.html" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25S3.75 16.556 3.75 12c0-4.556 3.86-8.25 8.625-8.25S21 7.444 21 12z" /></svg>
                    <span>Comentários</span>
                </a>
            </nav>
            <div class="pt-4 border-t border-slate-700">
                 <a href="#" class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-slate-300 hover:bg-slate-700 hover:text-white transition-colors">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" /></svg>
                    <span>Sair</span>
                </a>
            </div>
        </aside>

        <!-- Conteúdo Principal -->
        <main class="flex-1 md:ml-64 p-6 md:p-8">
            <!-- Botão para abrir sidebar em mobile -->
            <div class="md:hidden mb-4">
                <button id="mobileMenuButton" class="p-2 rounded-md text-slate-600 hover:bg-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <header class="mb-8 bg-white py-5 px-6 rounded-lg shadow-sm">
                <h1 class="text-3xl font-semibold text-slate-800">Dashboard</h1>
                <p class="text-slate-600 mt-1">Visão geral das suas atividades e estatísticas.</p>
            </header>

            <!-- Cards de Estatísticas -->
            <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6 mb-8">
                <!-- Card Artigos -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 flex flex-col justify-between hover:border-indigo-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium text-slate-500">Total de Artigos</h3>
                            <div class="p-2 bg-indigo-100 rounded-lg">
                                <svg class="w-5 h-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-800">1,287</p>
                    </div>
                    <a href="#" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium mt-4 inline-block">Ver todos →</a>
                </div>

                <!-- Card Usuários -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 flex flex-col justify-between hover:border-green-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium text-slate-500">Usuários Ativos</h3>
                             <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-800">356</p>
                    </div>
                     <a href="#" class="text-sm text-green-600 hover:text-green-800 font-medium mt-4 inline-block">Gerenciar usuários →</a>
                </div>

                <!-- Card Categorias -->
                 <div class="bg-white p-6 rounded-xl border border-slate-200/80 flex flex-col justify-between hover:border-amber-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium text-slate-500">Categorias</h3>
                            <div class="p-2 bg-amber-100 rounded-lg">
                                <svg class="w-5 h-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" /><path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-800">42</p>
                    </div>
                    <a href="#" class="text-sm text-amber-600 hover:text-amber-800 font-medium mt-4 inline-block">Ver categorias →</a>
                </div>

                <!-- Card Visitas -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 flex flex-col justify-between hover:border-sky-300 transition-colors">
                     <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium text-slate-500">Visitas (Últimas 24h)</h3>
                             <div class="p-2 bg-sky-100 rounded-lg">
                                <svg class="w-5 h-5 text-sky-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.432 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-800">8,721</p>
                    </div>
                    <a href="#" class="text-sm text-sky-600 hover:text-sky-800 font-medium mt-4 inline-block">Ver Analytics →</a>
                </div>

                <!-- Card Comentários -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 flex flex-col justify-between hover:border-rose-300 transition-colors">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-sm font-medium text-slate-500">Comentários Pendentes</h3>
                            <div class="p-2 bg-rose-100 rounded-lg">
                                <svg class="w-5 h-5 text-rose-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-3.86 8.25-8.625 8.25S3.75 16.556 3.75 12c0-4.556 3.86-8.25 8.625-8.25S21 7.444 21 12z" /></svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-slate-800">15</p>
                    </div>
                    <a href="#" class="text-sm text-rose-600 hover:text-rose-800 font-medium mt-4 inline-block">Moderar comentários →</a>
                </div>
            </section>

            <!-- Seção de Tabelas -->
            <section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Últimos Artigos Publicados -->
                <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-700 mb-4">Últimos Artigos Publicados</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] text-sm text-left text-slate-600">
                            <thead class="text-xs text-slate-500 uppercase bg-slate-50/50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 font-medium">Título</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Categoria</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Autor</th>
                                    <th scope="col" class="px-6 py-3 font-medium">Data</th>
                                    <th scope="col" class="px-6 py-3 font-medium text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-200/80">
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-800">O Futuro do Desenvolvimento Web com IA</td>
                                    <td class="px-6 py-4">Tecnologia</td>
                                    <td class="px-6 py-4">Ana Silva</td>
                                    <td class="px-6 py-4">15/07/2023</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-800">Design Minimalista: Menos é Mais</td>
                                    <td class="px-6 py-4">Design</td>
                                    <td class="px-6 py-4">Carlos Lima</td>
                                    <td class="px-6 py-4">12/07/2023</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                    </td>
                                </tr>
                                <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-800">Marketing de Conteúdo para Pequenas Empresas</td>
                                    <td class="px-6 py-4">Marketing</td>
                                    <td class="px-6 py-4">Beatriz Costa</td>
                                    <td class="px-6 py-4">10/07/2023</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                    </td>
                                </tr>
                                 <tr class="hover:bg-slate-50/30 transition-colors">
                                    <td class="px-6 py-4 font-medium text-slate-800">Explorando o Universo do Tailwind CSS</td>
                                    <td class="px-6 py-4">Desenvolvimento</td>
                                    <td class="px-6 py-4">João Pereira</td>
                                    <td class="px-6 py-4">08/07/2023</td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="#" class="text-indigo-600 hover:text-indigo-800 font-medium">Ver</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Últimos Usuários Registrados -->
                <div class="bg-white p-6 rounded-xl border border-slate-200/80 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-700 mb-4">Últimos Usuários Registrados</h2>
                    <ul class="space-y-4">
                        <li class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-50/50 transition-colors">
                            <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/32.jpg" alt="Rafael Martins">
                            <div>
                                <p class="font-medium text-slate-800">Rafael Martins</p>
                                <p class="text-xs text-slate-500">rafa.martins@example.com</p>
                            </div>
                            <span class="ml-auto text-xs text-slate-500">Hoje</span>
                        </li>
                        <li class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-50/50 transition-colors">
                            <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/44.jpg" alt="Juliana Alves">
                            <div>
                                <p class="font-medium text-slate-800">Juliana Alves</p>
                                <p class="text-xs text-slate-500">ju.alves@example.com</p>
                            </div>
                            <span class="ml-auto text-xs text-slate-500">Ontem</span>
                        </li>
                        <li class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-50/50 transition-colors">
                            <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/men/36.jpg" alt="Fernando Gomes">
                            <div>
                                <p class="font-medium text-slate-800">Fernando Gomes</p>
                                <p class="text-xs text-slate-500">fer.gomes@example.com</p>
                            </div>
                             <span class="ml-auto text-xs text-slate-500">13/07/2023</span>
                        </li>
                         <li class="flex items-center space-x-3 p-3 rounded-lg hover:bg-slate-50/50 transition-colors">
                            <img class="w-10 h-10 rounded-full object-cover" src="https://randomuser.me/api/portraits/women/68.jpg" alt="Carla Dias">
                            <div>
                                <p class="font-medium text-slate-800">Carla Dias</p>
                                <p class="text-xs text-slate-500">carla.d@example.com</p>
                            </div>
                             <span class="ml-auto text-xs text-slate-500">12/07/2023</span>
                        </li>
                    </ul>
                </div>
            </section>

        </main>
    </div>

    <script>
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebar = document.querySelector('aside');

        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Opcional: fechar sidebar ao clicar fora em mobile
        document.addEventListener('click', (event) => {
            if (!sidebar.contains(event.target) && !mobileMenuButton.contains(event.target) && window.innerWidth < 768) {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>

</body>
</html>