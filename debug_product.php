<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$p = \App\Models\Product::find(19);
if (!$p) {
    echo "Product 19 not found\n";
    exit(0);
}

echo "img: " . ($p->img ?? 'NULL') . PHP_EOL;
echo "imgs: " . ($p->imgs ?? 'NULL') . PHP_EOL;

// print first 500 chars for inspect
echo "imgs (substr): " . substr((string)$p->imgs, 0, 500) . PHP_EOL;

// attempt to show normalized images via controller method
$ctrl = new \App\Http\Controllers\Front\VendorProductController();
$norm = $ctrl->normalizeImagePaths($p->imgs);
foreach ($norm as $i => $n) {
    echo "norm[$i]: $n\n";
}

echo "Done\n";
