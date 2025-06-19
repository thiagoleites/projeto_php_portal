<!DOCTYPE html>
<html lang="pt-BR" class=""> <!-- A classe 'dark' será adicionada aqui via JS -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Seu Projeto</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://rsms.me/">
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bg-image { transition: background-image 0.5s ease-in-out; }
    </style>
    <script>
        // Script para tema escuro/claro
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
          document.documentElement.classList.add('dark')
        } else {
          document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-gray-200 dark:bg-gray-900">

    <!-- Container principal -->
    <div class="relative min-h-screen w-full flex items-center justify-center">
        
        <!-- Imagem de Fundo e Overlay -->
        <div class="absolute inset-0 z-0">
            <div class="bg-image w-full h-full bg-cover bg-center" style="background-image: url('<?php echo htmlspecialchars($backgroundImage); ?>');"></div>
            <div class="absolute inset-0 bg-black/60"></div>
        </div>

        <!-- Botão de Tema -->
        <button id="theme-toggle" type="button" class="absolute top-5 right-5 z-20 text-gray-300 hover:text-white hover:bg-white/10 focus:outline-none focus:ring-4 focus:ring-white/20 rounded-lg text-sm p-2.5">
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path></svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path></svg>
        </button>

        <!-- Conteúdo central (Branding + Formulário) -->
        <main class="relative z-10 container mx-auto p-4 flex flex-col lg:flex-row items-center gap-12">
            
            <!-- Seção de Branding (Esquerda) -->
            <div class="w-full lg:w-1/2 text-center lg:text-left">
                <h1 class="text-white font-bold text-4xl md:text-5xl lg:text-6xl leading-tight">
                    <?= htmlspecialchars($msgTitulo); ?>
                </h1>
                <p class="text-gray-200 text-lg md:text-xl mt-4">
                    <?= htmlspecialchars($msgDescricao); ?>
                </p>
            </div>

            <!-- Seção do Formulário (Direita) -->
            <div class="w-full lg:w-1/2 flex justify-center">
                <div class="w-full max-w-md bg-white dark:bg-slate-800/50 backdrop-blur-lg rounded-2xl shadow-2xl p-8 space-y-6  border border-slate-600">
                    
                    <div class="text-center">
                        <!-- **Substitua pelo seu logo** -->
                        <img src="./images/inicial-logo.png" alt="Logo do Projeto" class="mx-auto h-20 w-auto">
                        <h2 class="mt-6 text-2xl font-bold text-gray-900 dark:text-white">
                            Acesse sua conta
                        </h2>
                    </div>

                    <!-- Mensagem de erro -->
                    <?php if (isset($error_message)): ?>
                        <div class="p-3 bg-red-100 dark:bg-red-900/30 border-l-4 border-red-500 text-red-700 dark:text-red-300">
                            <p><?php echo htmlspecialchars($error_message); ?></p>
                        </div>
                    <?php endif; ?>

                    <form action="/login" method="POST" class="space-y-6">
                        <!-- **Campo de E-mail** -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Endereço de e-mail</label>
                            <input id="email" name="email" type="email" autocomplete="email" required placeholder="seu@email.com"
                                class="mt-1 w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                        </div>

                        <!-- **Campo de Senha (com botão de visibilidade)** -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Senha</label>
                            <div class="mt-1 relative">
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:bg-gray-700 dark:text-white">
                                
                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 px-3 flex items-center text-gray-500 dark:text-gray-400">
                                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.022 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" /></svg>
                                    <svg id="eye-slash-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor"><path d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074L3.707 2.293zM10 12a2 2 0 110-4 2 2 0 010 4z" /><path d="M2 10a9.959 9.959 0 012.066-5.814l-.151.151a1 1 0 001.414 1.414l.151-.151A6.01 6.01 0 0110 8c.98 0 1.894.225 2.714.618l.158-.158a1 1 0 00-1.414-1.414l-.158.158A8.003 8.003 0 0010 6c-3.955 0-7.444 2.582-8.941 6.331A.999.999 0 001 13.331V10a1 1 0 00-1-1h-.5a1 1 0 00-1 1v.001a10.01 10.01 0 001.542 4.999l1.415-1.415A7.962 7.962 0 012 10z" /></svg>
                                </button>
                            </div>
                        </div>

                        <div>
                            <button type="submit"
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800 transition-colors duration-200">
                                Entrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        // --- Script para Tema Escuro/Claro ---
        const themeToggleBtn = document.getElementById('theme-toggle');
        const themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        const themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        function toggleThemeIcons() { if (document.documentElement.classList.contains('dark')) { themeToggleLightIcon.classList.remove('hidden'); themeToggleDarkIcon.classList.add('hidden'); } else { themeToggleLightIcon.classList.add('hidden'); themeToggleDarkIcon.classList.remove('hidden'); } }
        toggleThemeIcons();
        themeToggleBtn.addEventListener('click', () => { document.documentElement.classList.toggle('dark'); localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light'; toggleThemeIcons(); });

        // --- Script para Exibir/Ocultar Senha ---
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');
        togglePassword.addEventListener('click', function () { const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password'; passwordInput.setAttribute('type', type); eyeIcon.classList.toggle('hidden'); eyeSlashIcon.classList.toggle('hidden'); });
    </script>

</body>
</html>