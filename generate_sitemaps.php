<?php
// Script to dynamically update sitemap.xml and sitemap.html
// This script PRESERVES all existing data/URLs and appends the newly generated ones.

$baseUrl = 'https://laravelkolkata.com';
$currentDate = date('Y-m-d');

// --- 1. Gather dynamic pages ---
$services = [];
if (is_dir('service')) {
    $files = scandir('service');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents("service/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $services["/service/$file"] = $title;
        }
    }
}

$industries = [];
if (is_dir('industry')) {
    $files = scandir('industry');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents("industry/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $industries["/industry/$file"] = $title;
        }
    }
}

$technologies = [];
if (is_dir('technology')) {
    $files = scandir('technology');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents("technology/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $technologies["/technology/$file"] = $title;
        }
    }
}

asort($services);
asort($industries);
asort($technologies);


// --- 2. Generate sitemap.xml (Preserve original structure and append new) ---
$originalUrls = [
    ['loc' => 'https://laravelkolkata.com/', 'lastmod' => '2024-12-01', 'changefreq' => 'weekly', 'priority' => '1.0'],
    ['loc' => 'https://laravelkolkata.com/#about', 'lastmod' => '2024-12-01', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => 'https://laravelkolkata.com/#services', 'lastmod' => '2024-12-01', 'changefreq' => 'monthly', 'priority' => '0.9'],
    ['loc' => 'https://laravelkolkata.com/#technologies', 'lastmod' => '2024-12-01', 'changefreq' => 'monthly', 'priority' => '0.7'],
    ['loc' => 'https://laravelkolkata.com/#contact', 'lastmod' => '2024-12-01', 'changefreq' => 'monthly', 'priority' => '0.8'],
    ['loc' => 'https://laravelkolkata.com/privacy-policy.html', 'lastmod' => '2024-12-01', 'changefreq' => 'yearly', 'priority' => '0.3'],
    ['loc' => 'https://laravelkolkata.com/terms-of-service.html', 'lastmod' => '2024-12-01', 'changefreq' => 'yearly', 'priority' => '0.3'],
    ['loc' => 'https://laravelkolkata.com/sitemap.html', 'lastmod' => '2024-12-01', 'changefreq' => 'monthly', 'priority' => '0.4'],
];

$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Add original URLs
foreach ($originalUrls as $url) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$url['loc']}</loc>\n";
    $xml .= "        <lastmod>{$url['lastmod']}</lastmod>\n";
    $xml .= "        <changefreq>{$url['changefreq']}</changefreq>\n";
    $xml .= "        <priority>{$url['priority']}</priority>\n";
    $xml .= "    </url>\n";
}

// Add new directory hub pages
$directoryHubs = [
    '/services.html',
    '/industries.html',
    '/technologies.html'
];
foreach ($directoryHubs as $hub) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$baseUrl}{$hub}</loc>\n";
    $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
    $xml .= "        <changefreq>weekly</changefreq>\n";
    $xml .= "        <priority>0.8</priority>\n";
    $xml .= "    </url>\n";
}

// Add dynamic service pages
foreach ($services as $path => $name) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$baseUrl}{$path}</loc>\n";
    $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
    $xml .= "        <changefreq>monthly</changefreq>\n";
    $xml .= "        <priority>0.7</priority>\n";
    $xml .= "    </url>\n";
}

// Add dynamic industry pages
foreach ($industries as $path => $name) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$baseUrl}{$path}</loc>\n";
    $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
    $xml .= "        <changefreq>monthly</changefreq>\n";
    $xml .= "        <priority>0.7</priority>\n";
    $xml .= "    </url>\n";
}

// Add dynamic technology pages
foreach ($technologies as $path => $name) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$baseUrl}{$path}</loc>\n";
    $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
    $xml .= "        <changefreq>monthly</changefreq>\n";
    $xml .= "        <priority>0.7</priority>\n";
    $xml .= "    </url>\n";
}

$xml .= '</urlset>';
file_put_contents('sitemap.xml', $xml);
echo "Generated sitemap.xml.\n";


// --- 3. Generate sitemap.html (Preserve original page and append sections) ---
function generateListHtml($pages) {
    $html = '<ul class="space-y-3">';
    foreach ($pages as $path => $name) {
        $html .= '
                        <li>
                            <a href="' . $path . '" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                ' . htmlspecialchars($name) . '
                            </a>
                        </li>';
    }
    $html .= '
                    </ul>';
    return $html;
}

$directoriesList = generateListHtml([
    '/services.html' => 'Integration Services Directory',
    '/industries.html' => 'Industries We Serve',
    '/technologies.html' => 'Technologies & Toolstack'
]);

$industriesList = generateListHtml($industries);
$technologiesList = generateListHtml($technologies);

// We want services list to be shown in a multi-column grid inside the card
$servicesList = '<div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3">';
foreach ($services as $path => $name) {
    $servicesList .= '
                        <div>
                            <a href="' . $path . '" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                ' . htmlspecialchars($name) . '
                            </a>
                        </div>';
}
$servicesList .= '</div>';

$htmlContent = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitemap - Laravel Experts Kolkata</title>
    
    <!-- Favicon and App Icons -->
    <link rel="icon" type="image/png" href="/favicon/favicon-96x96.png" sizes="96x96" />
    <link rel="icon" type="image/png" href="/favicon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="/favicon/favicon-16x16.png" sizes="16x16" />
    <link rel="icon" type="image/svg+xml" href="/favicon/favicon.svg" />
    <link rel="shortcut icon" href="/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png" />
    <meta name="apple-mobile-web-app-title" content="Laravel Experts Kolkata" />
    <link rel="manifest" href="/favicon/site.webmanifest" />
    
    <!-- Meta Tags -->
    <meta name="description" content="Sitemap for Laravel Experts Kolkata - Find all pages and services offered by our Laravel development agency.">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="https://laravelkolkata.com/sitemap">
    <link rel="alternate" hreflang="x-default" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-IN" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-US" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-GB" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-AU" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-CA" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-AE" href="https://laravelkolkata.com/sitemap.html" />
    <link rel="alternate" hreflang="en-SG" href="https://laravelkolkata.com/sitemap.html" />
    
    <meta property="og:title" content="Sitemap - Laravel Experts Kolkata">
    <meta property="og:description" content="Sitemap for Laravel Experts Kolkata - Find all pages and services offered by our Laravel development agency.">
    <meta property="og:url" content="https://laravelkolkata.com/sitemap.html">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Laravel Experts Kolkata">
    <meta property="og:locale" content="en_IN">
    <meta property="og:locale:alternate" content="en_US">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="og:locale:alternate" content="en_AU">
    <meta property="og:locale:alternate" content="en_CA">
    <meta property="og:locale:alternate" content="en_AE">
    <meta property="og:locale:alternate" content="en_SG">

    <!-- HubSpot Tracking Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/243064993.js"></script>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-65EWYHYPCP"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-65EWYHYPCP');
    </script>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'laravel-red': '#FF2D20',
                        'laravel-orange': '#FF6B35',
                        'laravel-dark': '#1A202C',
                    }
                }
            }
        }
    </script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 font-sans antialiased">
    <!-- Navigation -->
    <nav class="bg-white/95 backdrop-blur-md shadow-lg fixed w-full z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <!-- Logo and Brand -->
                <a href="/" class="flex items-center group cursor-pointer">
                    <div class="bg-gradient-to-r from-laravel-red to-laravel-orange p-2 rounded-lg mr-3 group-hover:scale-105 transition duration-300">
                        <i class="fab fa-laravel text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-bold text-gray-900 group-hover:text-laravel-red transition duration-300">Laravel Experts</span>
                        <span class="block text-xs text-gray-500 -mt-1">Kolkata</span>
                    </div>
                </a>
                <!-- Desktop Navigation -->
                <div class="hidden lg:flex items-center space-x-8">
                    <a href="/" class="text-gray-700 hover:text-laravel-red font-medium transition duration-300">Home</a>
                    <a href="/privacy-policy.html" class="text-gray-700 hover:text-laravel-red font-medium transition duration-300">Privacy Policy</a>
                    <a href="/terms-of-service.html" class="text-gray-700 hover:text-laravel-red font-medium transition duration-300">Terms</a>
                    <a href="/sitemap.html" class="text-gray-700 hover:text-laravel-red font-medium transition duration-300">Sitemap</a>
                    <a href="/#contact" class="bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-6 py-2.5 rounded-full font-semibold hover:shadow-lg transform hover:scale-105 transition duration-300">
                        Contact
                    </a>
                </div>
                <!-- Mobile menu button -->
                <div class="lg:hidden flex items-center">
                    <button class="mobile-menu-button p-2 rounded-md hover:bg-gray-100 transition duration-300" aria-label="Open Menu">
                        <i class="fas fa-bars text-gray-700 text-xl"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- Mobile menu -->
        <div class="mobile-menu hidden lg:hidden bg-white border-t border-gray-100 shadow-lg">
            <div class="px-4 py-4 space-y-2">
                <a href="/" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300">Home</a>
                <a href="/privacy-policy.html" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300">Privacy Policy</a>
                <a href="/terms-of-service.html" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300">Terms</a>
                <a href="/sitemap.html" class="block px-4 py-3 text-gray-700 hover:text-laravel-red hover:bg-gray-50 rounded-lg transition duration-300">Sitemap</a>
                <a href="/#contact" class="block mx-4 mt-4 bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-6 py-3 rounded-lg font-semibold text-center">Contact</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-24 pb-16">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Sitemap</h1>
                <p class="text-xl text-gray-600">Navigate through all our pages and services</p>
            </div>

            <!-- Original Sitemap Content -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Main Pages -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-laravel-red to-laravel-orange text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-home text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Main Pages</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="/" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="/#about" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Our Services
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Technologies
                            </a>
                        </li>
                        <li>
                            <a href="/#features" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Laravel Features
                            </a>
                        </li>
                        <li>
                            <a href="/#contact" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-cogs text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Our Services</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Custom Laravel Development
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                FilamentPHP Admin Panels
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Laravel Nova Integration
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Livewire Development
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                API Development
                            </a>
                        </li>
                        <li>
                            <a href="/#services" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Cloud Deployment
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Technologies -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-code text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Technologies</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Laravel Framework
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Livewire
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                FilamentPHP
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                React.js
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Vue.js
                            </a>
                        </li>
                        <li>
                            <a href="/#technologies" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Tailwind CSS
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Company Information -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-green-500 to-green-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Company Info</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <span class="text-gray-700 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                10+ Years Experience
                            </span>
                        </li>
                        <li>
                            <span class="text-gray-700 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                100+ Projects Delivered
                            </span>
                        </li>
                        <li>
                            <span class="text-gray-700 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Based in Kolkata, India
                            </span>
                        </li>
                        <li>
                            <span class="text-gray-700 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                24/7 Support Available
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Contact Details</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="mailto:hello@laravelkolkata.com" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-envelope text-xs mr-2 text-laravel-red"></i>
                                hello@laravelkolkata.com
                            </a>
                        </li>
                        <li>
                            <a href="tel:+919126338684" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-phone text-xs mr-2 text-laravel-red"></i>
                                +91 91263 38684
                            </a>
                        </li>
                        <li>
                            <span class="text-gray-700 flex items-start">
                                <i class="fas fa-map-marker-alt text-xs mr-2 text-laravel-red mt-1"></i>
                                Salt Lake City, Sector V, Kolkata
                            </span>
                        </li>
                        <li>
                            <span class="text-gray-700 flex items-center">
                                <i class="fas fa-clock text-xs mr-2 text-laravel-red"></i>
                                Mon-Sat: 9AM-6PM IST
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Legal Pages -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-gavel text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">Legal Pages</h2>
                    </div>
                    <ul class="space-y-3">
                        <li>
                            <a href="/privacy-policy.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Privacy Policy
                            </a>
                        </li>
                        <li>
                            <a href="/terms-of-service.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Terms of Service
                            </a>
                        </li>
                        <li>
                            <a href="/sitemap.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Sitemap (You are here)
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- New Solutions & Dynamic Pages Section -->
            <div class="text-center mt-20 mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Directories & Detailed Profiles</h2>
                <p class="text-xl text-gray-600">Navigate to our integration, industry, and technology hubs</p>
            </div>

            <!-- SIDE BY SIDE LAYOUT FOR DYNAMIC CONTENT -->
            <div class="grid lg:grid-cols-3 gap-8 items-start">
                <!-- Left Side: Directory, Industry, and Tech lists stacked vertically (col-span-1) -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Directories -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-r from-laravel-red to-laravel-orange text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-folder-open text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Directory Hubs</h2>
                        </div>
                        {$directoriesList}
                    </div>

                    <!-- Industry Pages -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-building text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Industries Served</h2>
                        </div>
                        {$industriesList}
                    </div>

                    <!-- Technology Pages -->
                    <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
                        <div class="flex items-center mb-4">
                            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-laptop-code text-xl"></i>
                            </div>
                            <h2 class="text-xl font-bold text-gray-900">Technology Stacks</h2>
                        </div>
                        {$technologiesList}
                    </div>
                </div>

                <!-- Right Side: API & Integration Services (col-span-2) -->
                <div class="lg:col-span-2 bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red h-full">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-plug text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">API & Integration Services</h2>
                    </div>
                    {$servicesList}
                </div>
            </div>

            <!-- Call to Action -->
            <div class="mt-16 text-center">
                <div class="bg-gradient-to-r from-laravel-red to-laravel-orange rounded-2xl p-8 text-white">
                    <h3 class="text-2xl font-bold mb-4">Ready to Start Your Laravel Project?</h3>
                    <p class="text-lg mb-6 opacity-90">
                        Contact our expert team today to discuss your requirements
                    </p>
                    <div class="space-y-4 md:space-y-0 md:space-x-4 md:flex md:justify-center">
                        <a href="/#contact" class="inline-block bg-white text-laravel-red px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                            Get In Touch
                        </a>
                        <a href="/#services" class="inline-block border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-laravel-red transition duration-300">
                            View Our Services
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white relative">
        <!-- Bottom Footer -->
        <div class="bg-black py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-400 text-sm mb-4 md:mb-0">
                        &copy; 2024 Laravel Experts Kolkata. All rights reserved.
                    </div>
                    <div class="flex space-x-6 text-sm">
                        <a href="/privacy-policy.html" target="_blank" class="text-gray-400 hover:text-laravel-red transition duration-300">Privacy Policy</a>
                        <a href="/terms-of-service.html" target="_blank" class="text-gray-400 hover:text-laravel-red transition duration-300">Terms of Service</a>
                        <a href="/sitemap.html" target="_blank" class="text-gray-400 hover:text-laravel-red transition duration-300">Sitemap</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Mobile Menu Script -->
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function () {
            const btn = document.querySelector("button.mobile-menu-button");
            const menu = document.querySelector(".mobile-menu");
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
            // Hide mobile menu when clicking a link
            document.querySelectorAll('.mobile-menu a').forEach(link => {
                link.addEventListener('click', () => {
                    menu.classList.add('hidden');
                });
            });
        });
    </script>
</body>
</html>
HTML;

file_put_contents('sitemap.html', $htmlContent);
echo "Generated sitemap.html with side-by-side layout.\n";
