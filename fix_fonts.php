<?php
$directory = new RecursiveDirectoryIterator(__DIR__ . '/resources/views');
$iterator = new RecursiveIteratorIterator($directory);
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;
        
        // Upgrade text-[Xpx] sizes
        $content = str_replace('text-[10px]', 'text-[12px]', $content);
        $content = str_replace('text-[11px]', 'text-[13px]', $content);
        $content = str_replace('text-[12px]', 'text-[14px]', $content);
        $content = str_replace('text-[13px]', 'text-[15px]', $content);
        $content = str_replace('text-[14px]', 'text-[15px]', $content);
        
        // Upgrade tables
        $content = preg_replace('/<table class="w-full[^"]*table-auto"/', '<table class="design-table"', $content);
        $content = preg_replace('/<table class="w-full border-collapse border border-gray-100[^"]*"/', '<table class="design-table"', $content);
        
        if ($original !== $content) {
            file_put_contents($file->getPathname(), $content);
            echo "Updated " . $file->getPathname() . "\n";
        }
    }
}
