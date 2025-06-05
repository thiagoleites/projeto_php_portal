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

            <!-- <header class="mb-8">
                <h1 class="text-3xl font-semibold text-slate-800">Criar Novo Artigo</h1>
                <h1 class="text-3xl font-semibold text-slate-800">Editar Artigo: [Nome do Artigo]</h1>
                <p class="text-slate-600 mt-1">Preencha os campos abaixo para publicar ou salvar um rascunho.</p>
            </header> -->
            <header class="mb-8 bg-white py-5 px-6 rounded-lg shadow-sm">
                <h1 class="text-3xl font-semibold text-slate-800">Dashboard</h1>
                <p class="text-slate-600 mt-1">Visão geral das suas atividades e estatísticas.</p>
            </header>

            <form class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Coluna Principal (Campos) -->
                <div class="lg:col-span-2 bg-white p-6 md:p-8 rounded-xl border border-slate-200/80">
                    <div class="space-y-6">
                        <div>
                            <label for="titulo" class="block text-sm font-medium text-slate-700 mb-1">Título do Artigo</label>
                            <input type="text" name="titulo" id="titulo" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Ex: As Novas Tendências de Design para 2024">
                        </div>

                        <div>
                            <label for="conteudo" class="block text-sm font-medium text-slate-700 mb-1">Conteúdo</label>
                            <textarea name="conteudo" id="conteudo" rows="12" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Escreva o conteúdo do seu artigo aqui..."></textarea>
                            <p class="mt-1 text-xs text-slate-500">Dica: Use markdown para formatação (se aplicável).</p>
                        </div>

                        <div>
                            <label for="resumo" class="block text-sm font-medium text-slate-700 mb-1">Resumo (Opcional)</label>
                            <textarea name="resumo" id="resumo" rows="3" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Um breve resumo para SEO e listagens."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Coluna Lateral (Metadados e Ações) -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-xl border border-slate-200/80">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Publicação</h2>
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <select id="status" name="status" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="publicado">Publicado</option>
                                <option value="rascunho" selected>Rascunho</option>
                                <option value="agendado">Agendado</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="data_publicacao" class="block text-sm font-medium text-slate-700 mb-1">Data de Publicação</label>
                            <input type="datetime-local" name="data_publicacao" id="data_publicacao" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div class="mt-6 flex flex-col space-y-3">
                             <button type="submit" name="action" value="save_draft" class="w-full bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold py-3 px-4 rounded-lg text-sm transition-colors">
                                Salvar Rascunho
                            </button>
                            <button type="submit" name="action" value="publish" class="w-full bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-4 rounded-lg text-sm transition-colors">
                                Publicar Artigo
                            </button>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200/80">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Organização</h2>
                        <div>
                            <label for="categoria" class="block text-sm font-medium text-slate-700 mb-1">Categoria</label>
                            <select id="categoria" name="categoria" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option>Selecione uma categoria</option>
                                <option value="tecnologia">Tecnologia</option>
                                <option value="design">Design</option>
                                <option value="marketing">Marketing</option>
                            </select>
                        </div>
                        <div class="mt-4">
                            <label for="tags" class="block text-sm font-medium text-slate-700 mb-1">Tags</label>
                            <input type="text" name="tags" id="tags" class="w-full px-4 py-3 border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400" placeholder="Ex: ia, frontend, ux (separadas por vírgula)">
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl border border-slate-200/80">
                        <h2 class="text-lg font-semibold text-slate-700 mb-4">Imagem Destacada</h2>
                        <div class="w-full h-40 bg-slate-100 rounded-lg flex items-center justify-center border-2 border-dashed border-slate-300 mb-3">
                            <img id="imagePreview" src="#" alt="Preview" class="max-h-full max-w-full object-contain hidden">
                            <span id="imagePlaceholder" class="text-slate-400 text-sm">Preview da Imagem</span>
                        </div>
                        <input type="file" name="imagem_destacada" id="imagem_destacada" class="block w-full text-sm text-slate-500
                            file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0
                            file:text-sm file:font-semibold
                            file:bg-indigo-50 file:text-indigo-700
                            hover:file:bg-indigo-100"
                            onchange="document.getElementById('imagePreview').src = window.URL.createObjectURL(this.files[0]); document.getElementById('imagePreview').classList.remove('hidden'); document.getElementById('imagePlaceholder').classList.add('hidden');"
                        >
                        <p class="mt-1 text-xs text-slate-500">PNG, JPG, GIF até 10MB.</p>
                    </div>
                </div>
            </form>
        </main>

<?php
View::end();
?>
