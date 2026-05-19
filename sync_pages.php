<?php
/**
 * Page Synchronization Script for Laravel Experts Kolkata
 * Synchronizes the Navigation Header and Footer across all static root-level HTML files
 * using index.html as the canonical source.
 */

// 1. Load the canonical index.html
$indexContent = file_get_contents('index.html');
if (!$indexContent) {
    die("Error: Could not read index.html\n");
}

// 2. Extract the canonical navigation block
$navStartComment = '<!-- Navigation -->';
$navStartPos = strpos($indexContent, $navStartComment);
if ($navStartPos === false) {
    die("Error: Could not find '{$navStartComment}' in index.html\n");
}
$navEndPos = strpos($indexContent, '</nav>', $navStartPos) + 6;
$canonicalNav = substr($indexContent, $navStartPos, $navEndPos - $navStartPos);

// 3. Extract the canonical footer block
$footerStartComment = '<!-- Footer -->';
$footerStartPos = strpos($indexContent, $footerStartComment);
if ($footerStartPos === false) {
    die("Error: Could not find '{$footerStartComment}' in index.html\n");
}
$canonicalFooter = substr($indexContent, $footerStartPos);

// Define the static target files and their active navigation item mappings
$targets = [
    'about.html' => 'about',
    'features.html' => 'features',
    'contact.html' => 'contact',
    'privacy-policy.html' => 'none',
    'terms-of-service.html' => 'none'
];

foreach ($targets as $filename => $activeItem) {
    if (!file_exists($filename)) {
        echo "Warning: File {$filename} not found, skipping.\n";
        continue;
    }

    $content = file_get_contents($filename);
    
    // Find nav section in target file
    $tNavStart = strpos($content, $navStartComment);
    if ($tNavStart === false) {
        echo "Error: Could not find '{$navStartComment}' in {$filename}. Skipping.\n";
        continue;
    }
    $tNavEnd = strpos($content, '</nav>', $tNavStart) + 6;

    // Find footer section in target file
    $tFooterStart = strpos($content, $footerStartComment);
    if ($tFooterStart === false) {
        echo "Error: Could not find '{$footerStartComment}' in {$filename}. Skipping.\n";
        continue;
    }

    // Extract target head and main body content
    $headSection = substr($content, 0, $tNavStart);
    $mainSection = substr($content, $tNavEnd, $tFooterStart - $tNavEnd);

    // Customize the navigation block active state
    $modifiedNav = $canonicalNav;

    // First, make Home (which is active in index.html) inactive
    // Desktop Home
    $homeDesktopActive = '<a href="/" class="relative text-laravel-red transition duration-300 font-medium group">
                        Home
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-laravel-red transition-all duration-300"></span>
                    </a>';
    $homeDesktopInactive = '<a href="/" class="relative text-gray-700 hover:text-laravel-red transition duration-300 font-medium group">
                        Home
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-laravel-red transition-all duration-300 group-hover:w-full"></span>
                    </a>';
    
    // Fallback search patterns (in case indentation or white space varies slightly)
    $modifiedNav = str_replace($homeDesktopActive, $homeDesktopInactive, $modifiedNav);
    
    // Mobile Home
    $homeMobileActive = '<a href="/" class="block px-4 py-3 text-laravel-red bg-red-50 rounded-lg transition duration-300 font-medium">Home</a>';
    $homeMobileInactive = '<a href="/" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300 font-medium">Home</a>';
    $modifiedNav = str_replace($homeMobileActive, $homeMobileInactive, $modifiedNav);

    // Apply active class to the target page if applicable
    if ($activeItem === 'about') {
        // Desktop About
        $aboutDesktopInactive = '<a href="/about.html" class="relative text-gray-700 hover:text-laravel-red transition duration-300 font-medium group">
                        About
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-laravel-red transition-all duration-300 group-hover:w-full"></span>
                    </a>';
        $aboutDesktopActive = '<a href="/about.html" class="relative text-laravel-red transition duration-300 font-medium group">
                        About
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-laravel-red transition-all duration-300"></span>
                    </a>';
        $modifiedNav = str_replace($aboutDesktopInactive, $aboutDesktopActive, $modifiedNav);

        // Mobile About
        $aboutMobileInactive = '<a href="/about.html" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300 font-medium">About</a>';
        $aboutMobileActive = '<a href="/about.html" class="block px-4 py-3 text-laravel-red bg-red-50 rounded-lg transition duration-300 font-medium">About</a>';
        $modifiedNav = str_replace($aboutMobileInactive, $aboutMobileActive, $modifiedNav);
        
    } elseif ($activeItem === 'features') {
        // Desktop Features
        $featuresDesktopInactive = '<a href="/features.html" class="relative text-gray-700 hover:text-laravel-red transition duration-300 font-medium group">
                        Features
                        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-laravel-red transition-all duration-300 group-hover:w-full"></span>
                    </a>';
        $featuresDesktopActive = '<a href="/features.html" class="relative text-laravel-red transition duration-300 font-medium group">
                        Features
                        <span class="absolute bottom-0 left-0 w-full h-0.5 bg-laravel-red transition-all duration-300"></span>
                    </a>';
        $modifiedNav = str_replace($featuresDesktopInactive, $featuresDesktopActive, $modifiedNav);

        // Mobile Features
        $featuresMobileInactive = '<a href="/features.html" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300 font-medium">Features</a>';
        $featuresMobileActive = '<a href="/features.html" class="block px-4 py-3 text-laravel-red bg-red-50 rounded-lg transition duration-300 font-medium">Features</a>';
        $modifiedNav = str_replace($featuresMobileInactive, $featuresMobileActive, $modifiedNav);
    }

    // Assemble new content and save
    $newFileContent = $headSection . $modifiedNav . $mainSection . $canonicalFooter;
    file_put_contents($filename, $newFileContent);
    echo "Successfully synchronized navigation and footer for: {$filename}\n";
}
