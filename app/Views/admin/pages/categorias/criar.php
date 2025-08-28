<?php
use Core\View;

View::extend('layouts/main');
View::start('content');
?>

 <!-- Conteúdo Principal -->
        <main class="flex-1 md:ml-64 p-6 md:p-8">
<!--            flex-1 md:ml-64 p-6 md:p-8-->
            <div class="md:hidden mb-4">
                <button id="mobileMenuButton" class="p-2 rounded-md text-slate-600 hover:bg-slate-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>

            <header class="mb-8">
                <h1 class="text-3xl font-semibold text-slate-800">Nova Categoria</h1>
                <!-- <h1 class="text-3xl font-semibold text-slate-800">Editar Categoria: [Nome da Categoria]</h1> -->
                <p class="text-slate-600 mt-1">Preencha os dados para criar ou atualizar uma categoria.</p>
            </header>

            <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200/80 w-full mx-auto">
                <form class="space-y-6">
                    <div>
                        <label for="nome_categoria" class="block text-sm font-medium text-slate-700 mb-1">Nome da Categoria</label>
                        <input type="text" name="nome_categoria" id="nome_categoria" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Ex: Novidades em IA" oninput="generateSlug(this.value)">
                    </div>

                    <div>
                        <label for="slug_categoria" class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                        <input type="text" name="slug_categoria" id="slug_categoria" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400 bg-slate-50" placeholder="Ex: novidades-em-ia" readonly>
                        <p class="mt-1 text-xs text-slate-500">Será gerado automaticamente a partir do nome. Pode ser editado se necessário.</p>
                    </div>
                    
                    <div>
                        <label for="descricao_categoria" class="block text-sm font-medium text-slate-700 mb-1">Descrição (Opcional)</label>
                        <textarea name="descricao_categoria" id="descricao_categoria" rows="4" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Uma breve descrição sobre a categoria..."></textarea>
                    </div>

                     <div>
                        <label for="categoria_pai" class="block text-sm font-medium text-slate-700 mb-1">Categoria Pai (Opcional)</label>
                        <select id="categoria_pai" name="categoria_pai" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                            <option value="">Nenhuma (Categoria Principal)</option>
                            <option value="1">Tecnologia</option>
                            <option value="2">-- Inteligência Artificial (sub de Tecnologia)</option>
                            <option value="3">Design Gráfico</option>
                            <!-- Popule com categorias existentes -->
                        </select>
                        <p class="mt-1 text-xs text-slate-500">Para criar hierarquias de categorias.</p>
                    </div>

                    <div class="pt-4 flex justify-end space-x-3">
                        <a href="categorias.html" class="bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
                            Salvar Categoria
                        </button>
                    </div>
                </form>
            </div>
        </main>

<?php
View::end();
?>
