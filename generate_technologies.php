<?php
$index = file_get_contents('index.html');

// extract header and footer
$header_end = strpos($index, '<main class="relative">');
$header = substr($index, 0, $header_end);

$footer_start = strpos($index, '<!-- Footer -->');
$footer = substr($index, $footer_start);

// modify header and footer links to be absolute paths for the root
$header = str_replace('href="#', 'href="/#', $header);
$footer = str_replace('href="#', 'href="/#', $footer);

// create technology directory
if (!is_dir('technology')) {
    mkdir('technology', 0755, true);
}

// Define technologies
$technologies = [
    'laravel.html' => [
        'title' => 'Laravel Development Services',
        'icon' => 'fab fa-laravel',
        'subtitle' => 'The PHP Framework for Web Artisans',
        'description' => 'We specialize in building robust, scalable, and secure backend architectures using Laravel. Our expertise covers complex API integrations, queue management, database optimization, and high-performance routing.',
        'benefits' => [
            'MVC architecture for clean and maintainable code.',
            'Built-in security features against SQL injection and CSRF.',
            'Eloquent ORM for elegant database interactions.',
            'Task scheduling and robust queue management with Horizon.'
        ]
    ],
    'livewire.html' => [
        'title' => 'Laravel Livewire Development',
        'icon' => 'fas fa-bolt',
        'subtitle' => 'Dynamic UI Components without writing JavaScript',
        'description' => 'Build highly interactive, modern web applications seamlessly. We use Livewire to bring reactivity to your Laravel app without the overhead of heavy JavaScript frameworks, ensuring fast loading times.',
        'benefits' => [
            'Real-time form validation and dynamic data binding.',
            'Seamless integration with the Laravel ecosystem.',
            'SEO-friendly, server-rendered components.',
            'Simplified state management without complex JS stores.'
        ]
    ],
    'filamentphp.html' => [
        'title' => 'FilamentPHP Admin Panels',
        'icon' => 'fas fa-layer-group',
        'subtitle' => 'Beautiful, TALL-stack Admin Interfaces',
        'description' => 'We create incredibly fast and customizable admin dashboards, CRMs, and content management systems using FilamentPHP. Empower your team with tools that look great and work flawlessly.',
        'benefits' => [
            'Rapid development of complex data tables and forms.',
            'Built-in user roles, permissions, and security policies.',
            'Custom widgets and real-time dashboard analytics.',
            'Highly extensible plugin ecosystem.'
        ]
    ],
    'nova-admin.html' => [
        'title' => 'Laravel Nova Integration',
        'icon' => 'fas fa-star',
        'subtitle' => 'Official Laravel Admin Dashboard',
        'description' => 'Need a powerful internal tool? We integrate and customize Laravel Nova to give your team complete control over your application\'s database with a stunning, official UI.',
        'benefits' => [
            'Deep, native integration with Laravel Eloquent.',
            'Custom metrics, lenses, and filters for data analysis.',
            'Resource management with advanced field types.',
            'Secure actions and authorization gates.'
        ]
    ],
    'react-js.html' => [
        'title' => 'React.js Development',
        'icon' => 'fab fa-react',
        'subtitle' => 'High-Performance UI Component Library',
        'description' => 'For complex, state-heavy frontends, we pair Laravel backends with React.js. We build single-page applications (SPAs) that offer native-like user experiences on the web.',
        'benefits' => [
            'Component-based architecture for reusable code.',
            'Virtual DOM for lightning-fast rendering.',
            'Robust state management with Redux or Context API.',
            'Seamless API communication with Laravel backend.'
        ]
    ],
    'vue-js.html' => [
        'title' => 'Vue.js Development',
        'icon' => 'fab fa-vuejs',
        'subtitle' => 'Progressive JavaScript Framework',
        'description' => 'We utilize Vue.js, Laravel\'s most beloved frontend framework, to create elegant and highly interactive user interfaces. Perfect for both SPAs and dropping into existing Blade templates.',
        'benefits' => [
            'Gentle learning curve and clean, readable syntax.',
            'Reactive data binding and powerful directives.',
            'First-class support within the Laravel ecosystem (Inertia.js).',
            'Excellent performance and lightweight footprint.'
        ]
    ],
    'alpine-js.html' => [
        'title' => 'Alpine.js Development',
        'icon' => 'fas fa-mountain',
        'subtitle' => 'Minimalist JavaScript Framework',
        'description' => 'When you need JavaScript functionality without the bulk, we use Alpine.js. It perfectly complements Livewire and Blade, providing reactive capabilities with virtually zero overhead.',
        'benefits' => [
            'No build step required, works directly in HTML.',
            'Extremely small file size (under 10kb gzipped).',
            'Declarative syntax similar to Vue.js.',
            'Perfect for modals, dropdowns, and lightweight interactions.'
        ]
    ],
    'tailwind-css.html' => [
        'title' => 'Tailwind CSS Styling',
        'icon' => 'fab fa-css3-alt',
        'subtitle' => 'Utility-First CSS Framework',
        'description' => 'We build fully custom, responsive, and pixel-perfect designs using Tailwind CSS. By eliminating CSS bloat, we ensure your application loads fast and looks stunning on any device.',
        'benefits' => [
            'Rapid UI prototyping and implementation.',
            'Highly optimized, tiny production CSS files.',
            'Completely custom designs without overriding framework defaults.',
            'Built-in responsive modifiers for flawless mobile layouts.'
        ]
    ],
    'bootstrap.html' => [
        'title' => 'Bootstrap Integration',
        'icon' => 'fab fa-bootstrap',
        'subtitle' => 'The Classic Responsive Framework',
        'description' => 'For enterprise projects or legacy migrations, we implement and customize Bootstrap to ensure a reliable, grid-based, and mobile-first frontend experience across all browsers.',
        'benefits' => [
            'Extensive library of pre-built UI components.',
            'Robust and battle-tested responsive grid system.',
            'Excellent cross-browser compatibility.',
            'Familiar structure for enterprise IT teams.'
        ]
    ],
    'node-js.html' => [
        'title' => 'Node.js Development',
        'icon' => 'fab fa-node-js',
        'subtitle' => 'Scalable Server-Side JavaScript',
        'description' => 'We build fast, scalable, and real-time backend systems using Node.js. Perfect for microservices, high-traffic APIs, and event-driven architectures that require lightning-fast performance.',
        'benefits' => [
            'Asynchronous, event-driven architecture for high concurrency.',
            'Real-time communication using WebSockets (Socket.io).',
            'Seamless full-stack JavaScript integration.',
            'Excellent performance for I/O intensive applications.'
        ]
    ],
    'next-js.html' => [
        'title' => 'Next.js Development',
        'icon' => 'fab fa-react',
        'subtitle' => 'The React Framework for the Web',
        'description' => 'We utilize Next.js to build incredibly fast, SEO-friendly React applications. From static site generation (SSG) to server-side rendering (SSR), we deliver unparalleled frontend performance.',
        'benefits' => [
            'Server-side rendering (SSR) for perfect SEO performance.',
            'Static Site Generation (SSG) for ultra-fast loading times.',
            'Built-in routing and API middleware.',
            'Optimized image loading and core web vitals.'
        ]
    ],
    'python.html' => [
        'title' => 'Python Development',
        'icon' => 'fab fa-python',
        'subtitle' => 'AI, Data Science & Backend Services',
        'description' => 'Leverage the power of Python for machine learning, data analytics, and robust backend services. We build intelligent integrations and APIs that extend your core application\'s capabilities.',
        'benefits' => [
            'Advanced data processing and machine learning integrations.',
            'Rapid development of REST APIs and microservices.',
            'Extensive library ecosystem for scientific computing.',
            'Highly readable and maintainable codebase.'
        ]
    ],
    'wordpress.html' => [
        'title' => 'WordPress Development',
        'icon' => 'fab fa-wordpress',
        'subtitle' => 'The World\'s Leading Content Management System',
        'description' => 'We create custom, high-performance WordPress websites. From bespoke theme development to complex plugin integrations, we ensure your WordPress site is secure, fast, and scalable.',
        'benefits' => [
            'Custom theme development tailored to your brand.',
            'Secure plugin architecture and third-party API integration.',
            'Optimized for search engines and core web vitals.',
            'Easy-to-use content management interface.'
        ]
    ],
    'shopify.html' => [
        'title' => 'Shopify Development',
        'icon' => 'fab fa-shopify',
        'subtitle' => 'Enterprise E-Commerce Solutions',
        'description' => 'Launch and scale your online store with custom Shopify solutions. We specialize in custom Liquid theme development, headless Shopify integrations, and complex app development.',
        'benefits' => [
            'Custom Liquid theme development and optimization.',
            'Headless e-commerce architecture using Storefront API.',
            'Seamless integration with third-party inventory systems.',
            'High-converting checkout customizations.'
        ]
    ],
    'fast-api.html' => [
        'title' => 'FastAPI Development',
        'icon' => 'fas fa-bolt',
        'subtitle' => 'High-Performance Python Web Framework',
        'description' => 'We build lightning-fast, production-ready APIs with FastAPI. Its asynchronous nature and automatic documentation generation make it perfect for microservices and data-intensive applications.',
        'benefits' => [
            'Extremely high performance, on par with NodeJS and Go.',
            'Automatic interactive API documentation (Swagger UI).',
            'Based on standard Python type hints for robust validation.',
            'Ideal for asynchronous programming and machine learning APIs.'
        ]
    ],
    'django.html' => [
        'title' => 'Django Development',
        'icon' => 'fab fa-python',
        'subtitle' => 'The Web Framework for Perfectionists',
        'description' => 'Leverage Django\'s "batteries-included" approach to rapidly build secure and scalable backend applications. We utilize Django for complex data models and enterprise-grade Python solutions.',
        'benefits' => [
            'Rapid development with built-in admin interface and ORM.',
            'Robust security features against SQL injection and XSS.',
            'Highly scalable architecture for large enterprise projects.',
            'Seamless integration with machine learning models and data pipelines.'
        ]
    ]
];

foreach ($technologies as $file => $data) {
    $title = $data['title'];
    $subtitle = $data['subtitle'];
    $desc = $data['description'];
    $icon = $data['icon'];
    
    $benefitsHtml = '';
    foreach ($data['benefits'] as $benefit) {
        $benefitsHtml .= "<li>{$benefit}</li>\n                ";
    }

    $shortTitle = str_replace([' Development', ' Services', ' Integration', ' Styling', ' Admin Panels'], '', $title);

    $content = <<<HTML
<main class="relative pt-24 pb-16 min-h-[70vh] bg-gray-50">
    <!-- Hero / Intro Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center hover:text-laravel-red transition duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <a href="/technologies.html" class="hover:text-laravel-red transition duration-300">Technologies</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-laravel-red font-semibold">{$shortTitle}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-6 border border-laravel-red/20">
                    <i class="{$icon} mr-2"></i>
                    <span class="text-sm font-semibold tracking-wide uppercase">Tech Stack Expertise</span>
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                    {$title}
                </h1>
                <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                    {$desc}
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="/#contact" class="inline-flex justify-center items-center bg-gradient-to-r from-laravel-red to-laravel-orange text-white px-8 py-4 rounded-full font-bold hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
                        Start Your Project
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-2xl p-8 lg:p-10 border-t-4 border-laravel-red relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-laravel-orange/10 to-transparent rounded-bl-full"></div>
                <h2 class="text-2xl font-bold mb-6 text-gray-900 relative z-10">{$subtitle}</h2>
                <h3 class="text-lg font-semibold mb-4 text-laravel-red relative z-10">Technical Benefits</h3>
                <ul class="space-y-4 text-gray-700 relative z-10">
                    {$benefitsHtml}
                </ul>
            </div>
        </div>
    </div>

    <!-- Process Section -->
    <div class="bg-white py-20 border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Implementation Process</h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">How we leverage {$shortTitle} to build enterprise-grade applications.</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-8 relative">
                <!-- Connecting Line -->
                <div class="hidden md:block absolute top-1/2 left-0 w-full h-0.5 bg-gray-200 -z-10 -translate-y-1/2"></div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">1</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Architecture</h3>
                    <p class="text-gray-600 text-sm">We design the optimal technical structure utilizing {$shortTitle} best practices.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">2</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Implementation</h3>
                    <p class="text-gray-600 text-sm">Clean, documented code is written focusing on performance and scalability.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">3</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Optimization</h3>
                    <p class="text-gray-600 text-sm">Rigorous testing, caching, and performance tuning for lightning-fast speeds.</p>
                </div>
                
                <div class="bg-gray-50 rounded-xl p-8 text-center relative border border-gray-100 hover:shadow-lg transition duration-300">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-md border-2 border-laravel-red text-laravel-red text-xl font-bold">4</div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Deployment</h3>
                    <p class="text-gray-600 text-sm">Zero-downtime deployment and ongoing infrastructure monitoring.</p>
                </div>
            </div>
        </div>
    </div>
</main>
HTML;

    $html = $header . $content . "\n" . $footer;
    // update title tag
    $html = preg_replace('/<title>.*?<\/title>/', "<title>{$title} - Laravel Experts Kolkata</title>", $html);
    
    // SEO Update: update canonical and hreflang links to point to this subpage
    $html = str_replace(
        'href="https://laravelkolkata.com"',
        "href=\"https://laravelkolkata.com/technology/{$file}\"",
        $html
    );
    // SEO Update: update og:url
    $html = str_replace(
        '<meta property="og:url" content="https://laravelkolkata.com">',
        "<meta property=\"og:url\" content=\"https://laravelkolkata.com/technology/{$file}\">",
        $html
    );
    
    file_put_contents('technology/' . $file, $html);
}
echo "Created " . count($technologies) . " customized technology pages.\n";

// Extract "Technologies Section" from index.html
$tech_start = strpos($index, '<!-- Technologies Section -->');
$tech_end = strpos($index, '<!-- Laravel Features Section -->');
$ourTechHtml = '';
if ($tech_start !== false && $tech_end !== false) {
    $ourTechHtml = substr($index, $tech_start, $tech_end - $tech_start);
    // Replace the <a> tags if they existed, but index.html Technologies section just has divs. Let's wrap them in links!
    // It's a bit complex to regex replace all, so we will just append the detailed cards below.
}

// Generate technologies.html
$categories = [
    'Backend & Admin Frameworks' => [
        'laravel.html', 'livewire.html', 'filamentphp.html', 'nova-admin.html', 'node-js.html', 'python.html', 'fast-api.html', 'django.html'
    ],
    'Frontend & Javascript' => [
        'react-js.html', 'next-js.html', 'vue-js.html', 'alpine-js.html'
    ],
    'Styling & UI' => [
        'tailwind-css.html', 'bootstrap.html'
    ],
    'CMS & E-Commerce' => [
        'wordpress.html', 'shopify.html'
    ]
];

$cardsHtml = '';
foreach ($categories as $categoryName => $files) {
    $cardsHtml .= '<div class="col-span-full mt-10 mb-2"><h3 class="text-2xl font-bold text-gray-900 border-b-2 border-laravel-red pb-2 inline-block">' . $categoryName . '</h3></div>';
    foreach ($files as $file) {
        if (isset($technologies[$file])) {
            $data = $technologies[$file];
            $shortTitle = str_replace([' Development', ' Services', ' Integration', ' Styling', ' Admin Panels'], '', $data['title']);
            $cardsHtml .= <<<HTML
            <a href="/technology/{$file}" class="group flex flex-col h-full bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-xl hover:border-laravel-red/30 transition-all duration-300 overflow-hidden transform hover:-translate-y-1">
                <div class="p-6 flex flex-col flex-grow">
                    <div class="w-12 h-12 bg-laravel-red/10 rounded-lg flex items-center justify-center mb-4 group-hover:bg-laravel-red transition-colors duration-300 shrink-0">
                        <i class="{$data['icon']} text-laravel-red group-hover:text-white transition-colors duration-300 text-xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-laravel-red transition-colors duration-300">{$shortTitle}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3 mb-6">{$data['subtitle']}</p>
                    <div class="mt-auto flex items-center text-laravel-red text-sm font-semibold pt-2">
                        View Details <i class="fas fa-arrow-right ml-2 transform group-hover:translate-x-1 transition-transform duration-300"></i>
                    </div>
                </div>
            </a>
HTML;
        }
    }
}

$techContent = <<<HTML
<div class="bg-white pt-28 pb-4 border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex text-gray-500 text-sm font-medium" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="/" class="inline-flex items-center hover:text-laravel-red transition duration-300">
                        <i class="fas fa-home mr-2"></i>
                        Home
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                        <span class="text-laravel-red font-semibold ml-1 md:ml-2">Technologies</span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>
</div>

{$ourTechHtml}

<main class="relative py-20 bg-gray-50 border-t border-gray-200 min-h-[70vh]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <div class="inline-flex items-center bg-laravel-red/10 text-laravel-red rounded-full px-4 py-1 mb-4 border border-laravel-red/20">
                <span class="text-sm font-semibold tracking-wide uppercase">Core Tech Stack</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6">Our Technical Expertise</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Explore in-depth details about the tools and frameworks we use to build world-class Laravel web applications.
            </p>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
{$cardsHtml}
        </div>
    </div>
</main>
HTML;

$techPageHtml = $header . $techContent . "\n" . $footer;
$techPageHtml = preg_replace('/<title>.*?<\/title>/', "<title>Technologies We Use - Laravel Experts Kolkata</title>", $techPageHtml);

// SEO Update: update canonical and hreflang links to point to this directory page
$techPageHtml = str_replace(
    'href="https://laravelkolkata.com"',
    'href="https://laravelkolkata.com/technologies.html"',
    $techPageHtml
);
// SEO Update: update og:url
$techPageHtml = str_replace(
    '<meta property="og:url" content="https://laravelkolkata.com">',
    '<meta property="og:url" content="https://laravelkolkata.com/technologies.html">',
    $techPageHtml
);

file_put_contents('technologies.html', $techPageHtml);

echo "Created technologies.html directory page.\n";
