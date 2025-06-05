<?php
use Core\View;
?>
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
        <?php View::partial('admin/partials/sidebar'); ?>
        <?php View::section('content'); ?>
    </div>
    <!-- JS Admin --> 
    <?php View::scripts(); ?>
</body>
</html>