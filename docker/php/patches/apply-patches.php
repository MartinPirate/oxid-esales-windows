<?php
/**
 * PHP 8.2 Compatibility Patches for OXID eShop
 * Fixes deprecation warnings for null parameters
 */

echo "Applying PHP 8.2 compatibility patches...\n";

// Patch 1: ShopControl.php - method_exists() null parameter
$file1 = '/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Core/ShopControl.php';
if (file_exists($file1)) {
    $content = file_get_contents($file1);
    $content = str_replace(
        'if (method_exists($view, $function)) {',
        'if ($function !== null && method_exists($view, $function)) {',
        $content
    );
    file_put_contents($file1, $content);
    echo "Patched: ShopControl.php\n";
}

// Patch 2: LoginController.php - strpos() null parameter
$file2 = '/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Application/Controller/Admin/LoginController.php';
if (file_exists($file2)) {
    $content = file_get_contents($file2);
    $content = str_replace(
        "strpos(\$myConfig->getConfigParam('sAdminSSLURL'), 'https://')",
        "strpos(\$myConfig->getConfigParam('sAdminSSLURL') ?? '', 'https://')",
        $content
    );
    file_put_contents($file2, $content);
    echo "Patched: LoginController.php\n";
}

// Patch 3: FrontendController.php - basename() null parameters
$file3 = '/var/www/html/vendor/oxid-esales/oxideshop-ce/source/Application/Controller/FrontendController.php';
if (file_exists($file3)) {
    $content = file_get_contents($file3);

    // Fix basename calls for 'page' and 'tpl' parameters
    $content = str_replace(
        "basename(Registry::getRequest()->getRequestEscapedParameter('page'))",
        "basename(Registry::getRequest()->getRequestEscapedParameter('page') ?? '')",
        $content
    );
    $content = str_replace(
        "basename(Registry::getRequest()->getRequestEscapedParameter('tpl'))",
        "basename(Registry::getRequest()->getRequestEscapedParameter('tpl') ?? '')",
        $content
    );

    file_put_contents($file3, $content);
    echo "Patched: FrontendController.php\n";
}

echo "All patches applied!\n";
