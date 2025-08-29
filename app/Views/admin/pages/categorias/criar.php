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
            <p class="text-slate-600 mt-1">Preencha os dados para criar ou atualizar uma categoria.</p>
        </header>

        <div class="bg-white p-6 md:p-8 rounded-xl border border-slate-200/80 w-full mx-auto">
            <form action="<?= Helpers::URL_BASE['admin'] ?>/categorias/criar" class="space-y-6" name="categoria"
                  id="categoriaForm"
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
                        <?php foreach ($categorias['data'] as $categoria): ?>
                            <option value="<?= $categoria['id'] ?>"><?= htmlspecialchars($categoria['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="mt-1 text-xs text-slate-500">Para criar hierarquias de categorias.</p>
                </div>

                <div class="pt-4 flex justify-end space-x-3">
                    <a href="<?= Helpers::URL_BASE['admin'] ?>/categorias"
                       class="bg-slate-200 text-slate-700 hover:bg-slate-300 font-semibold py-3 px-6 rounded-lg text-sm transition-colors">
                        Cancelar
                    </a>
                    <button type="submit" id="sendCategoria"
                            class="bg-slate-700 hover:bg-slate-600 text-white font-semibold py-3 px-6 rounded-lg text-sm transition-colors flex items-center">
                        <span id="submitText">Salvar Categoria</span>
                        <span id="loadingSpinner" class="hidden ml-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                    </button>
                </div>
            </form>
        </div>
    </main>

<?php
View::script(<<<'SCRIPT'
<script>
// Função para gerar slug
function generateSlug(text) {
    if (!text) return;
    
    const slug = text
        .toString()
        .toLowerCase()
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '')
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/(^-|-$)+/g, '');
    
    document.getElementById('slug_categoria').value = slug;
}

// Sistema de notificações
function showNotification(type, message) {
    const notificationContainer = document.getElementById('notification-container');
    const notification = document.createElement('div');
    
    const isSuccess = type === 'success';
    const bgClass = isSuccess ? 'bg-green-50 border-green-400 text-green-700' : 'bg-red-50 border-red-400 text-red-700';
    const iconPath = isSuccess ? 
        'M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z' : 
        'M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z';
    
    notification.className = 'notification animate-fade-in';
    notification.innerHTML = `
        <div class="flex items-center p-4 rounded-lg shadow-lg border-l-4 ${bgClass}">
            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="${iconPath}" clip-rule="evenodd"/>
            </svg>
            <span>${message}</span>
            <button class="ml-auto text-current hover:opacity-75" onclick="this.parentElement.parentElement.remove()">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    notificationContainer.appendChild(notification);
    notificationContainer.classList.remove('hidden');
    
    // Auto-remover após 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
        if (notificationContainer.children.length === 0) {
            notificationContainer.classList.add('hidden');
        }
    }, 5000);
}

// Interceptar o envio do formulário
$(document).ready(function() {
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
                    resetButton();
                    
                    // Mostrar erros de validação se existirem
                    if (response.errors) {
                        Object.keys(response.errors).forEach(field => {
                            const errorElement = $(`#${field}-error`);
                            const inputElement = $(`[name="${field}"]`);
                            
                            if (errorElement.length) {
                                errorElement.text(response.errors[field][0]).removeClass('hidden');
                                inputElement.addClass('border-red-500');
                            }
                        });
                    }
                }
            },
            error: function(xhr, status, error) {
                let errorMessage = 'Erro na requisição';
                
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                
                showNotification('error', errorMessage);
                resetButton();
            }
        });
    });
    
    function resetButton() {
        $('#loadingSpinner').addClass('hidden');
        $('#submitText').text('Salvar Categoria');
        $('#sendCategoria').prop('disabled', false);
    }
});
</script>
SCRIPT
);
View::end();
?>