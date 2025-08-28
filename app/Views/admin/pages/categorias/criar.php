<?php

use Core\Helpers;
use Core\View;

View::extend('layouts/main');
View::start('content');
?>

<!-- Sistema de Notificações -->
<div id="notification-container" class="fixed top-4 right-4 z-50 space-y-2 hidden"></div>

<!-- Conteúdo Principal -->
<main class="flex-1 md:ml-64 p-6 md:p-8">
    <!--            flex-1 md:ml-64 p-6 md:p-8-->
    <div class="md:hidden mb-4">
        <button id="mobileMenuButton" class="p-2 rounded-md text-slate-600 hover:bg-slate-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>

    <header class="mb-8">
        <h1 class="text-3xl font-semibold text-slate-800">Nova Categoria</h1>
        <!-- <h1 class="text-3xl font-semibold text-slate-800">Editar Categoria: [Nome da Categoria]</h1> -->
        <p class="text-slate-600 mt-1">Preencha os dados para criar ou atualizar uma categoria.</p>
    </header>

    <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200/80 w-full mx-auto">
        <!--                /base/admin/categorias/criar-->
        <form action="<?= Helpers::URL_BASE['admin'] ?>/categorias/criar" class="space-y-6" name="categoria"
              id="categoria"
              enctype="multipart/form-data" method="post">
            <div>
                <label for="nome_categoria" class="block text-sm font-medium text-slate-700 mb-1">Nome da
                    Categoria</label>
                <input type="text" name="name" id="nome_categoria"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400"
                       placeholder="Ex: Novidades em IA" oninput="generateSlug(this.value)">
            </div>

            <div>
                <label for="slug_categoria" class="block text-sm font-medium text-slate-700 mb-1">Slug</label>
                <input type="text" name="short_link" id="slug_categoria"
                       class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400 bg-slate-50"
                       placeholder="Ex: novidades-em-ia" readonly>
                <p class="mt-1 text-xs text-slate-500">Será gerado automaticamente a partir do nome. Pode ser editado se
                    necessário.</p>
            </div>

            <div>
                <label for="descricao_categoria" class="block text-sm font-medium text-slate-700 mb-1">Descrição
                    (Opcional)</label>
                <textarea name="descricao" id="descricao_categoria" rows="4"
                          class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 placeholder:text-slate-400"
                          placeholder="Uma breve descrição sobre a categoria..."></textarea>
            </div>

            <div>

                <label for="categoria_pai" class="block text-sm font-medium text-slate-700 mb-1">Categoria Pai
                    (Opcional)</label>
                <select id="categoria_pai" name="categoria_pai"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 bg-white">
                    <option value="">Nenhuma (Categoria Principal)</option>
                    <?php
                    foreach ($categorias as $key => $categoria):
                        foreach ($categoria as $key => $value):
                            ?>
                            <option value="<?= $value['id'] ?>"><?= htmlspecialchars($value['name']) ?></option>
                        <?php endforeach; endforeach; ?>
                    <!-- Popule com categorias existentes -->
                </select>
                <p class="mt-1 text-xs text-slate-500">Para criar hierarquias de categorias.</p>
            </div>

            <div class="pt-4 flex justify-end space-x-3">
                <a href="categorias.html"
                   class="bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
                    Cancelar
                </a>
                <button type="submit" id="sendCategoria"
                        class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
                    Salvar Categoria
                </button>
            </div>
        </form>
    </div>
</main>
<?php
View::script(<<<SCRIPT
<script>
$(document).ready(function() {
    // Interceptar o envio do formulário
    $('#categoriaForm').on('submit', function(e) {
        e.preventDefault();
        
        // Mostrar loading
        $('#loadingSpinner').removeClass('hidden');
        $('#submitText').text('Salvando...');
        $('#sendCategoria').prop('disabled', true);
        
        // Coletar dados do formulário
        const formData = new FormData(this);
        
        // Enviar via AJAX
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    showNotification('success', response.message);
                    
                    // Redirecionar após 2 segundos
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 2000);
                } else {
                    showNotification('error', response.message);
                    // Reativar botão
                    resetButton();
                }
            },
            error: function(xhr, status, error) {
                showNotification('error', 'Erro na requisição: ' + error);
                resetButton();
            }
        });
    });
    
    function resetButton() {
        $('#loadingSpinner').addClass('hidden');
        $('#submitText').text('Salvar Categoria');
        $('#sendCategoria').prop('disabled', false);
    }
    
    function showNotification(type, message) {
        const notification = $(`
            <div class="notification ${type}-notification animate-fade-in">
                <div class="flex items-center p-4 rounded-lg shadow-lg border-l-4 ${
type === 'success'
        ? 'bg-green-50 border-green-400 text-green-700'
        : 'bg-red-50 border-red-400 text-red-700'
}">
                    <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="${
type === 'success'
        ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
        : 'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z'
}" clip-rule="evenodd"/>
                    </svg>
                    <span>${message}</span>
                    <button class="ml-auto text-current hover:opacity-75" onclick="$(this).parent().parent().remove()">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        `);
        
        $('#notification-container').append(notification).removeClass('hidden');
        
        // Auto-remover após 5 segundos
        setTimeout(() => {
            notification.animate({opacity: 0}, 500, function() {
                $(this).remove();
                if ($('#notification-container').children().length === 0) {
                    $('#notification-container').addClass('hidden');
                }
            });
        }, 5000);
    }
    
    // Função para gerar slug (mantida do código original)
    function generateSlug(value) {
        // Sua função existente para gerar slug
    }
});
</script>
SCRIPT
);
View::end();
?>
