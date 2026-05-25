<?php
// Script to dynamically update sitemap.xml and sitemap.html
// This script PRESERVES all existing data/URLs and appends the newly generated ones.

$baseUrl = 'https://laravelkolkata.com';
$currentDate = date('Y-m-d');

// --- 1. Gather dynamic pages ---
$services = [];
if (is_dir(__DIR__ . '/../service')) {
    $files = scandir('service');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents(__DIR__ . "/../service/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $services["/service/$file"] = $title;
        }
    }
}

$industries = [];
if (is_dir(__DIR__ . '/../industry')) {
    $files = scandir('industry');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents(__DIR__ . "/../industry/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $industries["/industry/$file"] = $title;
        }
    }
}

$technologies = [];
if (is_dir(__DIR__ . '/../technology')) {
    $files = scandir('technology');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents(__DIR__ . "/../technology/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $technologies["/technology/$file"] = $title;
        }
    }
}

asort($services);
asort($industries);
asort($technologies);

$ai_pages = [];
if (is_dir(__DIR__ . '/../ai')) {
    $files = scandir('ai');
    foreach ($files as $file) {
        if (pathinfo($file, PATHINFO_EXTENSION) === 'html') {
            $content = file_get_contents(__DIR__ . "/../ai/$file");
            preg_match('/<title>(.*?)<\/title>/', $content, $matches);
            $title = isset($matches[1]) ? str_replace(' - Laravel Experts Kolkata', '', $matches[1]) : basename($file, '.html');
            $ai_pages["/ai/$file"] = $title;
        }
    }
}
asort($ai_pages);


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

// Add dynamic AI pages
foreach ($ai_pages as $path => $name) {
    $xml .= "    <url>\n";
    $xml .= "        <loc>{$baseUrl}{$path}</loc>\n";
    $xml .= "        <lastmod>{$currentDate}</lastmod>\n";
    $xml .= "        <changefreq>monthly</changefreq>\n";
    $xml .= "        <priority>0.7</priority>\n";
    $xml .= "    </url>\n";
}

$xml .= '</urlset>';
file_put_contents(__DIR__ . '/../sitemap.xml', $xml);
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
$aiList = generateListHtml($ai_pages);

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

$index = file_get_contents(__DIR__ . '/../index.html');

// extract header and footer
$header_end = strpos($index, '<main class="relative">');
$header = substr($index, 0, $header_end);

$footer_start = strpos($index, '<!-- Footer -->');
$footer = substr($index, $footer_start);

// modify header and footer links to be absolute paths for the root
$header = str_replace('href="#', 'href="/#', $header);
$footer = str_replace('href="#', 'href="/#', $footer);

$sitemapMainContent = <<<HTML
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-bold text-gray-900 mb-4">Sitemap</h1>
                <p class="text-xl text-gray-600">Navigate through all our pages and services</p>
            </div>

            <!-- Original Sitemap Content -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
                <!-- Main Pages -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
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
                                Home Page
                            </a>
                        </li>
                        <li>
                            <a href="/about.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                About Us
                            </a>
                        </li>
                        <li>
                            <a href="/features.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Laravel Features
                            </a>
                        </li>
                        <li>
                            <a href="/contact.html" class="text-gray-700 hover:text-laravel-red transition duration-300 flex items-center">
                                <i class="fas fa-chevron-right text-xs mr-2 text-laravel-red"></i>
                                Contact Us
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Directory Hubs -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-folder text-xl"></i>
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

                <!-- AI Solutions -->
                <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-r from-indigo-500 to-indigo-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-brain text-xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-gray-900">AI Solutions</h2>
                    </div>
                    {$aiList}
                </div>
            </div>

            <!-- Right Side: API & Integration Services -->
            <div class="bg-white rounded-lg shadow-lg p-6 border-t-4 border-laravel-red h-full">
                <div class="flex items-center mb-4">
                    <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white w-12 h-12 rounded-lg flex items-center justify-center mr-4">
                        <i class="fas fa-plug text-xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">API & Integration Services</h2>
                </div>
                {$servicesList}
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
HTML;

$htmlContent = $header . "\n" . '    <!-- Main Content -->' . "\n" . '    <main class="pt-24 pb-16">' . "\n" . $sitemapMainContent . "\n" . '    </main>' . "\n" . $footer;

// Update SEO and title tags for Sitemap page
$htmlContent = preg_replace('/<title>.*?<\/title>/', "<title>Sitemap - Laravel Experts Kolkata</title>", $htmlContent);
$htmlContent = str_replace(
    'href="https://laravelkolkata.com"',
    'href="https://laravelkolkata.com/sitemap.html"',
    $htmlContent
);
$htmlContent = str_replace(
    '<meta property="og:url" content="https://laravelkolkata.com">',
    '<meta property="og:url" content="https://laravelkolkata.com/sitemap.html">',
    $htmlContent
);

file_put_contents(__DIR__ . '/../sitemap.html', $htmlContent);
echo "Generated sitemap.html with dynamic header/footer.\n";
