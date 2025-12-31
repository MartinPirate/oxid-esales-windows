<?php
/**
 * PHP 8.2 Compatibility Patches for OXID eShop
 */

echo "Applying PHP 8.2 compatibility patches...\n";

// Patch 1: ShopControl.php - method_exists() null parameter
$file1 = '/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Core/ShopControl.php';
if (file_exists($file1)) {
    $content1 = file_get_contents($file1);
    $content1 = str_replace(
        'if (method_exists($view, $function)) {',
        'if ($function !== null && method_exists($view, $function)) {',
        $content1
    );
    file_put_contents($file1, $content1);
    echo "Patched: ShopControl.php\n";
}

// Patch 2: LoginController.php - strpos() null parameter
$file2 = '/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Application/Controller/Admin/LoginController.php';
if (file_exists($file2)) {
    $content2 = file_get_contents($file2);
    $content2 = str_replace(
        'strpos($myConfig->getConfigParam(\'sAdminSSLURL\'), \'https://\')',
        'strpos($myConfig->getConfigParam(\'sAdminSSLURL\') ?? \'\', \'https://\')',
        $content2
    );
    file_put_contents($file2, $content2);
    echo "Patched: LoginController.php\n";
}

echo "Patches complete!\n";
