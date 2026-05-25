<?php
/**
 * Asset processing script for Laravel Experts Kolkata
 * Resizes the generated logo & favicon to all the standard dimensions required by the site
 */

$sourceLogo = 'C:/Users/PC/.gemini/antigravity-ide/brain/14618f9c-c91c-4964-a73e-c41c9591adea/laravel_experts_logo_1779689843602.png';
$sourceFavicon = 'C:/Users/PC/.gemini/antigravity-ide/brain/14618f9c-c91c-4964-a73e-c41c9591adea/laravel_experts_favicon_1779689860575.png';

if (!file_exists($sourceLogo)) {
    die("Error: Source logo file not found at: {$sourceLogo}\n");
}
if (!file_exists($sourceFavicon)) {
    die("Error: Source favicon file not found at: {$sourceFavicon}\n");
}

// Make sure target directories exist
if (!is_dir('favicon')) {
    mkdir('favicon', 0755, true);
}
if (!is_dir('images')) {
    mkdir('images', 0755, true);
}

// Function to resize an image and save it as PNG
function resizePng($srcPath, $dstPath, $width, $height) {
    $src = imagecreatefromstring(file_get_contents($srcPath));
    if (!$src) {
        die("Error loading image: $srcPath\n");
    }
    
    // Create new true color image with transparent background
    $dst = imagecreatetruecolor($width, $height);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    
    $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
    imagefill($dst, 0, 0, $transparent);
    
    // Get source dimensions
    $srcWidth = imagesx($src);
    $srcHeight = imagesy($src);
    
    // Resample
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
    
    // Save
    imagepng($dst, $dstPath);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Saved PNG: $dstPath ({$width}x{$height})\n";
}

// Function to resize an image and save it as JPG
function resizeJpg($srcPath, $dstPath, $width, $height, $quality = 90) {
    $src = imagecreatefromstring(file_get_contents($srcPath));
    if (!$src) {
        die("Error loading image: $srcPath\n");
    }
    
    // Create new true color image with white background (since JPG doesn't support transparency)
    $dst = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);
    
    // Get source dimensions
    $srcWidth = imagesx($src);
    $srcHeight = imagesy($src);
    
    // Resample
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
    
    // Save
    imagejpeg($dst, $dstPath, $quality);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Saved JPG: $dstPath ({$width}x{$height})\n";
}

// Function to create standard 32x32 favicon.ico from a PNG
function createIco($srcPath, $dstPath) {
    $src = imagecreatefromstring(file_get_contents($srcPath));
    if (!$src) {
        die("Error loading image: $srcPath\n");
    }
    
    // 32x32 is standard for browser favicons
    $dst = imagecreatetruecolor(32, 32);
    imagealphablending($dst, false);
    imagesavealpha($dst, true);
    
    $transparent = imagecolorallocatealpha($dst, 255, 255, 255, 127);
    imagefill($dst, 0, 0, $transparent);
    
    $srcWidth = imagesx($src);
    $srcHeight = imagesy($src);
    
    imagecopyresampled($dst, $src, 0, 0, 0, 0, 32, 32, $srcWidth, $srcHeight);
    
    imagepng($dst, $dstPath);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Saved ICO: $dstPath (32x32)\n";
}

// Function to create an SVG containing base64 encoded PNG of the icon
function createSvg($srcPath, $dstPath) {
    $pngData = file_get_contents($srcPath);
    $base64 = base64_encode($pngData);
    
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" viewBox="0 0 512 512">
  <image width="512" height="512" xlink:href="data:image/png;base64,' . $base64 . '"/>
</svg>';
    
    file_put_contents($dstPath, $svg);
    echo "Saved SVG: $dstPath\n";
}

// Function to create an Open Graph / Twitter share card (1200x630)
// This puts the logo in the center of a nice clean letterbox canvas (like white background)
function createShareCard($srcPath, $dstPath) {
    $src = imagecreatefromstring(file_get_contents($srcPath));
    
    $dst = imagecreatetruecolor(1200, 630);
    // Draw solid white background
    $white = imagecolorallocate($dst, 255, 255, 255);
    imagefill($dst, 0, 0, $white);
    
    // Let's size the logo in the middle to be 300x300
    $logoSize = 300;
    $x = (1200 - $logoSize) / 2;
    $y = (630 - $logoSize) / 2 - 20; // offset slightly upwards to leave room for accent
    
    $srcWidth = imagesx($src);
    $srcHeight = imagesy($src);
    
    imagecopyresampled($dst, $src, $x, $y, 0, 0, $logoSize, $logoSize, $srcWidth, $srcHeight);
    
    // Draw bottom gradient line
    for ($i = 0; $i < 1200; $i++) {
        // Red to orange gradient
        $r = 255;
        $g = (int)(45 + (45 * ($i / 1200)));
        $b = 32;
        $color = imagecolorallocate($dst, $r, $g, $b);
        imageline($dst, $i, 615, $i, 630, $color);
    }
    
    imagejpeg($dst, $dstPath, 95);
    imagedestroy($src);
    imagedestroy($dst);
    echo "Saved share card: $dstPath (1200x630)\n";
}

// --- Process Favicons ---
echo "Processing favicons...\n";
resizePng($sourceFavicon, 'favicon/favicon-16x16.png', 16, 16);
resizePng($sourceFavicon, 'favicon/favicon-32x32.png', 32, 32);
resizePng($sourceFavicon, 'favicon/favicon-96x96.png', 96, 96);
resizePng($sourceFavicon, 'favicon/apple-touch-icon.png', 180, 180);
resizePng($sourceFavicon, 'favicon/web-app-manifest-192x192.png', 192, 192);
resizePng($sourceFavicon, 'favicon/web-app-manifest-512x512.png', 512, 512);
createIco($sourceFavicon, 'favicon/favicon.ico');
createSvg($sourceFavicon, 'favicon/favicon.svg');
resizePng($sourceFavicon, 'mstile-144x144.png', 144, 144);

// --- Process Logos ---
echo "\nProcessing branding logos...\n";
resizePng($sourceLogo, 'images/laravel-experts-logo.png', 300, 300);
resizePng($sourceLogo, 'images/laravel-experts-kolkata.png', 512, 512);
resizeJpg($sourceLogo, 'images/laravel-experts-kolkata.jpg', 512, 512);
createShareCard($sourceLogo, 'images/laravel-experts-kolkata-og.jpg');
createShareCard($sourceLogo, 'images/laravel-experts-kolkata-twitter.jpg');

echo "\nAsset processing completed successfully!\n";
