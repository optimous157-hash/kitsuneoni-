<?php
$dir = 'resources/views';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$count = 0;
$files = [];
foreach ($it as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && str_contains($file->getFilename(), '.blade.')) {
        $path = $file->getPathname();
        $c = file_get_contents($path);
        $orig = $c;
        $c = str_replace(["\xe2\x80\x94", "\xe2\x80\x93"], ' ', $c);
        if ($c !== $orig) {
            file_put_contents($path, $c);
            $files[] = $path;
            $count++;
        }
    }
}
echo "Files modified: $count\n";
foreach ($files as $f) {
    echo "  $f\n";
}
