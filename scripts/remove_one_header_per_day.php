<?php
declare(strict_types=1);

$baseDir = realpath(__DIR__ . '/../');
$progressFile = $baseDir . '/.storage/header_cleanup_progress.json';

if (!file_exists($progressFile)) {
    file_put_contents($progressFile, json_encode(['last_index' => -1]));
}

$progress = json_decode(file_get_contents($progressFile), true);
$lastIndex = (int) ($progress['last_index'] ?? -1);

/**
 * Coleta todos os arquivos PHP
 */
$files = [];

$rii = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($baseDir)
);

foreach ($rii as $file) {
    if (!$file->isFile()) continue;
    if ($file->getExtension() !== 'php') continue;
    if (str_contains($file->getPathname(), '/vendor/')) continue;

    $files[] = $file->getPathname();
}

sort($files);

$processed = false;

for ($i = $lastIndex + 1; $i < count($files); $i++) {
    $path = $files[$i];
    $content = file_get_contents($path);

    /**
     * Remove apenas comentário de cabeçalho no topo
     */
    $newContent = preg_replace(
        '/^<\?php\s*\/\*\*.*?\*\/\s*/s',
        "<?php\n",
        $content,
        1,
        $count
    );

    if ($count > 0 && $newContent !== $content) {
        file_put_contents($path, $newContent);

        // Atualiza progresso
        file_put_contents(
            $progressFile,
            json_encode(['last_index' => $i], JSON_PRETTY_PRINT)
        );

        echo "Header removed from: {$path}\n";
        $processed = true;
        break;
    }
}

// Se não encontrou mais arquivos com cabeçalho
if (!$processed) {
    echo "No more headers to remove.\n";
}
